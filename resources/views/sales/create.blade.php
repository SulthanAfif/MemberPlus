@extends('layouts.app')
@section('title', 'Kasir')
@section('content')
<section class="mb-7">
    <p class="mb-2 text-xs font-bold uppercase tracking-[.18em] text-teal-700">Kasir</p>
    <h1 class="text-3xl font-bold tracking-tight text-slate-950">Catat transaksi</h1>
    <p class="mt-2 text-sm text-slate-500">Masukkan detail belanja untuk menambahkan poin ke akun member.</p>
</section>

<div class="grid items-start gap-5 xl:grid-cols-[minmax(0,1.5fr)_minmax(260px,.8fr)]">
    <form method="POST" action="{{ route('sales.store') }}" class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm shadow-slate-900/[.025]">
        @csrf
        <div class="border-b border-slate-100 px-5 py-4 sm:px-6"><h2 class="font-bold text-slate-900">Detail pembelian</h2><p class="mt-1 text-xs text-slate-400">Kolom bertanda * wajib diisi.</p></div>
        <div class="space-y-5 p-5 sm:p-6">
            <div>
                <label for="member-search" class="mb-1.5 block text-sm font-semibold text-slate-700">Member <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <svg viewBox="0 0 24 24" fill="none" class="pointer-events-none absolute left-3 top-3 h-4 w-4 text-slate-400" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.8" stroke="currentColor" stroke-width="1.7"/><path d="m16 16 4.5 4.5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
                    <input type="search" id="member-search" autocomplete="off" placeholder="Cari nama, nomor WhatsApp, atau kode" class="w-full rounded-xl border border-slate-200 py-2.5 pl-10 pr-3 text-sm outline-none transition placeholder:text-slate-400 focus:border-teal-600 focus:ring-4 focus:ring-teal-600/10">
                </div>
                <select name="member_id" id="member-id" required aria-label="Pilih member" class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-teal-600 focus:ring-4 focus:ring-teal-600/10">
                    <option value="">Pilih member</option>
                    @php
                        $prefill = request('member_id');
                        $list = \App\Models\Member::with('tier')->active()->orderBy('name')->limit(50)->get();
                    @endphp
                    @foreach($list as $member)
                        <option value="{{ $member->id }}" @selected($prefill == $member->id)>{{ $member->name }} ({{ $member->code }}) · {{ number_format($member->points_balance) }} poin · {{ $member->tier?->name }}</option>
                    @endforeach
                </select>
                <p id="member-search-status" aria-live="polite" class="mt-1.5 min-h-4 text-xs text-slate-400">Pilih dari daftar atau ketik minimal 2 karakter untuk mencari.</p>
            </div>

            <div>
                <label for="amount" class="mb-1.5 block text-sm font-semibold text-slate-700">Total belanja <span class="text-rose-500">*</span></label>
                <div class="flex overflow-hidden rounded-xl border border-slate-200 transition focus-within:border-teal-600 focus-within:ring-4 focus-within:ring-teal-600/10">
                    <span class="flex items-center border-r border-slate-200 bg-slate-50 px-3 text-sm font-semibold text-slate-500">Rp</span>
                    <input id="amount" type="number" name="amount" value="{{ old('amount', 50000) }}" min="1000" step="1000" required inputmode="numeric" class="w-full min-w-0 border-0 px-3 py-2.5 text-sm text-slate-800 outline-none">
                </div>
                <p class="mt-1.5 text-xs text-slate-400">Perhitungan poin mengikuti aturan dan multiplier tier member.</p>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div><label for="invoice-number" class="mb-1.5 block text-sm font-semibold text-slate-700">Nomor invoice <span class="font-normal text-slate-400">(opsional)</span></label><input id="invoice-number" type="text" name="invoice_number" value="{{ old('invoice_number') }}" placeholder="Contoh: INV-00125" class="w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm outline-none transition placeholder:text-slate-400 focus:border-teal-600 focus:ring-4 focus:ring-teal-600/10"></div>
                <div><label for="notes" class="mb-1.5 block text-sm font-semibold text-slate-700">Catatan <span class="font-normal text-slate-400">(opsional)</span></label><input id="notes" type="text" name="notes" value="{{ old('notes') }}" placeholder="Catatan transaksi" class="w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm outline-none transition placeholder:text-slate-400 focus:border-teal-600 focus:ring-4 focus:ring-teal-600/10"></div>
            </div>
        </div>
        <div class="flex flex-col-reverse gap-2 border-t border-slate-100 bg-slate-50/60 px-5 py-4 sm:flex-row sm:justify-end sm:px-6">
            <a href="{{ route('sales.index') }}" class="rounded-xl px-4 py-2.5 text-center text-sm font-semibold text-slate-600 transition hover:bg-slate-100">Lihat riwayat transaksi</a>
            <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-teal-700 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-teal-900/15 transition hover:bg-teal-800"><svg viewBox="0 0 24 24" fill="none" class="h-4 w-4" aria-hidden="true"><path d="m5 12 4 4L19 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>Proses transaksi</button>
        </div>
    </form>

    <aside class="rounded-2xl border border-teal-100 bg-gradient-to-br from-teal-50 via-white to-white p-5 sm:p-6">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-teal-100 text-teal-800"><svg viewBox="0 0 24 24" fill="none" class="h-5 w-5" aria-hidden="true"><path d="M12 3 14.5 8.1l5.6.8-4.1 4 1 5.6-5-2.6-5 2.6 1-5.6-4.1-4 5.6-.8L12 3Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/></svg></span>
        <h2 class="mt-4 font-bold text-slate-900">Poin otomatis</h2>
        <p class="mt-2 text-sm leading-6 text-slate-500">Setelah transaksi berhasil, poin akan ditambahkan ke saldo member sesuai nominal belanja dan tier yang berlaku.</p>
        <div class="mt-5 rounded-xl border border-teal-100 bg-white/80 p-4">
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Sebelum menyimpan</p>
            <ul class="mt-3 space-y-2.5 text-sm text-slate-600">
                <li class="flex gap-2"><span class="font-bold text-teal-700">✓</span>Pastikan member yang dipilih benar.</li>
                <li class="flex gap-2"><span class="font-bold text-teal-700">✓</span>Periksa kembali total belanja.</li>
                <li class="flex gap-2"><span class="font-bold text-teal-700">✓</span>Gunakan nomor invoice untuk memudahkan pelacakan.</li>
            </ul>
        </div>
    </aside>
</div>

<script>
const search = document.getElementById('member-search');
const select = document.getElementById('member-id');
const status = document.getElementById('member-search-status');
let timer;
search?.addEventListener('input', () => {
    clearTimeout(timer);
    const query = search.value.trim();
    if (query.length < 2) {
        status.textContent = 'Pilih dari daftar atau ketik minimal 2 karakter untuk mencari.';
        return;
    }

    status.textContent = 'Mencari member…';
    timer = setTimeout(async () => {
        try {
            const response = await fetch(`{{ url('/api/members/search') }}?q=` + encodeURIComponent(query), {
                headers: { 'Accept': 'application/json' },
            });
            const result = await response.json();
            const members = result.data ?? [];
            if (!members.length) {
                status.textContent = 'Member tidak ditemukan. Coba kata kunci lain.';
                return;
            }

            select.replaceChildren(new Option('Pilih member', ''));
            members.forEach((member) => {
                const details = [member.code, `${new Intl.NumberFormat('id-ID').format(member.points)} poin`, member.tier].filter(Boolean).join(' · ');
                select.add(new Option(`${member.name} · ${details}`, member.id));
            });
            status.textContent = `${members.length} member ditemukan.`;
        } catch (error) {
            status.textContent = 'Pencarian gagal. Silakan coba lagi.';
        }
    }, 300);
});
</script>
@endsection
