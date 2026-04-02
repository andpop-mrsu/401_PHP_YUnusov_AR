<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Простое ли число?')</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:       #0f172a;
            --surface:  #1e293b;
            --card:     #273549;
            --border:   #334155;
            --accent:   #6366f1;
            --accent2:  #818cf8;
            --success:  #22c55e;
            --error:    #ef4444;
            --warn:     #f59e0b;
            --text:     #e2e8f0;
            --muted:    #94a3b8;
            --radius:   12px;
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── Nav ── */
        nav {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 0 2rem;
            display: flex;
            align-items: center;
            gap: 2rem;
            height: 60px;
        }
        nav .brand {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--accent2);
            text-decoration: none;
            letter-spacing: .5px;
        }
        nav a {
            color: var(--muted);
            text-decoration: none;
            font-size: .9rem;
            padding: .25rem .6rem;
            border-radius: 6px;
            transition: color .2s, background .2s;
        }
        nav a:hover, nav a.active {
            color: var(--text);
            background: var(--card);
        }

        /* ── Main ── */
        main {
            flex: 1;
            padding: 2.5rem 1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .container {
            width: 100%;
            max-width: 680px;
        }

        /* ── Card ── */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 2rem 2.5rem;
        }

        h1 {
            font-size: 1.6rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: var(--text);
        }

        h2 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        /* ── Form ── */
        .form-group {
            margin-bottom: 1.25rem;
        }
        label {
            display: block;
            font-size: .85rem;
            color: var(--muted);
            margin-bottom: .4rem;
            font-weight: 500;
        }
        input[type="text"] {
            width: 100%;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: .65rem 1rem;
            color: var(--text);
            font-size: 1rem;
            outline: none;
            transition: border-color .2s;
        }
        input[type="text"]:focus {
            border-color: var(--accent);
        }

        /* ── Radio buttons ── */
        .radio-group {
            display: flex;
            gap: 1rem;
            margin-top: .25rem;
        }
        .radio-card {
            flex: 1;
            position: relative;
        }
        .radio-card input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0; height: 0;
        }
        .radio-card label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            background: var(--card);
            border: 2px solid var(--border);
            border-radius: 10px;
            padding: .9rem 1.25rem;
            cursor: pointer;
            font-size: 1rem;
            color: var(--text);
            transition: border-color .2s, background .2s;
            user-select: none;
        }
        .radio-card input[type="radio"]:checked + label {
            border-color: var(--accent);
            background: rgba(99,102,241,.15);
            color: var(--accent2);
            font-weight: 600;
        }
        .radio-card label:hover {
            border-color: var(--accent2);
        }

        /* ── Button ── */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: .75rem 1.75rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: background .2s, transform .1s;
        }
        .btn:hover   { background: var(--accent2); }
        .btn:active  { transform: scale(.98); }
        .btn-outline {
            background: transparent;
            border: 2px solid var(--border);
            color: var(--muted);
        }
        .btn-outline:hover {
            border-color: var(--accent2);
            color: var(--text);
            background: transparent;
        }
        .btn-sm { padding: .4rem 1rem; font-size: .875rem; }

        /* ── Number display ── */
        .number-display {
            text-align: center;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 2rem;
            margin-bottom: 1.75rem;
        }
        .number-display .label {
            font-size: .8rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--muted);
            margin-bottom: .5rem;
        }
        .number-display .number {
            font-size: 4rem;
            font-weight: 800;
            color: var(--accent2);
            line-height: 1;
        }

        /* ── Result banner ── */
        .result-banner {
            border-radius: var(--radius);
            padding: 1.25rem 1.5rem;
            margin-bottom: 1.5rem;
            font-size: 1.1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: .75rem;
        }
        .result-banner.correct {
            background: rgba(34,197,94,.12);
            border: 1px solid rgba(34,197,94,.4);
            color: var(--success);
        }
        .result-banner.wrong {
            background: rgba(239,68,68,.12);
            border: 1px solid rgba(239,68,68,.4);
            color: var(--error);
        }
        .result-banner .icon { font-size: 1.5rem; }

        /* ── Info block ── */
        .info-block {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 1rem 1.25rem;
            margin-bottom: 1rem;
            font-size: .95rem;
            color: var(--text);
        }
        .info-block .key {
            color: var(--muted);
            font-size: .8rem;
            text-transform: uppercase;
            letter-spacing: .8px;
            margin-bottom: .25rem;
        }

        /* ── Divisors ── */
        .divisors {
            display: flex;
            flex-wrap: wrap;
            gap: .5rem;
            margin-top: .5rem;
        }
        .divisor-chip {
            background: rgba(99,102,241,.2);
            border: 1px solid rgba(99,102,241,.4);
            color: var(--accent2);
            border-radius: 6px;
            padding: .2rem .65rem;
            font-size: .9rem;
            font-weight: 600;
        }

        /* ── Table ── */
        .table-wrap {
            overflow-x: auto;
            margin-top: 1rem;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: .9rem;
        }
        thead tr {
            background: var(--card);
            border-bottom: 2px solid var(--border);
        }
        th {
            text-align: left;
            padding: .75rem 1rem;
            color: var(--muted);
            font-weight: 600;
            font-size: .8rem;
            text-transform: uppercase;
            letter-spacing: .8px;
            white-space: nowrap;
        }
        td {
            padding: .7rem 1rem;
            border-bottom: 1px solid var(--border);
            color: var(--text);
            vertical-align: middle;
        }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: rgba(255,255,255,.02); }

        /* ── Badges ── */
        .badge {
            display: inline-block;
            border-radius: 5px;
            padding: .2rem .55rem;
            font-size: .78rem;
            font-weight: 700;
            letter-spacing: .3px;
        }
        .badge-success { background: rgba(34,197,94,.15); color: var(--success); }
        .badge-error   { background: rgba(239,68,68,.15);  color: var(--error);   }
        .badge-info    { background: rgba(99,102,241,.15); color: var(--accent2); }
        .badge-warn    { background: rgba(245,158,11,.15); color: var(--warn);    }

        /* ── Stat cards ── */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1rem 1.25rem;
            text-align: center;
        }
        .stat-card .val {
            font-size: 2rem;
            font-weight: 800;
            color: var(--accent2);
        }
        .stat-card .lbl {
            font-size: .78rem;
            color: var(--muted);
            margin-top: .2rem;
        }

        /* ── Pagination ── */
        .pagination {
            display: flex;
            gap: .4rem;
            justify-content: center;
            margin-top: 1.5rem;
            flex-wrap: wrap;
        }
        .pagination a, .pagination span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            padding: 0 .6rem;
            border-radius: 7px;
            font-size: .875rem;
            text-decoration: none;
            border: 1px solid var(--border);
            color: var(--muted);
            transition: background .2s, color .2s;
        }
        .pagination a:hover { background: var(--card); color: var(--text); }
        .pagination .active span {
            background: var(--accent);
            border-color: var(--accent);
            color: #fff;
            font-weight: 700;
        }
        .pagination .disabled span { opacity: .35; cursor: default; }

        /* ── Filter form ── */
        .filter-row {
            display: flex;
            gap: .75rem;
            margin-bottom: 1.25rem;
            flex-wrap: wrap;
        }
        .filter-row input[type="text"] {
            flex: 1;
            min-width: 180px;
        }

        /* ── Alert ── */
        .alert {
            border-radius: 8px;
            padding: .75rem 1rem;
            margin-bottom: 1rem;
            font-size: .9rem;
        }
        .alert-error {
            background: rgba(239,68,68,.12);
            border: 1px solid rgba(239,68,68,.4);
            color: var(--error);
        }

        /* ── Validation errors ── */
        .invalid-feedback {
            color: var(--error);
            font-size: .8rem;
            margin-top: .3rem;
        }
        input.is-invalid { border-color: var(--error) !important; }

        /* ── Actions row ── */
        .actions {
            display: flex;
            gap: .75rem;
            flex-wrap: wrap;
            margin-top: 1.5rem;
        }

        /* ── Footer ── */
        footer {
            text-align: center;
            padding: 1rem;
            color: var(--muted);
            font-size: .8rem;
            border-top: 1px solid var(--border);
        }

        @media (max-width: 500px) {
            .card { padding: 1.5rem 1.25rem; }
            .number-display .number { font-size: 3rem; }
            nav { gap: 1rem; padding: 0 1rem; }
        }
    </style>
</head>
<body>
    <nav>
        <a href="{{ route('game.index') }}" class="brand">🔢 PrimeGame</a>
        <a href="{{ route('game.index') }}" class="{{ request()->routeIs('game.index') ? 'active' : '' }}">Играть</a>
        <a href="{{ route('history.index') }}" class="{{ request()->routeIs('history.index') ? 'active' : '' }}">История</a>
    </nav>

    <main>
        <div class="container">
            @if (session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif

            @yield('content')
        </div>
    </main>

    <footer>
        &copy; {{ date('Y') }} PrimeGame — Лабораторная работа Laravel
    </footer>
</body>
</html>
