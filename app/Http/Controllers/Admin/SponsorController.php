<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SponsorController extends Controller
{
    public function index(Request $request)
    {
        $query = Sponsor::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $sponsors = $query->orderBy('position')->orderBy('name')->paginate(15)->withQueryString();

        return view('admin.sponsors.index', compact('sponsors'));
    }

    public function create()
    {
        return view('admin.sponsors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'svg'       => 'required|string',
            'link'      => 'required|url|max:255',
            'position'  => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $sponsor = Sponsor::create([
            'name'      => $request->name,
            'svg'       => $request->svg,
            'link'      => $request->link,
            'position'  => $request->input('position', 0),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.sponsors.index')
            ->with('success', 'Sponsor "' . $sponsor->name . '" created successfully.');
    }

    public function edit(Sponsor $sponsor)
    {
        return view('admin.sponsors.edit', compact('sponsor'));
    }

    public function update(Request $request, Sponsor $sponsor)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'svg'       => 'required|string',
            'link'      => 'required|url|max:255',
            'position'  => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $sponsor->update([
            'name'      => $request->name,
            'svg'       => $request->svg,
            'link'      => $request->link,
            'position'  => $request->input('position', 0),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.sponsors.index')
            ->with('success', 'Sponsor "' . $sponsor->name . '" updated successfully.');
    }

    public function destroy(Sponsor $sponsor)
    {
        $name = $sponsor->name;
        $sponsor->delete();
        return redirect()->route('admin.sponsors.index')
            ->with('success', 'Sponsor "' . $name . '" deleted.');
    }
}
