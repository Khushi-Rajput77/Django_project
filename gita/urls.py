from django.urls import path, include
from rest_framework.routers import DefaultRouter
from gita import views

router = DefaultRouter()
router.register(r'verses', views.VerseViewSet, basename='verse')
router.register(r'drf-reflections', views.ReflectionViewSet, basename='drf-reflection')

urlpatterns = [
    # Pages
    path('', views.home, name='home'),
    path('gita-book/', views.gita_book, name='gita_book'),

    # Backward Compatibility Endpoints
    path('search.php', views.search_api, name='search_php'),
    path('submit.php', views.submit_reflection_api, name='submit_php'),

    # Modern REST APIs
    path('api/search/', views.search_api, name='api_search'),
    path('api/reflections/', views.submit_reflection_api, name='api_reflections'),
    path('api/', include(router.urls)),
]
