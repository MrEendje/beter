<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inloggen - Theater Aurora</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Outfit:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --gold: #d4af37;
            --gold-glow: rgba(212, 175, 55, 0.4);
            --dark-bg: #070709;
            --border-glass: rgba(255, 255, 255, 0.05);
            --text-main: #fcfcfc;
            --text-muted: #9aa0a6;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--dark-bg);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(7,7,9,0.9) 0%, rgba(7,7,9,0.6) 100%),
                        url('https://images.unsplash.com/photo-1507676184212-d0c30a510c55?q=80&w=2070&auto=format&fit=crop') center/cover fixed;
        }

        .auth-container {
            background: rgba(18, 18, 22, 0.85);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border-glass);
            border-radius: 24px;
            padding: 4rem;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 30px 60px rgba(0,0,0,0.8);
            position: relative;
            overflow: hidden;
        }

        .auth-container::before {
            content: '';
            position: absolute;
            top: -50px; right: -50px;
            width: 150px; height: 150px;
            background: radial-gradient(circle, var(--gold-glow) 0%, transparent 70%);
            z-index: 0;
        }

        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            color: var(--text-main);
            font-weight: 700;
            text-align: center;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
        }
        .logo span { color: var(--gold); }

        .auth-subtitle {
            text-align: center;
            color: var(--text-muted);
            margin-bottom: 3rem;
            font-size: 1rem;
            position: relative;
            z-index: 1;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
            z-index: 1;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--text-muted);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .form-control {
            width: 100%;
            padding: 1rem 1.5rem;
            background: rgba(0,0,0,0.4);
            border: 1px solid var(--border-glass);
            border-radius: 12px;
            color: #fff;
            font-family: 'Outfit', sans-serif;
            font-size: 1rem;
            transition: all 0.3s;
            outline: none;
        }

        .form-control:focus {
            border-color: var(--gold);
            box-shadow: 0 0 10px var(--gold-glow);
        }

        .btn-submit {
            width: 100%;
            background: var(--gold);
            color: var(--dark-bg);
            border: none;
            padding: 1.2rem;
            font-size: 1.1rem;
            font-weight: 700;
            border-radius: 12px;
            text-transform: uppercase;
            letter-spacing: 2px;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 1rem;
            position: relative;
            z-index: 1;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px var(--gold-glow);
            background: #fff;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 2rem;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s;
            position: relative;
            z-index: 1;
        }
        .back-link:hover { color: var(--gold); }
    </style>
</head>
<body>

    <div class="auth-container">
        <div class="logo">Aurora<span>.</span></div>
        <p class="auth-subtitle">Welkom terug, log in op uw account.</p>

        <form method="POST" action="{{ url('/login') }}">
            @csrf

            @if ($errors->any())
                <div style="background: rgba(255, 0, 0, 0.1); border: 1px solid #ff4d4d; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; color: #ff4d4d; font-size: 0.9rem; text-align: center;">
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif

            <div class="form-group">
                <label for="email">E-mailadres</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Wachtwoord</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn-submit">Inloggen</button>
        </form>

        <a href="/" class="back-link">&larr; Terug naar de homepagina</a>
    </div>

</body>
</html>
