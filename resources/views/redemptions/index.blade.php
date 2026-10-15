@extends('layouts.app')
@section('title', 'Riwayat Penukaran')
@section('content')
<section class="mb-6 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
    <div><p class="mb-2 text-xs font-bold uppercase tracking-[.18em] text-amber-700">Program reward</p><h1 class="text-3xl font-bold tracking-tight text-slate-950">Riwayat penukaran</h1><p class="mt-2 text-sm text-slate-500">Reward yang telah ditukar oleh para member.</p></div>
    <a href="{{ route('redemptions.create') }}" class="inline-flex items-center justify-center rounded-xl bg-amber-500 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-amber-600">+ Tukar reward</a>
</section>
<div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full min-w-[560px] text-left text-sm">
            <thead class="bg-slate-50/80 text-xs font-semibold uppercase tracking-wide text-slate-500">
                <tr><th scope="col" class="px-5 py-3.5">Waktu</th><th scope="col" class="px-4 py-3.5">Member</th><th scope="col" class="px-4 py-3.5">Reward</th><th scope="col" class="px-5 py-3.5 text-right">Poin</th></tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($redemptions as $redemption)
                    <tr class="transition hover:bg-slate-50/70">
                        <td class="whitespace-nowrap px-5 py-4 text-slate-500">{{ $redemption->redeemed_at?->format('d/m/Y H:i') ?? $redemption->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-4 font-medium text-slate-700">{{ $redemption->member->name ?? '—' }}</td>
                        <td class="px-4 py-4 font-medium text-slate-700">{{ $redemption->reward->name ?? '—' }}</td>
                        <td class="whitespace-nowrap px-5 py-4 text-right font-semibold text-amber-700">−{{ number_format($redemption->points_spent) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-6 py-12 text-center text-sm text-slate-400">Belum ada penukaran.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">{{ $redemptions->links() }}</div>
@endsection
