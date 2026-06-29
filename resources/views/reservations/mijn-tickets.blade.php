<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mijn Tickets - Theater Aurora</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700&family=Outfit:wght@300;400;500;700&display=swap" rel="stylesheet">
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
        .btn-gold { background:var(--gold); color:#070709 !important; padding:.5rem 1.5rem; border-radius:30px; font-weight:700; }

        .container { max-width:1000px; margin:0 auto; padding:4rem 2rem; }
        h1 { font-family:'Playfair Display',serif; font-size:2.5rem; margin-bottom:.5rem; }
        .subtitle { color:var(--muted); margin-bottom:3rem; }

        .flash { padding:1rem 1.5rem; border-radius:8px; margin-bottom:1.5rem; }
        .flash.success { background:rgba(76,175,80,.1); border:1px solid rgba(76,175,80,.4); color:#4caf50; font-weight:600; }

        .ticket-card {
            background:var(--surface); border:1px solid var(--border); border-radius:16px;
            padding:1.8rem; margin-bottom:1.5rem;
            display:flex; justify-content:space-between; align-items:center; gap:1.5rem;
            transition:border-color .3s;
        }
        .ticket-card:hover { border-color:rgba(212,175,55,.3); }
        .tc-left { flex: 1; }
        .tc-left h3 { font-family:'Playfair Display',serif; font-size:1.4rem; margin-bottom:.3rem; }
        .tc-meta { color:var(--muted); font-size:.9rem; }
        .tc-meta span { margin-right:1.2rem; }
        .tc-barcode { font-family:monospace; color:var(--gold); letter-spacing:2px; font-size:.9rem; margin-top:.5rem; }
        .badge-status { display:inline-block; padding:.3rem .8rem; border-radius:20px; font-size:.8rem; font-weight:600; text-transform:uppercase; }
        .badge-gereserveerd { background:rgba(212,175,55,.1); color:var(--gold); border:1px solid rgba(212,175,55,.3); }
        .badge-gescand { background:rgba(76,175,80,.1); color:#4caf50; border:1px solid rgba(76,175,80,.3); }
        .badge-geannuleerd { background:rgba(229,57,53,.1); color:#e53935; border:1px solid rgba(229,57,53,.3); }

        .qr-code {
            text-align: center;
            padding: 10px;
            background: #fff;
            border-radius: 8px;
            min-width: 120px;
        }
        .qr-code img {
            width: 100px;
            height: 100px;
        }
        .qr-label {
            font-size: 0.7rem;
            color: #333;
            margin-top: 5px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .empty { text-align:center; padding:5rem 2rem; color:var(--muted); }
        .empty h2 { color:#fff; margin:.5rem 0 1rem; }

        .btn-primary { display:inline-block; background:var(--gold); color:#070709; padding:1rem 2.5rem; font-weight:700; text-decoration:none; border-radius:4px; text-transform:uppercase; letter-spacing:1px; transition:all .3s; }
        .btn-primary:hover { background:#fff; transform:translateY(-2px); }
    </style>
</head>
<body>
<nav>
    <a href="/" class="logo">Aurora<span>.</span></a>
    <ul class="nav-links">
        <li><a href="/">Home</a></li>
        <li>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" style="background:none;border:none;color:var(--muted);cursor:pointer;font-family:'Outfit',sans-serif;font-size:1rem;">Uitloggen</button>
            </form>
        </li>
    </ul>
</nav>

<div class="container">
    <h1>Mijn Tickets</h1>
    <p class="subtitle">Welkom, {{ Auth::user()->name }}. Hier vind je al jouw reserveringen met QR-codes.</p>

    @if(session('success'))
        <div class="flash success">✅ {{ session('success') }}</div>
    @endif

    @if($reservations->isEmpty())
        <div class="empty">
            <div style="font-size:3rem;">🎫</div>
            <h2>Nog geen tickets</h2>
            <p>U heeft nog geen tickets gereserveerd.</p>
            <a href="/#voorstellingen" class="btn-primary" style="margin-top:2rem;">Reserveer Nu</a>
        </div>
    @else
        @foreach($reservations as $r)
        <div class="ticket-card">
            <div class="tc-left">
                <h3>{{ $r->show_name }}</h3>
                <div class="tc-meta">
                    <span>📅 {{ \Carbon\Carbon::parse($r->show_date)->format('d M Y') }}</span>
                    <span>⏰ {{ \Carbon\Carbon::parse($r->show_date)->format('H:i') }}</span>
                    <span>🎟️ {{ $r->number_of_tickets }} ticket(s)</span>
                </div>
                <div class="tc-barcode">{{ $r->ticket_barcode }}</div>
            </div>
            <div class="qr-code">
                {!! QrCode::size(100)->generate($r->ticket_barcode) !!}
                <div class="qr-label">Scan bij ingang</div>
            </div>
            <div style="display:flex; flex-direction:column; gap:0.8rem; align-items:flex-end;">
                <span class="badge-status badge-{{ $r->status }}">{{ $r->status }}</span>
            </div>
        </div>
        @endforeach
    @endif
</div>
</body>
</html>
