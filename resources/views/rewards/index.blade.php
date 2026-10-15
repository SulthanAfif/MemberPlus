@extends('layouts.app')
@section('title', 'Katalog Reward')
@section('content')
<section class="mb-7 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
    <div><p class="mb-2 text-xs font-bold uppercase tracking-[.18em] text-teal-700">Program loyalitas</p><h1 class="text-3xl font-bold tracking-tight text-slate-950">Katalog reward</h1><p class="mt-2 text-sm text-slate-500">Kelola hadiah yang dapat ditukar oleh member.</p></div>
    <a href="{{ route('rewards.create') }}" class="inline-flex items-center justify-center rounded-xl bg-teal-700 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-teal-800">+ Tambah reward</a>
</section>
@if($rewards->isEmpty())
    <div class="rounded-2xl border border-dashed border-slate-300 bg-white px-5 py-14 text-center"><p class="text-sm font-semibold text-slate-700">Katalog reward masih kosong</p><p class="mt-1 text-xs text-slate-400">Tambahkan reward agar member dapat menukar poin mereka.</p><a href="{{ route('rewards.create') }}" class="mt-4 inline-flex rounded-xl bg-teal-700 px-4 py-2.5 text-sm font-semibold text-white">Tambah reward</a></div>
@else
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
        @foreach($rewards as $reward)
            <article class="flex min-w-0 flex-col rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm {{ !$reward->is_active ? 'opacity-70' : '' }}">
                <div class="flex items-start justify-between gap-3"><h2 class="min-w-0 break-words font-bold text-slate-900">{{ $reward->name }}</h2><span class="shrink-0 rounded-lg bg-teal-50 px-2.5 py-1 text-xs font-bold text-teal-800">{{ number_format($reward->points_cost) }} poin</span></div>
                <p class="mt-2 min-h-10 text-sm leading-5 text-slate-500">{{ $reward->description ?: 'Belum ada deskripsi.' }}</p>
                <div class="mt-4 flex flex-wrap items-center gap-2 text-xs"><span class="rounded-full bg-slate-100 px-2.5 py-1 font-medium text-slate-600">Stok: {{ $reward->stock === null ? 'Tidak terbatas' : number_format($reward->stock) }}</span><span class="rounded-full px-2.5 py-1 font-semibold {{ $reward->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">{{ $reward->is_active ? 'Aktif' : 'Nonaktif' }}</span></div>
                <div class="mt-5 flex items-center gap-2 border-t border-slate-100 pt-4 text-sm"><a href="{{ route('rewards.edit', $reward) }}" class="rounded-lg px-3 py-2 font-semibold text-teal-800 transition hover:bg-teal-50">Edit</a><form action="{{ route('rewards.destroy', $reward) }}" method="POST" onsubmit="return confirm('Hapus reward ini?')">@csrf @method('DELETE')<button type="submit" class="rounded-lg px-3 py-2 font-semibold text-rose-600 transition hover:bg-rose-50">Hapus</button></form></div>
            </article>
        @endforeach
    </div>
@endif
@endsection
