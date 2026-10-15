@extends('layouts.app')
@section('title', 'Member')
@section('content')
<section class="mb-7 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
    <div>
        <p class="mb-2 text-xs font-bold uppercase tracking-[.18em] text-teal-700">Hubungan pelanggan</p>
        <h1 class="text-3xl font-bold tracking-tight text-slate-950">Direktori member</h1>
        <p class="mt-2 text-sm text-slate-500">Lihat profil, status, dan saldo poin pelanggan Anda.</p>
    </div>
    <a href="{{ route('members.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-teal-700 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-teal-900/15 transition hover:bg-teal-800"><span class="text-lg leading-none">+</span> Daftarkan member</a>
</section>

<section class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm shadow-slate-900/[.025]">
    <form method="GET" class="flex flex-col gap-3 border-b border-slate-100 p-4 sm:flex-row sm:items-end sm:p-5">
        <div class="min-w-0 flex-1">
            <label for="member-query" class="mb-1.5 block text-xs font-semibold text-slate-600">Cari member</label>
            <div class="relative">
                <svg viewBox="0 0 24 24" fill="none" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.8" stroke="currentColor" stroke-width="1.7"/><path d="m16 16 4.5 4.5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
                <input id="member-query" type="search" name="q" value="{{ request('q') }}" placeholder="Nama, nomor WhatsApp, atau kode" class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-teal-600 focus:ring-4 focus:ring-teal-600/10">
            </div>
        </div>
        <div class="sm:w-52">
            <label for="member-status" class="mb-1.5 block text-xs font-semibold text-slate-600">Status</label>
            <select id="member-status" name="status" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-teal-600 focus:ring-4 focus:ring-teal-600/10">
                <option value="">Semua status</option>
                <option value="active" @selected(request('status') === 'active')>Aktif</option>
                <option value="inactive" @selected(request('status') === 'inactive')>Nonaktif</option>
                <option value="suspended" @selected(request('status') === 'suspended')>Ditangguhkan</option>
            </select>
        </div>
        <button type="submit" class="rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">Terapkan filter</button>
        @if(request()->filled('q') || request()->filled('status'))
            <a href="{{ route('members.index') }}" class="rounded-xl px-3 py-2.5 text-center text-sm font-semibold text-slate-500 transition hover:bg-slate-100 hover:text-slate-800">Hapus filter</a>
        @endif
    </form>

    <div class="overflow-x-auto">
        <table class="w-full min-w-[760px] text-left text-sm">
            <thead class="bg-slate-50/80 text-[11px] font-bold uppercase tracking-[.1em] text-slate-400">
                <tr>
                    <th scope="col" class="px-5 py-3.5 sm:px-6">Member</th>
                    <th scope="col" class="px-4 py-3.5">Kode</th>
                    <th scope="col" class="px-4 py-3.5">Tier</th>
                    <th scope="col" class="px-4 py-3.5">Saldo poin</th>
                    <th scope="col" class="px-4 py-3.5">Status</th>
                    <th scope="col" class="px-5 py-3.5 text-right sm:px-6">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($members as $member)
                    <tr class="transition hover:bg-slate-50/70">
                        <td class="px-5 py-4 sm:px-6">
                            <div class="flex items-center gap-3">
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-teal-50 text-sm font-bold text-teal-800">{{ mb_strtoupper(mb_substr($member->name, 0, 1)) }}</span>
                                <div class="min-w-0"><p class="truncate font-semibold text-slate-800">{{ $member->name }}</p><p class="mt-1 text-xs text-slate-400">{{ $member->phone ?: 'Nomor belum ditambahkan' }}</p></div>
                            </div>
                        </td>
                        <td class="px-4 py-4"><span class="rounded-md bg-slate-100 px-2 py-1 font-mono text-xs font-medium text-slate-600">{{ $member->code }}</span></td>
                        <td class="px-4 py-4 text-slate-600">{{ $member->tier?->name ?? '—' }}</td>
                        <td class="px-4 py-4"><span class="font-bold text-slate-800">{{ number_format($member->points_balance) }}</span><span class="ml-1 text-xs text-slate-400">poin</span></td>
                        <td class="px-4 py-4">
                            @php
                                $statusStyle = match ($member->status->value) {
                                    'active' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/15',
                                    'suspended' => 'bg-amber-50 text-amber-700 ring-amber-600/15',
                                    default => 'bg-slate-100 text-slate-600 ring-slate-500/10',
                                };
                            @endphp
                            <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset {{ $statusStyle }}"><span class="h-1.5 w-1.5 rounded-full {{ $member->status->value === 'active' ? 'bg-emerald-500' : ($member->status->value === 'suspended' ? 'bg-amber-500' : 'bg-slate-400') }}"></span>{{ $member->status->label() }}</span>
                        </td>
                        <td class="px-5 py-4 text-right sm:px-6"><a href="{{ route('members.show', $member) }}" class="inline-flex items-center gap-1 rounded-lg px-2.5 py-1.5 text-xs font-semibold text-teal-800 transition hover:bg-teal-50">Lihat profil <span aria-hidden="true">→</span></a></td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-14 text-center"><span class="mx-auto mb-3 flex h-11 w-11 items-center justify-center rounded-2xl bg-slate-100 text-slate-400"><svg viewBox="0 0 24 24" fill="none" class="h-5 w-5" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.8" stroke="currentColor" stroke-width="1.7"/><path d="m16 16 4.5 4.5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></span><p class="text-sm font-semibold text-slate-700">Tidak ada member ditemukan</p><p class="mt-1 text-xs text-slate-400">Coba ubah kata kunci atau filter status.</p></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
<div class="mt-4">{{ $members->links() }}</div>
@endsection
