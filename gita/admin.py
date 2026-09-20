from django.contrib import admin
from gita.models import Verse, Reflection


@admin.register(Verse)
class VerseAdmin(admin.ModelAdmin):
    list_display = ('chapter', 'verse', 'theme', 'get_english_snippet', 'get_sanskrit_snippet')
    list_filter = ('chapter', 'theme')
    search_fields = ('english', 'transliteration', 'sanskrit', 'theme')
    ordering = ('chapter', 'verse')
    list_per_page = 25

    @admin.display(description='English Translation')
    def get_english_snippet(self, obj):
        return obj.english[:60] + ('...' if len(obj.english) > 60 else '')

    @admin.display(description='Sanskrit Shloka')
    def get_sanskrit_snippet(self, obj):
        return obj.sanskrit[:40] + ('...' if len(obj.sanskrit) > 40 else '')


@admin.register(Reflection)
class ReflectionAdmin(admin.ModelAdmin):
    list_display = ('name', 'verse', 'get_reflection_snippet', 'date')
    list_filter = ('date',)
    search_fields = ('name', 'verse', 'reflection')
    ordering = ('-date',)
    readonly_fields = ('date',)
    list_per_page = 25

    @admin.display(description='Reflection')
    def get_reflection_snippet(self, obj):
        return obj.reflection[:75] + ('...' if len(obj.reflection) > 75 else '')
