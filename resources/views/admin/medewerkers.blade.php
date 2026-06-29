<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overzicht Medewerkers - Theater Aurora</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700&family=Outfit:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --gold: #d4af37;
            --gold-glow: rgba(212, 175, 55, 0.25);
            --dark-bg: #070709;
            --surface: #121216;
            --border: rgba(255,255,255,0.06);
            --text: #fcfcfc;
            --muted: #9aa0a6;
            --red: #e53935;
            --green: #4caf50;
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Outfit',sans-serif; background:var(--dark-bg); color:var(--text); min-height:100vh; display:flex; }

        /* SIDEBAR */
        .sidebar {
            width:260px; min-height:100vh; background:#0c0c10; border-right:1px solid var(--border);
            display:flex; flex-direction:column; padding:2rem 1.5rem; position:fixed; left:0; top:0; bottom:0;
        }
        .logo { font-family:'Playfair Display',serif; font-size:1.8rem; color:#fff; font-weight:700; text-decoration:none; margin-bottom:3rem; }
        .logo span { color:var(--gold); }
        .nav-item { display:flex; align-items:center; gap:.75rem; padding:.85rem 1rem; color:var(--muted); text-decoration:none; border-radius:8px; margin-bottom:.4rem; font-size:.95rem; transition:all .2s; }
        .nav-item.active, .nav-item:hover { background:rgba(212,175,55,.08); color:var(--gold); }
        .nav-item.active { font-weight:600; }
        .sidebar-bottom { margin-top:auto; padding-top:1.5rem; border-top:1px solid var(--border); }
        .sidebar-user-name { font-weight:600; color:#fff; font-size:.95rem; }
        .sidebar-user-role { color:var(--gold); font-size:.8rem; text-transform:uppercase; letter-spacing:1px; margin-bottom:1rem; }
        .btn-logout { width:100%; background:transparent; border:1px solid var(--border); color:var(--muted); padding:.6rem 1rem; border-radius:8px; cursor:pointer; font-family:'Outfit',sans-serif; transition:all .3s; }
        .btn-logout:hover { border-color:var(--red); color:var(--red); }

        /* MAIN */
        .main { margin-left:260px; flex:1; padding:3rem; }
        .page-header { display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:2rem; gap:1rem; }
        .page-header-text h1 { font-family:'Playfair Display',serif; font-size:2.2rem; }
        .page-header-text p { color:var(--muted); margin-top:.3rem; }

        /* FLASH */
        .flash { padding:1rem 1.5rem; border-radius:8px; margin-bottom:1.5rem; font-weight:500; }
        .flash.success { background:rgba(76,175,80,.1); border:1px solid rgba(76,175,80,.4); color:#4caf50; }
        .flash.error { background:rgba(229,57,53,.1); border:1px solid rgba(229,57,53,.4); color:#e53935; }

        /* TOOLBAR */
        .toolbar { display:flex; align-items:center; gap:1rem; margin-bottom:1.5rem; flex-wrap:wrap; }
        .stat-badge { background:var(--surface); border:1px solid var(--border); border-radius:10px; padding:.7rem 1.2rem; font-size:.9rem; color:var(--muted); white-space:nowrap; }
        .stat-badge strong { color:#fff; }

        /* BUTTONS */
        .btn-primary { background:var(--gold); color:#070709; border:none; padding:.75rem 1.5rem; border-radius:8px; font-size:.95rem; font-weight:700; font-family:'Outfit',sans-serif; cursor:pointer; letter-spacing:.5px; transition:all .2s; white-space:nowrap; }
        .btn-primary:hover { background:#fff; }

        /* TABLE */
        .table-wrap { background:var(--surface); border:1px solid var(--border); border-radius:16px; overflow:hidden; }
        table { width:100%; border-collapse:collapse; }
        thead th { padding:1rem 1.2rem; text-align:left; font-size:.8rem; text-transform:uppercase; letter-spacing:1px; color:var(--muted); font-weight:500; border-bottom:1px solid var(--border); background:rgba(255,255,255,.02); }
        tbody td { padding:1rem 1.2rem; border-bottom:1px solid var(--border); vertical-align:middle; font-size:.95rem; }
        tbody tr:last-child td { border-bottom:none; }
        tbody tr:hover { background:rgba(255,255,255,.015); }

        .td-name { font-weight:600; color:#fff; }
        .td-email { color:var(--muted); font-size:.9rem; }
        .badge-role { display:inline-block; padding:.3rem .8rem; border-radius:20px; font-size:.8rem; font-weight:600; text-transform:uppercase; letter-spacing:.5px; background:rgba(212,175,55,.1); color:var(--gold); border:1px solid rgba(212,175,55,.3); }
        .avatar { width:36px; height:36px; border-radius:50%; background:rgba(212,175,55,.15); border:1px solid rgba(212,175,55,.3); display:inline-flex; align-items:center; justify-content:center; font-weight:700; font-size:.85rem; color:var(--gold); text-transform:uppercase; flex-shrink:0; }
        .btn-del { background:rgba(229,57,53,.1); color:var(--red); border:1px solid rgba(229,57,53,.3); padding:.45rem .9rem; border-radius:6px; font-size:.82rem; font-weight:600; cursor:pointer; font-family:'Outfit',sans-serif; transition:all .2s; }
        .btn-del:hover { background:var(--red); color:#fff; }

        /* EMPTY STATE */
        .empty { padding:5rem 2rem; text-align:center; color:var(--muted); }
        .empty-icon { font-size:3rem; margin-bottom:1rem; }
        .empty h3 { color:#fff; margin-bottom:.5rem; }

        /* MODAL */
        .modal-backdrop { display:none; position:fixed; inset:0; background:rgba(0,0,0,.7); backdrop-filter:blur(6px); z-index:999; align-items:center; justify-content:center; }
        .modal-backdrop.open { display:flex; }
        .modal { background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:2.5rem; width:100%; max-width:480px; position:relative; }
        .modal h2 { font-family:'Playfair Display',serif; font-size:1.8rem; margin-bottom:1.5rem; }
        .modal-close { position:absolute; top:1.5rem; right:1.5rem; background:transparent; border:none; color:var(--muted); font-size:1.5rem; cursor:pointer; }
        .modal-close:hover { color:#fff; }
        .form-group { margin-bottom:1.2rem; }
        .form-group label { display:block; font-size:.85rem; color:var(--muted); text-transform:uppercase; letter-spacing:1px; margin-bottom:.4rem; }
        .form-control { width:100%; padding:.85rem 1rem; background:rgba(0,0,0,.4); border:1px solid var(--border); border-radius:8px; color:#fff; font-family:'Outfit',sans-serif; font-size:1rem; outline:none; transition:border .3s; }
        .form-control:focus { border-color:var(--gold); }
        .form-error { color:#e53935; font-size:.82rem; margin-top:.3rem; }
        .btn-save { width:100%; background:var(--gold); color:#070709; border:none; padding:1rem; font-size:1rem; font-weight:700; border-radius:8px; cursor:pointer; font-family:'Outfit',sans-serif; letter-spacing:1px; text-transform:uppercase; transition:all .3s; margin-top:.5rem; }
        .btn-save:hover { background:#fff; }
    </style>
</head>
<body>

<!-- Sidebar -->
<aside class="sidebar">
    <a href="/" class="logo">Aurora<span>.</span></a>
    <nav>
        <a href="/medewerker/tickets" class="nav-item">🎫 Ticketbeheer</a>
        <a href="/admin/medewerkers" class="nav-item active">👥 Medewerkers</a>
        <a href="#" class="nav-item">🎭 Voorstellingen</a>
        <a href="#" class="nav-item">📡 Scanner</a>
    </nav>
    <div class="sidebar-bottom">
        <div class="sidebar-user-name">{{ Auth::user()->name }}</div>
        <div class="sidebar-user-role">{{ Auth::user()->role }}</div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout">Uitloggen</button>
        </form>
    </div>
</aside>

<!-- Main Content -->
<main class="main">
    <div class="page-header">
        <div class="page-header-text">
            <h1>Overzicht Medewerkers</h1>
            <p>Bekijk en beheer hier alle medewerkers van Theater Aurora.</p>
        </div>
        <button class="btn-primary" onclick="openModal()">+ Medewerker toevoegen</button>
    </div>

    @if(session('success'))
        <div class="flash success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="flash error">{{ $errors->first() }}</div>
    @endif

    <div class="toolbar">
        <div class="stat-badge">Medewerkers: <strong>{{ $employees->count() }}</strong></div>
    </div>

    <div class="table-wrap">
        @if($employees->isEmpty())
            <div class="empty">
                <div class="empty-icon">👥</div>
                <h3>Er zijn geen medewerkers gevonden.</h3>
                <p>Voeg een medewerker toe via de knop rechtsboven.</p>
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Naam</th>
                        <th>E-mailadres</th>
                        <th>Rol</th>
                        <th>Lid sinds</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employees as $employee)
                    <tr>
                        <td style="color:var(--muted); font-size:.85rem;">#{{ str_pad($employee->id, 5, '0', STR_PAD_LEFT) }}</td>
                        <td>
                            <div style="display:flex; align-items:center; gap:.75rem;">
                                <div class="avatar">{{ substr($employee->name, 0, 2) }}</div>
                                <span class="td-name">{{ $employee->name }}</span>
                            </div>
                        </td>
                        <td class="td-email">{{ $employee->email }}</td>
                        <td><span class="badge-role">{{ $employee->role }}</span></td>
                        <td style="color:var(--muted);">{{ $employee->created_at->format('d M Y') }}</td>
                        <td>
                            {{-- DELETE via POST-spoofing, HTML ondersteunt geen DELETE --}}
                            <form method="POST" action="{{ route('admin.medewerkers.destroy', $employee->id) }}" onsubmit="return confirm('Weet je zeker dat je {{ $employee->name }} wil verwijderen?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-del">🗑️ Verwijder</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</main>

{{-- Blade-directieven werken niet in <script>, dus via hidden input --}}
<input type="hidden" id="hasErrors" value="{{ $errors->any() ? '1' : '0' }}">

<!-- Modal: Medewerker toevoegen -->
<div class="modal-backdrop" id="addModal">
    <div class="modal">
        <button class="modal-close" onclick="closeModal()">✕</button>
        <h2>Medewerker toevoegen</h2>
        <form method="POST" action="{{ route('admin.medewerkers.store') }}">
            @csrf
            <div class="form-group">
                <label>Naam</label>
                <input type="text" name="name" class="form-control" placeholder="Voor- en achternaam" value="{{ old('name') }}" required>
            </div>
            <div class="form-group">
                <label>E-mailadres</label>
                <input type="email" name="email" class="form-control" placeholder="naam@aurora.nl" value="{{ old('email') }}" required>
            </div>
            <div class="form-group">
                <label>Wachtwoord</label>
                <input type="password" name="password" class="form-control" placeholder="Minimaal 8 tekens" required>
            </div>
            <button type="submit" class="btn-save">Medewerker toevoegen</button>
        </form>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('addModal').classList.add('open');
    }
    function closeModal() {
        document.getElementById('addModal').classList.remove('open');
    }
    document.getElementById('addModal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });

    if (document.getElementById('hasErrors').value === '1') {
        openModal();
    }
</script>

</body>
</html>
