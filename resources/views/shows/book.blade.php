<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tickets Bestellen - {{ $show->title }} - Theater Aurora</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Outfit:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --gold: #d4af37;
            --gold-glow: rgba(212,175,55,.3);
            --dark-bg: #070709;
            --surface: #121216;
            --border: rgba(255,255,255,.06);
            --text: #fcfcfc;
            --muted: #9aa0a6;
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Outfit',sans-serif; background:var(--dark-bg); color:var(--text); min-height:100vh; }
        nav {
            display:flex; justify-content:space-between; align-items:center;
            padding:1.2rem 5%; background:rgba(7,7,9,.9); backdrop-filter:blur(16px);
            border-bottom:1px solid var(--border); position:sticky; top:0; z-index:100;
        }
        .logo { font-family:'Playfair Display',serif; font-size:1.8rem; color:#fff; text-decoration:none; }
        .logo span { color:var(--gold); }
        .nav-links { display:flex; gap:1.5rem; align-items:center; list-style:none; }
        .nav-links a { color:var(--muted); text-decoration:none; transition:color .3s; }
        .nav-links a:hover { color:var(--gold); }

        .container { max-width:1200px; margin:0 auto; padding:6rem 2rem 4rem; }

        .booking-grid {
            display:grid;
            grid-template-columns: 1fr 1fr;
            gap:4rem;
            margin-top:2rem;
        }

        .show-details {
            background:var(--surface);
            border:1px solid var(--border);
            border-radius:16px;
            overflow:hidden;
        }

        .show-image {
            width:100%;
            height:300px;
            object-fit:cover;
        }

        .show-info {
            padding:2rem;
        }

        .show-info h1 {
            font-family:'Playfair Display',serif;
            font-size:2rem;
            margin-bottom:1rem;
        }

        .show-meta {
            display:flex;
            flex-direction:column;
            gap:0.5rem;
            margin-bottom:1.5rem;
            color:var(--muted);
        }

        .show-meta span {
            display:flex;
            align-items:center;
            gap:0.5rem;
        }

        .show-description {
            color:var(--muted);
            line-height:1.6;
            margin-bottom:1.5rem;
        }

        .price-tag {
            font-size:1.5rem;
            color:var(--gold);
            font-weight:700;
        }

        .booking-form {
            background:var(--surface);
            border:1px solid var(--border);
            border-radius:16px;
            padding:2rem;
            height:fit-content;
        }

        .booking-form h2 {
            font-family:'Playfair Display',serif;
            font-size:1.5rem;
            margin-bottom:1.5rem;
        }

        .form-group {
            margin-bottom:1.5rem;
        }

        .form-group label {
            display:block;
            margin-bottom:0.5rem;
            color:var(--muted);
            font-size:0.9rem;
        }

        .form-group input,
        .form-group select {
            width:100%;
            padding:1rem;
            background:rgba(0,0,0,0.3);
            border:1px solid var(--border);
            border-radius:8px;
            color:var(--text);
            font-family:'Outfit',sans-serif;
            font-size:1rem;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline:none;
            border-color:var(--gold);
        }

        .order-summary {
            background:rgba(0,0,0,0.2);
            border-radius:8px;
            padding:1.5rem;
            margin-bottom:1.5rem;
        }

        .order-row {
            display:flex;
            justify-content:space-between;
            margin-bottom:0.5rem;
            color:var(--muted);
        }

        .order-row.total {
            border-top:1px solid var(--border);
            padding-top:0.5rem;
            margin-top:0.5rem;
            color:var(--gold);
            font-weight:700;
            font-size:1.1rem;
        }

        .btn-primary {
            display:block;
            width:100%;
            background:var(--gold);
            color:#070709;
            padding:1rem;
            border:none;
            border-radius:8px;
            font-weight:700;
            font-size:1rem;
            text-transform:uppercase;
            letter-spacing:1px;
            cursor:pointer;
            transition:all .3s;
            text-decoration:none;
            text-align:center;
        }

        .btn-primary:hover {
            background:#fff;
            transform:translateY(-2px);
        }

        .btn-secondary {
            display:inline-block;
            background:transparent;
            color:var(--muted);
            padding:0.5rem 1rem;
            border:1px solid var(--border);
            border-radius:6px;
            text-decoration:none;
            font-size:0.9rem;
            transition:all .3s;
        }

        .btn-secondary:hover {
            color:var(--gold);
            border-color:var(--gold);
        }

        .flash {
            padding:1rem 1.5rem;
            border-radius:8px;
            margin-bottom:1.5rem;
        }
        .flash.error {
            background:rgba(229,57,53,.1);
            border:1px solid rgba(229,57,53,.4);
            color:#e53935;
        }
        .flash.success {
            background:rgba(76,175,80,.1);
            border:1px solid rgba(76,175,80,.4);
            color:#4caf50;
        }

        @media (max-width: 768px) {
            .booking-grid {
                grid-template-columns: 1fr;
                gap:2rem;
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
            <li><a href="{{ route('mijn.tickets') }}" class="btn-gold">Mijn Tickets</a></li>
        </ul>
    </nav>

    <div class="container">
        <a href="/" class="btn-secondary" style="margin-bottom:2rem;">&larr; Terug naar overzicht</a>

        @if(session('error'))
            <div class="flash error">{{ session('error') }}</div>
        @endif

        <div class="booking-grid">
            <div class="show-details">
                <img src="{{ $show->image_url }}" alt="{{ $show->title }}" class="show-image">
                <div class="show-info">
                    <h1>{{ $show->title }}</h1>
                    <div class="show-meta">
                        <span>📅 {{ $show->date->format('d M Y') }}</span>
                        <span>⏰ {{ $show->date->format('H:i') }}</span>
                        <span>📍 {{ $show->location }}</span>
                        <span>🎭 {{ $show->category }}</span>
                    </div>
                    <p class="show-description">{{ $show->description }}</p>
                    <p class="price-tag">€ {{ number_format($show->price, 2) }} per ticket</p>
                    <p style="margin-top:1rem; color:var(--muted); font-size:0.9rem;">
                        Nog {{ $show->available_tickets }} tickets beschikbaar
                    </p>
                </div>
            </div>

            <div class="booking-form">
                <h2>Tickets Bestellen</h2>

                <form action="{{ route('shows.book.store', $show) }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="number_of_tickets">Aantal tickets</label>
                        <select name="number_of_tickets" id="number_of_tickets" required onchange="updateTotal()">
                            @for($i = 1; $i <= min(10, $show->available_tickets); $i++)
                                <option value="{{ $i }}">{{ $i }} ticket{{ $i > 1 ? 's' : '' }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="order-summary">
                        <div class="order-row">
                            <span>Show</span>
                            <span>{{ $show->title }}</span>
                        </div>
                        <div class="order-row">
                            <span>Datum</span>
                            <span>{{ $show->date->format('d M Y, H:i') }}</span>
                        </div>
                        <div class="order-row">
                            <span>Prijs per ticket</span>
                            <span>€ {{ number_format($show->price, 2) }}</span>
                        </div>
                        <div class="order-row">
                            <span>Aantal</span>
                            <span id="summary-quantity">1</span>
                        </div>
                        <div class="order-row total">
                            <span>Totaal</span>
                            <span id="summary-total">€ {{ number_format($show->price, 2) }}</span>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary">Bestel Tickets</button>
                </form>

                <p style="margin-top:1.5rem; font-size:0.85rem; color:var(--muted); text-align:center;">
                    Na aankoop ontvangt u uw tickets met QR-code in uw account.
                </p>
            </div>
        </div>
    </div>

    <script>
        const price = {{ $show->price }};

        function updateTotal() {
            const quantity = document.getElementById('number_of_tickets').value;
            const total = price * quantity;
            document.getElementById('summary-quantity').textContent = quantity;
            document.getElementById('summary-total').textContent = '€ ' + total.toFixed(2);
        }
    </script>
</body>
</html>