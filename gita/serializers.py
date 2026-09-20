from rest_framework import serializers
from gita.models import Verse, Reflection


class VerseSerializer(serializers.ModelSerializer):
    class Meta:
        model = Verse
        fields = ['id', 'chapter', 'verse', 'sanskrit', 'transliteration', 'english', 'theme']


class ReflectionSerializer(serializers.ModelSerializer):
    formatted_date = serializers.SerializerMethodField()

    class Meta:
        model = Reflection
        fields = ['id', 'name', 'verse', 'reflection', 'date', 'formatted_date']

    def get_formatted_date(self, obj):
        return obj.date.strftime('%d %b %Y, %H:%M') if obj.date else ''
