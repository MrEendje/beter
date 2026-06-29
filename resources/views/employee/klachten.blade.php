<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klachten & Berichten - Theater Aurora</title>
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
            --blue: #2196f3;
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Outfit',sans-serif; background:var(--dark-bg); color:var(--text); min-height:100vh; display:flex; }

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

        .main { margin-left:260px; flex:1; padding:3rem; }
        .page-header { margin-bottom:2rem; }
        .page-header h1 { font-family:'Playfair Display',serif; font-size:2.2rem; }
        .page-header p { color:var(--muted); margin-top:.3rem; }

        .flash { padding:1rem 1.5rem; border-radius:8px; margin-bottom:1.5rem; font-weight:500; }
        .flash.success { background:rgba(76,175,80,.1); border:1px solid rgba(76,175,80,.4); color:#4caf50; }
        .flash.error { background:rgba(229,57,53,.1); border:1px solid rgba(229,57,53,.4); color:#e53935; }

        .toolbar { display:flex; align-items:center; gap:1rem; margin-bottom:1.5rem; flex-wrap:wrap; }
        .search-wrap { flex:1; min-width:250px; position:relative; }
        .search-wrap input {
            width:100%; padding:.85rem 1rem .85rem 3rem;
            background:var(--surface); border:1px solid var(--border); border-radius:10px;
            color:#fff; font-family:'Outfit',sans-serif; font-size:1rem; outline:none; transition:border .3s;
        }
        .search-wrap input:focus { border-color:var(--gold); }
        .search-wrap .icon { position:absolute; left:1rem; top:50%; transform:translateY(-50%); color:var(--muted); }
        .filter-select { padding:.85rem 1rem; background:var(--surface); border:1px solid var(--border); border-radius:10px; color:#fff; font-family:'Outfit',sans-serif; font-size:.95rem; outline:none; cursor:pointer; }
        .filter-select:focus { border-color:var(--gold); }
        .stat-badge { background:var(--surface); border:1px solid var(--border); border-radius:10px; padding:.7rem 1.2rem; font-size:.9rem; color:var(--muted); white-space:nowrap; }
        .stat-badge strong { color:#fff; }

        .table-wrap { background:var(--surface); border:1px solid var(--border); border-radius:16px; overflow:hidden; }
        table { width:100%; border-collapse:collapse; }
        thead th { padding:1rem 1.2rem; text-align:left; font-size:.8rem; text-transform:uppercase; letter-spacing:1px; color:var(--muted); font-weight:500; border-bottom:1px solid var(--border); background:rgba(255,255,255,.02); }
        tbody td { padding:1rem 1.2rem; border-bottom:1px solid var(--border); vertical-align:middle; font-size:.95rem; }
        tbody tr:last-child td { border-bottom:none; }
        tbody tr:hover { background:rgba(255,255,255,.015); }

        .td-name { font-weight:600; color:#fff; }
        .td-subject { color:#fff; }
        .td-message { color:var(--muted); font-size:.88rem; max-width:250px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }

        .badge-status { display:inline-block; padding:.3rem .8rem; border-radius:20px; font-size:.8rem; font-weight:600; text-transform:uppercase; letter-spacing:.5px; }
        .badge-nieuw { background:rgba(33,150,243,.1); color:var(--blue); border:1px solid rgba(33,150,243,.3); }
        .badge-in_behandeling { background:rgba(212,175,55,.1); color:var(--gold); border:1px solid rgba(212,175,55,.3); }
        .badge-gereed { background:rgba(76,175,80,.1); color:#4caf50; border:1px solid rgba(76,175,80,.3); }

        .actions { display:flex; gap:.5rem; flex-wrap:wrap; }
        .btn-action { padding:.45rem .9rem; border-radius:6px; font-size:.82rem; font-weight:600; border:none; cursor:pointer; font-family:'Outfit',sans-serif; transition:all .2s; text-decoration:none; display:inline-flex; align-items:center; gap:.3rem; }
        .btn-edit { background:rgba(212,175,55,.1); color:var(--gold); border:1px solid rgba(212,175,55,.3); }
        .btn-edit:hover { background:var(--gold); color:#070709; }
        .btn-del { background:rgba(229,57,53,.1); color:var(--red); border:1px solid rgba(229,57,53,.3); }
        .btn-del:hover { background:var(--red); color:#fff; }
        .btn-done { background:rgba(76,175,80,.1); color:#4caf50; border:1px solid rgba(76,175,80,.3); }
        .btn-done:hover { background:#4caf50; color:#fff; }

        .empty { padding:5rem 2rem; text-align:center; color:var(--muted); }
        .empty-icon { font-size:3rem; margin-bottom:1rem; }
        .empty h3 { color:#fff; margin-bottom:.5rem; }

        /* Modal */
        .modal-backdrop { display:none; position:fixed; inset:0; background:rgba(0,0,0,.7); backdrop-filter:blur(6px); z-index:999; align-items:center; justify-content:center; }
        .modal-backdrop.open { display:flex; }
        .modal { background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:2.5rem; width:100%; max-width:560px; position:relative; max-height:90vh; overflow-y:auto; }
        .modal h2 { font-family:'Playfair Display',serif; font-size:1.8rem; margin-bottom:1.5rem; }
        .modal-close { position:absolute; top:1.5rem; right:1.5rem; background:transparent; border:none; color:var(--muted); font-size:1.5rem; cursor:pointer; }
        .modal-close:hover { color:#fff; }
        .form-group { margin-bottom:1.2rem; }
        .form-group label { display:block; font-size:.85rem; color:var(--muted); text-transform:uppercase; letter-spacing:1px; margin-bottom:.4rem; }
        .form-control { width:100%; padding:.85rem 1rem; background:rgba(0,0,0,.4); border:1px solid var(--border); border-radius:8px; color:#fff; font-family:'Outfit',sans-serif; font-size:1rem; outline:none; transition:border .3s; }
        .form-control:focus { border-color:var(--gold); }
        .btn-save { width:100%; background:var(--gold); color:#070709; border:none; padding:1rem; font-size:1rem; font-weight:700; border-radius:8px; cursor:pointer; font-family:'Outfit',sans-serif; letter-spacing:1px; text-transform:uppercase; transition:all .3s; margin-top:.5rem; }
        .btn-save:hover { background:#fff; }

        /* Detail modal */
        .detail-row { display:flex; flex-direction:column; gap:.3rem; margin-bottom:1.2rem; }
        .detail-label { font-size:.8rem; color:var(--muted); text-transform:uppercase; letter-spacing:1px; }
        .detail-value { color:#fff; font-size:1rem; line-height:1.6; }
    </style>
</head>
<body>

<aside class="sidebar">
    <a href="/" class="logo">Aurora<span>.</span></a>
    <nav>
        <a href="/medewerker/tickets" class="nav-item">🎫 Ticketbeheer</a>
        @if(Auth::user()->role === 'administrator')
            <a href="/admin/medewerkers" class="nav-item">👥 Medewerkers</a>
        @endif
        <a href="{{ route('employee.shows.index') }}" class="nav-item">🎭 Voorstellingen</a>
        <a href="{{ route('tickets.scan') }}" class="nav-item">📡 Scanner</a>
        <a href="{{ route('employee.contacts.index') }}" class="nav-item active">📩 Klachten & Berichten</a>
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

<main class="main">
    <div class="page-header">
        <h1>Klachten & Berichten</h1>
        <p>Beheer alle ingestuurde contactberichten van bezoekers.</p>
    </div>

    @if(session('success'))
        <div class="flash success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="flash error">{{ session('error') }}</div>
    @endif

    <form method="GET" action="{{ route('employee.contacts.index') }}" class="toolbar">
        <div class="search-wrap">
            <span class="icon">🔍</span>
            <input type="text" name="search" placeholder="Zoek op naam, e-mail of onderwerp..." value="{{ request('search') }}" autocomplete="off">
        </div>
        <select name="status" class="filter-select" onchange="this.form.submit()">
            <option value="">Alle statussen</option>
            <option value="nieuw" {{ request('status') === 'nieuw' ? 'selected' : '' }}>Nieuw</option>
            <option value="in_behandeling" {{ request('status') === 'in_behandeling' ? 'selected' : '' }}>In behandeling</option>
            <option value="gereed" {{ request('status') === 'gereed' ? 'selected' : '' }}>Gereed</option>
        </select>
        <button type="submit" class="btn-action btn-edit" style="padding:.85rem 1.5rem;">Zoeken</button>
        @if(request('search') || request('status'))
            <a href="{{ route('employee.contacts.index') }}" class="btn-action btn-del">Wis filter</a>
        @endif
        <div class="stat-badge">Resultaten: <strong>{{ $contacts->count() }}</strong></div>
    </form>

    <div class="table-wrap">
        @if($contacts->isEmpty())
            <div class="empty">
                <div class="empty-icon">📩</div>
                <h3>Geen berichten gevonden</h3>
                <p>Er zijn nog geen contactberichten ontvangen.</p>
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Naam</th>
                        <th>E-mail</th>
                        <th>Onderwerp</th>
                        <th>Bericht</th>
                        <th>Status</th>
                        <th>Datum</th>
                        <th>Acties</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contacts as $c)
                    <tr>
                        <td style="color:var(--muted); font-size:.85rem;">#{{ str_pad($c->id, 5, '0', STR_PAD_LEFT) }}</td>
                        <td class="td-name">{{ $c->name }}</td>
                        <td style="color:var(--muted);">{{ $c->email }}</td>
                        <td class="td-subject">{{ $c->subject }}</td>
                        <td>
                            <span class="td-message" title="{{ $c->message }}">{{ $c->message }}</span>
                        </td>
                        <td><span class="badge-status badge-{{ $c->status }}">{{ str_replace('_', ' ', $c->status) }}</span></td>
                        <td style="color:var(--muted); font-size:.88rem;">{{ $c->created_at->format('d M Y • H:i') }}</td>
                        <td>
                            <div class="actions">
                                <button class="btn-action btn-edit"
                                    onclick="openEdit({{ $c->id }}, '{{ addslashes($c->name) }}', '{{ addslashes($c->email) }}', '{{ addslashes($c->subject) }}', '{{ addslashes($c->message) }}', '{{ $c->status }}')">
                                    ✏️ Wijzig
                                </button>
                                <form method="POST" action="{{ route('employee.contacts.done', $c->id) }}" style="display:inline;">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn-action btn-done" {{ $c->status === 'gereed' ? 'disabled style=opacity:.4;cursor:default;' : '' }}>✅ Gereed</button>
                                </form>
                                <form method="POST" action="{{ route('employee.contacts.destroy', $c->id) }}" style="display:inline;" onsubmit="return confirm('Weet je zeker dat je dit bericht wil verwijderen?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-action btn-del">🗑️ Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</main>

<!-- Edit Modal -->
<div class="modal-backdrop" id="editModal">
    <div class="modal">
        <button class="modal-close" onclick="closeEdit()">✕</button>
        <h2>Bericht Bewerken</h2>
        <form method="POST" id="editForm" action="">
            @csrf @method('PUT')
            <div class="form-group">
                <label>Naam</label>
                <input type="text" name="name" id="edit_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>E-mail</label>
                <input type="email" name="email" id="edit_email" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Onderwerp</label>
                <input type="text" name="subject" id="edit_subject" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Bericht</label>
                <textarea name="message" id="edit_message" rows="5" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" id="edit_status" class="form-control">
                    <option value="nieuw">Nieuw</option>
                    <option value="in_behandeling">In behandeling</option>
                    <option value="gereed">Gereed</option>
                </select>
            </div>
            <button type="submit" class="btn-save">Opslaan</button>
        </form>
    </div>
</div>

<script>
function openEdit(id, name, email, subject, message, status) {
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_email').value = email;
    document.getElementById('edit_subject').value = subject;
    document.getElementById('edit_message').value = message;
    document.getElementById('edit_status').value = status;
    document.getElementById('editForm').action = '/medewerker/contacts/' + id;
    document.getElementById('editModal').classList.add('open');
}

function closeEdit() {
    document.getElementById('editModal').classList.remove('open');
}

document.getElementById('editModal').addEventListener('click', function(e) {
    if (e.target === this) closeEdit();
});
</script>
</body>
</html>
