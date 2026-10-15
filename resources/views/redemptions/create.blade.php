@extends('layouts.app')
@section('title', 'Tukar Reward')
@section('content')
<section class="mb-6"><p class="mb-2 text-xs font-bold uppercase tracking-[.18em] text-amber-700">Program reward</p><h1 class="text-3xl font-bold tracking-tight text-slate-950">Tukar reward</h1><p class="mt-2 text-sm text-slate-500">Pilih member untuk melihat saldo poin dan hadiah yang tersedia.</p></section>

<form method="POST" action="{{ route('redemptions.store') }}" id="redeem-form" class="mb-5 max-w-2xl rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm sm:p-5">
    @csrf
    <label for="member_id" class="mb-1.5 block text-sm font-semibold text-slate-700">Pilih member <span class="text-rose-500">*</span></label>
    <select name="member_id" id="member_id" required class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none transition focus:border-teal-600 focus:ring-4 focus:ring-teal-600/10" onchange="location.href='{{ route('redemptions.create') }}?member_id='+this.value">
        <option value="">Pilih member</option>
        @php $list = \App\Models\Member::with('tier')->active()->orderBy('name')->limit(50)->get(); @endphp
        @foreach($list as $memberOption)
            <option value="{{ $memberOption->id }}" @selected(($member->id ?? request('member_id')) == $memberOption->id)>{{ $memberOption->name }} · {{ number_format($memberOption->points_balance) }} poin · {{ $memberOption->tier?->name }}</option>
        @endforeach
    </select>
    @if($member ?? null)
        <div class="mt-3 flex flex-wrap items-center justify-between gap-2 rounded-xl bg-teal-50 px-3.5 py-3"><span class="text-sm font-medium text-slate-600">Saldo poin {{ $member->name }}</span><span class="text-sm font-bold text-teal-800">{{ number_format($member->points_balance) }} poin <span class="font-medium text-teal-700">· {{ $member->tier?->name }}</span></span></div>
    @endif
</form>

@if($rewards->isEmpty())
    <div class="rounded-2xl border border-dashed border-slate-300 bg-white px-5 py-12 text-center"><p class="text-sm font-semibold text-slate-700">Belum ada reward tersedia</p><p class="mt-1 text-xs text-slate-400">Reward aktif akan muncul di sini.</p></div>
@else
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
        @foreach($rewards as $reward)
            <form method="POST" action="{{ route('redemptions.store') }}" class="flex min-w-0 flex-col rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md sm:p-5">
                @csrf
                <input type="hidden" name="member_id" value="{{ $member->id ?? request('member_id') }}">
                <input type="hidden" name="reward_id" value="{{ $reward->id }}">
                <div class="flex items-start justify-between gap-3"><h2 class="min-w-0 font-bold text-slate-900">{{ $reward->name }}</h2><span class="shrink-0 rounded-lg bg-amber-50 px-2.5 py-1 text-xs font-bold text-amber-700">{{ number_format($reward->points_cost) }} poin</span></div>
                <p class="mt-2 min-h-10 text-sm leading-5 text-slate-500">{{ $reward->description ?: 'Tukarkan poin dengan reward ini.' }}</p>
                <p class="mt-3 text-xs text-slate-400">Stok: {{ $reward->stock === null ? 'Tidak terbatas' : number_format($reward->stock) }}</p>
                <button type="submit" class="mt-4 w-full rounded-xl bg-amber-500 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-amber-600 disabled:cursor-not-allowed disabled:opacity-40" @disabled(!($member ?? null) || (($member->points_balance ?? 0) < $reward->points_cost) || ($reward->stock !== null && $reward->stock < 1)) onclick="return confirm('Tukar reward ini?')">Tukar reward</button>
            </form>
        @endforeach
    </div>
@endif
<a href="{{ route('redemptions.index') }}" class="mt-5 inline-flex text-sm font-semibold text-teal-800 hover:underline">Lihat riwayat penukaran <span class="ml-1" aria-hidden="true">→</span></a>
@endsection
