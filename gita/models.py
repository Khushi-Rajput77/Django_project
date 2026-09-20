from django.db import models


class Verse(models.Model):
    chapter = models.IntegerField(help_text="Chapter number (1-18)")
    verse = models.IntegerField(help_text="Verse number")
    sanskrit = models.TextField(help_text="Original Sanskrit text in Devanagari")
    transliteration = models.TextField(help_text="Romanized transliteration of Sanskrit shloka")
    english = models.TextField(help_text="English translation / meaning")
    theme = models.CharField(max_length=100, db_index=True, help_text="Theme category (e.g. duty, soul, dharma)")

    class Meta:
        ordering = ['chapter', 'verse']
        verbose_name = "Verse"
        verbose_name_plural = "Verses"

    def __str__(self):
        return f"Chapter {self.chapter}, Verse {self.verse} ({self.theme})"


class Reflection(models.Model):
    name = models.CharField(max_length=255, help_text="Name of the person leaving reflection")
    verse = models.CharField(max_length=255, blank=True, default="", help_text="Referenced verse (optional)")
    reflection = models.TextField(max_length=1000, help_text="Personal reflection text (max 1000 chars)")
    date = models.DateTimeField(auto_now_add=True, help_text="Submission timestamp")

    class Meta:
        ordering = ['-date']
        verbose_name = "Reflection"
        verbose_name_plural = "Reflections"

    def __str__(self):
        return f"Reflection by {self.name} on {self.date.strftime('%Y-%m-%d %H:%M')}"
