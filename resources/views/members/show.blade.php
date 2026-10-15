@extends('layouts.app')
@section('title', $member->name)
@section('content')
<section class="mb-6 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
    <div class="min-w-0"><a href="{{ route('members.index') }}" class="text-sm font-semibold text-teal-800 hover:underline">← Kembali ke member</a><h1 class="mt-2 break-words text-3xl font-bold tracking-tight text-slate-950">{{ $member->name }}</h1><p class="mt-1 break-all font-mono text-sm text-slate-500">{{ $member->code }} <span class="font-sans">· {{ $member->tier?->name ?? 'Tanpa tier' }}</span></p></div>
    <div class="flex flex-wrap gap-2"><a href="{{ route('sales.create', ['member_id' => $member->id]) }}" class="rounded-xl bg-teal-700 px-3.5 py-2.5 text-sm font-semibold text-white hover:bg-teal-800">Catat belanja</a><a href="{{ route('redemptions.create', ['member_id' => $member->id]) }}" class="rounded-xl bg-amber-500 px-3.5 py-2.5 text-sm font-semibold text-white hover:bg-amber-600">Tukar reward</a><a href="{{ route('members.edit', $member) }}" class="rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Edit</a></div>
</section>

<section class="mb-5 grid grid-cols-1 gap-3 sm:grid-cols-3" aria-label="Ringkasan member">
    <article class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm"><p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Saldo poin</p><p class="mt-2 text-3xl font-bold tracking-tight text-teal-800">{{ number_format($member->points_balance) }}</p></article>
    <article class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm"><p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Poin terkumpul</p><p class="mt-2 text-3xl font-bold tracking-tight text-slate-900">{{ number_format($member->lifetime_points) }}</p></article>
    <article class="min-w-0 rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm"><p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Status akun</p><p class="mt-2 text-lg font-bold text-slate-900">{{ $member->status->label() }}</p><p class="mt-1 break-words text-xs text-slate-500">{{ collect([$member->phone, $member->email])->filter()->implode(' · ') ?: 'Kontak belum ditambahkan' }}</p></article>
</section>

<section class="grid grid-cols-1 gap-4 lg:grid-cols-2">
    <article class="min-w-0 rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm sm:p-5"><h2 class="mb-3 font-bold text-slate-900">Riwayat poin</h2><div class="divide-y divide-slate-100">
        @forelse($pointHistory as $point)
            <div class="flex min-w-0 items-center justify-between gap-3 py-3 text-sm"><span class="min-w-0 break-words text-slate-600">{{ $point->description ?? $point->type->label() }}</span><span class="shrink-0 font-semibold {{ $point->points >= 0 ? 'text-teal-700' : 'text-amber-700' }}">{{ $point->points >= 0 ? '+' : '' }}{{ number_format($point->points) }}</span></div>
        @empty
            <p class="py-5 text-sm text-slate-400">Belum ada riwayat poin.</p>
        @endforelse
    </div></article>
    <article class="min-w-0 rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm sm:p-5"><h2 class="mb-3 font-bold text-slate-900">Penukaran reward</h2><div class="divide-y divide-slate-100">
        @forelse($redemptions as $redemption)
            <div class="flex min-w-0 items-center justify-between gap-3 py-3 text-sm"><span class="min-w-0 break-words text-slate-600">{{ $redemption->reward->name ?? 'Reward tidak ditemukan' }}</span><span class="shrink-0 font-semibold text-amber-700">−{{ number_format($redemption->points_spent) }}</span></div>
        @empty
            <p class="py-5 text-sm text-slate-400">Belum ada penukaran reward.</p>
        @endforelse
    </div></article>
</section>
@endsection
