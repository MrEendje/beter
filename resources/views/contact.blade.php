<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact & FAQ - Theater Aurora</title>
    <meta name="description" content="Heeft u een vraag of wilt u contact met ons opnemen? Bekijk onze FAQ of stuur direct een bericht. Theater Aurora staat voor u klaar.">
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
        .contact-hero {
            height: 50vh;
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
            background: url('https://images.unsplash.com/photo-1514306191717-452ec28c7814?q=80&w=2070&auto=format&fit=crop') center/cover no-repeat;
            z-index: -2;
            transform: scale(1.05);
        }

        .hero-overlay {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(180deg, rgba(7,7,9,0.7) 0%, rgba(7,7,9,0.95) 100%);
            z-index: -1;
        }

        .contact-hero h1 {
            font-size: 4.5rem;
            color: #fff;
            margin-bottom: 1rem;
        }
        .contact-hero h1 span { color: var(--gold); }
        .contact-hero p {
            font-size: 1.25rem;
            color: var(--text-muted);
            max-width: 600px;
            margin: 0 auto;
        }

        /* Contact Section */
        .section {
            padding: 5rem 0;
            border-bottom: 1px solid var(--border-glass);
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

        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 4rem;
            margin-top: 2rem;
        }

        .contact-info-list {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .contact-card {
            background: var(--surface);
            border: 1px solid var(--border-glass);
            border-radius: 16px;
            padding: 2rem;
            display: flex;
            gap: 1.2rem;
            align-items: flex-start;
        }

        .contact-icon {
            font-size: 1.8rem;
            color: var(--gold);
            background: rgba(212, 175, 55, 0.1);
            padding: 0.8rem;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .contact-details h3 {
            color: #fff;
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
        }
        .contact-details p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        .form-wrap {
            background: var(--surface);
            border: 1px solid var(--border-glass);
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
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
            box-shadow: 0 0 8px rgba(212,175,55,0.2);
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
            transform: translateY(-2px);
        }

        /* FAQ Styling */
        .faq-intro {
            text-align: center;
            max-width: 600px;
            margin: 0 auto 3rem auto;
        }
        .faq-intro p {
            color: var(--text-muted);
            font-size: 1.1rem;
        }

        .faq-list {
            display: flex;
            flex-direction: column;
            gap: 1.2rem;
            max-width: 900px;
            margin: 0 auto;
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
            font-size: 1.15rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            user-select: none;
        }

        .faq-question:hover {
            background: rgba(255,255,255,0.01);
            color: var(--gold);
        }

        .faq-answer {
            padding: 0 2rem;
            max-height: 0;
            overflow: hidden;
            color: var(--text-muted);
            font-size: 1rem;
            transition: max-height 0.3s ease, padding 0.3s ease;
        }

        .faq-item.active {
            border-color: rgba(212,175,55,0.3);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .faq-item.active .faq-answer {
            padding: 0 2rem 1.5rem 2rem;
            max-height: 250px;
        }

        .faq-arrow {
            transition: transform 0.3s;
        }

        .faq-item.active .faq-arrow {
            transform: rotate(180deg);
            color: var(--gold);
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
            .contact-grid { grid-template-columns: 1fr; gap: 3rem; }
            .footer-grid { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 768px) {
            .nav-links { display: none; }
            .form-row { grid-template-columns: 1fr; }
            .footer-grid { grid-template-columns: 1fr; }
            .contact-hero h1 { font-size: 3.5rem; }
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
            <li><a href="{{ route('about') }}">Over ons</a></li>
            <li><a href="{{ route('contact') }}" style="color: var(--gold);">Contact</a></li>
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
    <header class="contact-hero">
        <div class="hero-bg"></div>
        <div class="hero-overlay"></div>
        <div class="container reveal active">
            <h1>Klantenservice & <span>Contact</span></h1>
            <p>Heeft u een vraag of wilt u meer informatie? Ons team staat klaar om u te helpen.</p>
        </div>
    </header>

    <!-- Contact details & form -->
    <section class="section" id="form">
        <div class="container">
            <span class="section-tag">Direct Contact</span>
            <h2>Stuur ons een bericht</h2>
            
            <div class="contact-grid reveal active">
                <div class="contact-info-list">
                    <div class="contact-card">
                        <div class="contact-icon">📍</div>
                        <div class="contact-details">
                            <h3>Bezoekadres</h3>
                            <p>Podiumlaan 12, 1012 AB Amsterdam</p>
                        </div>
                    </div>
                    
                    <div class="contact-card">
                        <div class="contact-icon">📞</div>
                        <div class="contact-details">
                            <h3>Telefoonnummer</h3>
                            <p>+31 (0)20 123 4567<br><small style="color:var(--text-muted);">Bereikbaar op werkdagen van 09:00 tot 17:00</small></p>
                        </div>
                    </div>
                    
                    <div class="contact-card">
                        <div class="contact-icon">✉️</div>
                        <div class="contact-details">
                            <h3>E-mailadres</h3>
                            <p>info@theateraurora.nl<br>support@theateraurora.nl</p>
                        </div>
                    </div>

                    <div class="contact-card">
                        <div class="contact-icon">🚗</div>
                        <div class="contact-details">
                            <h3>Parkeren & Bereikbaarheid</h3>
                            <p>Parkeergarage 'Q-Park Aurora' is direct onder het theater gevestigd. Openbaar vervoer stopt voor de deur (Tram 2, 12, halte Podiumlaan).</p>
                        </div>
                    </div>
                </div>

                <div class="form-wrap">
                    @if(session('success'))
                        <div style="background:rgba(76,175,80,.1); border:1px solid rgba(76,175,80,.4); color:#4caf50; padding:1rem 1.5rem; border-radius:8px; margin-bottom:1.5rem; font-weight:500;">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if($errors->any())
                        <div style="background:rgba(229,57,53,.1); border:1px solid rgba(229,57,53,.4); color:#e53935; padding:1rem 1.5rem; border-radius:8px; margin-bottom:1.5rem; font-weight:500;">
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif
                    <form class="contact-form" method="POST" action="{{ route('contact.store') }}">
                        @csrf
                        <div class="form-row">
                            <div class="form-group">
                                <label for="form_name">Volledige Naam</label>
                                <input type="text" id="form_name" name="name" class="form-control" placeholder="Jan de Vries" value="{{ old('name') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="form_email">E-mailadres</label>
                                <input type="email" id="form_email" name="email" class="form-control" placeholder="jan@voorbeeld.nl" value="{{ old('email') }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="form_subject">Onderwerp</label>
                            <input type="text" id="form_subject" name="subject" class="form-control" placeholder="bijv. Ticket annulering" value="{{ old('subject') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="form_message">Uw Bericht</label>
                            <textarea id="form_message" name="message" rows="5" class="form-control" placeholder="Schrijf hier uw vraag of opmerking..." required>{{ old('message') }}</textarea>
                        </div>

                        <button type="submit" class="btn-submit">Bericht Verzenden</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="section" id="faq" style="background: rgba(255,255,255,0.01);">
        <div class="container reveal active">
            <div class="faq-intro">
                <span class="section-tag">Veelgestelde Vragen</span>
                <h2>Antwoorden op uw Vragen</h2>
                <p>Bekijk de antwoorden op de meest gestelde vragen van onze bezoekers.</p>
            </div>

            <div class="faq-list">
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>Wanneer gaan de deuren van het theater open?</span>
                        <span class="faq-arrow">▼</span>
                    </div>
                    <div class="faq-answer">
                        <p>Het theater en de bijbehorende foyer openen exact 1 uur voor aanvang van de voorstelling. We adviseren om ten minste 30 minuten voor aanvang aanwezig te zijn om rustig uw tickets te laten scannen en plaats te nemen.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>Kan ik mijn gereserveerde tickets annuleren of wijzigen?</span>
                        <span class="faq-arrow">▼</span>
                    </div>
                    <div class="faq-answer">
                        <p>Ja, dat kan tot 24 uur voor aanvang van de voorstelling. U kunt uw reservering wijzigen of annuleren via uw online account onder 'Mijn Tickets', of door contact op te nemen met onze ticketbalie via telefoon of e-mail.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>Is het theater toegankelijk voor rolstoelgebruikers?</span>
                        <span class="faq-arrow">▼</span>
                    </div>
                    <div class="faq-answer">
                        <p>Zeker. Theater Aurora is volledig drempelvrij en beschikt over speciale rolstoelplaatsen in de Grote Zaal. Neem vooraf telefonisch contact met ons op om een specifieke rolstoelplaats te reserveren.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>Is er een garderobe aanwezig en is deze bewaakt?</span>
                        <span class="faq-arrow">▼</span>
                    </div>
                    <div class="faq-answer">
                        <p>Ja, er is een gratis bewaakte garderobe aanwezig in de centrale hal. Om veiligheidsredenen is het niet toegestaan om grote jassen en tassen mee te nemen in de Grote Zaal.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>Kan ik aan de bar met contant geld betalen?</span>
                        <span class="faq-arrow">▼</span>
                    </div>
                    <div class="faq-answer">
                        <p>Nee, Theater Aurora is een 'cashless' theater. U kunt bij ons alleen betalen met PIN, creditcard of met de speciale Theater Aurora Cadeaukaart.</p>
                    </div>
                </div>
            </div>
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
