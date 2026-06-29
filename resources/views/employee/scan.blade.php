<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Scannen - Theater Aurora</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700&family=Outfit:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --gold: #d4af37;
            --dark-bg: #070709;
            --surface: #121216;
            --border: rgba(255,255,255,0.06);
            --text: #fcfcfc;
            --muted: #9aa0a6;
            --green: #4caf50;
            --red: #e53935;
            --orange: #ff9800;
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Outfit',sans-serif; background:var(--dark-bg); color:var(--text); min-height:100vh; display:flex; flex-direction:column; align-items:center; justify-content:center; padding:2rem; }
        h1 { font-family:'Playfair Display',serif; color:var(--gold); margin-bottom:2rem; font-size:2rem; }
        .card { background:var(--surface); border:1px solid var(--border); border-radius:12px; padding:2rem; width:100%; max-width:480px; }
        .form-group { margin-bottom:1.5rem; }
        label { display:block; margin-bottom:.5rem; color:var(--muted); font-size:.875rem; }
        input[type=text] { width:100%; padding:.875rem 1rem; background:#1c1c22; border:1px solid var(--border); border-radius:8px; color:var(--text); font-size:1rem; font-family:'Outfit',sans-serif; }
        input[type=text]:focus { outline:none; border-color:var(--gold); }
        button { width:100%; padding:.875rem; background:var(--gold); color:#000; border:none; border-radius:8px; font-size:1rem; font-weight:600; cursor:pointer; font-family:'Outfit',sans-serif; }
        button:hover { opacity:.9; }
        .alert { padding:1rem 1.25rem; border-radius:8px; margin-bottom:1.5rem; font-weight:500; }
        .alert-success { background:rgba(76,175,80,.15); border:1px solid var(--green); color:var(--green); }
        .alert-error   { background:rgba(229,57,53,.15);  border:1px solid var(--red);   color:var(--red); }
        .alert-warning { background:rgba(255,152,0,.15);  border:1px solid var(--orange); color:var(--orange); }
        .back { display:inline-block; margin-top:1.5rem; color:var(--muted); text-decoration:none; font-size:.875rem; }
        .back:hover { color:var(--gold); }
    </style>
</head>
<body>
    <h1>Ticket Scannen</h1>
    <div class="card">
        @if(session('success'))
            <div class="alert alert-success">✓ {{ session('success') }}</div>
        @endif
        @if(session('warning'))
            <div class="alert alert-warning">⚠ {{ session('warning') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">✗ {{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('tickets.scan') }}">
            @csrf
            <div class="form-group">
                <label for="barcode">Barcode</label>
                <input type="text" id="barcode" name="barcode" placeholder="AUR-..." autofocus autocomplete="off">
            </div>
            <button type="submit">Scannen</button>
        </form>
    </div>
    <a href="{{ route('tickets.index') }}" class="back">← Terug naar ticketoverzicht</a>
</body>
</html>
