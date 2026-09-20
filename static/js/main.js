/* ============================================
   BHAGAVAD GITA PORTAL — main.js
   ============================================ */

// ======== PARTICLES ========
(function(){
  const c = document.getElementById('particles');
  if (!c) return;
  for(let i=0;i<40;i++){
    const p=document.createElement('div');
    p.className='particle';
    p.style.cssText=`left:${Math.random()*100}vw;width:${Math.random()*4+1}px;height:${Math.random()*4+1}px;animation-duration:${Math.random()*12+8}s;animation-delay:${Math.random()*10}s`;
    c.appendChild(p);
  }
})();

// ======== MUSIC ========
const audio    = document.getElementById('fluteAudio');
const musicBtn = document.getElementById('musicBtn');
let playing    = false;
if (musicBtn && audio) {
  musicBtn.addEventListener('click',()=>{
    playing ? audio.pause() : audio.play().catch(()=>{});
    playing = !playing;
    musicBtn.textContent = playing ? '🔇 Stop' : '🎵 Music';
    musicBtn.classList.toggle('playing', playing);
  });
}

// ======== TTS HELPERS ========
function speakText(text, lang='en-US'){
  if(!window.speechSynthesis) return;
  window.speechSynthesis.cancel();
  const u = new SpeechSynthesisUtterance(text);
  u.lang  = 'en-US';
  u.rate  = 0.8;
  u.pitch = 0.95;
  const voices = window.speechSynthesis.getVoices();
  const v = voices.find(v=>v.lang===lang) || voices.find(v=>v.name.includes('Google'));
  if(v) u.voice = v;
  window.speechSynthesis.speak(u);
}

// Sanskrit shlok spoken in Hindi voice (closest to Sanskrit)
function speakSanskrit(){
  const text = 'यदा यदा हि धर्मस्य ग्लानिर्भवति भारत। अभ्युत्थानमधर्मस्य तदात्मानं सृजाम्यहम्॥ परित्राणाय साधूनां विनाशाय च दुष्कृताम्। धर्मसंस्थापनार्थाय सम्भवामि युगे युगे॥';
  if(!window.speechSynthesis) return;
  window.speechSynthesis.cancel();
  const u = new SpeechSynthesisUtterance(text);
  u.lang  = 'hi-IN';
  u.rate  = 0.65;
  u.pitch = 0.85;
  const voices = window.speechSynthesis.getVoices();
  const v = voices.find(v=>v.lang==='hi-IN') || voices.find(v=>v.lang.startsWith('hi'));
  if(v) u.voice = v;
  window.speechSynthesis.speak(u);
}

function speakEnglish(text){
  if(!text){
    text = 'Whenever and wherever there is a decline in righteousness, I shall appear.';
  }
  if(!window.speechSynthesis) return;
  window.speechSynthesis.cancel();

  const u = new SpeechSynthesisUtterance(text);
  u.lang  = 'en-US';
  u.rate  = 0.82;
  u.pitch = 1.0;

  function doSpeak(){
    const voices = window.speechSynthesis.getVoices();
    const v = voices.find(v => v.lang === 'en-US') ||
              voices.find(v => v.lang.startsWith('en')) ||
              voices.find(v => v.default);
    if(v) u.voice = v;
    window.speechSynthesis.speak(u);
  }

  if(window.speechSynthesis.getVoices().length > 0){
    doSpeak();
  } else {
    window.speechSynthesis.onvoiceschanged = doSpeak;
  }
}

// ======== 4-STAGE SCROLL BOOK ========
(function initBook(){
  const container  = document.getElementById('bookScrollContainer');
  const scrollHint = document.getElementById('scrollHint');

  const s1 = document.getElementById('stageClosed');
  const s2 = document.getElementById('stageOpening');
  const s3 = document.getElementById('stageFlipping');
  const s4 = document.getElementById('stageFinal');

  const obCover = document.getElementById('obCover');

  let stage = 1;
  let locked = false;

  function showStage(n){
    [s1,s2,s3,s4].forEach((s,i)=>{
      if(!s) return;
      if(i+1===n){
        s.style.display='flex';
        requestAnimationFrame(()=>{ s.classList.add('active'); });
      } else {
        s.classList.remove('active');
        setTimeout(()=>{ if(stage!==i+1) s.style.display='none'; }, 600);
      }
    });
    stage = n;
  }

  if (s1) {
    s1.style.display='flex';
    s1.classList.add('active');
  }

  window.addEventListener('scroll',()=>{
    if(!container || locked) return;
    const rect    = container.getBoundingClientRect();
    const total   = container.offsetHeight - window.innerHeight;
    const scrolled = Math.max(0, Math.min(1, -rect.top / total));

    if(scrollHint) scrollHint.style.opacity = Math.max(0, 1 - scrolled*6);

    if(scrolled >= 0.18 && stage === 1){
      showStage(2);
      requestAnimationFrame(()=>{
        if(obCover) setTimeout(()=>{ obCover.classList.add('flip-go'); }, 80);
      });

      setTimeout(()=>{
        if(stage===2) showStage(3);

        setTimeout(()=>{
          if(stage===3) showStage(4);
          locked = true;
        }, 3800);

      }, 1500);
    }
  });
})();

// ======== CHAPTER NAVIGATOR ========
function loadChapter(num){
  const result  = document.getElementById('chapterResult');
  if(!result || typeof verses === 'undefined') return;
  const ch = verses.filter(v=>v.chapter===num);

  document.querySelectorAll('.chapter-card').forEach((c,i)=>{
    const active = (i+1===num);
    c.style.borderColor = active ? 'var(--gold)' : '';
    c.style.background  = active ? 'rgba(245,197,24,.1)' : '';
  });

  if(!ch.length){
    result.innerHTML=`<p style="color:var(--text-muted);text-align:center">No verses stored for Chapter ${num} yet.</p>`;
  } else {
    result.innerHTML = `
      <div style="font-family:var(--font-heading);color:var(--gold);margin-bottom:1rem;font-size:.8rem;letter-spacing:2px">
        CHAPTER ${num} — ${ch.length} VERSE(S)
      </div>
      ${ch.map(v=>`
        <div style="margin-bottom:1.5rem;padding-bottom:1.5rem;border-bottom:1px solid var(--border)">
          <div style="color:var(--lotus);font-size:.72rem;letter-spacing:2px;font-family:var(--font-heading);margin-bottom:.4rem">VERSE ${v.verse} · ${v.theme.toUpperCase()}</div>
          <div style="color:var(--text-sanskrit);font-family:var(--font-heading);line-height:1.8;margin-bottom:.5rem">${v.sanskrit}</div>
          <div style="color:var(--text-muted);font-style:italic;line-height:1.7;font-size:.9rem;margin-bottom:.6rem">"${v.english}"</div>
          <button class="result-speak" onclick="speakText('${v.english.replace(/'/g,"\\'")}')">🔊 Speak</button>
        </div>
      `).join('')}`;
  }
  result.classList.add('visible');
  result.scrollIntoView({behavior:'smooth',block:'nearest'});
}

// ======== SEARCH ========
function searchVerses(){
  const searchInput = document.getElementById('searchInput');
  if(!searchInput || typeof verses === 'undefined') return;
  const q = searchInput.value.trim().toLowerCase();
  if(!q){ renderResults(verses); return; }
  renderResults(verses.filter(v=>
    v.english.toLowerCase().includes(q)||
    v.theme.toLowerCase().includes(q)||
    v.transliteration.toLowerCase().includes(q)||
    String(v.chapter).includes(q)
  ));
}

function filterByTheme(theme){
  if(typeof verses === 'undefined') return;
  document.querySelectorAll('.theme-btn').forEach(b=>{
    b.classList.toggle('active', b.textContent.toLowerCase()===(theme||'all'));
  });
  renderResults(theme ? verses.filter(v=>v.theme===theme) : verses);
}

function renderResults(list){
  const c = document.getElementById('searchResults');
  if(!c) return;
  if(!list || !list.length){
    c.innerHTML=`<p style="color:var(--text-muted);text-align:center;padding:2rem">No verses found.</p>`;
    return;
  }
  c.innerHTML = list.map(v=>`
    <div class="result-card">
      <div class="result-meta">Chapter ${v.chapter} · Verse ${v.verse} · ${v.theme.toUpperCase()}</div>
      <div class="result-sanskrit">${v.sanskrit}</div>
      <div class="result-english">"${v.english}"</div>
      <button class="result-speak" onclick="speakText('${v.english.replace(/'/g,"\\'")}')">🔊 Speak this Verse</button>
    </div>
  `).join('');
}

if(typeof verses !== 'undefined'){
  renderResults(verses);
}

const searchEl = document.getElementById('searchInput');
if(searchEl){
  searchEl.addEventListener('keydown',e=>{
    if(e.key==='Enter') searchVerses();
  });
}

// Helper to extract CSRF token from cookies
function getCookie(name) {
  let cookieValue = null;
  if (document.cookie && document.cookie !== '') {
    const cookies = document.cookie.split(';');
    for (let i = 0; i < cookies.length; i++) {
      const cookie = cookies[i].trim();
      if (cookie.substring(0, name.length + 1) === (name + '=')) {
        cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
        break;
      }
    }
  }
  return cookieValue;
}

// ======== REFLECTIONS ========
function submitReflection(){
  const nameEl       = document.getElementById('rName');
  const verseEl      = document.getElementById('rVerse');
  const reflEl       = document.getElementById('rReflection');
  const msg          = document.getElementById('formMsg');

  if(!nameEl || !reflEl || !msg) return;

  const name       = nameEl.value.trim();
  const verse      = verseEl ? verseEl.value.trim() : '';
  const reflection = reflEl.value.trim();

  if(!name||!reflection){
    msg.className='form-msg error';
    msg.textContent='🙏 Please enter your name and reflection.';
    return;
  }

  const fd = new FormData();
  fd.append('name',name);
  fd.append('verse',verse);
  fd.append('reflection',reflection);

  const csrftoken = getCookie('csrftoken');
  const headers = {};
  if(csrftoken){
    headers['X-CSRFToken'] = csrftoken;
  }

  fetch('submit.php',{
    method:'POST',
    headers: headers,
    body:fd
  })
    .then(r=>r.json())
    .then(d=>{
      if(d.success){
        msg.className='form-msg success';
        msg.textContent='🙏 '+d.message;
        nameEl.value='';
        if(verseEl) verseEl.value='';
        reflEl.value='';
        loadReflections();
      } else {
        msg.className='form-msg error';
        msg.textContent='⚠️ '+d.message;
      }
    })
    .catch(()=>{
      msg.className='form-msg success';
      msg.textContent='🙏 Reflection noted!';
      addReflectionToDOM({name,verse,reflection});
    });
}

function loadReflections(){
  const listEl = document.getElementById('reflectionsList');
  if(!listEl) return;

  fetch('submit.php?action=get')
    .then(r=>r.json())
    .then(d=>{ if(d.reflections) listEl.innerHTML=d.reflections.map(r=>reflHTML(r)).join(''); })
    .catch(()=>{});
}

function reflHTML(r){
  return `<div class="reflection-item">
    <div class="reflection-name">🙏 ${esc(r.name)}</div>
    <div class="reflection-verse">${r.verse?'📖 '+esc(r.verse):''}</div>
    <div class="reflection-text">"${esc(r.reflection)}"</div>
  </div>`;
}
function addReflectionToDOM(r){
  const listEl = document.getElementById('reflectionsList');
  if(listEl) listEl.insertAdjacentHTML('afterbegin',reflHTML(r));
}
function esc(s){ return s ? s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;') : ''; }

loadReflections();

// ======== NAVBAR HIGHLIGHT ========
window.addEventListener('scroll',()=>{
  const y = window.scrollY;
  document.querySelectorAll('section[id]').forEach(sec=>{
    const top = sec.offsetTop-100;
    const link = document.querySelector(`.nav-links a[href="#${sec.id}"]`);
    if(link) link.style.color = (y>=top && y<top+sec.offsetHeight) ? 'var(--gold)' : '';
  });
});