<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticketbeheer - Theater Aurora</title>
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
        .page-header { margin-bottom:2rem; }
        .page-header h1 { font-family:'Playfair Display',serif; font-size:2.2rem; }
        .page-header p { color:var(--muted); margin-top:.3rem; }

        /* Flash message */
        .flash { padding:1rem 1.5rem; border-radius:8px; margin-bottom:1.5rem; font-weight:500; }
        .flash.success { background:rgba(76,175,80,.1); border:1px solid rgba(76,175,80,.4); color:#4caf50; }
        .flash.error { background:rgba(229,57,53,.1); border:1px solid rgba(229,57,53,.4); color:#e53935; }

        /* SEARCH & STATS */
        .toolbar { display:flex; align-items:center; gap:1rem; margin-bottom:1.5rem; flex-wrap:wrap; }
        .search-wrap { flex:1; min-width:250px; position:relative; }
        .search-wrap input {
            width:100%; padding:.85rem 1rem .85rem 3rem;
            background:var(--surface); border:1px solid var(--border); border-radius:10px;
            color:#fff; font-family:'Outfit',sans-serif; font-size:1rem; outline:none; transition:border .3s;
        }
        .search-wrap input:focus { border-color:var(--gold); }
        .search-wrap .icon { position:absolute; left:1rem; top:50%; transform:translateY(-50%); color:var(--muted); }
        .stat-badge { background:var(--surface); border:1px solid var(--border); border-radius:10px; padding:.7rem 1.2rem; font-size:.9rem; color:var(--muted); white-space:nowrap; }
        .stat-badge strong { color:#fff; }

        /* TABLE */
        .table-wrap { background:var(--surface); border:1px solid var(--border); border-radius:16px; overflow:hidden; }
        table { width:100%; border-collapse:collapse; }
        thead th { padding:1rem 1.2rem; text-align:left; font-size:.8rem; text-transform:uppercase; letter-spacing:1px; color:var(--muted); font-weight:500; border-bottom:1px solid var(--border); background:rgba(255,255,255,.02); }
        tbody td { padding:1rem 1.2rem; border-bottom:1px solid var(--border); vertical-align:middle; font-size:.95rem; }
        tbody tr:last-child td { border-bottom:none; }
        tbody tr:hover { background:rgba(255,255,255,.015); }

        .td-name { font-weight:600; color:#fff; }
        .td-show { color:#fff; }
        .td-barcode { font-family:monospace; letter-spacing:2px; color:var(--gold); font-size:.85rem; }

        .badge-status { display:inline-block; padding:.3rem .8rem; border-radius:20px; font-size:.8rem; font-weight:600; text-transform:uppercase; letter-spacing:.5px; }
        .badge-gereserveerd { background:rgba(212,175,55,.1); color:var(--gold); border:1px solid rgba(212,175,55,.3); }
        .badge-gescand { background:rgba(76,175,80,.1); color:#4caf50; border:1px solid rgba(76,175,80,.3); }
        .badge-geannuleerd { background:rgba(229,57,53,.1); color:var(--red); border:1px solid rgba(229,57,53,.3); }

        /* ACTION BUTTONS */
        .actions { display:flex; gap:.5rem; }
        .btn-action { padding:.45rem .9rem; border-radius:6px; font-size:.82rem; font-weight:600; border:none; cursor:pointer; font-family:'Outfit',sans-serif; transition:all .2s; text-decoration:none; display:inline-flex; align-items:center; gap:.3rem; }
        .btn-edit { background:rgba(212,175,55,.1); color:var(--gold); border:1px solid rgba(212,175,55,.3); }
        .btn-edit:hover { background:var(--gold); color:#070709; }
        .btn-del { background:rgba(229,57,53,.1); color:var(--red); border:1px solid rgba(229,57,53,.3); }
        .btn-del:hover { background:var(--red); color:#fff; }

        /* EMPTY STATE */
        .empty { padding:5rem 2rem; text-align:center; color:var(--muted); }
        .empty-icon { font-size:3rem; margin-bottom:1rem; }
        .empty h3 { color:#fff; margin-bottom:.5rem; }

        /* MODAL */
        .modal-backdrop { display:none; position:fixed; inset:0; background:rgba(0,0,0,.7); backdrop-filter:blur(6px); z-index:999; align-items:center; justify-content:center; }
        .modal-backdrop.open { display:flex; }
        .modal { background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:2.5rem; width:100%; max-width:500px; position:relative; }
        .modal h2 { font-family:'Playfair Display',serif; font-size:1.8rem; margin-bottom:1.5rem; }
        .modal-close { position:absolute; top:1.5rem; right:1.5rem; background:transparent; border:none; color:var(--muted); font-size:1.5rem; cursor:pointer; }
        .modal-close:hover { color:#fff; }
        .form-group { margin-bottom:1.2rem; }
        .form-group label { display:block; font-size:.85rem; color:var(--muted); text-transform:uppercase; letter-spacing:1px; margin-bottom:.4rem; }
        .form-control { width:100%; padding:.85rem 1rem; background:rgba(0,0,0,.4); border:1px solid var(--border); border-radius:8px; color:#fff; font-family:'Outfit',sans-serif; font-size:1rem; outline:none; transition:border .3s; }
        .form-control:focus { border-color:var(--gold); }
        .btn-save { width:100%; background:var(--gold); color:#070709; border:none; padding:1rem; font-size:1rem; font-weight:700; border-radius:8px; cursor:pointer; font-family:'Outfit',sans-serif; letter-spacing:1px; text-transform:uppercase; transition:all .3s; margin-top:.5rem; }
        .btn-save:hover { background:#fff; }
    </style>
</head>
<body>

<!-- Sidebar -->
<aside class="sidebar">
    <a href="/" class="logo">Aurora<span>.</span></a>
    <nav>
        <a href="/medewerker/tickets" class="nav-item active">🎫 Ticketbeheer</a>
        @if(Auth::user()->role === 'administrator')
            <a href="/admin/medewerkers" class="nav-item">👥 Medewerkers</a>
        @endif
        <a href="{{ route('employee.shows.index') }}" class="nav-item">🎭 Voorstellingen</a>
        <a href="{{ route('tickets.scan') }}" class="nav-item">📡 Scanner</a>
        <a href="{{ route('employee.contacts.index') }}" class="nav-item">📩 Klachten & Berichten</a>
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
        <h1>Overzicht Reserveringen</h1>
        <p>Beheer hier alle geboekte tickets en reserveringen.</p>
    </div>

    @if(session('success'))
        <div class="flash success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="flash error">{{ session('error') }}</div>
    @endif

    <!-- Toolbar: toevoegen + zoeken + stat -->
    <div class="toolbar">
        <button type="button" class="btn-action btn-edit" style="padding:.85rem 1.5rem; white-space:nowrap;" onclick="document.getElementById('addModal').classList.add('open')">
            ➕ Ticket toevoegen
        </button>
        <form method="GET" action="{{ route('tickets.index') }}" class="toolbar" style="flex:1; margin:0; padding:0; border:none;">
            <div class="search-wrap">
                <span class="icon">🔍</span>
                <input type="text" name="search" placeholder="Zoek op naam, voorstelling of barcode..." value="{{ request('search') }}" autocomplete="off">
            </div>
            <button type="submit" class="btn-action btn-edit" style="padding:.85rem 1.5rem;">Zoeken</button>
            @if(request('search'))
                <a href="{{ route('tickets.index') }}" class="btn-action btn-del">Wis filter</a>
            @endif
        </form>
        <div class="stat-badge">Resultaten: <strong>{{ $reservations->count() }}</strong></div>
    </div>

    <!-- Table -->
    <div class="table-wrap">
        @if($reservations->isEmpty())
            <div class="empty">
                <div class="empty-icon">🎫</div>
                <h3>Geen reserveringen gevonden</h3>
                <p>Er zijn momenteel geen reserveringen gevonden.</p>
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Klant</th>
                        <th>Voorstelling</th>
                        <th>Datum & Tijd</th>
                        <th>Tickets</th>
                        <th>Barcode</th>
                        <th>Status</th>
                        <th>Acties</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservations as $r)
                    <tr>
                        <td style="color:var(--muted); font-size:.85rem;">#{{ str_pad($r->id, 5, '0', STR_PAD_LEFT) }}</td>
                        <td class="td-name">{{ $r->user->name ?? 'Onbekend' }}</td>
                        <td class="td-show">{{ $r->show_name }}</td>
                        <td style="color:var(--muted);">{{ \Carbon\Carbon::parse($r->show_date)->format('d M Y • H:i') }}</td>
                        <td style="text-align:center;">{{ $r->number_of_tickets }}</td>
                        <td class="td-barcode">{{ $r->ticket_barcode }}</td>
                        <td><span class="badge-status badge-{{ $r->status }}">{{ $r->status }}</span></td>
                        <td>
                            <div class="actions">
                                <button class="btn-action btn-edit"
                                    onclick="openEdit({{ $r->id }}, '{{ addslashes($r->show_name) }}', '{{ $r->show_date }}', {{ $r->number_of_tickets }}, '{{ $r->status }}')">
                                    ✏️ Bewerk
                                </button>
                                <form method="POST" action="{{ route('tickets.destroy', $r->id) }}" onsubmit="return confirm('Weet je zeker dat je deze reservering wil verwijderen?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-action btn-del">🗑️ Verwijder</button>
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

<!-- Add Modal -->
<div class="modal-backdrop" id="addModal">
    <div class="modal">
        <button class="modal-close" onclick="document.getElementById('addModal').classList.remove('open')">✕</button>
        <h2>Ticket Toevoegen</h2>
        <form method="POST" action="{{ route('tickets.store.manual') }}">
            @csrf
            <div class="form-group">
                <label>Klant</label>
                <select name="user_id" class="form-control" required>
                    <option value="">— Selecteer klant —</option>
                    @foreach($users as $u)
                        <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Voorstelling</label>
                <select name="show_id" class="form-control" required>
                    <option value="">— Selecteer voorstelling —</option>
                    @foreach($shows as $s)
                        <option value="{{ $s->id }}">{{ $s->title }} — {{ \Carbon\Carbon::parse($s->date)->format('d M Y • H:i') }} ({{ $s->available_tickets }} vrij)</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Aantal Tickets</label>
                <input type="number" name="number_of_tickets" class="form-control" min="1" value="1" required>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="gereserveerd">Gereserveerd</option>
                    <option value="gescand">Gescand</option>
                    <option value="geannuleerd">Geannuleerd</option>
                </select>
            </div>
            <button type="submit" class="btn-save">Toevoegen</button>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal-backdrop" id="editModal">
    <div class="modal">
        <button class="modal-close" onclick="closeEdit()">✕</button>
        <h2>Reservering Bewerken</h2>
        <form method="POST" id="editForm" action="">
            @csrf @method('PUT')
            <div class="form-group">
                <label>Voorstelling</label>
                <input type="text" name="show_name" id="edit_show_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Datum & Tijd</label>
                <input type="datetime-local" name="show_date" id="edit_show_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Aantal Tickets</label>
                <input type="number" name="number_of_tickets" id="edit_tickets" class="form-control" min="1" required>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" id="edit_status" class="form-control">
                    <option value="gereserveerd">Gereserveerd</option>
                    <option value="gescand">Gescand</option>
                    <option value="geannuleerd">Geannuleerd</option>
                </select>
            </div>
            <button type="submit" class="btn-save">Opslaan</button>
        </form>
    </div>
</div>

<script>
function openEdit(id, show_name, show_date, tickets, status) {
    document.getElementById('edit_show_name').value = show_name;
    // datetime-local verwacht "YYYY-MM-DDTHH:MM" format
    document.getElementById('edit_show_date').value = show_date.replace(' ', 'T').substring(0, 16);
    document.getElementById('edit_tickets').value = tickets;
    document.getElementById('edit_status').value = status;
    document.getElementById('editForm').action = '/medewerker/tickets/' + id;
    document.getElementById('editModal').classList.add('open');
}

function closeEdit() {
    document.getElementById('editModal').classList.remove('open');
}

document.getElementById('editModal').addEventListener('click', function(e) {
    if (e.target === this) closeEdit();
});
document.getElementById('addModal').addEventListener('click', function(e) {
    if (e.target === this) this.classList.remove('open');
});
</script>
</body>
</html>
