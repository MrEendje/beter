<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voorstellingenbeheer - Theater Aurora</title>
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
        .page-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem; }
        .page-header h1 { font-family:'Playfair Display',serif; font-size:2.2rem; }
        .page-header p { color:var(--muted); margin-top:.3rem; }

        /* Flash message */
        .flash { padding:1rem 1.5rem; border-radius:8px; margin-bottom:1.5rem; font-weight:500; }
        .flash.success { background:rgba(76,175,80,.1); border:1px solid rgba(76,175,80,.4); color:#4caf50; }
        .flash.error { background:rgba(229,57,53,.1); border:1px solid rgba(229,57,53,.4); color:#e53935; }

        /* TOOLBAR */
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

        /* TABLE CUSTOM COLUMNS */
        .show-media-col { display:flex; gap:1rem; align-items:center; }
        .show-img-thumb { width:70px; height:45px; border-radius:6px; object-fit:cover; border:1px solid var(--border); }
        .show-details-col { display:flex; flex-direction:column; gap:.2rem; }
        .show-title-text { font-weight:600; color:#fff; font-size:1.05rem; }
        .show-cat-badge { font-size:.72rem; color:var(--gold); font-weight:600; text-transform:uppercase; letter-spacing:.5px; }
        
        .info-meta-list { display:flex; flex-direction:column; gap:.3rem; font-size:.85rem; color:var(--muted); }
        .info-meta-item strong { color:#fff; }

        .badge-status { display:inline-block; padding:.3rem .8rem; border-radius:20px; font-size:.8rem; font-weight:600; text-transform:uppercase; letter-spacing:.5px; }
        .badge-active { background:rgba(76,175,80,.1); color:#4caf50; border:1px solid rgba(76,175,80,.3); }
        .badge-inactive { background:rgba(229,57,53,.1); color:var(--red); border:1px solid rgba(229,57,53,.3); }

        /* ACTION BUTTONS */
        .actions { display:flex; gap:.5rem; }
        .btn-action { padding:.45rem .9rem; border-radius:6px; font-size:.82rem; font-weight:600; border:none; cursor:pointer; font-family:'Outfit',sans-serif; transition:all .2s; text-decoration:none; display:inline-flex; align-items:center; gap:.3rem; }
        .btn-edit { background:rgba(212,175,55,.1); color:var(--gold); border:1px solid rgba(212,175,55,.3); }
        .btn-edit:hover { background:var(--gold); color:#070709; }
        .btn-del { background:rgba(229,57,53,.1); color:var(--red); border:1px solid rgba(229,57,53,.3); }
        .btn-del:hover { background:var(--red); color:#fff; }
        .btn-primary-dashboard { background:var(--gold); color:#070709; font-weight:700; letter-spacing:1px; text-transform:uppercase; border:none; padding:.75rem 1.5rem; border-radius:8px; cursor:pointer; transition:all .3s; font-family:'Outfit',sans-serif; }
        .btn-primary-dashboard:hover { background:#fff; transform:translateY(-2px); box-shadow:0 5px 15px var(--gold-glow); }

        /* EMPTY STATE */
        .empty { padding:5rem 2rem; text-align:center; color:var(--muted); }
        .empty-icon { font-size:3rem; margin-bottom:1rem; }
        .empty h3 { color:#fff; margin-bottom:.5rem; }

        /* MODAL */
        .modal-backdrop { display:none; position:fixed; inset:0; background:rgba(0,0,0,.7); backdrop-filter:blur(6px); z-index:999; align-items:center; justify-content:center; }
        .modal-backdrop.open { display:flex; }
        .modal { background:var(--surface); border:1px solid var(--border); border-radius:20px; padding:2.5rem; width:100%; max-width:600px; position:relative; max-height:90vh; overflow-y:auto; }
        .modal h2 { font-family:'Playfair Display',serif; font-size:1.8rem; margin-bottom:1.5rem; }
        .modal-close { position:absolute; top:1.5rem; right:1.5rem; background:transparent; border:none; color:var(--muted); font-size:1.5rem; cursor:pointer; }
        .modal-close:hover { color:#fff; }
        
        .form-group { margin-bottom:1.2rem; }
        .form-group label { display:block; font-size:.85rem; color:var(--muted); text-transform:uppercase; letter-spacing:1px; margin-bottom:.4rem; }
        .form-control { width:100%; padding:.85rem 1rem; background:rgba(0,0,0,.4); border:1px solid var(--border); border-radius:8px; color:#fff; font-family:'Outfit',sans-serif; font-size:1rem; outline:none; transition:border .3s; }
        .form-control:focus { border-color:var(--gold); }
        
        .form-row { display:grid; grid-template-columns:1fr 1fr; gap:1.2rem; }

        .form-checkbox { display:flex; align-items:center; gap:.5rem; margin-top:.5rem; cursor:pointer; }
        .form-checkbox input { width:18px; height:18px; accent-color:var(--gold); cursor:pointer; }

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
        <a href="/medewerker/shows" class="nav-item active">🎭 Voorstellingen</a>
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
        <div>
            <h1>Voorstellingenbeheer</h1>
            <p>Voeg nieuwe voorstellingen toe of bewerk bestaande programmeringen.</p>
        </div>
        <button class="btn-primary-dashboard" onclick="openAdd()">➕ Nieuwe Voorstelling</button>
    </div>

    @if(session('success'))
        <div class="flash success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="flash error">{{ session('error') }}</div>
    @endif

    <!-- Toolbar: zoeken + stat -->
    <form method="GET" action="{{ route('employee.shows.index') }}" class="toolbar">
        <div class="search-wrap">
            <span class="icon">🔍</span>
            <input type="text" name="search" placeholder="Zoek op titel, categorie of locatie..." value="{{ request('search') }}" autocomplete="off">
        </div>
        <button type="submit" class="btn-action btn-edit" style="padding:.85rem 1.5rem;">Zoeken</button>
        @if(request('search'))
            <a href="{{ route('employee.shows.index') }}" class="btn-action btn-del">Wis filter</a>
        @endif
        <div class="stat-badge">Totaal aantal shows: <strong>{{ $shows->count() }}</strong></div>
    </form>

    <!-- Table -->
    <div class="table-wrap">
        @if($shows->isEmpty())
            <div class="empty">
                <div class="empty-icon">🎭</div>
                <h3>Geen voorstellingen gevonden</h3>
                <p>Er zijn momenteel geen voorstellingen beschikbaar of passend bij uw zoekopdracht.</p>
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th style="width: 45%;">Voorstelling</th>
                        <th style="width: 35%;">Informatie</th>
                        <th style="width: 15%;">Acties</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($shows as $show)
                    <tr>
                        <td style="color:var(--muted); font-size:.85rem;">#{{ str_pad($show->id, 3, '0', STR_PAD_LEFT) }}</td>
                        <td>
                            <div class="show-media-col">
                                @if($show->image_url)
                                    <img src="{{ $show->image_url }}" alt="" class="show-img-thumb">
                                @else
                                    <div style="width:70px; height:45px; background:rgba(255,255,255,.05); border-radius:6px; display:flex; align-items:center; justify-content:center; color:var(--muted); font-size:.7rem;">Geen foto</div>
                                @endif
                                <div class="show-details-col">
                                    <span class="show-cat-badge">{{ $show->category ?? 'Voorstelling' }}</span>
                                    <span class="show-title-text">{{ $show->title }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="info-meta-list">
                                <div class="info-meta-item">📅 <strong>Datum & Tijd:</strong> {{ \Carbon\Carbon::parse($show->date)->format('d M Y • H:i') }}</div>
                                <div class="info-meta-item">📍 <strong>Locatie:</strong> {{ $show->location }}</div>
                                <div class="info-meta-item">🎟️ <strong>Tickets:</strong> {{ $show->available_tickets }} beschikbaar • 💰 <strong>Prijs:</strong> €{{ number_format($show->price, 2) }}</div>
                                <div class="info-meta-item">
                                    <strong>Status:</strong> 
                                    @if($show->is_active)
                                        <span class="badge-status badge-active">Actief</span>
                                    @else
                                        <span class="badge-status badge-inactive">Inactief</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="actions">
                                <button class="btn-action btn-edit"
                                    onclick="openEdit({{ $show->id }}, '{{ addslashes($show->title) }}', '{{ addslashes($show->description) }}', '{{ $show->date }}', '{{ addslashes($show->location) }}', '{{ addslashes($show->category) }}', '{{ $show->image_url }}', {{ $show->available_tickets }}, {{ $show->price }}, {{ $show->is_active ? 1 : 0 }})">
                                    ✏️ Bewerk
                                </button>
                                <form method="POST" action="{{ route('employee.shows.destroy', $show->id) }}" onsubmit="return confirm('Weet je zeker dat je deze voorstelling wil verwijderen?');">
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

<!-- Add/Edit Modal -->
<div class="modal-backdrop" id="showModal">
    <div class="modal">
        <button class="modal-close" onclick="closeModal()">✕</button>
        <h2 id="modalTitle">Nieuwe Voorstelling</h2>
        <form method="POST" id="modalForm" action="{{ route('employee.shows.store') }}">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            
            <div class="form-group">
                <label for="title">Titel van de Voorstelling</label>
                <input type="text" name="title" id="form_title" class="form-control" placeholder="bijv. Zwanenmeer Klassiek" required>
            </div>
            
            <div class="form-group">
                <label for="description">Beschrijving</label>
                <textarea name="description" id="form_description" class="form-control" rows="3" placeholder="Voer een gedetailleerde beschrijving in..."></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="date">Datum & Tijd</label>
                    <input type="datetime-local" name="date" id="form_date" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="location">Locatie (Zaal)</label>
                    <input type="text" name="location" id="form_location" class="form-control" placeholder="bijv. Grote Zaal" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="category">Categorie</label>
                    <input type="text" name="category" id="form_category" class="form-control" placeholder="bijv. Ballet & Dans">
                </div>
                <div class="form-group">
                    <label for="image_url">Afbeelding URL</label>
                    <input type="url" name="image_url" id="form_image_url" class="form-control" placeholder="https://example.com/image.jpg">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="available_tickets">Aantal Tickets</label>
                    <input type="number" name="available_tickets" id="form_tickets" class="form-control" min="0" value="100" required>
                </div>
                <div class="form-group">
                    <label for="price">Prijs (EUR)</label>
                    <input type="number" name="price" id="form_price" class="form-control" step="0.01" min="0" value="25.00" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-checkbox">
                    <input type="checkbox" name="is_active" id="form_is_active" value="1" checked>
                    <span>Deze voorstelling direct actief en zichtbaar maken</span>
                </label>
            </div>

            <button type="submit" class="btn-save">Opslaan</button>
        </form>
    </div>
</div>

<script>
function openAdd() {
    document.getElementById('modalTitle').innerText = 'Nieuwe Voorstelling';
    document.getElementById('formMethod').value = 'POST';
    document.getElementById('modalForm').action = "{{ route('employee.shows.store') }}";
    
    // Reset form fields
    document.getElementById('form_title').value = '';
    document.getElementById('form_description').value = '';
    document.getElementById('form_date').value = '';
    document.getElementById('form_location').value = 'Grote Zaal';
    document.getElementById('form_category').value = '';
    document.getElementById('form_image_url').value = '';
    document.getElementById('form_tickets').value = 100;
    document.getElementById('form_price').value = '25.00';
    document.getElementById('form_is_active').checked = true;

    document.getElementById('showModal').classList.add('open');
}

function openEdit(id, title, description, date, location, category, image_url, tickets, price, is_active) {
    document.getElementById('modalTitle').innerText = 'Voorstelling Bewerken';
    document.getElementById('formMethod').value = 'PUT';
    document.getElementById('modalForm').action = '/medewerker/shows/' + id;
    
    document.getElementById('form_title').value = title;
    document.getElementById('form_description').value = description;
    // format date to YYYY-MM-DDTHH:MM
    document.getElementById('form_date').value = date.replace(' ', 'T').substring(0, 16);
    document.getElementById('form_location').value = location;
    document.getElementById('form_category').value = category;
    document.getElementById('form_image_url').value = image_url;
    document.getElementById('form_tickets').value = tickets;
    document.getElementById('form_price').value = price;
    document.getElementById('form_is_active').checked = is_active === 1;

    document.getElementById('showModal').classList.add('open');
}

function closeModal() {
    document.getElementById('showModal').classList.remove('open');
}

// Sluit modal bij klik buiten het venster
document.getElementById('showModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
</script>
</body>
</html>
