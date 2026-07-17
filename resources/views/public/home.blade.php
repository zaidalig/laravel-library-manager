<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="Cedar Stack Library — stories, study, and community under one roof.">
    <title>Cedar Stack — Find your next chapter</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset_cdn('fontawesome','vendor/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset_cdn('bootstrap_css','vendor/bootstrap/bootstrap.min.css') }}">
    <style>
        :root{--ink:#1f1a14;--muted:#6d6458;--line:#e2d8c8;--paper:#f7f2e8;--cedar:#8b4513;--leaf:#2f5d50;--sand:#efe6d6}
        *{box-sizing:border-box}html{scroll-behavior:smooth}body{font-family:"DM Sans",sans-serif;color:var(--ink);background:var(--paper);overflow-x:hidden}
        .serif{font-family:"Libre Baskerville",serif}
        .navbar{background:rgba(247,242,232,.92);backdrop-filter:blur(18px);border-bottom:1px solid rgba(31,26,20,.08)}
        .navbar-brand{font-family:"Libre Baskerville";font-weight:700;font-size:1.2rem}
        .mark{width:34px;height:34px;border-radius:10px;background:var(--cedar);color:#fff;display:grid;place-items:center}
        .nav-link{color:#5a5146!important;font-weight:600;font-size:.92rem}.btn{border-radius:10px;font-weight:700;padding:.75rem 1.15rem}
        .btn-cedar{background:var(--cedar);border-color:var(--cedar);color:#fff}.btn-cedar:hover{background:#6e3610;color:#fff;transform:translateY(-2px)}
        .hero{padding:9rem 0 5rem;min-height:840px;background:radial-gradient(circle at 80% 10%,#efe4d0,transparent 28%),var(--paper)}
        .hero h1{font-size:clamp(3.4rem,7vw,6.6rem);line-height:.95}.hero-copy{max-width:560px;color:var(--muted);font-size:1.14rem}
        .hero-shelf{height:560px;border-radius:24px;background:linear-gradient(180deg,transparent 50%,rgba(31,26,20,.45)),url("https://images.unsplash.com/photo-1507842217343-583bb7270b66?auto=format&fit=crop&w=1400&q=85") center/cover;box-shadow:0 35px 80px rgba(40,30,20,.2);position:relative;animation:enter 1s both}
        .shelf-note{position:absolute;left:24px;bottom:24px;color:#fff}.section{padding:7rem 0}
        .kicker{color:var(--leaf);font-size:.75rem;text-transform:uppercase;letter-spacing:.14em;font-weight:800}
        .title{font-family:"Libre Baskerville";font-size:clamp(2.4rem,4.5vw,4.2rem);line-height:1.05}
        .book-card{background:#fff;border:1px solid var(--line);border-radius:18px;overflow:hidden;height:100%;transition:.35s}.book-card:hover{transform:translateY(-8px);box-shadow:0 22px 50px rgba(40,30,20,.12)}
        .book-cover{height:240px;background-size:cover;background-position:center}.genre-chip{display:inline-flex;align-items:center;gap:.4rem;padding:.55rem 1rem;border:1px solid var(--line);border-radius:999px;background:#fff;color:var(--ink);text-decoration:none;font-weight:600;font-size:.9rem;transition:.2s}
        .genre-chip:hover{border-color:var(--cedar);color:var(--cedar)}
        .membership{background:var(--ink);color:#fff;border-radius:28px;overflow:hidden}.member-img{min-height:520px;background:url("https://images.unsplash.com/photo-1481627834876-b7833e8f5570?auto=format&fit=crop&w=1100&q=85") center/cover}
        .perk{display:flex;gap:1rem;padding:1rem 0;border-bottom:1px solid rgba(255,255,255,.12)}.perk:last-child{border:0}
        .cta{background:var(--sand);border-radius:28px;padding:clamp(2rem,5vw,4rem)}.footer{background:#17120e;color:#cbbfaf;padding:4rem 0 2rem}
        .reveal{opacity:0;transform:translateY(24px);transition:.75s cubic-bezier(.2,.8,.2,1)}.reveal.visible{opacity:1;transform:none}
        @keyframes enter{from{opacity:0;transform:translateY(30px)}to{opacity:1;transform:none}}
        @media(max-width:991px){.hero{padding-top:7rem}.hero-shelf{height:420px}.section{padding:5rem 0}}
        @media(prefers-reduced-motion:reduce){*{animation:none!important;transition:none!important}.reveal{opacity:1;transform:none}}
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg fixed-top py-3"><div class="container">
    <a class="navbar-brand d-flex align-items-center gap-2" href="#"><span class="mark"><i class="fa-solid fa-book-open"></i></span>Cedar Stack</a>
    <button class="navbar-toggler border-0" data-bs-toggle="collapse" data-bs-target="#nav"><span class="navbar-toggler-icon"></span></button>
    <div class="collapse navbar-collapse" id="nav">
        <div class="navbar-nav mx-auto gap-lg-3"><a class="nav-link" href="#picks">Staff picks</a><a class="nav-link" href="#genres">Browse</a><a class="nav-link" href="#join">Membership</a></div>
        @auth<a class="btn btn-dark btn-sm" href="{{ route('dashboard') }}">Dashboard</a>@else<a class="btn btn-dark btn-sm" href="{{ route('login') }}">Staff login</a>@endauth
    </div>
</div></nav>
<main>
<section class="hero"><div class="container"><div class="row align-items-center g-5">
    <div class="col-lg-7"><div class="kicker mb-4">Public library · Free for everyone</div>
        <h1 class="serif mb-4">Find your next chapter.</h1>
        <p class="hero-copy mb-4">Quiet corners, curious collections, and a community that still believes in the magic of a good book—and a good seat by the window.</p>
        <div class="d-flex flex-wrap gap-2"><a href="#picks" class="btn btn-cedar btn-lg">See staff picks</a><a href="#join" class="btn btn-outline-dark btn-lg">Get a library card</a></div>
    </div>
    <div class="col-lg-5"><div class="hero-shelf"><div class="shelf-note"><small class="text-uppercase">Open today</small><h3 class="serif h4 mb-0">9 AM – 8 PM</h3></div></div></div>
</div></div></section>

<section class="section" id="picks"><div class="container">
    <div class="row align-items-end mb-5 reveal"><div class="col-lg-8"><div class="kicker mb-3">This month</div><h2 class="title mb-0">Staff picks worth borrowing.</h2></div>
    <div class="col-lg-4"><p class="text-secondary mb-0">Hand-chosen by librarians who read widely and recommend honestly.</p></div></div>
    <div class="row g-4">
        <div class="col-md-4 reveal"><article class="book-card"><div class="book-cover" style="background-image:url('https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&w=800&q=85')"></div><div class="p-4"><small class="text-secondary">Fiction</small><h3 class="h5 fw-bold mt-1">The Quiet Harbor</h3><p class="small text-secondary mb-0">A coastal novel about belonging, letters, and second chances.</p></div></article></div>
        <div class="col-md-4 reveal"><article class="book-card"><div class="book-cover" style="background-image:url('https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&w=800&q=85')"></div><div class="p-4"><small class="text-secondary">Science</small><h3 class="h5 fw-bold mt-1">How Forests Think</h3><p class="small text-secondary mb-0">An accessible journey into ecosystems and deep time.</p></div></article></div>
        <div class="col-md-4 reveal"><article class="book-card"><div class="book-cover" style="background-image:url('https://images.unsplash.com/photo-1495446815904-a1ea4f7c9d8a?auto=format&fit=crop&w=800&q=85')"></div><div class="p-4"><small class="text-secondary">Young readers</small><h3 class="h5 fw-bold mt-1">Maps & Moonlight</h3><p class="small text-secondary mb-0">Adventure, friendship, and a city that wakes after dark.</p></div></article></div>
    </div>
</div></section>

<section class="section pt-0" id="genres"><div class="container reveal">
    <div class="kicker mb-3">Browse by genre</div><h2 class="title mb-4">Something for every mood.</h2>
    <div class="d-flex flex-wrap gap-2">
        <a class="genre-chip" href="#"><i class="fa-solid fa-feather text-success"></i> Fiction</a>
        <a class="genre-chip" href="#"><i class="fa-solid fa-atom text-success"></i> Science</a>
        <a class="genre-chip" href="#"><i class="fa-solid fa-clock-rotate-left text-success"></i> History</a>
        <a class="genre-chip" href="#"><i class="fa-solid fa-child text-success"></i> Kids</a>
        <a class="genre-chip" href="#"><i class="fa-solid fa-lightbulb text-success"></i> Biography</a>
        <a class="genre-chip" href="#"><i class="fa-solid fa-globe text-success"></i> Travel</a>
        <a class="genre-chip" href="#"><i class="fa-solid fa-music text-success"></i> Arts</a>
    </div>
</div></section>

<section class="section pt-0" id="join"><div class="container"><div class="membership reveal"><div class="row g-0 align-items-center">
    <div class="col-lg-6 member-img"></div>
    <div class="col-lg-6 p-5">
        <div class="kicker text-warning mb-3">Join free</div><h2 class="title mb-4">Your card opens everything.</h2>
        <div class="perk"><i class="fa-solid fa-book mt-1 text-warning"></i><div><strong>Borrow books & media</strong><small class="d-block text-white-50">Novels, audiobooks, magazines, and more.</small></div></div>
        <div class="perk"><i class="fa-solid fa-wifi mt-1 text-warning"></i><div><strong>Study spaces & Wi‑Fi</strong><small class="d-block text-white-50">Quiet rooms, group tables, and power everywhere.</small></div></div>
        <div class="perk"><i class="fa-solid fa-users mt-1 text-warning"></i><div><strong>Events for all ages</strong><small class="d-block text-white-50">Storytime, author talks, and weekend workshops.</small></div></div>
        <a href="mailto:hello@cedarstack.test" class="btn btn-cedar mt-3">Get a library card</a>
    </div>
</div></div></div></section>

<section class="section pt-0"><div class="container"><div class="cta reveal"><div class="row align-items-center">
    <div class="col-lg-8"><div class="kicker text-dark mb-3">Hours</div><h2 class="title mb-2">Come browse awhile.</h2><p class="mb-0">Mon–Thu 9–8 · Fri–Sat 9–6 · Sun 12–5 · 41 Cedar Avenue</p></div>
    <div class="col-lg-4 text-lg-end"><a href="mailto:hello@cedarstack.test" class="btn btn-cedar btn-lg">Ask a librarian</a></div>
</div></div></div></section>
</main>
<footer class="footer"><div class="container"><div class="row g-4">
    <div class="col-lg-6"><h3 class="serif">Cedar Stack Library</h3><p class="text-white-50">Stories, study, and community under one roof.</p></div>
    <div class="col-6 col-lg-3"><strong>Explore</strong><div class="small text-white-50 mt-2">Catalog<br>Events<br>Kids & teens</div></div>
    <div class="col-6 col-lg-3"><strong>Contact</strong><div class="small text-white-50 mt-2">hello@cedarstack.test<br>+1 555 014 3434</div></div>
</div><hr class="border-secondary"><small class="text-white-50">© {{ date('Y') }} Cedar Stack Library.</small></div></footer>
<script src="{{ asset_cdn('bootstrap_js','vendor/bootstrap/bootstrap.bundle.min.js') }}"></script>
<script>const o=new IntersectionObserver(es=>es.forEach(e=>{if(e.isIntersecting){e.target.classList.add('visible');o.unobserve(e.target)}}),{threshold:.12});document.querySelectorAll('.reveal').forEach(el=>o.observe(el));</script>
</body>
</html>
