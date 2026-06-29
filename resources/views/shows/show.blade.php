<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $show ? $show->title . ' - ' : '' }}Theater Aurora</title>
    <meta name="description" content="{{ $show ? Str::limit($show->description, 160) : 'Voorstelling niet gevonden.' }}">
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
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

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

        /* Navbar */
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.2rem 5%;
            background: rgba(7, 7, 9, 0.9);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border-glass);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo {
            font-size: 1.8rem;
            color: #fff;
            text-decoration: none;
            font-weight: 700;
        }
        .logo span { color: var(--gold); }

        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
            align-items: center;
        }

        .nav-links a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            transition: color 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .nav-links a:hover { color: var(--gold); }

        .btn-nav {
            border: 1px solid var(--border-glass);
            padding: 0.5rem 1.2rem;
            border-radius: 30px;
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(5px);
            transition: all 0.3s ease;
        }
        .btn-nav:hover {
            background: var(--gold);
            color: var(--dark-bg) !important;
            border-color: var(--gold);
        }

        /* Hero Banner */
        .show-hero {
            position: relative;
            height: 55vh;
            min-height: 400px;
            overflow: hidden;
        }

        .show-hero-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform: scale(1.02);
            transition: transform 8s ease;
        }

        .show-hero:hover .show-hero-img {
            transform: scale(1.08);
        }

        .show-hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(0deg,
                var(--dark-bg) 0%,
                rgba(7,7,9,0.6) 40%,
                rgba(7,7,9,0.2) 70%,
                rgba(7,7,9,0.4) 100%
            );
        }

        .show-hero-content {
            position: absolute;
            bottom: 3rem;
            left: 5%;
            right: 5%;
            max-width: 800px;
        }

        .badge {
            display: inline-block;
            padding: 0.35rem 1rem;
            border: 1px solid var(--gold);
            color: var(--gold);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            border-radius: 20px;
            margin-bottom: 1rem;
            animation: fadeUp 0.8s ease forwards;
        }

        .show-hero-content h1 {
            font-size: 3.5rem;
            color: #fff;
            line-height: 1.1;
            margin-bottom: 0.5rem;
            animation: fadeUp 0.8s ease forwards 0.2s;
            opacity: 0;
        }

        .show-hero-meta {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
            color: var(--text-muted);
            font-size: 1rem;
            animation: fadeUp 0.8s ease forwards 0.4s;
            opacity: 0;
        }

        .show-hero-meta span {
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        /* Main Content */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .show-detail-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 3rem;
            margin-top: -4rem;
            position: relative;
            z-index: 10;
            padding-bottom: 5rem;
        }

        /* Left Column - Show Info */
        .show-main {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .info-card {
            background: var(--surface);
            border: 1px solid var(--border-glass);
            border-radius: 16px;
            padding: 2.5rem;
        }

        .info-card h2 {
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            color: #fff;
        }

        .info-card p {
            color: var(--text-muted);
            font-size: 1.05rem;
            line-height: 1.8;
        }

        .detail-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 1.2rem;
        }

        .detail-list li {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1rem 1.5rem;
            background: rgba(255,255,255,0.02);
            border: 1px solid var(--border-glass);
            border-radius: 12px;
            transition: all 0.3s;
        }

        .detail-list li:hover {
            background: rgba(212, 175, 55, 0.05);
            border-color: rgba(212, 175, 55, 0.2);
        }

        .detail-icon {
            font-size: 1.3rem;
            flex-shrink: 0;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(212, 175, 55, 0.1);
            border-radius: 10px;
        }

        .detail-text {
            display: flex;
            flex-direction: column;
        }

        .detail-label {
            font-size: 0.8rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 0.2rem;
        }

        .detail-value {
            font-size: 1.05rem;
            color: #fff;
            font-weight: 500;
        }

        /* Right Column - Booking Card */
        .booking-sidebar {
            position: sticky;
            top: 100px;
            height: fit-content;
        }

        .booking-card {
            background: var(--surface);
            border: 1px solid var(--border-glass);
            border-radius: 16px;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .price-display {
            text-align: center;
            padding: 1.5rem;
            background: rgba(212, 175, 55, 0.08);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 12px;
        }

        .price-label {
            font-size: 0.8rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 0.3rem;
        }

        .price-amount {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--gold);
            font-family: 'Playfair Display', serif;
        }

        .price-per {
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .ticket-status {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.8rem;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .ticket-available {
            background: rgba(76, 175, 80, 0.1);
            border: 1px solid rgba(76, 175, 80, 0.3);
            color: #4caf50;
        }

        .ticket-low {
            background: rgba(255, 152, 0, 0.1);
            border: 1px solid rgba(255, 152, 0, 0.3);
            color: #ff9800;
        }

        .ticket-soldout {
            background: rgba(229, 57, 53, 0.1);
            border: 1px solid rgba(229, 57, 53, 0.3);
            color: #e53935;
        }

        .btn-book {
            display: block;
            width: 100%;
            background: var(--gold);
            color: var(--dark-bg);
            padding: 1.1rem;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
            text-decoration: none;
            text-align: center;
            font-family: 'Outfit', sans-serif;
        }

        .btn-book:hover {
            background: #fff;
            transform: translateY(-3px);
            box-shadow: 0 10px 30px var(--gold-glow);
        }

        .btn-book:disabled, .btn-book.disabled {
            background: rgba(255,255,255,0.1);
            color: var(--text-muted);
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .booking-info {
            text-align: center;
            font-size: 0.85rem;
            color: var(--text-muted);
            line-height: 1.5;
        }

        /* Back Button */
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: transparent;
            color: var(--text-muted);
            padding: 0.6rem 1.2rem;
            border: 1px solid var(--border-glass);
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s;
            margin-bottom: 1.5rem;
        }
        .btn-back:hover {
            color: var(--gold);
            border-color: var(--gold);
        }

        /* Error / Not Found State */
        .error-state {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 70vh;
            padding: 4rem 2rem;
        }

        .error-card {
            text-align: center;
            max-width: 550px;
            background: var(--surface);
            border: 1px solid var(--border-glass);
            border-radius: 24px;
            padding: 4rem 3rem;
            animation: fadeUp 0.8s ease forwards;
        }

        .error-icon {
            font-size: 5rem;
            margin-bottom: 1.5rem;
            display: block;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }

        .error-card h1 {
            font-size: 2rem;
            color: #fff;
            margin-bottom: 1rem;
        }

        .error-card p {
            color: var(--text-muted);
            font-size: 1.1rem;
            line-height: 1.7;
            margin-bottom: 2.5rem;
        }

        .btn-home {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--gold);
            color: var(--dark-bg);
            padding: 1rem 2.5rem;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
            text-decoration: none;
            font-family: 'Outfit', sans-serif;
        }

        .btn-home:hover {
            background: #fff;
            transform: translateY(-3px);
            box-shadow: 0 10px 30px var(--gold-glow);
        }

        /* Footer */
        footer {
            background: #030304;
            padding: 3rem 0;
            border-top: 1px solid var(--border-glass);
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .footer-content a {
            color: var(--gold);
            text-decoration: none;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 992px) {
            .show-detail-grid {
                grid-template-columns: 1fr;
            }
            .booking-sidebar {
                position: static;
            }
            .show-hero-content h1 {
                font-size: 2.5rem;
            }
        }

        @media (max-width: 768px) {
            .nav-links { display: none; }
            .show-hero {
                height: 40vh;
                min-height: 300px;
            }
            .show-hero-content h1 {
                font-size: 2rem;
            }
            .show-hero-meta {
                flex-direction: column;
                gap: 0.5rem;
            }
            .info-card {
                padding: 1.5rem;
            }
            .error-card {
                padding: 2.5rem 1.5rem;
            }
            .error-card h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <nav>
        <a href="/" class="logo">Aurora<span>.</span></a>
        <ul class="nav-links">
            <li><a href="/">Home</a></li>
            <li><a href="/#voorstellingen">Voorstellingen</a></li>
            <li><a href="{{ route('about') }}">Over ons</a></li>
            <li><a href="{{ route('contact') }}">Contact</a></li>
            @auth
                @if(in_array(Auth::user()->role, ['medewerker', 'administrator']))
                    <li><a href="{{ route('tickets.index') }}" class="btn-nav">Dashboard</a></li>
                @else
                    <li><a href="{{ route('mijn.tickets') }}" class="btn-nav">Mijn Tickets</a></li>
                @endif
            @else
                <li><a href="{{ route('login') }}" class="btn-nav">Inloggen</a></li>
            @endauth
        </ul>
    </nav>

    @if($show)
    <!-- Hero Banner -->
    <section class="show-hero" id="show-hero">
        <img
            src="{{ $show->image_url ?? 'https://images.unsplash.com/photo-1507676184212-d0c30a510c55?q=80&w=2070&auto=format&fit=crop' }}"
            alt="{{ $show->title }}"
            class="show-hero-img"
        >
        <div class="show-hero-overlay"></div>
        <div class="show-hero-content">
            <span class="badge">{{ $show->category ?? 'Voorstelling' }}</span>
            <h1>{{ $show->title }}</h1>
            <div class="show-hero-meta">
                <span>📅 {{ $show->date->format('d M Y') }}</span>
                <span>⏰ {{ $show->date->format('H:i') }} uur</span>
                <span>📍 {{ $show->location }}</span>
            </div>
        </div>
    </section>

    <!-- Detail Content -->
    <div class="container">
        <div class="show-detail-grid">
            <!-- Left: Show Information -->
            <div class="show-main">
                <a href="/" class="btn-back">← Terug naar overzicht</a>

                <div class="info-card">
                    <h2>Over deze voorstelling</h2>
                    <p>{{ $show->description ?? 'Meer informatie volgt binnenkort.' }}</p>
                </div>

                <div class="info-card">
                    <h2>Praktische Informatie</h2>
                    <ul class="detail-list">
                        <li>
                            <div class="detail-icon">📅</div>
                            <div class="detail-text">
                                <span class="detail-label">Datum</span>
                                <span class="detail-value">{{ $show->date->translatedFormat('l d F Y') }}</span>
                            </div>
                        </li>
                        <li>
                            <div class="detail-icon">⏰</div>
                            <div class="detail-text">
                                <span class="detail-label">Aanvang</span>
                                <span class="detail-value">{{ $show->date->format('H:i') }} uur</span>
                            </div>
                        </li>
                        <li>
                            <div class="detail-icon">📍</div>
                            <div class="detail-text">
                                <span class="detail-label">Locatie</span>
                                <span class="detail-value">{{ $show->location }}</span>
                            </div>
                        </li>
                        <li>
                            <div class="detail-icon">🎭</div>
                            <div class="detail-text">
                                <span class="detail-label">Categorie</span>
                                <span class="detail-value">{{ $show->category ?? 'Voorstelling' }}</span>
                            </div>
                        </li>
                        <li>
                            <div class="detail-icon">💰</div>
                            <div class="detail-text">
                                <span class="detail-label">Prijs per ticket</span>
                                <span class="detail-value">€ {{ number_format($show->price, 2) }}</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Right: Booking Sidebar -->
            <div class="booking-sidebar">
                <div class="booking-card">
                    <div class="price-display">
                        <div class="price-label">Vanaf</div>
                        <div class="price-amount">€{{ number_format($show->price, 2) }}</div>
                        <div class="price-per">per ticket</div>
                    </div>

                    @if($show->available_tickets > 20)
                        <div class="ticket-status ticket-available">
                            🎟️ {{ $show->available_tickets }} tickets beschikbaar
                        </div>
                    @elseif($show->available_tickets > 0)
                        <div class="ticket-status ticket-low">
                            ⚡ Nog maar {{ $show->available_tickets }} tickets!
                        </div>
                    @else
                        <div class="ticket-status ticket-soldout">
                            ❌ Uitverkocht
                        </div>
                    @endif

                    @if($show->available_tickets > 0 && $show->is_active)
                        <a href="{{ route('shows.book', $show) }}" class="btn-book" id="btn-book-tickets">
                            Bestel Tickets
                        </a>
                    @else
                        <button class="btn-book disabled" disabled>Niet Beschikbaar</button>
                    @endif

                    <p class="booking-info">
                        Na aankoop ontvangt u uw tickets met barcode in uw account. U kunt maximaal 10 tickets per bestelling reserveren.
                    </p>
                </div>
            </div>
        </div>
    </div>

    @else
    <!-- Unhappy Scenario: Voorstelling niet gevonden -->
    <div class="error-state">
        <div class="error-card">
            <span class="error-icon">🎭</span>
            <h1>Voorstelling niet gevonden</h1>
            <p>{{ $error ?? 'Deze voorstelling bestaat niet of is niet meer beschikbaar. Bekijk ons actuele programma voor andere voorstellingen.' }}</p>
            <a href="/" class="btn-home">← Bekijk Voorstellingen</a>
        </div>
    </div>
    @endif

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <p>&copy; 2026 Theater Aurora. Alle rechten voorbehouden.</p>
                <a href="/">Terug naar home</a>
            </div>
        </div>
    </footer>
</body>
</html>
