<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Reserveren - Theater Aurora</title>
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
        body {
            font-family:'Outfit',sans-serif; background:var(--dark-bg); color:var(--text);
            min-height:100vh; display:flex; flex-direction:column;
            background: linear-gradient(135deg,rgba(7,7,9,.95),rgba(7,7,9,.7)),
                url('https://images.unsplash.com/photo-1507676184212-d0c30a510c55?q=80&w=2070&auto=format&fit=crop') center/cover fixed;
        }
        nav {
            display:flex; justify-content:space-between; align-items:center;
            padding:1.2rem 5%; background:rgba(7,7,9,.85); backdrop-filter:blur(16px);
            border-bottom:1px solid var(--border);
        }
        .logo { font-family:'Playfair Display',serif; font-size:1.8rem; color:#fff; text-decoration:none; }
        .logo span { color:var(--gold); }

        main { flex:1; display:flex; align-items:center; justify-content:center; padding:3rem 1rem; }
        .card {
            background:rgba(18,18,22,.9); backdrop-filter:blur(20px); border:1px solid var(--border);
            border-radius:24px; padding:3rem; width:100%; max-width:580px;
            box-shadow:0 30px 60px rgba(0,0,0,.6);
        }
        h1 { font-family:'Playfair Display',serif; font-size:2.2rem; margin-bottom:.4rem; }
        .subtitle { color:var(--muted); margin-bottom:2.5rem; }

        .show-grid { display:grid; grid-template-columns:1fr 1fr; gap:.75rem; margin-bottom:1.5rem; }
        .show-option { display:none; }
        .show-option + label {
            display:block; padding:1rem; border:1px solid var(--border); border-radius:10px;
            cursor:pointer; transition:all .2s;
        }
        .show-option:checked + label { border-color:var(--gold); background:rgba(212,175,55,.08); }
        .show-option + label .show-name { font-weight:700; color:#fff; margin-bottom:.2rem; }
        .show-option + label .show-date { font-size:.82rem; color:var(--muted); }

        .form-group { margin-bottom:1.3rem; }
        .form-group label { display:block; font-size:.85rem; color:var(--muted); text-transform:uppercase; letter-spacing:1px; margin-bottom:.4rem; }
        .form-control { width:100%; padding:.9rem 1rem; background:rgba(0,0,0,.4); border:1px solid var(--border); border-radius:10px; color:#fff; font-family:'Outfit',sans-serif; font-size:1rem; outline:none; transition:border .3s; }
        .form-control:focus { border-color:var(--gold); }

        .btn-submit { width:100%; background:var(--gold); color:#070709; border:none; padding:1.1rem; font-size:1rem; font-weight:700; border-radius:10px; cursor:pointer; font-family:'Outfit',sans-serif; letter-spacing:1.5px; text-transform:uppercase; transition:all .3s; margin-top:.5rem; }
        .btn-submit:hover { background:#fff; transform:translateY(-2px); box-shadow:0 8px 20px var(--gold-glow); }
        .back { display:block; text-align:center; margin-top:1.5rem; color:var(--muted); text-decoration:none; transition:color .3s; }
        .back:hover { color:var(--gold); }
        .error { color:#e53935; font-size:.85rem; margin-top:.3rem; }
    </style>
</head>
<body>
<nav>
    <a href="/" class="logo">Aurora<span>.</span></a>
</nav>

<main>
    <div class="card">
        <h1>Ticket Reserveren</h1>
        <p class="subtitle">Kies uw voorstelling en reserveer direct uw plaatsen.</p>

        @if($errors->any())
            <div style="background:rgba(229,57,53,.1);border:1px solid rgba(229,57,53,.4);padding:1rem;border-radius:8px;margin-bottom:1.5rem;color:#e53935;">
                @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('reserveer') }}">
            @csrf

            <div class="form-group">
                <label>Kies een Voorstelling</label>
                <div class="show-grid">
                    <div>
                        <input class="show-option" type="radio" name="show_name" id="s1" value="Zwanenmeer Klassiek" required {{ old('show_name') === 'Zwanenmeer Klassiek' ? 'checked' : '' }}>
                        <label for="s1">
                            <div class="show-name">Zwanenmeer Klassiek</div>
                            <div class="show-date">12 Juni 2026 • 20:00</div>
                        </label>
                    </div>
                    <div>
                        <input class="show-option" type="radio" name="show_name" id="s2" value="Jazz Night: The Legends" {{ old('show_name') === 'Jazz Night: The Legends' ? 'checked' : '' }}>
                        <label for="s2">
                            <div class="show-name">Jazz Night: The Legends</div>
                            <div class="show-date">18 Juni 2026 • 19:30</div>
                        </label>
                    </div>
                    <div>
                        <input class="show-option" type="radio" name="show_name" id="s3" value="Hamlet Modern" {{ old('show_name') === 'Hamlet Modern' ? 'checked' : '' }}>
                        <label for="s3">
                            <div class="show-name">Hamlet Modern</div>
                            <div class="show-date">24 Juni 2026 • 20:15</div>
                        </label>
                    </div>
                    <div>
                        <input class="show-option" type="radio" name="show_name" id="s4" value="Cinema in Concert" {{ old('show_name') === 'Cinema in Concert' ? 'checked' : '' }}>
                        <label for="s4">
                            <div class="show-name">Cinema in Concert</div>
                            <div class="show-date">02 Juli 2026 • 15:00</div>
                        </label>
                    </div>
                </div>
            </div>

            <input type="hidden" name="show_date" id="show_date_input" value="{{ old('show_date') }}">

            <div class="form-group">
                <label for="number_of_tickets">Aantal Tickets (max. 10)</label>
                <input type="number" id="number_of_tickets" name="number_of_tickets" class="form-control" min="1" max="10" value="{{ old('number_of_tickets', 2) }}" required>
            </div>

            <button type="submit" class="btn-submit">Reservering Bevestigen</button>
        </form>

        <a href="{{ route('mijn.tickets') }}" class="back">&larr; Mijn tickets bekijken</a>
    </div>
</main>

<script>
// Automatisch de datum koppelen aan de voorstelling
const showDates = {
    'Zwanenmeer Klassiek': '2026-06-12 20:00:00',
    'Jazz Night: The Legends': '2026-06-18 19:30:00',
    'Hamlet Modern': '2026-06-24 20:15:00',
    'Cinema in Concert': '2026-07-02 15:00:00',
};
document.querySelectorAll('.show-option').forEach(radio => {
    radio.addEventListener('change', () => {
        document.getElementById('show_date_input').value = showDates[radio.value] || '';
    });
});
// Set initial
const checked = document.querySelector('.show-option:checked');
if (checked) document.getElementById('show_date_input').value = showDates[checked.value] || '';
</script>
</body>
</html>
