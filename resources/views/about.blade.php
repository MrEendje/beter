<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Over Ons - Theater Aurora</title>
    <meta name="description" content="Ontdek de rijke geschiedenis, de adembenemende Grote Zaal en de uitstekende bereikbaarheid van Theater Aurora. Uw premium bestemming voor kunst en cultuur.">
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

        .container {
            width: 90%;
            max-width: 1200px;
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
            padding: 1rem 5%;
            background: rgba(7, 7, 9, 0.85);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border-glass);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .logo {
            font-size: 2.2rem;
            color: var(--text-main);
            font-weight: 700;
            text-decoration: none;
            letter-spacing: 2px;
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
        }
        .nav-links a:hover { color: var(--gold); }

        .btn-login {
            border: 1px solid var(--border-glass);
            padding: 0.6rem 1.8rem;
            border-radius: 30px;
            color: var(--text-main) !important;
            transition: all 0.3s ease !important;
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(5px);
            text-decoration: none;
        }

        .btn-login:hover {
            background: var(--gold);
            color: var(--dark-bg) !important;
            border-color: var(--gold);
            box-shadow: 0 0 15px var(--gold-glow);
        }

        /* Hero */
        .about-hero {
            height: 60vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            text-align: center;
            padding-top: 80px;
        }

        .hero-bg {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: url('https://images.unsplash.com/photo-1460723237483-7a6dc9d0b212?q=80&w=2070&auto=format&fit=crop') center/cover no-repeat;
            z-index: -2;
            transform: scale(1.05);
        }

        .hero-overlay {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(180deg, rgba(7,7,9,0.7) 0%, rgba(7,7,9,0.95) 100%);
            z-index: -1;
        }

        .about-hero h1 {
            font-size: 4.5rem;
            color: #fff;
            margin-bottom: 1rem;
        }
        .about-hero h1 span { color: var(--gold); }
        .about-hero p {
            font-size: 1.25rem;
            color: var(--text-muted);
            max-width: 600px;
            margin: 0 auto;
        }

        /* Split Section */
        .section {
            padding: 6rem 0;
            border-bottom: 1px solid var(--border-glass);
        }

        .split-content {
            display: flex;
            align-items: center;
            gap: 4rem;
        }
        .split-text { flex: 1; }
        .split-img {
            flex: 1;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid var(--border-glass);
            box-shadow: 0 15px 35px rgba(0,0,0,0.4);
        }
        .split-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.8s;
        }
        .split-img:hover img {
            transform: scale(1.04);
        }

        .section-tag {
            color: var(--gold);
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 2px;
            font-weight: 700;
            display: block;
            margin-bottom: 0.8rem;
        }

        .section h2 {
            font-size: 2.8rem;
            color: #fff;
            margin-bottom: 1.5rem;
        }
        .section p {
            color: var(--text-muted);
            font-size: 1.05rem;
            margin-bottom: 1.5rem;
        }

        /* Features Cards Grid */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }
        .feature-card {
            background: var(--surface);
            border: 1px solid var(--border-glass);
            border-radius: 16px;
            padding: 2.5rem;
            transition: all 0.3s;
        }
        .feature-card:hover {
            transform: translateY(-8px);
            border-color: rgba(212,175,55,0.3);
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            color: var(--gold);
        }
        .feature-card h3 {
            font-size: 1.5rem;
            color: #fff;
            margin-bottom: 1rem;
        }
        .feature-card p {
            font-size: 0.95rem;
            color: var(--text-muted);
            margin-bottom: 0;
        }

        /* FAQ Accordions */
        .faq-list {
            margin-top: 3rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .faq-item {
            background: var(--surface);
            border: 1px solid var(--border-glass);
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s;
        }
        .faq-question {
            padding: 1.5rem 2rem;
            color: #fff;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            user-select: none;
        }
        .faq-question:hover {
            background: rgba(255,255,255,0.01);
        }
        .faq-answer {
            padding: 0 2rem;
            max-height: 0;
            overflow: hidden;
            color: var(--text-muted);
            font-size: 0.95rem;
            transition: max-height 0.3s ease, padding 0.3s ease;
        }
        .faq-item.active .faq-answer {
            padding: 0 2rem 1.5rem 2rem;
            max-height: 200px;
        }
        .faq-arrow {
            transition: transform 0.3s;
        }
        .faq-item.active .faq-arrow {
            transform: rotate(180deg);
            color: var(--gold);
        }

        /* Contact Details */
        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 4rem;
            margin-top: 3rem;
        }
        .contact-info {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }
        .contact-method {
            display: flex;
            gap: 1rem;
            align-items: flex-start;
        }
        .contact-method-icon {
            font-size: 1.5rem;
            color: var(--gold);
            background: rgba(212, 175, 55, 0.1);
            padding: 0.8rem;
            border-radius: 50%;
            flex-shrink: 0;
        }
        .contact-method-text h4 {
            color: #fff;
            font-size: 1.1rem;
            margin-bottom: 0.3rem;
        }
        .contact-method-text p {
            font-size: 0.95rem;
            color: var(--text-muted);
            margin: 0;
        }

        .contact-form-wrap {
            background: var(--surface);
            border: 1px solid var(--border-glass);
            border-radius: 20px;
            padding: 3rem;
        }
        .contact-form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        .form-group label {
            font-size: 0.85rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .form-control {
            background: rgba(0,0,0,0.3);
            border: 1px solid var(--border-glass);
            border-radius: 8px;
            padding: 1rem;
            color: #fff;
            outline: none;
            font-family: inherit;
            transition: all 0.3s;
        }
        .form-control:focus {
            border-color: var(--gold);
        }
        .btn-submit {
            background: var(--gold);
            color: var(--dark-bg);
            border: none;
            padding: 1.2rem;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-submit:hover {
            background: #fff;
            box-shadow: 0 5px 15px var(--gold-glow);
        }

        /* Footer */
        footer {
            background: #030304;
            padding: 5rem 0 2rem;
            border-top: 1px solid var(--border-glass);
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

        /* Responsive */
        @media (max-width: 992px) {
            .split-content { flex-direction: column; gap: 3rem; }
            .about-hero h1 { font-size: 3.5rem; }
            .contact-grid { grid-template-columns: 1fr; gap: 3rem; }
            .footer-grid { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 768px) {
            .nav-links { display: none; }
            .footer-grid { grid-template-columns: 1fr; }
            .form-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav>
        <a href="/" class="logo">Aurora<span>.</span></a>
        <ul class="nav-links">
            <li><a href="/#home">Home</a></li>
            <li><a href="/#voorstellingen">Voorstellingen</a></li>
            <li><a href="{{ route('about') }}" style="color: var(--gold);">Over ons</a></li>
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

    <!-- Hero -->
    <header class="about-hero">
        <div class="hero-bg"></div>
        <div class="hero-overlay"></div>
        <div class="container reveal active">
            <h1>Over <span>Theater Aurora</span></h1>
            <p>Ontdek de verhalen, de architectuur en de passie achter het meest prestigieuze podium van het land.</p>
        </div>
    </header>

    <!-- History Section -->
    <section class="section">
        <div class="container">
            <div class="split-content reveal active">
                <div class="split-text">
                    <span class="section-tag">Onze Geschiedenis</span>
                    <h2>Waar Passie en Kunst Samenkomen</h2>
                    <p>Theater Aurora opende haar deuren aan het begin van de 20e eeuw met één duidelijke missie: het creëren van een magische ontmoetingsplek voor cultuur en verhalen. Wat begon als een bescheiden schouwburg, is in de loop der jaren uitgegroeid tot een rijksmonument en een toonaangevend nationaal theater.</p>
                    <p>Onze karakteristieke grote boogconstructie en verfijnde interieurdetails herinneren aan een rijke geschiedenis, terwijl we met moderne faciliteiten en state-of-the-art geluidstechniek de standaarden voor de toekomst blijven bepalen. Elk seizoen verwelkomen we tienduizenden bezoekers die samen met ons lachen, huilen en genieten.</p>
                </div>
                <div class="split-img">
                    <img src="https://images.unsplash.com/photo-1503095396549-807759245b35?q=80&w=800&auto=format&fit=crop" alt="Theater Aurora Foyer">
                </div>
            </div>
        </div>
    </section>

    <!-- Premium Features Section -->
    <section class="section">
        <div class="container reveal active">
            <span class="section-tag" style="text-align: center;">Onze Faciliteiten</span>
            <h2 style="text-align: center; margin-bottom: 1rem;">Een Premium Beleving</h2>
            <p style="text-align: center; max-width: 600px; margin: 0 auto 3rem;">Vanaf het moment dat u onze marmeren foyer binnenstapt tot het laatste applaus in de Grote Zaal, bieden wij u comfort en gastvrijheid van het hoogste niveau.</p>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">🔊</div>
                    <h3>Fenomenale Akoestiek</h3>
                    <p>Onze zaal is wetenschappelijk ontworpen om elke toon, fluistering en instrumentaal detail kraakhelder over te brengen naar elke stoel.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🛋️</div>
                    <h3>Luxueus Comfort</h3>
                    <p>Geniet van royale, ergonomische fluwelen stoelen met royale beenruimte, zodat u zich volledig kunt overgeven aan de voorstelling.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🥂</div>
                    <h3>Premium Foyer</h3>
                    <p>Voorafgaand aan de show en tijdens de pauze kunt u in onze sfeervolle foyer genieten van culinaire hapjes en zorgvuldig geselecteerde wijnen.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact link button block -->
    <section class="section" style="text-align: center; background: rgba(255,255,255,0.01);">
        <div class="container reveal active">
            <span class="section-tag">Klantenservice</span>
            <h2>Heeft u vragen of wilt u langskomen?</h2>
            <p style="max-width: 600px; margin: 0 auto 2rem;">Bekijk onze openingstijden, bereikbaarheid en veelgestelde vragen op onze dedicated contactpagina of stuur direct een bericht.</p>
            <a href="{{ route('contact') }}" class="btn-login" style="font-size: 1.1rem; padding: 0.8rem 2.5rem;">Ga naar Contact & FAQ</a>
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
                        <li><a href="/#voorstellingen">Alle Voorstellingen</a></li>
                        <li><a href="/#voorstellingen">Klassiek & Ballet</a></li>
                        <li><a href="/#voorstellingen">Theater & Toneel</a></li>
                        <li><a href="/#voorstellingen">Muziek & Concerten</a></li>
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
        function toggleFaq(element) {
            const item = element.parentElement;
            item.classList.toggle('active');
        }

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
