from django.test import TestCase, Client
from django.urls import reverse
from gita.models import Verse, Reflection
from gita.forms import ReflectionForm


class VerseModelTest(TestCase):
    def setUp(self):
        self.verse = Verse.objects.create(
            chapter=2,
            verse=47,
            sanskrit="कर्मण्येवाधिकारस्ते...",
            transliteration="Karmanye vadhikaraste...",
            english="You have a right to perform your prescribed duties...",
            theme="duty"
        )

    def test_verse_creation(self):
        self.assertEqual(self.verse.chapter, 2)
        self.assertEqual(self.verse.verse, 47)
        self.assertEqual(self.verse.theme, "duty")
        self.assertIn("Chapter 2, Verse 47", str(self.verse))


class ReflectionModelTest(TestCase):
    def setUp(self):
        self.reflection = Reflection.objects.create(
            name="Arjuna",
            verse="Chapter 2, Verse 47",
            reflection="This shloka gives me profound clarity."
        )

    def test_reflection_creation(self):
        self.assertEqual(self.reflection.name, "Arjuna")
        self.assertEqual(self.reflection.verse, "Chapter 2, Verse 47")
        self.assertIn("Reflection by Arjuna", str(self.reflection))

    def test_reflection_form_validation(self):
        # Valid form
        form = ReflectionForm(data={
            'name': 'Radha',
            'verse': 'Chapter 4, Verse 7',
            'reflection': 'Jai Shri Krishna!'
        })
        self.assertTrue(form.is_valid())

        # Empty name
        form_empty_name = ReflectionForm(data={
            'name': '',
            'reflection': 'Some reflection text'
        })
        self.assertFalse(form_empty_name.is_valid())

        # Exceeds max length
        long_text = "a" * 1001
        form_long = ReflectionForm(data={
            'name': 'Gopi',
            'reflection': long_text
        })
        self.assertFalse(form_long.is_valid())


class SearchAPITest(TestCase):
    def setUp(self):
        self.client = Client()
        Verse.objects.create(
            chapter=2,
            verse=47,
            sanskrit="कर्मण्येवाधिकारस्ते",
            transliteration="Karmanye vadhikaraste",
            english="Right to perform prescribed duties",
            theme="duty"
        )
        Verse.objects.create(
            chapter=4,
            verse=7,
            sanskrit="यदा यदा हि धर्मस्य",
            transliteration="Yada yada hi dharmasya",
            english="Decline in righteousness",
            theme="dharma"
        )

    def test_search_by_query(self):
        response = self.client.get(reverse('search_php'), {'q': 'dharma'})
        self.assertEqual(response.status_code, 200)
        data = response.json()
        self.assertTrue(data['success'])
        self.assertEqual(data['count'], 1)
        self.assertEqual(data['results'][0]['chapter'], 4)

    def test_filter_by_theme(self):
        response = self.client.get(reverse('search_php'), {'theme': 'duty'})
        self.assertEqual(response.status_code, 200)
        data = response.json()
        self.assertTrue(data['success'])
        self.assertEqual(data['count'], 1)
        self.assertEqual(data['results'][0]['theme'], 'duty')

    def test_filter_by_chapter(self):
        response = self.client.get(reverse('search_php'), {'chapter': '2'})
        self.assertEqual(response.status_code, 200)
        data = response.json()
        self.assertEqual(data['count'], 1)
        self.assertEqual(data['results'][0]['chapter'], 2)


class ReflectionAPITest(TestCase):
    def setUp(self):
        self.client = Client()
        Reflection.objects.create(
            name="Bhakta",
            verse="Chapter 18, Verse 66",
            reflection="Surrender unto Him."
        )

    def test_get_reflections(self):
        response = self.client.get(reverse('submit_php'), {'action': 'get'})
        self.assertEqual(response.status_code, 200)
        data = response.json()
        self.assertTrue(data['success'])
        self.assertEqual(len(data['reflections']), 1)
        self.assertEqual(data['reflections'][0]['name'], "Bhakta")

    def test_submit_reflection_success(self):
        response = self.client.post(reverse('submit_php'), {
            'name': 'Devotee',
            'verse': 'Chapter 2, Verse 20',
            'reflection': 'The soul is immortal.'
        })
        self.assertEqual(response.status_code, 200)
        data = response.json()
        self.assertTrue(data['success'])
        self.assertIn("Your reflection has been saved", data['message'])
        self.assertEqual(Reflection.objects.count(), 2)

    def test_submit_reflection_invalid(self):
        response = self.client.post(reverse('submit_php'), {
            'name': '',
            'reflection': ''
        })
        self.assertEqual(response.status_code, 200)
        data = response.json()
        self.assertFalse(data['success'])


class PageViewsTest(TestCase):
    def setUp(self):
        self.client = Client()

    def test_home_page(self):
        response = self.client.get(reverse('home'))
        self.assertEqual(response.status_code, 200)
        self.assertTemplateUsed(response, 'index.html')

    def test_gita_book_page(self):
        response = self.client.get(reverse('gita_book'))
        self.assertEqual(response.status_code, 200)
        self.assertTemplateUsed(response, 'gita_book.html')


class DRFAPITest(TestCase):
    def setUp(self):
        self.client = Client()
        Verse.objects.create(
            chapter=1,
            verse=1,
            sanskrit="धर्मक्षेत्रे कुरुक्षेत्रे",
            transliteration="Dharmaksetre kuruksetre",
            english="On the field of Kurukshetra...",
            theme="dharma"
        )

    def test_drf_verses_endpoint(self):
        response = self.client.get('/api/verses/')
        self.assertEqual(response.status_code, 200)
        data = response.json()
        self.assertTrue(len(data) > 0)
