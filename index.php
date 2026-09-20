<?php
$verses = json_decode(file_get_contents(__DIR__ . '/verses.json'), true);
$dayOfYear = date('z');
$votd = $verses[$dayOfYear % count($verses)];
$chapters = [
  1=>"Arjuna's Dilemma",2=>"Transcendental Knowledge",3=>"Path of Action",
  4=>"Wisdom in Action",5=>"Renunciation",6=>"Meditation",
  7=>"Knowledge of the Absolute",8=>"Attaining the Supreme",9=>"Royal Knowledge",
  10=>"Divine Glories",11=>"Universal Form",12=>"Path of Devotion",
  13=>"Nature & the Enjoyer",14=>"Three Qualities",15=>"Supreme Person",
  16=>"Divine & Demonic",17=>"Faith",18=>"Liberation"
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Bhagavad Gita Portal</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&family=Cinzel:wght@400;600;700&family=Lato:ital,wght@0,300;0,400;1,300&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css"/>


<!-- Glitter Cursor CSS -->
  <style id="cursor-css">
    * { cursor: none !important; }
    #cursor-white {
      position: fixed; pointer-events: none; z-index: 99999;
      width: 12px; height: 12px; border-radius: 50%;
      background: radial-gradient(circle at 38% 30%, #ffffff 0%, #fffde0 55%, rgba(255,255,220,0.7) 100%);
      box-shadow: 0 0 6px 2px rgba(255,255,255,0.9), 0 0 14px 4px rgba(255,255,200,0.4);
      transform: translate(-50%, -50%);
    }
    #cursor-yellow {
      position: fixed; pointer-events: none; z-index: 99998;
      width: 22px; height: 22px; border-radius: 50%;
      background: radial-gradient(circle at 40% 35%, #fff9a0 0%, #ffe600 45%, #ffa800 80%, rgba(255,160,0,0.4) 100%);
      box-shadow: 0 0 8px 3px rgba(255,210,0,0.7), 0 0 18px 6px rgba(255,180,0,0.3);
      transform: translate(-50%, -50%);
    }
    .glitter-particle { position: fixed; pointer-events: none; border-radius: 50%; z-index: 99997; }
  </style>
  





<!-- ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  STEP 1 : Add this CSS inside your <head> <style> block
  ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ -->
<style>
/* ── Sanskrit Marquee Strip ── */
.sanskrit-strip {
  width: 100%;
  overflow: hidden;
  padding: 0;
  position: relative;
  z-index: 10;
  margin: 2.5rem 0;
 
  /* golden gradient background */
  background: linear-gradient(
    90deg,
    #0a0612 0%,
    #1a0f00 15%,
    #2a1a00 30%,
    #1a0f00 50%,
    #2a1a00 70%,
    #1a0f00 85%,
    #0a0612 100%
  );
 
  border-top:    1px solid rgba(245, 197, 24, 0.25);
  border-bottom: 1px solid rgba(245, 197, 24, 0.25);
 
  /* top + bottom gold glow lines */
  box-shadow:
    0  2px 20px rgba(245, 197, 24, 0.12),
    0 -2px 20px rgba(245, 197, 24, 0.12);
}
 
/* inner track that holds all marquee items */
.sanskrit-strip-track {
  display: flex;
  align-items: center;
  width: max-content;     /* grows as wide as needed */
  padding: 1rem 0;
  will-change: transform;

 /* Important */
  transform: translate3d(0, 0, 0);
}

/* one repeating item */
.strip-item {
  display: flex;
  align-items: center;
  gap: 1.2rem;
  padding: 0 2.5rem;
  flex-shrink: 0;
  white-space: nowrap;
}
 
/* Sanskrit text */
.strip-item span {
  font-family: 'Cinzel', serif;
  font-size: clamp(16px, 2.2vw, 26px);
  font-weight: 600;
  letter-spacing: 0.18em;
  background: linear-gradient(
    135deg,
    #fffbe0 0%,
    #f5c518 35%,
    #e8a800 60%,
    #fffbe0 100%
  );
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  text-shadow: none;
  filter: drop-shadow(0 0 8px rgba(245, 197, 24, 0.4));
}
 
/* divider symbol between items */
.strip-divider {
  font-size: clamp(18px, 2.5vw, 30px);
  color: rgba(245, 197, 24, 0.55);
  line-height: 1;
  filter: drop-shadow(0 0 6px rgba(245, 197, 24, 0.5));
  animation: divGlow 2s ease-in-out infinite alternate;
}
 
@keyframes divGlow {
  from { opacity: 0.4; filter: drop-shadow(0 0 4px rgba(245,197,24,0.3)); }
  to   { opacity: 0.9; filter: drop-shadow(0 0 12px rgba(245,197,24,0.8)); }
}
</style>




  

  <style>
    /* ── SACRED BOOK SECTION ── */
    .book-section {
      text-align: center;
      max-width: 1100px;
      margin: 0 auto;
      padding: 5rem 2rem;
      position: relative;
      z-index: 1;
    }

    /* Preview card that wraps the iframe */
    .book-preview-card {
      background: linear-gradient(135deg, #1a1230, #200f40);
      border: 1px solid rgba(245,197,24,.25);
      border-radius: 16px;
      padding: 2.5rem 2rem;
      margin-top: 2rem;
      box-shadow: 0 0 60px rgba(106,61,232,.2);
      position: relative;
      overflow: hidden;
    }
    .book-preview-card::before {
      content: 'ॐ';
      position: absolute;
      top: -20px; right: 20px;
      font-size: 9rem;
      color: rgba(245,197,24,.04);
      font-family: 'Cinzel', serif;
      pointer-events: none;
    }

    /* Decorative top strip */
    .book-preview-card::after {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0;
      height: 3px;
      background: linear-gradient(to right, transparent, #f5c518, transparent);
    }

    /* Info row above iframe */
    .book-info-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 1rem;
      margin-bottom: 1.5rem;
    }
    .book-info-text {
      text-align: left;
    }
    .book-info-text h3 {
      font-family: 'Cinzel', serif;
      font-size: 1.1rem;
      color: #f5c518;
      letter-spacing: 2px;
      margin-bottom: .3rem;
    }
    .book-info-text p {
      color: #9d8fa5;
      font-size: .85rem;
      line-height: 1.6;
    }
    .book-features {
      display: flex;
      gap: .6rem;
      flex-wrap: wrap;
    }
    .book-feat-tag {
      background: rgba(245,197,24,.1);
      border: 1px solid rgba(245,197,24,.2);
      color: #f5c518;
      padding: .3rem .8rem;
      border-radius: 20px;
      font-size: .7rem;
      font-family: 'Cinzel', serif;
      letter-spacing: 1px;
    }

    /* iframe wrapper */
    .book-frame-wrap {
      width: 100%;
      border-radius: 10px;
      overflow: hidden;
      border: 1px solid rgba(245,197,24,.15);
      box-shadow: 0 10px 40px rgba(0,0,0,.5);
      position: relative;
    }
    .book-frame-wrap iframe {
      width: 100%;
      height: 600px;
      border: none;
      display: block;
      border-radius: 10px;
    }

    /* Fullscreen button */
    .book-fullscreen-btn {
      display: inline-flex;
      align-items: center;
      gap: .5rem;
      margin-top: 1.2rem;
      background: linear-gradient(135deg, #f5c518, #ffe066);
      color: #0a0612;
      border: none;
      padding: .75rem 2rem;
      border-radius: 4px;
      font-family: 'Cinzel', serif;
      font-size: .85rem;
      letter-spacing: 2px;
      cursor: pointer;
      font-weight: 700;
      transition: all .3s;
      box-shadow: 0 0 20px rgba(245,197,24,.3);
      text-decoration: none;
    }
    .book-fullscreen-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 0 35px rgba(245,197,24,.6);
    }

    /* Responsive */
    @media (max-width: 768px) {
      .book-frame-wrap iframe { height: 480px; }
      .book-info-row { flex-direction: column; }
    }
    @media (max-width: 480px) {
      .book-frame-wrap iframe { height: 380px; }
    }
  </style>



</head>
<body>

<div class="particles" id="particles"></div>

<!-- NAVBAR -->
<nav class="navbar">
  <div class="nav-logo">🪈 GitaPortal</div>
  <ul class="nav-links">
    <li><a href="#hero">Home</a></li>
    <li><a href="#votd">Daily Verse</a></li>
    <li><a href="#book">Sacred Book</a></li>
    <li><a href="#chapters">Chapters</a></li>
    <li><a href="#search-section">Search</a></li>
    <li><a href="#reflections">Reflect</a></li>
  </ul>
  <button class="music-btn" id="musicBtn">🎵 Music</button>
</nav>

<!-- HERO -->
<section class="hero" id="hero">
  <div class="hero-content">
    <p class="hero-sub">॥ श्रीमद्भगवद्गीता ॥</p>
    <h1 class="hero-title">Bhagavad Gita</h1>
    <p class="hero-tagline">The Song of the Divine — Wisdom for Every Soul</p>
    <div class="hero-btns">
      <a href="#book" class="btn btn-gold">Open the Sacred Book</a>
      <a href="#votd" class="btn btn-outline">Today's Verse</a>
    </div>
  </div>
  <div class="hero-peacock">🦚</div>
</section>



<!-- ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  STEP 2A : Paste this ABOVE your #votd section
  (find VERSE OF THE DAY in your PHP and paste before it)
  ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ -->
 
<div class="sanskrit-strip" id="strip-top">
  <div class="sanskrit-strip-track" id="track-top">
 
    <div class="strip-item"><span>ॐ नमो भगवते वासुदेवाय</span><span class="strip-divider">✦</span></div>
    <div class="strip-item"><span>श्रीमद्भगवद्गीता</span><span class="strip-divider">ॐ</span></div>
    <div class="strip-item"><span>कर्म एव धर्मः</span><span class="strip-divider">✦</span></div>
    <div class="strip-item"><span>सत्यं शिवं सुन्दरम्</span><span class="strip-divider">ॐ</span></div>
    <div class="strip-item"><span>योगः कर्मसु कौशलम्</span><span class="strip-divider">✦</span></div>
    <div class="strip-item"><span>हरे कृष्ण हरे राम</span><span class="strip-divider">ॐ</span></div>
    <div class="strip-item"><span>ॐ तत् सत्</span><span class="strip-divider">✦</span></div>
    <div class="strip-item"><span>जय श्री कृष्ण</span><span class="strip-divider">ॐ</span></div>
 
    <!-- duplicated for seamless loop -->
    <div class="strip-item"><span>ॐ नमो भगवते वासुदेवाय</span><span class="strip-divider">✦</span></div>
    <div class="strip-item"><span>श्रीमद्भगवद्गीता</span><span class="strip-divider">ॐ</span></div>
    <div class="strip-item"><span>कर्म एव धर्मः</span><span class="strip-divider">✦</span></div>
    <div class="strip-item"><span>सत्यं शिवं सुन्दरम्</span><span class="strip-divider">ॐ</span></div>
    <div class="strip-item"><span>योगः कर्मसु कौशलम्</span><span class="strip-divider">✦</span></div>
    <div class="strip-item"><span>हरे कृष्ण हरे राम</span><span class="strip-divider">ॐ</span></div>
    <div class="strip-item"><span>ॐ तत् सत्</span><span class="strip-divider">✦</span></div>
    <div class="strip-item"><span>जय श्री कृष्ण</span><span class="strip-divider">ॐ</span></div>
 
  </div>
</div>
 




<!-- VERSE OF THE DAY -->
<section class="votd-section" id="votd">
  <!-- <div class="section-label">📅 PHP-Powered Daily Selection</div> -->
  <h2 class="section-title">Verse of the Day</h2>
  <div class="votd-card">
    <div class="votd-meta">Chapter <?= $votd['chapter'] ?> · Verse <?= $votd['verse'] ?> · Theme: <span class="theme-tag"><?= ucfirst($votd['theme']) ?></span></div>
    <div class="votd-sanskrit"><?= nl2br(htmlspecialchars($votd['sanskrit'])) ?></div>
    <div class="votd-transliteration"><?= nl2br(htmlspecialchars($votd['transliteration'])) ?></div>
    <div class="votd-english">"<?= htmlspecialchars($votd['english']) ?>"</div>
    <button class="btn btn-gold speak-btn" onclick="speakText(`<?= addslashes($votd['english']) ?>`)">🔊 Speak This Verse</button>
  </div>
</section>




<!-- ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  STEP 2B : Paste this BELOW your #votd section
  (find SACRED BOOK SECTION in your PHP and paste before it)
  ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ -->
 
<div class="sanskrit-strip" id="strip-bottom">
  <div class="sanskrit-strip-track" id="track-bottom">
 
    <div class="strip-item"><span>ॐ नमो भगवते वासुदेवाय</span><span class="strip-divider">✦</span></div>
    <div class="strip-item"><span>श्रीमद्भगवद्गीता</span><span class="strip-divider">ॐ</span></div>
    <div class="strip-item"><span>कर्म एव धर्मः</span><span class="strip-divider">✦</span></div>
    <div class="strip-item"><span>सत्यं शिवं सुन्दरम्</span><span class="strip-divider">ॐ</span></div>
    <div class="strip-item"><span>योगः कर्मसु कौशलम्</span><span class="strip-divider">✦</span></div>
    <div class="strip-item"><span>हरे कृष्ण हरे राम</span><span class="strip-divider">ॐ</span></div>
    <div class="strip-item"><span>ॐ तत् सत्</span><span class="strip-divider">✦</span></div>
    <div class="strip-item"><span>जय श्री कृष्ण</span><span class="strip-divider">ॐ</span></div>
    <div class="strip-item"><span>ॐ नमो भगवते वासुदेवाय</span><span class="strip-divider">✦</span></div>
    <div class="strip-item"><span>श्रीमद्भगवद्गीता</span><span class="strip-divider">ॐ</span></div>
    <div class="strip-item"><span>कर्म एव धर्मः</span><span class="strip-divider">✦</span></div>
    <div class="strip-item"><span>सत्यं शिवं सुन्दरम्</span><span class="strip-divider">ॐ</span></div>
    <div class="strip-item"><span>योगः कर्मसु कौशलम्</span><span class="strip-divider">✦</span></div>
    <div class="strip-item"><span>हरे कृष्ण हरे राम</span><span class="strip-divider">ॐ</span></div>
    <div class="strip-item"><span>ॐ तत् सत्</span><span class="strip-divider">✦</span></div>
    <div class="strip-item"><span>जय श्री कृष्ण</span><span class="strip-divider">ॐ</span></div>
 


    <!-- duplicated for seamless loop -->
    <div class="strip-item"><span>ॐ नमो भगवते वासुदेवाय</span><span class="strip-divider">✦</span></div>
    <div class="strip-item"><span>श्रीमद्भगवद्गीता</span><span class="strip-divider">ॐ</span></div>
    <div class="strip-item"><span>कर्म एव धर्मः</span><span class="strip-divider">✦</span></div>
    <div class="strip-item"><span>सत्यं शिवं सुन्दरम्</span><span class="strip-divider">ॐ</span></div>
    <div class="strip-item"><span>योगः कर्मसु कौशलम्</span><span class="strip-divider">✦</span></div>
    <div class="strip-item"><span>हरे कृष्ण हरे राम</span><span class="strip-divider">ॐ</span></div>
    <div class="strip-item"><span>ॐ तत् सत्</span><span class="strip-divider">✦</span></div>
    <div class="strip-item"><span>जय श्री कृष्ण</span><span class="strip-divider">ॐ</span></div>
    <div class="strip-item"><span>ॐ नमो भगवते वासुदेवाय</span><span class="strip-divider">✦</span></div>
    <div class="strip-item"><span>श्रीमद्भगवद्गीता</span><span class="strip-divider">ॐ</span></div>
    <div class="strip-item"><span>कर्म एव धर्मः</span><span class="strip-divider">✦</span></div>
    <div class="strip-item"><span>सत्यं शिवं सुन्दरम्</span><span class="strip-divider">ॐ</span></div>
    <div class="strip-item"><span>योगः कर्मसु कौशलम्</span><span class="strip-divider">✦</span></div>
    <div class="strip-item"><span>हरे कृष्ण हरे राम</span><span class="strip-divider">ॐ</span></div>
    <div class="strip-item"><span>ॐ तत् सत्</span><span class="strip-divider">✦</span></div>
    <div class="strip-item"><span>जय श्री कृष्ण</span><span class="strip-divider">ॐ</span></div>
 

  </div>
</div>
 
 





<!-- ====== SACRED BOOK SECTION (gita_book.html embedded) ====== -->
<section class="book-section" id="book">
  <h2 class="section-title">The Sacred Book</h2>
  <p class="section-sub">Read all 18 chapters with Sanskrit, transliteration &amp; English</p>

  <div class="book-preview-card">

    <!-- Info row -->
    <div class="book-info-row">
      <div class="book-info-text">
        <h3>📖 Bhagavad Gita — Complete Edition</h3>
        <p>All 18 chapters · Key verses with Sanskrit &amp; English · Voice reading · Page navigation</p>
      </div>
      <div class="book-features">
        <span class="book-feat-tag">18 Chapters</span>
        <span class="book-feat-tag">🕉 Sanskrit Voice</span>
        <span class="book-feat-tag">🔊 English Voice</span>
        <span class="book-feat-tag">← → Navigate</span>
      </div>
    </div>

    <!-- Embedded gita_book.html -->
    <div class="book-frame-wrap">
      <iframe
        src="gita_book.html"
        title="Bhagavad Gita Sacred Book"
        loading="lazy"
        allowfullscreen
        allow="autoplay; speech; *"
      ></iframe>
    </div>

    <!-- Open in full tab
    <div style="text-align:center;margin-top:1.2rem">
      <a href="gita_book.html" target="_blank" class="book-fullscreen-btn">
        ⛶ &nbsp; Open Full Screen
      </a>
      <p style="color:#9d8fa5;font-size:.75rem;margin-top:.6rem;font-style:italic">
        💡 For the best experience, open in full screen · Use ← → arrow keys to turn pages
      </p>
    </div> -->

  </div>
</section>

<!-- ====== 3D BOOK ====== -->
<section class="book-section" id="book">
  <!-- <div <?php
$verses = json_decode(file_get_contents(__DIR__ . '/verses.json'), true);
$dayOfYear = date('z');
$votd = $verses[$dayOfYear % count($verses)];
$chapters = [
  1=>"Arjuna's Dilemma",2=>"Transcendental Knowledge",3=>"Path of Action",
  4=>"Wisdom in Action",5=>"Renunciation",6=>"Meditation",
  7=>"Knowledge of the Absolute",8=>"Attaining the Supreme",9=>"Royal Knowledge",
  10=>"Divine Glories",11=>"Universal Form",12=>"Path of Devotion",
  13=>"Nature & the Enjoyer",14=>"Three Qualities",15=>"Supreme Person",
  16=>"Divine & Demonic",17=>"Faith",18=>"Liberation"
];
?>

<!-- CHAPTERS -->
<section class="chapters-section" id="chapters">
  <div class="section-label">📚 18 Chapters of the Gita</div>
  <h2 class="section-title">Chapter Navigator</h2>
  <!-- <div class="chapters-grid">
    <?php foreach ($chapters as $num => $title): ?>
    <div class="chapter-card" onclick="loadChapter(<?= $num ?>)">
      <div class="chapter-num"><?= $num ?></div>
      <div class="chapter-title"><?= $title ?></div>
    </div>
    <?php endforeach; ?>
  </div> -->


<div class="chapters-grid">
  <?php foreach ($chapters as $num => $title): ?>
  <div class="chapter-card-wrap" data-chapter="<?= $num ?>">
    <canvas class="ch-canvas"></canvas>
    <div class="chapter-card" onclick="loadChapter(<?= $num ?>)">
      <div class="ch-holo"></div>
      <div class="ch-glow"></div>
      <div class="chapter-num"><?= $num ?></div>
      <div class="chapter-title"><?= $title ?></div>
    </div>
  </div>
  <?php endforeach; ?>
</div>




  <div class="chapter-result" id="chapterResult"></div>
</section>

<!-- SEARCH -->
<section class="search-section" id="search-section">
  <h2 class="section-title">Search the Verses</h2>
  <div class="search-box">
    <input type="text" id="searchInput" placeholder="Search by keyword, theme or chapter..."/>
    <button class="btn btn-gold" onclick="searchVerses()">Search</button>
  </div>
  <div class="theme-filters">
    <span class="filter-label">Filter by theme:</span>
    <?php $themes = array_unique(array_column($verses,'theme')); foreach($themes as $t): ?>
    <button class="theme-btn" onclick="filterByTheme('<?= $t ?>')"><?= ucfirst($t) ?></button>
    <?php endforeach; ?>
    <button class="theme-btn active" onclick="filterByTheme('')">All</button>
  </div>
  <div class="search-results" id="searchResults"></div>
</section>

<!-- REFLECTIONS -->
<section class="reflections-section" id="reflections">
  <h2 class="section-title">Leave a Reflection</h2>
  <p class="section-sub">Share how the Gita speaks to your heart</p>
  <div class="form-wrapper">
    <div id="formMsg" class="form-msg"></div>
    <div class="gita-form">
      <input type="text" id="rName" placeholder="Your Name"/>
      <input type="text" id="rVerse" placeholder="Your Favourite Verse (e.g. Chapter 2, Verse 47)"/>
      <textarea id="rReflection" placeholder="Share your reflection..." rows="4"></textarea>
      <button class="btn btn-gold" onclick="submitReflection()">🙏 Submit Reflection</button>
    </div>
    <div class="reflections-list" id="reflectionsList"></div>
  </div>
</section>





 
    <!-- FIX 3: OM symbols placed outside the path y range so they're visible -->
    <text
      id="om-left"
      x="18" y="62"
      font-size="18"
      fill="rgba(245,197,24,0.55)"
      font-family="serif"
      text-anchor="middle"
      dominant-baseline="middle"
    >ॐ</text>
 
    <text
      id="om-right"
      x="982" y="62"
      font-size="18"
      fill="rgba(245,197,24,0.55)"
      font-family="serif"
      text-anchor="middle"
      dominant-baseline="middle"
    >ॐ</text>
 
  </svg>





<footer class="footer">
  <div class="footer-om">ॐ</div>
  <p>॥ सर्वे भवन्तु सुखिनः ॥</p>
  <p>May all beings be happy · Bhagavad Gita Portal</p>
</footer>

<audio id="fluteAudio" loop>
  <source src="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3" type="audio/mpeg">
</audio>
<script>const verses = <?= json_encode($verses) ?>;</script>
<script src="js/main.js"></script>





<!-- ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  CHANGE 3 : Paste this entire <script> block just before </body>
  ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ -->
<script>
(function initChapterCards() {
 
  const COL = '#f5c518';   /* gold */
  const RGB = '245,197,24';
 
  document.querySelectorAll('.chapter-card-wrap').forEach(function(wrap) {
    const card   = wrap.querySelector('.chapter-card');
    const holo   = wrap.querySelector('.ch-holo');
    const canvas = wrap.querySelector('.ch-canvas');
    if (!card || !canvas) return;
 
    /* ── size canvas to match card ── */
    function syncCanvas() {
      const r = card.getBoundingClientRect();
      /* give extra room for particles to float outside card */
      canvas.width  = r.width  + 80;
      canvas.height = r.height + 80;
    }
    syncCanvas();
    window.addEventListener('resize', syncCanvas);
 
    const ctx = canvas.getContext('2d');
 
    /* ── create orbiting particles ── */
    const particles = [];
    const COUNT = 28;
 
    function mkParticle() {
      const cw = canvas.width, ch = canvas.height;
      const angle = Math.random() * Math.PI * 2;
      const r     = 60 + Math.random() * 50;
      const ox    = cw/2 + Math.cos(angle)*r;
      const oy    = ch/2 + Math.sin(angle)*r;
      return {
        x: ox, y: oy, ox: ox, oy: oy,
        vx: 0, vy: 0,
        sz:    Math.random() * 1.8 + 0.4,
        alpha: Math.random() * 0.5 + 0.2,
        phase: Math.random() * Math.PI * 2,
        burst: false, life: 1,
      };
    }
    for (var i = 0; i < COUNT; i++) particles.push(mkParticle());
 
    /* ── state ── */
    var inside = false;
    var mx = canvas.width/2, my = canvas.height/2;
    var tX = 0, tY = 0, ttX = 0, ttY = 0;
    var time = Math.random() * 100;
 
    function lerp(a, b, t) { return a + (b - a) * t; }
 
    /* ── mouse events ── */
    wrap.addEventListener('mouseenter', function() { inside = true; });
    wrap.addEventListener('mouseleave', function() {
      inside = false; ttX = 0; ttY = 0;
    });
 
    wrap.addEventListener('mousemove', function(e) {
      var r  = canvas.getBoundingClientRect();
      mx = e.clientX - r.left;
      my = e.clientY - r.top;
 
      var cw = canvas.width, ch = canvas.height;
      var dx = (mx - cw/2) / (cw/2);
      var dy = (my - ch/2) / (ch/2);
      ttX = -dy * 14;
      ttY =  dx * 14;
 
      /* holographic shimmer */
      var sx = ((e.clientX - card.getBoundingClientRect().left) / card.offsetWidth)  * 100;
      var sy = ((e.clientY - card.getBoundingClientRect().top)  / card.offsetHeight) * 100;
      var hue = sx * 2.5;
      holo.style.background =
        'radial-gradient(circle at ' + sx + '% ' + sy + '%, rgba(255,255,255,0.18) 0%, transparent 60%),' +
        'linear-gradient(' + hue + 'deg, rgba(' + RGB + ',0.07), rgba(255,255,255,0.04), rgba(' + RGB + ',0.05))';
    });
 
    /* burst on card click */
    card.addEventListener('click', function() {
      for (var b = 0; b < 10; b++) burstParticle(mx, my);
    });
 
    function burstParticle(x, y) {
      var angle = Math.random() * Math.PI * 2;
      var spd   = Math.random() * 4 + 1.5;
      particles.push({
        x: x, y: y, ox: x, oy: y,
        vx: Math.cos(angle) * spd,
        vy: Math.sin(angle) * spd - 1.5,
        sz: Math.random() * 2.5 + 1,
        alpha: 0.9, phase: 0,
        burst: true, life: 1,
      });
    }
 
    /* ── render loop ── */
    (function draw() {
      time += 0.016;
      var cw = canvas.width, ch = canvas.height;
 
      tX = lerp(tX, ttX, 0.09);
      tY = lerp(tY, ttY, 0.09);
 
      /* apply 3D tilt to card */
      card.style.transform =
        'perspective(800px) rotateX(' + tX + 'deg) rotateY(' + tY + 'deg) scale(' + (inside ? 1.06 : 1) + ')';
      card.style.boxShadow = inside
        ? '0 12px 40px rgba(245,197,24,0.25), 0 4px 12px rgba(0,0,0,0.4)'
        : '';
 
      ctx.clearRect(0, 0, cw, ch);
 
      /* draw particles */
      for (var pi = particles.length - 1; pi >= 0; pi--) {
        var p = particles[pi];
 
        if (p.burst) {
          p.vy   += 0.1;
          p.vx   *= 0.91; p.vy *= 0.91;
          p.x    += p.vx; p.y  += p.vy;
          p.life -= 0.035;
          if (p.life <= 0) { particles.splice(pi, 1); continue; }
          ctx.beginPath();
          ctx.arc(p.x, p.y, p.sz * p.life, 0, Math.PI * 2);
          ctx.fillStyle   = 'rgba(' + RGB + ',' + (p.life * 0.85) + ')';
          ctx.shadowBlur  = p.sz * 5;
          ctx.shadowColor = COL;
          ctx.fill();
          continue;
        }
 
        /* magnetic pull toward cursor */
        if (inside) {
          var ddx  = mx - p.x, ddy = my - p.y;
          var dist = Math.sqrt(ddx*ddx + ddy*ddy) + 1;
          var force = Math.min(70 / dist, 3.5);
          p.vx += ddx/dist * force * 0.08;
          p.vy += ddy/dist * force * 0.08;
        }
 
        /* spring back to orbit */
        p.vx += (p.ox - p.x) * 0.02;
        p.vy += (p.oy - p.y) * 0.02;
        p.vx *= 0.88; p.vy *= 0.88;
        p.x  += p.vx; p.y  += p.vy;
 
        var pulse = 0.5 + 0.5 * Math.sin(time * 2 + p.phase);
        var al    = p.alpha * (inside ? 0.5 + 0.5 * pulse : 0.2);
        var sz    = p.sz    * (inside ? 1   + 0.4 * pulse : 0.6);
 
        ctx.beginPath();
        ctx.arc(p.x, p.y, Math.max(sz, 0.3), 0, Math.PI * 2);
        ctx.fillStyle   = 'rgba(' + RGB + ',' + al + ')';
        ctx.shadowBlur  = inside ? sz * 5 : 1;
        ctx.shadowColor = COL;
        ctx.fill();
      }
 
      /* neural web lines between close particles */
      if (inside) {
        ctx.shadowBlur = 0;
        for (var a = 0; a < particles.length; a++) {
          for (var b2 = a + 1; b2 < particles.length; b2++) {
            var pa = particles[a], pb = particles[b2];
            if (pa.burst || pb.burst) continue;
            var ddx2 = pa.x - pb.x, ddy2 = pa.y - pb.y;
            var d = Math.sqrt(ddx2*ddx2 + ddy2*ddy2);
            if (d < 45) {
              ctx.beginPath();
              ctx.moveTo(pa.x, pa.y); ctx.lineTo(pb.x, pb.y);
              ctx.strokeStyle = 'rgba(' + RGB + ',' + ((1 - d/45) * 0.2) + ')';
              ctx.lineWidth   = 0.5;
              ctx.stroke();
            }
          }
        }
 
        /* radial glow under cursor */
        var grd = ctx.createRadialGradient(mx, my, 0, mx, my, 70);
        grd.addColorStop(0, 'rgba(' + RGB + ',0.1)');
        grd.addColorStop(1, 'transparent');
        ctx.fillStyle = grd;
        ctx.fillRect(0, 0, cw, ch);
      }
 
      requestAnimationFrame(draw);
    })();
 
  }); /* end forEach */
 
})();
</script>
 









</body>
</html>
<script src="js/main.js"></script>


<!-- ============================================================
     PASTE THIS ENTIRE BLOCK JUST BEFORE </body> IN YOUR index.php
     ============================================================ -->

<!-- STEP 1 : Cursor DOM elements (were missing from your HTML) -->
<div id="cursor-white"></div>
<div id="cursor-yellow"></div>

<!-- STEP 2 : Cursor + Glitter JavaScript (was completely missing) -->
<script>
(function () {
  const cw   = document.getElementById('cursor-white');
  const cy   = document.getElementById('cursor-yellow');

  /* safety check — if elements don't exist yet, abort */
  if (!cw || !cy) return;

  let mx = -300, my = -300;   // current mouse position
  let tx = -300, ty = -300;   // yellow circle lagging position
  let lastSpawn = 0;

  /* ── move white circle instantly ── */
  document.addEventListener('mousemove', function (e) {
    mx = e.clientX;
    my = e.clientY;

    cw.style.left = mx + 'px';
    cw.style.top  = my + 'px';

    /* spawn glitter trail every 22 ms */
    const now = Date.now();
    if (now - lastSpawn > 22) {
      lastSpawn = now;
      spawnGlitters(mx, my, 3, false);
    }
  });

  /* ── yellow circle lags behind with squash-stretch ── */
  function lerp(a, b, t) { return a + (b - a) * t; }

  (function animYellow() {
    tx = lerp(tx, mx, 0.13);
    ty = lerp(ty, my, 0.13);

    cy.style.left = tx + 'px';
    cy.style.top  = ty + 'px';

    /* squash-stretch based on speed */
    const dx   = mx - tx;
    const dy   = my - ty;
    const dist = Math.sqrt(dx * dx + dy * dy);
    const sx   = 1 + Math.min(dist * 0.02, 0.4);
    const sy   = 1 / sx * 0.82 + 0.18;
    cy.style.transform = 'translate(-50%,-50%) scaleX(' + sx + ') scaleY(' + sy + ')';

    requestAnimationFrame(animYellow);
  })();

  /* ── click = burst of glitters ── */
  document.addEventListener('mousedown', function () {
    spawnGlitters(mx, my, 28, true);
  });

  /* ── glitter colors ── */
  var WHITE_COLORS  = ['#ffffff', '#fffef0', '#f5f5ff', '#fffde8'];
  var YELLOW_COLORS = ['#ffe600', '#ffd000', '#ffee44', '#fff176', '#ffbb00', '#ffc400'];

  /* ── spawn N glitter particles ── */
  function spawnGlitters(x, y, n, burst) {
    for (var i = 0; i < n; i++) {
      var isWhite = Math.random() > 0.48;
      var col     = isWhite
        ? WHITE_COLORS [Math.floor(Math.random() * WHITE_COLORS.length)]
        : YELLOW_COLORS[Math.floor(Math.random() * YELLOW_COLORS.length)];

      var sz    = burst ? (Math.random() * 4 + 2)   : (Math.random() * 2.5 + 1);
      var angle = Math.random() * Math.PI * 2;
      var spd   = burst ? (Math.random() * 4 + 1.5) : (Math.random() * 1.2 + 0.2);
      var vx    = Math.cos(angle) * spd;
      var vy    = Math.sin(angle) * spd - (burst ? 1.5 : 0.8);

      /* create particle element */
      var el = document.createElement('div');
      el.className = 'glitter-particle';
      el.style.cssText = [
        'width:'      + sz + 'px',
        'height:'     + sz + 'px',
        'background:' + col,
        'left:'       + x  + 'px',
        'top:'        + y  + 'px',
        'box-shadow: 0 0 ' + (sz * 2) + 'px ' + sz + 'px ' + col + 'cc',
        'transform: translate(-50%,-50%)'
      ].join(';');
      document.body.appendChild(el);

      /* animate it */
      var life   = burst ? (0.8 + Math.random() * 0.4) : (0.45 + Math.random() * 0.35);
      var maxL   = life;
      var px     = x, py = y, grav = 0;

      (function animate(elem, pvx, pvy, plife, pmaxL, ppx, ppy, pgrav) {
        (function tick() {
          plife -= 0.028;
          pgrav += 0.055;
          ppx   += pvx;
          ppy   += pvy + pgrav;

          elem.style.left      = ppx + 'px';
          elem.style.top       = ppy + 'px';
          elem.style.opacity   = Math.max(plife / pmaxL, 0);
          elem.style.transform = 'translate(-50%,-50%) scale(' + (0.3 + plife / pmaxL * 0.7) + ')';

          if (plife > 0) {
            requestAnimationFrame(tick);
          } else {
            elem.remove();
          }
        })();
      })(el, vx, vy, life, maxL, px, py, grav);
    }
  }

})();
</script>



<!-- ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  STEP 3 : Paste this <script> just before </body>
  (GSAP must already be loaded before this — it is in your file)
  ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ -->
<script>
(function initSanskritStrips() {
 
  /* ── get both tracks ── */
  var trackTop    = document.getElementById('track-top');
  var trackBottom = document.getElementById('track-bottom');
  if (!trackTop || !trackBottom) return;
 
  /* ── base speed (px/sec) — positive = left, negative = right ── */
  var BASE_SPEED = 60;   /* px per second at rest          */
  var FAST_SPEED = 140;  /* px per second when scrolling   */
 
  /* current speed for each track (can be + or -) */
  var speedTop    = -BASE_SPEED;   /* top strip: moves LEFT  by default */
  var speedBottom =  BASE_SPEED;   /* bottom strip: moves RIGHT by default */
 
  /* scroll direction tracker */
  var scrollDir    = 0;   /*  1 = down, -1 = up, 0 = idle */
  var scrollTimer  = null;
 
  /* current pixel offset for each track */
  var offsetTop    = 0;
  var offsetBottom = 0;
 
  /* half-width of the track (we loop when we've moved one full half) */
  var halfTop    = trackTop.scrollWidth    / 2;
  var halfBottom = trackBottom.scrollWidth / 2;
 
  /* ── smooth speed lerp ── */
  var currentSpeedTop    = speedTop;
  var currentSpeedBottom = speedBottom;
 
  /* ── wheel listener ── */
  window.addEventListener('wheel', function (e) {
 
    clearTimeout(scrollTimer);
 
    if (e.deltaY > 0) {
      /* scrolling DOWN → strips move faster, top goes RIGHT */
      speedTop    =  FAST_SPEED;   /* reverse top strip to RIGHT */
      speedBottom =  FAST_SPEED;   /* bottom strip also RIGHT    */
 
      /* rotate any star/om dividers for fun */
      gsap.to('.strip-divider', { rotate: 180, duration: 0.6, ease: 'power2.out' });
 
    } else {
      /* scrolling UP → top strip goes LEFT, bottom goes RIGHT (reversed) */
      speedTop    = -FAST_SPEED;
      speedBottom = -FAST_SPEED;
 
      gsap.to('.strip-divider', { rotate: 0, duration: 0.6, ease: 'power2.out' });
    }
 
    /* after 800ms of no scroll, return to base speed */
    scrollTimer = setTimeout(function () {
      speedTop    = -BASE_SPEED;
      speedBottom =  BASE_SPEED;
    }, 800);
 
  }, { passive: true });
 
  /* ── rAF loop for smooth infinite scroll ── */
  var lastTime = performance.now();
 
  function tick(now) {
    var dt = (now - lastTime) / 1000;   /* seconds since last frame */
    lastTime = now;
 
    /* lerp current speeds toward target for smooth acceleration */
    currentSpeedTop    += (speedTop    - currentSpeedTop)    * Math.min(dt * 4, 1);
    currentSpeedBottom += (speedBottom - currentSpeedBottom) * Math.min(dt * 4, 1);
 
    /* advance offsets */
    offsetTop    += currentSpeedTop    * dt;
    offsetBottom += currentSpeedBottom * dt;
 
    /* seamless loop: when we've moved a full half-width, reset */
    halfTop    = trackTop.scrollWidth    / 2;
    halfBottom = trackBottom.scrollWidth / 2;
 
    /* wrap top */
    if (offsetTop >=  halfTop)  offsetTop -= halfTop;
    if (offsetTop <= -halfTop)  offsetTop += halfTop;
 
    /* wrap bottom */
    if (offsetBottom >=  halfBottom) offsetBottom -= halfBottom;
    if (offsetBottom <= -halfBottom) offsetBottom += halfBottom;
 
    trackTop.style.transform    = 'translateX(' + offsetTop    + 'px)';
    trackBottom.style.transform = 'translateX(' + offsetBottom + 'px)';
 
    requestAnimationFrame(tick);
  }
 
  requestAnimationFrame(tick);
 
})();
</script>
</body>
</html>