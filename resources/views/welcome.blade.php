<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Theater Aurora - De Magie van het Podium</title>
    <meta name="description" content="Welkom bij Theater Aurora. Reserveer eenvoudig uw tickets voor de mooiste voorstellingen en beleef de magie van het podium in ons premium theater.">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Outfit:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --gold: #d4af37;
            --gold-hover: #f1c40f;
            --gold-glow: rgba(212, 175, 55, 0.4);
            --dark-bg: #070709;
            --surface: #121216;
            --card-bg: rgba(255, 255, 255, 0.02);
            --border-glass: rgba(255, 255, 255, 0.05);
            --text-main: #fcfcfc;
            --text-muted: #9aa0a6;
            --accent-red: #8b0000;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--dark-bg);
            color: var(--text-main);
            line-height: 1.6;
            overflow-x: hidden;
        }

        h1, h2, h3, .logo {
            font-family: 'Playfair Display', serif;
        }

        /* Utility */
        .container {
            width: 90%;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Scroll Animations */
        .reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: all 1s cubic-bezier(0.25, 0.8, 0.25, 1);
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* Navbar */
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 5%;
            background: transparent;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            transition: all 0.4s ease;
            border-bottom: 1px solid transparent;
        }
        nav.scrolled {
            background: rgba(7, 7, 9, 0.85);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border-glass);
            padding: 1rem 5%;
        }

        .logo {
            font-size: 2.2rem;
            color: var(--text-main);
            font-weight: 700;
            text-decoration: none;
            letter-spacing: 2px;
            position: relative;
        }
        .logo span { color: var(--gold); }

        .nav-links {
            display: flex;
            gap: 2.5rem;
            list-style: none;
            align-items: center;
        }

        .nav-links a {
            color: var(--text-main);
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            transition: color 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            position: relative;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--gold);
            transition: width 0.3s ease;
        }

        .nav-links a:hover::after { width: 100%; }
        .nav-links a:hover { color: var(--gold); }

        .btn-login {
            border: 1px solid var(--border-glass);
            padding: 0.6rem 1.8rem;
            border-radius: 30px;
            color: var(--text-main) !important;
            transition: all 0.3s ease !important;
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(5px);
        }

        .btn-login:hover {
            background: var(--gold);
            color: var(--dark-bg) !important;
            border-color: var(--gold);
            box-shadow: 0 0 15px var(--gold-glow);
        }

        /* Hero Section */
        .hero {
            height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .hero-bg {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: url('https://images.unsplash.com/photo-1507676184212-d0c30a510c55?q=80&w=2070&auto=format&fit=crop') center/cover no-repeat;
            z-index: -2;
            transform: scale(1.05);
            animation: slowZoom 20s infinite alternate;
        }

        @keyframes slowZoom {
            from { transform: scale(1); }
            to { transform: scale(1.1); }
        }

        .hero-overlay {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(90deg, rgba(7,7,9,0.9) 0%, rgba(7,7,9,0.5) 50%, rgba(7,7,9,0.2) 100%),
                        radial-gradient(circle at top right, rgba(212, 175, 55, 0.15) 0%, transparent 50%);
            z-index: -1;
        }

        .hero-content {
            padding: 0 5%;
            max-width: 800px;
        }

        .badge {
            display: inline-block;
            padding: 0.4rem 1rem;
            border: 1px solid var(--gold);
            color: var(--gold);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            border-radius: 20px;
            margin-bottom: 1.5rem;
            animation: fadeUp 1s ease forwards 0.2s;
            opacity: 0;
        }

        .hero h1 {
            font-size: 5.5rem;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            color: #fff;
            animation: fadeUp 1s ease forwards 0.5s;
            opacity: 0;
        }
        
        .hero h1 span {
            color: var(--gold);
            font-style: italic;
        }

        .hero p {
            font-size: 1.25rem;
            color: var(--text-muted);
            margin-bottom: 2.5rem;
            animation: fadeUp 1s ease forwards 0.8s;
            opacity: 0;
            font-weight: 300;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--gold);
            color: var(--dark-bg);
            padding: 1.2rem 3rem;
            font-size: 1rem;
            font-weight: 700;
            text-decoration: none;
            border-radius: 2px;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
            position: relative;
            overflow: hidden;
            animation: fadeUp 1s ease forwards 1.1s;
            opacity: 0;
            border: none;
            cursor: pointer;
        }

        .btn-primary:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 30px var(--gold-glow);
            background: #fff;
        }

        /* Featured Blockbuster */
        .featured {
            padding: 8rem 0;
            background: var(--dark-bg);
            position: relative;
        }

        .featured-wrapper {
            display: flex;
            align-items: center;
            gap: 4rem;
            background: var(--surface);
            border-radius: 24px;
            padding: 4rem;
            border: 1px solid var(--border-glass);
            position: relative;
            overflow: hidden;
        }

        .featured-wrapper::before {
            content: '';
            position: absolute;
            top: -50%; left: -50%; width: 200%; height: 200%;
            background: radial-gradient(circle, rgba(139,0,0,0.1) 0%, transparent 60%);
            z-index: 0;
        }

        .featured-img {
            flex: 1;
            border-radius: 16px;
            overflow: hidden;
            position: relative;
            z-index: 1;
            box-shadow: 0 20px 50px rgba(0,0,0,0.5);
        }

        .featured-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.7s;
        }
        
        .featured-wrapper:hover .featured-img img {
            transform: scale(1.05);
        }

        .featured-content {
            flex: 1;
            z-index: 1;
        }

        .featured-content h2 {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #fff;
        }

        /* Shows Grid */
        .shows {
            padding: 5rem 0;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 4rem;
        }

        .section-title {
            font-size: 3.5rem;
            color: #fff;
        }

        .shows-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 3rem;
        }

        .show-card {
            background: var(--surface);
            border: 1px solid var(--border-glass);
            border-radius: 16px;
            overflow: hidden;
            transition: transform 0.5s ease, box-shadow 0.5s ease, border-color 0.5s ease;
            position: relative;
            cursor: pointer;
        }

        .show-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.8);
            border-color: rgba(212, 175, 55, 0.4);
        }

        .show-img {
            height: 250px;
            background: #1a1a1f;
            position: relative;
            overflow: hidden;
        }

        .show-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.7s ease;
        }

        .show-card:hover .show-img img {
            transform: scale(1.08);
            opacity: 0.8;
        }

        .show-content {
            padding: 2rem;
            position: relative;
            background: linear-gradient(to bottom, transparent, var(--surface) 20%);
            margin-top: -50px;
            z-index: 2;
        }

        .show-date {
            color: var(--gold);
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 0.8rem;
            display: block;
        }

        .show-title {
            font-size: 1.8rem;
            margin-bottom: 1rem;
            color: #fff;
        }

        .show-desc {
            color: var(--text-muted);
            font-size: 1rem;
            margin-bottom: 2rem;
        }

        .btn-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: #fff;
            text-decoration: none;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 700;
            border-top: 1px solid var(--border-glass);
            padding-top: 1rem;
            transition: all 0.3s;
        }

        .show-card:hover .btn-card {
            color: var(--gold);
            border-color: rgba(212, 175, 55, 0.3);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 5rem 2rem;
            color: var(--text-muted);
        }
        .empty-state h3 {
            color: #fff;
            font-size: 2rem;
            margin: 1rem 0;
        }
        .empty-state-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        /* Reviews Section */
        .reviews {
            padding: 8rem 0;
            background: url('https://images.unsplash.com/photo-1514306191717-452ec28c7814?q=80&w=2000&auto=format&fit=crop') center/cover fixed;
            position: relative;
        }

        .reviews::before {
            content: '';
            position: absolute;
            top:0; left:0; width:100%; height:100%;
            background: rgba(7, 7, 9, 0.9);
            backdrop-filter: blur(8px);
        }

        .reviews-content {
            position: relative;
            z-index: 1;
        }

        .reviews-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .review-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(212, 175, 55, 0.2);
            padding: 2.5rem;
            border-radius: 16px;
            backdrop-filter: blur(10px);
        }

        .stars { color: var(--gold); font-size: 1.2rem; margin-bottom: 1rem; }
        .review-text { font-size: 1.1rem; font-style: italic; color: #fff; margin-bottom: 1.5rem; }
        .review-author { font-size: 0.9rem; color: var(--gold); font-weight: 700; text-transform: uppercase; letter-spacing: 1px; }

        /* Newsletter */
        .newsletter {
            padding: 6rem 0;
            text-align: center;
            background: linear-gradient(135deg, var(--surface) 0%, var(--dark-bg) 100%);
            border-top: 1px solid var(--border-glass);
            border-bottom: 1px solid var(--border-glass);
        }

        .newsletter h2 { font-size: 2.5rem; margin-bottom: 1rem; color: #fff; }
        .newsletter p { color: var(--text-muted); margin-bottom: 2rem; }
        
        .subscribe-form {
            display: flex;
            justify-content: center;
            gap: 1rem;
            max-width: 500px;
            margin: 0 auto;
        }

        .subscribe-form input {
            padding: 1rem 1.5rem;
            border-radius: 30px;
            border: 1px solid var(--border-glass);
            background: rgba(0,0,0,0.3);
            color: #fff;
            flex: 1;
            font-family: 'Outfit', sans-serif;
            outline: none;
        }
        .subscribe-form input:focus { border-color: var(--gold); }

        /* Footer */
        footer {
            background: #030304;
            padding: 5rem 0 2rem;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 4rem;
            margin-bottom: 4rem;
        }

        .footer-logo { font-size: 2.5rem; color: var(--gold); margin-bottom: 1.5rem; display: block; text-decoration: none; }
        .footer-desc { color: var(--text-muted); max-width: 300px; }
        
        .footer-links h4 { color: #fff; font-size: 1.2rem; margin-bottom: 1.5rem; letter-spacing: 1px; }
        .footer-links ul { list-style: none; }
        .footer-links ul li { margin-bottom: 0.8rem; }
        .footer-links ul li a { color: var(--text-muted); text-decoration: none; transition: color 0.3s; }
        .footer-links ul li a:hover { color: var(--gold); }

        .footer-bottom {
            border-top: 1px solid var(--border-glass);
            padding-top: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 992px) {
            .hero h1 { font-size: 4rem; }
            .featured-wrapper { flex-direction: column; padding: 2rem; }
            .footer-grid { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 768px) {
            .nav-links { display: none; }
            .hero h1 { font-size: 3rem; }
            .section-header { flex-direction: column; align-items: flex-start; gap: 1rem; }
            .footer-grid { grid-template-columns: 1fr; }
        }

        /* Shows Table styling on Home page */
        .shows-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 1.5rem;
            margin-top: 1.5rem;
        }
        .shows-table thead th {
            font-family: 'Outfit', sans-serif;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--gold);
            padding: 1rem 2rem;
            border-bottom: 2px solid var(--border-glass);
            text-align: left;
        }
        .shows-table tbody tr {
            background: var(--surface);
            border: 1px solid var(--border-glass);
            border-radius: 16px;
            transition: all 0.4s ease;
        }
        .shows-table tbody tr:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            background: rgba(255, 255, 255, 0.03);
        }
        .shows-table tbody td {
            padding: 2rem;
            vertical-align: top;
        }
        .shows-table tbody td:first-child {
            border-top-left-radius: 16px;
            border-bottom-left-radius: 16px;
            border-left: 1px solid var(--border-glass);
            border-top: 1px solid var(--border-glass);
            border-bottom: 1px solid var(--border-glass);
        }
        .shows-table tbody td:last-child {
            border-top-right-radius: 16px;
            border-bottom-right-radius: 16px;
            border-right: 1px solid var(--border-glass);
            border-top: 1px solid var(--border-glass);
            border-bottom: 1px solid var(--border-glass);
        }
        .show-media-wrap {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }
        .show-thumbnail {
            width: 150px;
            height: 100px;
            border-radius: 10px;
            overflow: hidden;
            flex-shrink: 0;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }
        .show-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .show-details-main {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        .show-category-badge {
            display: inline-block;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--gold);
            font-weight: 700;
        }
        .show-title-main {
            font-size: 1.6rem;
            color: #fff;
            font-family: 'Playfair Display', serif;
        }
        .info-block {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .info-meta-row {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            font-size: 0.9rem;
            color: var(--text-muted);
            align-items: center;
        }
        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }
        .price-tag {
            color: #fff;
            font-weight: 700;
            background: rgba(212, 175, 55, 0.15);
            padding: 0.2rem 0.6rem;
            border-radius: 4px;
            border: 1px solid var(--gold-glow);
        }
        .show-desc-text {
            color: var(--text-muted);
            font-size: 0.95rem;
            line-height: 1.5;
        }
        .btn-book-table {
            align-self: flex-start;
            padding: 0.6rem 1.8rem;
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }

        @media (max-width: 768px) {
            .shows-table, .shows-table thead, .shows-table tbody, .shows-table tr, .shows-table td {
                display: block;
                width: 100% !important;
            }
            .shows-table thead {
                display: none;
            }
            .shows-table tbody tr {
                margin-bottom: 2rem;
            }
            .shows-table tbody td {
                padding: 1.5rem;
            }
            .shows-table tbody td:first-child {
                border-bottom: none;
                border-top-right-radius: 16px;
                border-bottom-left-radius: 0;
                border-right: 1px solid var(--border-glass);
            }
            .shows-table tbody td:last-child {
                border-top: none;
                border-bottom-left-radius: 16px;
                border-top-right-radius: 0;
                border-left: 1px solid var(--border-glass);
            }
            .show-media-wrap {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            .show-thumbnail {
                width: 100%;
                height: 180px;
            }
        }
    </style>
</head>
<body>

    <nav id="navbar">
        <a href="/" class="logo">Aurora<span>.</span></a>
        <ul class="nav-links">
            <li><a href="/#home">Home</a></li>
            <li><a href="/#voorstellingen">Voorstellingen</a></li>
            <li><a href="{{ route('about') }}">Over ons</a></li>
            <li><a href="{{ route('contact') }}">Contact</a></li>
            <li><a href="/#ervaringen">Ervaringen</a></li>
            @auth
                @if(in_array(Auth::user()->role, ['medewerker', 'administrator']))
                    <li><a href="{{ route('tickets.index') }}" class="btn-login">Dashboard</a></li>
                @else
                    <li><a href="{{ route('mijn.tickets') }}" class="btn-login">Mijn Tickets</a></li>
                @endif
            @else
                <li><a href="{{ route('login') }}" class="btn-login">Inloggen</a></li>
            @endauth
        </ul>
    </nav>

    <!-- Hero Section -->
    <header class="hero" id="home">
        <div class="hero-bg"></div>
        <div class="hero-overlay"></div>
        <div class="container hero-content">
            <span class="badge">Seizoen 2026</span>
            <h1>Beleef de magie van <span>het podium</span>.</h1>
            <p>Ervaar ongeëvenaarde voorstellingen in het meest prestigieuze theater van het land. Waar meeslepende verhalen en pure emotie samenkomen.</p>
            <a href="#voorstellingen" class="btn-primary">Reserveer Nu</a>
        </div>
    </header>

    <!-- Featured Show Section -->
    @if($shows->count() > 0)
    <section class="featured">
        <div class="container">
            <div class="featured-wrapper reveal">
                <div class="featured-img">
                    <img src="{{ $shows->first()->image_url ?? 'https://images.unsplash.com/photo-1514306191717-452ec28c7814?q=80&w=1200&auto=format&fit=crop' }}" alt="{{ $shows->first()->title }}">
                </div>
                <div class="featured-content">
                    <span class="badge" style="border-color: #8b0000; color: #ff4d4d;">{{ $shows->first()->category ?? 'Première' }}</span>
                    <h2>{{ $shows->first()->title }}</h2>
                    <p class="show-desc" style="font-size: 1.1rem;">{{ $shows->first()->description }}</p>
                    <ul style="list-style: none; margin-bottom: 2rem; color: #fff;">
                        <li style="margin-bottom: 0.5rem;">📅 {{ $shows->first()->date->format('d M Y') }}</li>
                        <li style="margin-bottom: 0.5rem;">⏰ {{ $shows->first()->date->format('H:i') }} - {{ $shows->first()->location }}</li>
                        <li>🎭 {{ $shows->first()->category ?? 'Voorstelling' }}</li>
                    </ul>
                    <a href="{{ route('shows.book', $shows->first()) }}" class="btn-primary" style="padding: 1rem 2rem;">Tickets & Info</a>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- All Shows -->
    <section class="shows" id="voorstellingen">
        <div class="container">
            <div class="section-header reveal">
                <div>
                    <span class="badge">Programma</span>
                    <h2 class="section-title">Binnenkort te Zien</h2>
                </div>
            </div>

            @if($shows->count() > 0)
                <div class="shows-list-container reveal">
                    <table class="shows-table">
                        <thead>
                            <tr>
                                <th style="width: 45%;">Voorstelling</th>
                                <th style="width: 55%;">Informatie</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($shows as $show)
                                <tr class="reveal" style="transition-delay: {{ $loop->index * 0.1 }}s;">
                                    <td class="col-voorstelling">
                                        <div class="show-media-wrap">
                                            @if($show->image_url)
                                                <div class="show-thumbnail">
                                                    <img src="{{ $show->image_url }}" alt="{{ $show->title }}">
                                                </div>
                                            @endif
                                            <div class="show-details-main">
                                                <span class="show-category-badge">{{ $show->category ?? 'Voorstelling' }}</span>
                                                <h3 class="show-title-main">{{ $show->title }}</h3>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="col-informatie">
                                        <div class="info-block">
                                            <div class="info-meta-row">
                                                <span class="meta-item">📅 {{ $show->date->format('d M Y') }} • {{ $show->date->format('H:i') }}</span>
                                                <span class="meta-item">📍 {{ $show->location }}</span>
                                                <span class="meta-item">🎟️ {{ $show->available_tickets }} tickets</span>
                                                <span class="meta-item price-tag">€{{ number_format($show->price, 2) }}</span>
                                            </div>
                                            <p class="show-desc-text">{{ $show->description }}</p>
                                            <a href="{{ route('shows.book', $show) }}" class="btn-primary btn-book-table">Bestel Tickets</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state reveal">
                    <div class="empty-state-icon">🎭</div>
                    <h3>Er zijn momenteel geen voorstellingen beschikbaar.</h3>
                    <p style="margin-top: 1rem; font-size: 0.9rem;">Kom later terug voor nieuwe aankondigingen.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Reviews -->
    <section class="reviews" id="ervaringen">
        <div class="container reviews-content reveal">
            <span class="badge">Beoordelingen</span>
            <h2 class="section-title">Wat Onze Bezoekers Zeggen</h2>
            
            <div class="reviews-grid">
                <div class="review-card reveal">
                    <div class="stars">★★★★★</div>
                    <p class="review-text">"Werkelijk een magische ervaring. Het geluid, de ambiance, de zachte stoelen... Alles straalt pure luxe uit."</p>
                    <span class="review-author">— Sophie van D.</span>
                </div>
                <div class="review-card reveal" style="transition-delay: 0.1s;">
                    <div class="stars">★★★★★</div>
                    <p class="review-text">"De beste theaterervaring die ik in jaren heb gehad. De makkelijke online reservering was ook een enorme plus!"</p>
                    <span class="review-author">— Mark T.</span>
                </div>
                <div class="review-card reveal" style="transition-delay: 0.2s;">
                    <div class="stars">★★★★☆</div>
                    <p class="review-text">"Prachtig gebouw en topvoorstellingen. Personeel was ontzettend gastvrij bij de ticketcontrole."</p>
                    <span class="review-author">— Elena R.</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="newsletter reveal">
        <div class="container">
            <h2>Blijf op de hoogte</h2>
            <p>Schrijf u in voor onze nieuwsbrief en krijg als eerste toegang tot voorverkopen en exclusieve kortingen.</p>
            <form class="subscribe-form">
                <input type="email" placeholder="Uw e-mailadres" required>
                <button type="submit" class="btn-primary" style="padding: 1rem 2rem;">Inschrijven</button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div>
                    <a href="/" class="logo footer-logo">Aurora<span>.</span></a>
                    <p class="footer-desc">Hét premium theater voor onvergetelijke avonden vol kunst, cultuur en magie.</p>
                </div>
                <div class="footer-links">
                    <h4>Programma</h4>
                    <ul>
                        <li><a href="#voorstellingen">Alle Voorstellingen</a></li>
                        <li><a href="#">Klassiek & Ballet</a></li>
                        <li><a href="#">Theater & Toneel</a></li>
                        <li><a href="#">Muziek & Concerten</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h4>Informatie</h4>
                    <ul>
                        <li><a href="{{ route('about') }}">Over Theater Aurora</a></li>
                        <li><a href="{{ route('contact') }}#form">Bereikbaarheid</a></li>
                        <li><a href="{{ route('contact') }}#faq">Veelgestelde Vragen</a></li>
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h4>Account</h4>
                    <ul>
                        @auth
                            @if(in_array(Auth::user()->role, ['medewerker', 'administrator']))
                                <li><a href="{{ route('tickets.index') }}">Dashboard</a></li>
                            @else
                                <li><a href="{{ route('mijn.tickets') }}">Mijn Tickets</a></li>
                            @endif
                            <li>
                                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                                    @csrf
                                    <button type="submit" style="background:none;border:none;color:inherit;cursor:pointer;font-family:inherit;font-size:inherit;padding:0;">Uitloggen</button>
                                </form>
                            </li>
                        @else
                            <li><a href="{{ route('login') }}">Inloggen / Registreren</a></li>
                        @endauth
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2026 Theater Aurora. Alle rechten voorbehouden.</p>
                <div style="display: flex; gap: 1.5rem;">
                    <span style="color: #555;">Voldoet aan de AVG-wetgeving</span>
                    <span style="color: #555;">100% Beveiligd via HTTPS</span>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Sticky Navbar
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 50) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        });

        // Intersection Observer for Scroll Animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: "0px 0px -50px 0px"
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.querySelectorAll('.reveal').forEach(el => {
            observer.observe(el);
        });
    </script>
</body>
</html>