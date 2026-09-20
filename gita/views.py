import json
from datetime import datetime
from django.shortcuts import render
from django.http import JsonResponse
from django.views.decorators.http import require_http_methods
from django.views.decorators.csrf import ensure_csrf_cookie
from django.db.models import Q
from django.utils import timezone
from rest_framework import viewsets, generics
from rest_framework.response import Response

from gita.models import Verse, Reflection
from gita.forms import ReflectionForm
from gita.serializers import VerseSerializer, ReflectionSerializer

# 18 Bhagavad Gita Chapters dictionary
CHAPTERS = {
    1: "Arjuna's Dilemma",
    2: "Transcendental Knowledge",
    3: "Path of Action",
    4: "Wisdom in Action",
    5: "Renunciation",
    6: "Meditation",
    7: "Knowledge of the Absolute",
    8: "Attaining the Supreme",
    9: "Royal Knowledge",
    10: "Divine Glories",
    11: "Universal Form",
    12: "Path of Devotion",
    13: "Nature & the Enjoyer",
    14: "Three Qualities",
    15: "Supreme Person",
    16: "Divine & Demonic",
    17: "Faith",
    18: "Liberation"
}


@ensure_csrf_cookie
def home(request):
    """
    Renders the Krishna Portal Home Page (index.html).
    Calculates Verse of the Day dynamically based on the current date.
    """
    verses_qs = Verse.objects.all().order_by('id')
    total_verses = verses_qs.count()

    votd = None
    if total_verses > 0:
        day_of_year = timezone.now().timetuple().tm_yday - 1
        votd_index = day_of_year % total_verses
        votd = verses_qs[votd_index]

    # Unique themes list for filtering buttons
    themes = list(Verse.objects.values_list('theme', flat=True).distinct())

    # Build verses list as list of dicts for frontend JavaScript
    verses_data = [
        {
            "id": v.id,
            "chapter": v.chapter,
            "verse": str(v.verse),
            "sanskrit": v.sanskrit,
            "transliteration": v.transliteration,
            "english": v.english,
            "theme": v.theme
        }
        for v in verses_qs
    ]

    context = {
        'votd': votd,
        'chapters': CHAPTERS,
        'themes': themes,
        'verses_json': json.dumps(verses_data),
    }
    return render(request, 'index.html', context)


from django.views.decorators.clickjacking import xframe_options_sameorigin

@xframe_options_sameorigin
def gita_book(request):
    """
    Renders the interactive 3D Bhagavad Gita Sacred Book (gita_book.html).
    """
    return render(request, 'gita_book.html')


@require_http_methods(["GET"])
def search_api(request):
    """
    Search API endpoint (compatible with legacy search.php and /api/search/).
    Accepts:
      - q: search keyword in english, transliteration, or sanskrit
      - theme: filter by theme
      - chapter: filter by chapter number
    Returns JSON structure: {"success": true, "count": N, "results": [...]}
    """
    query = request.GET.get('q', '').strip().lower()
    theme = request.GET.get('theme', '').strip().lower()
    chapter = request.GET.get('chapter', '').strip()

    queryset = Verse.objects.all()

    if query:
        queryset = queryset.filter(
            Q(english__icontains=query) |
            Q(transliteration__icontains=query) |
            Q(sanskrit__icontains=query)
        )

    if theme and theme != 'all':
        queryset = queryset.filter(theme__iexact=theme)

    if chapter:
        try:
            ch_num = int(chapter)
            if ch_num > 0:
                queryset = queryset.filter(chapter=ch_num)
        except ValueError:
            pass

    results = [
        {
            "id": v.id,
            "chapter": v.chapter,
            "verse": str(v.verse),
            "sanskrit": v.sanskrit,
            "transliteration": v.transliteration,
            "english": v.english,
            "theme": v.theme,
        }
        for v in queryset
    ]

    return JsonResponse({
        "success": True,
        "count": len(results),
        "results": results
    })


@require_http_methods(["GET", "POST"])
def submit_reflection_api(request):
    """
    Reflection API endpoint (compatible with legacy submit.php and /api/reflections/).
    GET action=get: Returns latest 10 reflections.
    POST: Validates and saves a new reflection.
    """
    if request.method == 'GET':
        action = request.GET.get('action', '')
        if action == 'get' or not action:
            reflections_qs = Reflection.objects.all().order_by('-date')[:10]
            reflections = [
                {
                    "id": str(r.id),
                    "name": r.name,
                    "verse": r.verse,
                    "reflection": r.reflection,
                    "date": r.date.strftime('%d %b %Y, %H:%M') if r.date else ''
                }
                for r in reflections_qs
            ]
            return JsonResponse({'success': True, 'reflections': reflections})
        return JsonResponse({'success': False, 'message': 'Invalid action.'})

    elif request.method == 'POST':
        form = ReflectionForm(request.POST)
        if form.is_valid():
            form.save()
            return JsonResponse({
                'success': True,
                'message': 'Your reflection has been saved. Jai Shri Krishna! 🙏'
            })
        else:
            errors = []
            for field, field_errors in form.errors.items():
                for err in field_errors:
                    errors.append(f"{err}")
            error_message = " ".join(errors) if errors else "Invalid reflection data."
            return JsonResponse({'success': False, 'message': error_message})


# ==========================================
# Django REST Framework (DRF) ViewSets / APIs
# ==========================================

class VerseViewSet(viewsets.ReadOnlyModelViewSet):
    """
    DRF ViewSet for Verses (/api/verses/).
    Supports listing and retrieving verses.
    """
    queryset = Verse.objects.all()
    serializer_class = VerseSerializer


class ReflectionViewSet(viewsets.ModelViewSet):
    """
    DRF ViewSet for Reflections (/api/reflections/).
    Supports list, create, retrieve operations.
    """
    queryset = Reflection.objects.all().order_by('-date')
    serializer_class = ReflectionSerializer

    def list(self, request, *args, **kwargs):
        # Default list returns latest 10 reflections for consistency
        queryset = self.filter_queryset(self.get_queryset())[:10]
        serializer = self.get_serializer(queryset, many=True)
        return Response({'success': True, 'reflections': serializer.data})
