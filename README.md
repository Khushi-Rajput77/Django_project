# 🪈 Krishna Portal — Bhagavad Gita Django Application

A beautiful, fully-featured **Bhagavad Gita web portal** powered by **Django**, preserving the original frontend's sacred aesthetics, animations, and interactive experience.

---

## ✨ Features

- 📅 **Verse of the Day** — Dynamically selected based on the current date
- 📖 **Interactive 3D Sacred Book** — Cover animation, page navigation, keyboard support
- 🔊 **Text-to-Speech** — Sanskrit (Hindi voice) & English verse reading
- 📚 **18-Chapter Navigator** — Holographic particle card effects
- 🔍 **Verse Search** — Filter by keyword, theme, or chapter
- 🎵 **Flute Music Toggle** — Background ambient music
- 🙏 **Reflection Submission & Retrieval** — Community reflections with validation
- 🌟 **Floating Particle Animations** — Sacred golden particle effects
- ✨ **Glitter Cursor** — Custom animated cursor
- 📜 **Sanskrit Marquee Strip** — Scrolling Sanskrit shloka banner
- 🛡️ **Django Admin Panel** — Full CRUD for Verses & Reflections
- 🔗 **REST API** — DRF endpoints for verses and reflections
- 🔒 **CSRF Protection** — Secure AJAX form submissions

---

## 🛠️ Technology Stack

| Layer | Technology |
|-------|-----------|
| Backend | Python, Django 5.x |
| API | Django REST Framework |
| Database | SQLite (dev) / PostgreSQL (prod) |
| Frontend | HTML5, Vanilla CSS, Vanilla JavaScript |
| Fonts | Google Fonts (Cinzel, Lato) |
| Environment | python-dotenv |
| Production | Gunicorn |

---

## 🚀 Installation

### Prerequisites
- Python 3.10+
- WSL (Windows Subsystem for Linux) or Linux/macOS

### Setup Steps

```bash
# 1. Clone the repository
git clone <your-repo-url>
cd krishna-portal

# 2. Create virtual environment
python3 -m venv venv
source venv/bin/activate       # Linux/macOS/WSL
# OR: .\venv\Scripts\activate  # Windows PowerShell

# 3. Install dependencies
pip install -r requirements.txt

# 4. Configure environment variables
cp .env.example .env
# Edit .env if needed (optional for development)

# 5. Run database migrations
python manage.py migrate

# 6. Import Bhagavad Gita verse data
python manage.py import_verses

# 7. Create Django admin superuser
python manage.py createsuperuser

# 8. Start the development server
python manage.py runserver
```

Visit: **http://127.0.0.1:8000/**

---

## 🌐 URL Structure

### Pages
| URL | Description |
|-----|-------------|
| `/` | Home page with Verse of the Day, search, reflections |
| `/gita-book/` | Interactive 3D Sacred Book |
| `/admin/` | Django Admin Panel |

### Compatibility Endpoints (for frontend JS — unchanged)
| Old PHP Endpoint | Django Route | Purpose |
|-----------------|-------------|---------|
| `submit.php?action=get` | `/submit.php?action=get` | Get latest 10 reflections |
| `POST submit.php` | `POST /submit.php` | Submit a new reflection |
| `search.php?q=...` | `/search.php?q=...` | Search verses |

### Modern REST API Endpoints
| URL | Method | Description |
|-----|--------|-------------|
| `/api/verses/` | GET | List all verses |
| `/api/verses/<id>/` | GET | Get single verse |
| `/api/reflections/` | GET/POST | List or submit reflections |
| `/api/search/?q=&theme=&chapter=` | GET | Search API |

---

## 🗄️ Database

### Development (default)
```
SQLite — db.sqlite3
```

### Production (PostgreSQL)
Set these in `.env`:
```env
DB_ENGINE=django.db.backends.postgresql
DB_NAME=krishna_portal
DB_USER=postgres
DB_PASSWORD=yourpassword
DB_HOST=localhost
DB_PORT=5432
```

---

## 🧪 Running Tests

```bash
python manage.py test gita --verbosity=2
```

Tests cover:
- Verse model creation and field validation
- Reflection form validation (name required, max 1000 chars)
- Search API with query, theme, chapter filters
- Reflection GET and POST endpoints
- Home page and Gita book page rendering
- DRF `/api/verses/` endpoint

---

## 📂 Project Structure

```
krishna-portal/
├── manage.py
├── requirements.txt
├── .env.example
├── .gitignore
├── README.md
│
├── krishna_portal/          # Django project settings
│   ├── settings.py
│   ├── urls.py
│   ├── wsgi.py
│   └── asgi.py
│
├── gita/                    # Main Django app
│   ├── models.py            # Verse + Reflection models
│   ├── views.py             # All views (home, book, APIs, DRF)
│   ├── urls.py              # URL routing
│   ├── admin.py             # Admin panel registration
│   ├── forms.py             # ReflectionForm
│   ├── serializers.py       # DRF serializers
│   ├── tests.py             # Automated tests
│   └── management/
│       └── commands/
│           └── import_verses.py   # Data import command
│
├── templates/
│   ├── index.html           # Home page (Django template)
│   └── gita_book.html       # Interactive Sacred Book
│
├── static/
│   ├── css/style.css        # All styling
│   ├── js/main.js           # Frontend JavaScript
│   └── assets/              # Images, audio, etc.
│
└── data/
    └── verses.json          # Source verse data
```

---

## 🔒 Security Notes

- `SECRET_KEY` is loaded from `.env` — never commit `.env`
- CSRF protection is enabled for all POST requests
- Django's built-in XSS protection is active
- Reflection input is validated server-side via `ReflectionForm`
- `db.sqlite3` is excluded from git via `.gitignore`

---

## 🙏 Jai Shri Krishna!

> *॥ सर्वे भवन्तु सुखिनः ॥*  
> May all beings be happy.