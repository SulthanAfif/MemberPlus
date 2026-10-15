<?php

namespace App\Http\Controllers;

use App\Models\Reward;
use Illuminate\Http\Request;

class RewardController extends Controller
{
    public function index()
    {
        $rewards = Reward::ordered()->get();

        return view('rewards.index', compact('rewards'));
    }

    public function create()
    {
        return view('rewards.form', ['reward' => new Reward()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'points_cost' => 'required|integer|min:1',
            'stock' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $data['is_active'] = $request->boolean('is_active', true);
        $data['sort_order'] = $data['sort_order'] ?? 0;

        Reward::create($data);

        return redirect()->route('rewards.index')->with('success', 'Reward ditambahkan.');
    }

    public function edit(Reward $reward)
    {
        return view('rewards.form', compact('reward'));
    }

    public function update(Request $request, Reward $reward)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'points_cost' => 'required|integer|min:1',
            'stock' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $reward->update($data);

        return redirect()->route('rewards.index')->with('success', 'Reward diupdate.');
    }

    public function destroy(Reward $reward)
    {
        $reward->delete();

        return redirect()->route('rewards.index')->with('success', 'Reward dihapus.');
    }
}
