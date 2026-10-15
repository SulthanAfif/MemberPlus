@extends('layouts.app')
@section('title', 'Ringkasan')
@section('content')
<section class="mb-8 flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
    <div>
        <p class="mb-2 text-xs font-bold uppercase tracking-[.18em] text-teal-700">Ringkasan bisnis</p>
        <h1 class="text-3xl font-bold tracking-tight text-slate-950 sm:text-[34px]">Selamat datang kembali</h1>
        <p class="mt-2 text-sm text-slate-500">Pantau aktivitas loyalitas pelanggan dan performa hari ini.</p>
    </div>
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('members.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
            <span class="text-lg leading-none text-slate-400">+</span> Tambah member
        </a>
        <a href="{{ route('sales.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-teal-700 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-teal-900/15 transition hover:bg-teal-800">
            <svg viewBox="0 0 24 24" fill="none" class="h-4 w-4" aria-hidden="true"><path d="M4 5h2l2.1 10.1a2 2 0 0 0 2 1.6h7.8a2 2 0 0 0 2-1.6L21 9H7" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/><circle cx="10" cy="20" r="1" fill="currentColor"/><circle cx="18" cy="20" r="1" fill="currentColor"/></svg>
            Catat transaksi
        </a>
    </div>
</section>

<section aria-label="Statistik utama" class="mb-7 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
    <article class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm shadow-slate-900/[.025]">
        <div class="flex items-start justify-between">
            <div><p class="text-sm font-medium text-slate-500">Member aktif</p><p class="mt-3 text-3xl font-bold tracking-tight text-slate-950">{{ number_format($stats['members_active']) }}</p></div>
            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-teal-50 text-teal-700"><svg viewBox="0 0 24 24" fill="none" class="h-5 w-5" aria-hidden="true"><path d="M16 20v-1.5a3.5 3.5 0 0 0-3.5-3.5h-5A3.5 3.5 0 0 0 4 18.5V20m15 0v-1.5a3.5 3.5 0 0 0-2.5-3.36M10 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm6-7.5a4 4 0 0 1 0 7.75" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></span>
        </div>
        <div class="mt-4 flex items-center gap-2 border-t border-slate-100 pt-3 text-xs"><span class="rounded-md bg-teal-50 px-2 py-1 font-semibold text-teal-700">{{ number_format($stats['members_total']) }} total</span><span class="text-slate-400">terdaftar</span></div>
    </article>

    <article class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm shadow-slate-900/[.025]">
        <div class="flex items-start justify-between">
            <div><p class="text-sm font-medium text-slate-500">Poin beredar</p><p class="mt-3 text-3xl font-bold tracking-tight text-slate-950">{{ number_format($stats['points_circulating']) }}</p></div>
            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-amber-600"><svg viewBox="0 0 24 24" fill="none" class="h-5 w-5" aria-hidden="true"><circle cx="12" cy="12" r="8.5" stroke="currentColor" stroke-width="1.7"/><path d="M14.8 9.2c-.5-.7-1.4-1.1-2.6-1.1-1.3 0-2.2.7-2.2 1.7 0 2.7 5.1 1.1 5.1 4 0 1.1-1 2-2.7 2-1.3 0-2.4-.5-3-1.4M12 6.5v11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg></span>
        </div>
        <div class="mt-4 flex items-center gap-2 border-t border-slate-100 pt-3 text-xs"><span class="text-slate-400">Saldo poin seluruh member</span></div>
    </article>

    <article class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm shadow-slate-900/[.025]">
        <div class="flex items-start justify-between">
            <div><p class="text-sm font-medium text-slate-500">Penjualan hari ini</p><p class="mt-3 text-3xl font-bold tracking-tight text-slate-950">{{ number_format($stats['sales_today']) }}<span class="ml-1 text-base font-semibold text-slate-400">trx</span></p></div>
            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600"><svg viewBox="0 0 24 24" fill="none" class="h-5 w-5" aria-hidden="true"><path d="M4 19V5m0 14h16M7 15l4-4 3 2 5-6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
        </div>
        <div class="mt-4 flex items-center gap-2 border-t border-slate-100 pt-3 text-xs"><span class="font-semibold text-slate-700">Rp {{ number_format($stats['sales_today_amount']) }}</span><span class="text-slate-400">total penjualan</span></div>
    </article>

    <article class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm shadow-slate-900/[.025]">
        <div class="flex items-start justify-between">
            <div><p class="text-sm font-medium text-slate-500">Aktivitas poin hari ini</p><p class="mt-3 text-3xl font-bold tracking-tight text-slate-950">{{ number_format($stats['points_issued_today']) }}</p></div>
            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-50 text-violet-600"><svg viewBox="0 0 24 24" fill="none" class="h-5 w-5" aria-hidden="true"><path d="m12 3 2.5 5.1 5.6.8-4.1 4 1 5.6-5-2.6-5 2.6 1-5.6-4.1-4 5.6-.8L12 3Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/></svg></span>
        </div>
        <div class="mt-4 flex items-center gap-2 border-t border-slate-100 pt-3 text-xs"><span class="font-semibold text-teal-700">+{{ number_format($stats['points_issued_today']) }} poin</span><span class="text-slate-300">·</span><span class="font-semibold text-amber-600">{{ number_format($stats['redeems_today']) }} penukaran</span></div>
    </article>
</section>

<section class="grid gap-5 xl:grid-cols-[1.4fr_1fr]">
    <article class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm shadow-slate-900/[.025]">
        <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4 sm:px-6">
            <div><h2 class="font-bold text-slate-900">Transaksi terbaru</h2><p class="mt-1 text-xs text-slate-400">Aktivitas penjualan dan poin member</p></div>
            <a href="{{ route('sales.index') }}" class="rounded-lg px-2 py-1.5 text-xs font-semibold text-teal-700 transition hover:bg-teal-50">Lihat semua <span aria-hidden="true">→</span></a>
        </div>
        <div class="divide-y divide-slate-100 px-5 sm:px-6">
            @forelse($recentSales as $sale)
                <div class="flex items-center justify-between gap-3 py-4">
                    <div class="flex min-w-0 items-center gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-sm font-bold text-slate-500">{{ mb_strtoupper(mb_substr($sale->member->name ?? 'M', 0, 1)) }}</span>
                        <div class="min-w-0"><p class="truncate text-sm font-semibold text-slate-800">{{ $sale->member->name ?? 'Member tidak ditemukan' }}</p><p class="mt-1 text-xs text-slate-400">{{ $sale->created_at->format('d M Y · H:i') }}</p></div>
                    </div>
                    <div class="shrink-0 text-right"><p class="text-sm font-semibold text-slate-800">Rp {{ number_format($sale->amount) }}</p><p class="mt-1 text-xs font-semibold text-teal-700">+{{ number_format($sale->points_earned) }} poin</p></div>
                </div>
            @empty
                <div class="py-12 text-center"><span class="mx-auto mb-3 flex h-11 w-11 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">—</span><p class="text-sm font-semibold text-slate-600">Belum ada transaksi</p><p class="mt-1 text-xs text-slate-400">Transaksi baru akan tampil di sini.</p></div>
            @endforelse
        </div>
    </article>

    <article class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm shadow-slate-900/[.025]">
        <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4 sm:px-6">
            <div><h2 class="font-bold text-slate-900">Member teratas</h2><p class="mt-1 text-xs text-slate-400">Berdasarkan poin sepanjang waktu</p></div>
            <a href="{{ route('members.index') }}" class="rounded-lg px-2 py-1.5 text-xs font-semibold text-teal-700 transition hover:bg-teal-50">Semua member <span aria-hidden="true">→</span></a>
        </div>
        <div class="divide-y divide-slate-100 px-5 sm:px-6">
            @forelse($topMembers as $position => $member)
                <div class="flex items-center justify-between gap-3 py-4">
                    <div class="flex min-w-0 items-center gap-3">
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg text-xs font-bold {{ $position === 0 ? 'bg-amber-50 text-amber-700' : 'bg-slate-100 text-slate-500' }}">{{ str_pad($position + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        <div class="min-w-0"><p class="truncate text-sm font-semibold text-slate-800">{{ $member->name }}</p><p class="mt-1 text-xs text-slate-400">{{ $member->tier?->name ?? 'Member' }}</p></div>
                    </div>
                    <span class="shrink-0 text-sm font-bold text-slate-800">{{ number_format($member->lifetime_points) }} <span class="text-xs font-medium text-slate-400">poin</span></span>
                </div>
            @empty
                <div class="py-12 text-center"><p class="text-sm font-semibold text-slate-600">Belum ada data member</p><p class="mt-1 text-xs text-slate-400">Member yang bergabung akan tampil di sini.</p></div>
            @endforelse
        </div>
    </article>
</section>

<section class="mt-5 flex flex-col gap-4 rounded-2xl border border-teal-100 bg-gradient-to-r from-teal-50 to-white p-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
    <div><p class="text-sm font-bold text-slate-900">Akses cepat</p><p class="mt-1 text-xs text-slate-500">Kelola program loyalitas langsung dari sini.</p></div>
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('redemptions.create') }}" class="rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs font-semibold text-slate-700 shadow-sm transition hover:border-teal-200 hover:text-teal-800">Tukar reward</a>
        <a href="{{ route('rewards.index') }}" class="rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs font-semibold text-slate-700 shadow-sm transition hover:border-teal-200 hover:text-teal-800">Kelola katalog reward</a>
    </div>
</section>
@endsection
