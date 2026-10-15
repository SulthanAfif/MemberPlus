<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MemberPlus') · MemberPlus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root { color-scheme: light; }
        body { background: #f5f7fa; }
        .app-shell { background-image: radial-gradient(ellipse at top right, rgba(20, 184, 166, .07), transparent 36rem); }
        .nav-scroll { scrollbar-width: none; }
        .nav-scroll::-webkit-scrollbar { display: none; }
    </style>
</head>
<body class="min-h-screen text-slate-800 antialiased">
    <div class="app-shell min-h-screen">
        <header class="sticky top-0 z-20 border-b border-slate-200/80 bg-white/90 backdrop-blur-xl">
            <div class="mx-auto flex h-[72px] max-w-7xl items-center justify-between gap-5 px-4 sm:px-6 lg:px-8">
                <a href="{{ route('dashboard') }}" class="flex shrink-0 items-center gap-3" aria-label="MemberPlus, beranda">
                    <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-teal-700 text-white shadow-lg shadow-teal-900/15">
                        <svg viewBox="0 0 24 24" fill="none" class="h-5 w-5" aria-hidden="true"><path d="M4 7.5 12 3l8 4.5v9L12 21l-8-4.5v-9Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="M8 12h8M12 8v8" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
                    </span>
                    <span class="leading-tight">
                        <span class="block text-[15px] font-bold tracking-tight text-slate-900">Member<span class="text-teal-700">Plus</span></span>
                        <span class="mt-0.5 block text-[10px] font-semibold uppercase tracking-[.16em] text-slate-400">Loyalty management</span>
                    </span>
                </a>

                <nav aria-label="Navigasi utama" class="nav-scroll flex min-w-0 items-center gap-1 overflow-x-auto">
                    @php
                        $navigation = [
                            ['label' => 'Ringkasan', 'route' => 'dashboard', 'active' => request()->routeIs('dashboard')],
                            ['label' => 'Member', 'route' => 'members.index', 'active' => request()->routeIs('members.*')],
                            ['label' => 'Kasir', 'route' => 'sales.create', 'active' => request()->routeIs('sales.create') || request()->routeIs('sales.store')],
                            ['label' => 'Transaksi', 'route' => 'sales.index', 'active' => request()->routeIs('sales.index')],
                            ['label' => 'Reward', 'route' => 'rewards.index', 'active' => request()->routeIs('rewards.*')],
                            ['label' => 'Penukaran', 'route' => 'redemptions.create', 'active' => request()->routeIs('redemptions.create')],
                            ['label' => 'Riwayat tukar', 'route' => 'redemptions.index', 'active' => request()->routeIs('redemptions.index')],
                        ];
                    @endphp
                    @foreach($navigation as $item)
                        <a href="{{ route($item['route']) }}" @if($item['active']) aria-current="page" @endif class="whitespace-nowrap rounded-xl px-3 py-2 text-[13px] font-semibold transition {{ $item['active'] ? 'bg-teal-50 text-teal-800' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-900' }}">{{ $item['label'] }}</a>
                    @endforeach
                </nav>

                <div class="hidden shrink-0 items-center gap-3 border-l border-slate-200 pl-5 sm:flex">
                    <span class="flex h-9 w-9 items-center justify-center rounded-full bg-slate-100 text-xs font-bold text-slate-600">MP</span>
                    <span class="hidden text-xs font-semibold text-slate-600 lg:block">Administrator</span>
                </div>
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-4 py-7 sm:px-6 sm:py-9 lg:px-8">
            @if(session('success'))
                <div role="status" class="mb-5 flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3.5 text-sm text-emerald-800 shadow-sm">
                    <span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-emerald-100 font-bold">✓</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div role="alert" class="mb-5 flex items-start gap-3 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3.5 text-sm text-rose-800 shadow-sm">
                    <span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-rose-100 font-bold">!</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif
            @if($errors->any())
                <div role="alert" class="mb-5 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3.5 text-sm text-rose-800 shadow-sm">
                    <p class="mb-1 font-semibold">Periksa kembali data berikut:</p>
                    <ul class="list-inside list-disc space-y-1">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif
            @yield('content')
        </main>
        <footer class="mx-auto max-w-7xl px-4 pb-7 text-xs text-slate-400 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-1 border-t border-slate-200/80 pt-5 sm:flex-row sm:items-center sm:justify-between">
                <span>MemberPlus · Program loyalitas pelanggan</span>
                <span>{{ now()->format('Y') }} © MemberPlus</span>
            </div>
        </footer>
    </div>
</body>
</html>
