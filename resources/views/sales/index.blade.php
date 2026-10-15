@extends('layouts.app')
@section('title', 'Riwayat Transaksi')
@section('content')
<section class="mb-6 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
    <div><p class="mb-2 text-xs font-bold uppercase tracking-[.18em] text-teal-700">Aktivitas toko</p><h1 class="text-3xl font-bold tracking-tight text-slate-950">Riwayat transaksi</h1><p class="mt-2 text-sm text-slate-500">Daftar belanja member dan poin yang diperoleh.</p></div>
    <a href="{{ route('sales.create') }}" class="inline-flex items-center justify-center rounded-xl bg-teal-700 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-teal-800">+ Catat transaksi</a>
</section>
<div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full min-w-[640px] text-left text-sm">
            <thead class="bg-slate-50/80 text-xs font-semibold uppercase tracking-wide text-slate-500">
                <tr><th scope="col" class="px-5 py-3.5">Waktu</th><th scope="col" class="px-4 py-3.5">Member</th><th scope="col" class="px-4 py-3.5">Invoice</th><th scope="col" class="px-4 py-3.5">Nominal</th><th scope="col" class="px-5 py-3.5 text-right">Poin</th></tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($sales as $sale)
                    <tr class="transition hover:bg-slate-50/70">
                        <td class="whitespace-nowrap px-5 py-4 text-slate-500">{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-4"><a href="{{ route('members.show', $sale->member_id) }}" class="font-semibold text-teal-800 hover:underline">{{ $sale->member->name ?? '—' }}</a></td>
                        <td class="px-4 py-4 text-slate-500">{{ $sale->invoice_number ?? '—' }}</td>
                        <td class="whitespace-nowrap px-4 py-4 font-medium text-slate-700">Rp {{ number_format($sale->amount) }}</td>
                        <td class="whitespace-nowrap px-5 py-4 text-right font-semibold text-teal-700">+{{ number_format($sale->points_earned) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-6 py-12 text-center text-sm text-slate-400">Belum ada transaksi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">{{ $sales->links() }}</div>
@endsection
