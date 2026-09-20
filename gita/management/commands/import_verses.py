import json
import os
from django.core.management.base import BaseCommand
from django.conf import settings
from gita.models import Verse, Reflection


class Command(BaseCommand):
    help = "Imports Bhagavad Gita verses from verses.json into the Verse database model."

    def handle(self, *args, **options):
        # Locate verses.json file
        data_path = settings.BASE_DIR / 'data' / 'verses.json'
        if not os.path.exists(data_path):
            data_path = settings.BASE_DIR / 'verses.json'

        if not os.path.exists(data_path):
            self.stdout.write(self.style.ERROR(f"verses.json not found at {data_path}"))
            return

        with open(data_path, 'r', encoding='utf-8') as f:
            verses_data = json.load(f)

        imported_count = 0
        updated_count = 0

        for item in verses_data:
            chapter = int(item['chapter'])
            verse_num = int(item['verse'])
            sanskrit = item['sanskrit'].strip()
            transliteration = item['transliteration'].strip()
            english = item['english'].strip()
            theme = item['theme'].strip().lower()

            verse_obj, created = Verse.objects.update_or_create(
                chapter=chapter,
                verse=verse_num,
                defaults={
                    'sanskrit': sanskrit,
                    'transliteration': transliteration,
                    'english': english,
                    'theme': theme,
                }
            )

            if created:
                imported_count += 1
            else:
                updated_count += 1

        self.stdout.write(
            self.style.SUCCESS(
                f"Successfully processed {len(verses_data)} verses! ({imported_count} imported, {updated_count} updated)."
            )
        )

        # Optionally import reflections.json if Reflection table is empty
        refl_path = settings.BASE_DIR / 'reflections.json'
        if os.path.exists(refl_path) and Reflection.objects.count() == 0:
            try:
                with open(refl_path, 'r', encoding='utf-8') as rf:
                    refl_data = json.load(rf)
                refl_count = 0
                for r in refl_data:
                    name = r.get('name', '').strip()
                    verse_ref = r.get('verse', '').strip()
                    text = r.get('reflection', '').strip()
                    if name and text:
                        Reflection.objects.create(
                            name=name,
                            verse=verse_ref,
                            reflection=text
                        )
                        refl_count += 1
                self.stdout.write(self.style.SUCCESS(f"Imported {refl_count} initial reflections from reflections.json."))
            except Exception as e:
                self.stdout.write(self.style.WARNING(f"Could not import reflections.json: {e}"))
