<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Apex Admin</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --admin-bg: #efefef;
            --admin-surface: #ffffff;
            --admin-border: #dddddd;
            --admin-text: #171717;
            --admin-muted: #6d6d6d;
            --admin-accent: #d88411;
            --admin-accent-soft: #f3e4cc;
            --admin-dark: #0b0b0b;
        }

        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            color: var(--admin-text);
            background: var(--admin-bg);
        }

        .admin-shell {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 280px 1fr;
            grid-template-rows: 60px 1fr;
            grid-template-areas:
                "top top"
                "side main";
        }

        .admin-topbar {
            grid-area: top;
            background: var(--admin-dark);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 16px;
            border-bottom: 1px solid #2a2a2a;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: 'Oswald', sans-serif;
            font-size: 20px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .brand-badge {
            width: 34px;
            height: 34px;
            object-fit: cover;
            border-radius: 2px;
            background: #fff;
        }

        .top-user {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 500;
            font-size: 15px;
        }

        .top-user-circle {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--admin-accent);
            display: grid;
            place-items: center;
            font-weight: 700;
        }

        .admin-sidebar {
            grid-area: side;
            background: #f7f7f7;
            border-right: 1px solid var(--admin-border);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .admin-nav-group { padding: 18px 14px; }

        .admin-link,
        .admin-parent {
            display: flex;
            align-items: center;
            gap: 12px;
            width: 100%;
            border: none;
            text-decoration: none;
            color: #555;
            border-radius: 0;
            padding: 14px 14px;
            font-size: 15px;
            font-weight: 400;
            margin-bottom: 4px;
            background: transparent;
        }

        .admin-link:hover { background: #ececec; color: #111; }

        .admin-link.active {
            background: var(--admin-accent);
            color: #fff;
            font-weight: 500;
        }

        .admin-parent {
            cursor: pointer;
            color: #222;
            font-weight: 500;
            margin-top: 6px;
            margin-bottom: 2px;
            padding-bottom: 10px;
            justify-content: space-between;
        }

        .admin-parent-left {
            display: inline-flex;
            align-items: center;
            gap: 12px;
        }

        .admin-caret {
            font-size: 12px;
            color: #666;
            transition: transform 0.2s ease;
        }

        .admin-subnav {
            padding-left: 16px;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.24s ease;
        }

        .admin-subnav.open {
            max-height: 240px;
        }

        .admin-parent[aria-expanded='true'] .admin-caret {
            transform: rotate(180deg);
        }

        .admin-subnav .admin-link {
            font-size: 15px;
            padding: 10px 12px;
            border-left: 2px solid #dfdfdf;
            border-radius: 0;
            margin-left: 16px;
        }

        .admin-subnav .admin-link.active {
            border-left-color: var(--admin-accent);
            background: #f6ead8;
            color: #8a4e00;
        }

        .admin-bottom {
            border-top: 1px solid var(--admin-border);
            padding: 14px;
            display: grid;
            gap: 8px;
        }

        .admin-bottom a,
        .admin-bottom button {
            text-align: left;
            text-decoration: none;
            border: none;
            background: transparent;
            font-size: 17px;
            font-family: 'Inter', sans-serif;
            color: #666;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            cursor: pointer;
        }

        .admin-bottom a:hover,
        .admin-bottom button:hover { color: #111; }

        .admin-bottom .logout { color: #d22626; }

        .admin-main {
            grid-area: main;
            padding: 24px 32px 30px;
            overflow: auto;
        }

        .admin-page-title {
            font-family: 'Oswald', sans-serif;
            font-size: 28px;
            line-height: 1;
            margin: 4px 0 22px;
            text-transform: uppercase;
            font-weight: 600;
        }

        .admin-container { max-width: 1200px; margin: 0 auto; }
        .admin-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 18px;
            padding: 16px;
        }
        .admin-table-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 18px;
            overflow: auto;
        }
        .admin-table { width: 100%; border-collapse: collapse; min-width: 880px; }
        .admin-table th,
        .admin-table td { padding: 12px 14px; text-align: left; border-top: 1px solid #f1f5f9; }
        .admin-table th {
            border-top: none;
            font-size: 12px;
            letter-spacing: .04em;
            color: #6b7280;
            text-transform: uppercase;
        }
        .admin-toolbar { display: flex; gap: 10px; flex-wrap: wrap; align-items: center; justify-content: space-between; margin-bottom: 12px; }
        .admin-form-row { display: flex; gap: 8px; flex-wrap: wrap; align-items: center; }
        .admin-input,
        .admin-select {
            padding: 10px 12px;
            border: 1px solid #d7d7d7;
            border-radius: 12px;
            background: #fff;
            font-size: 14px;
        }
        .admin-input:focus,
        .admin-select:focus {
            outline: none;
            border-color: var(--admin-accent);
            box-shadow: 0 0 0 3px #f7e8d1;
        }
        .admin-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 14px;
            border: none;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
            cursor: pointer;
        }
        .admin-btn-primary { background: var(--admin-accent); color: #fff; }
        .admin-btn-primary:hover { background: #be730f; }
        .admin-btn-dark { background: #111827; color: #fff; }
        .admin-btn-dark:hover { background: #1f2937; }
        .status-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 88px;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
        }
        .status-in { background: #dcf5e5; color: #187748; }
        .status-low { background: #fff4d6; color: #9a6900; }
        .status-out { background: #fee2e2; color: #991b1b; }

        .pagination-wrap { margin-top: 14px; }
        .pagination-wrap nav { display: flex; justify-content: flex-start; }
        .pagination {
            display: flex;
            flex-wrap: nowrap;
            gap: 8px;
            align-items: center;
            margin: 0;
            padding: 0;
            list-style: none;
        }
        .pagination li { list-style: none; margin: 0; }
        .pagination .page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            padding: 0 12px;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            background: #fff;
            color: #374151;
            text-decoration: none;
            font-size: 14px;
        }
        .pagination .page-item.active .page-link {
            border-color: var(--admin-accent);
            background: #f6ead8;
            color: #8a4e00;
        }
        .pagination .page-item.disabled .page-link {
            opacity: .45;
            pointer-events: none;
        }

        @media (max-width: 980px) {
            .admin-shell {
                grid-template-columns: 1fr;
                grid-template-rows: 60px auto 1fr;
                grid-template-areas:
                    "top"
                    "side"
                    "main";
            }

            .admin-sidebar { border-right: none; border-bottom: 1px solid var(--admin-border); }
            .admin-main { padding: 18px 14px 24px; }
            .admin-page-title { font-size: 24px; }
            .admin-bottom a, .admin-bottom button { font-size: 16px; }
            .admin-toolbar { align-items: stretch; }
            .admin-form-row { width: 100%; }
            .admin-input,
            .admin-select,
            .admin-btn { width: 100%; }
        }
    </style>
    @yield('extra-css')
</head>
<body>
    @php
        $inventoryExpanded = request()->routeIs('admin.inventory.*') || request()->routeIs('admin.reports.*');
    @endphp
    <div class="admin-shell">
        <header class="admin-topbar">
            <div class="brand">
                <img class="brand-badge" src="{{ asset('images/logo.png') }}" alt="Apex logo">
                <span>APEX ADMIN</span>
            </div>
            <div class="top-user">
                <div class="top-user-circle">{{ strtoupper(substr(auth()->user()->first_name ?? 'A', 0, 1)) }}</div>
                <span>{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</span>
            </div>
        </header>

        <aside class="admin-sidebar">
            <div class="admin-nav-group">
                <a href="{{ route('admin.dashboard') }}" class="admin-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fa-solid fa-gauge"></i> Dashboard</a>
                <a href="{{ route('admin.orders') }}" class="admin-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}"><i class="fa-solid fa-box"></i> Orders</a>
                <a href="{{ route('admin.customers.index') }}" class="admin-link {{ request()->routeIs('admin.customers*') ? 'active' : '' }}"><i class="fa-solid fa-users"></i> Customers</a>
                <a href="{{ route('admin.products.index') }}" class="admin-link {{ request()->routeIs('admin.products*') ? 'active' : '' }}"><i class="fa-solid fa-boxes-stacked"></i> Products</a>

                <button type="button" id="inventoryToggle" class="admin-parent" aria-expanded="{{ $inventoryExpanded ? 'true' : 'false' }}">
                    <span class="admin-parent-left"><i class="fa-solid fa-warehouse"></i> Inventory</span>
                    <i class="fa-solid fa-chevron-down admin-caret"></i>
                </button>
                <div id="inventorySubnav" class="admin-subnav {{ $inventoryExpanded ? 'open' : '' }}">
                    <a href="{{ route('admin.inventory.index') }}" class="admin-link {{ request()->routeIs('admin.inventory.index') || request()->routeIs('admin.inventory.products.show') ? 'active' : '' }}">Stock Levels</a>
                    <a href="{{ route('admin.inventory.movements') }}" class="admin-link {{ request()->routeIs('admin.inventory.movements') || request()->routeIs('admin.inventory.incoming.*') ? 'active' : '' }}">Stock Movements</a>
                    <a href="{{ route('admin.inventory.alerts') }}" class="admin-link {{ request()->routeIs('admin.inventory.alerts') || request()->routeIs('admin.inventory.threshold.*') ? 'active' : '' }}">Low Stock Alerts</a>
                    <a href="{{ route('admin.reports.stock-levels') }}" class="admin-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">Reports</a>
                </div>

                <a href="{{ route('admin.messages.index') }}" class="admin-link {{ request()->routeIs('admin.messages*') ? 'active' : '' }}"><i class="fa-solid fa-envelope"></i> Customer Messages</a>
            </div>

            <div class="admin-bottom">
                <a href="{{ route('home') }}"><i class="fa-solid fa-store"></i> View Store</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</button>
                </form>
            </div>
        </aside>

        <main class="admin-main">
            @hasSection('page-title')
                <h1 class="admin-page-title">@yield('page-title')</h1>
            @endif
            @yield('content')
        </main>
    </div>

    <script>
        (function () {
            const toggle = document.getElementById('inventoryToggle');
            const subnav = document.getElementById('inventorySubnav');
            if (!toggle || !subnav) {
                return;
            }

            toggle.addEventListener('click', function () {
                const currentlyOpen = subnav.classList.contains('open');
                subnav.classList.toggle('open', !currentlyOpen);
                toggle.setAttribute('aria-expanded', currentlyOpen ? 'false' : 'true');
            });
        })();
    </script>
</body>
</html>
