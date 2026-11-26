<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FacilityController extends Controller
{
    public function index()
    {
        $facilities = Facility::withCount('kamars')->orderBy('kategori')->orderBy('nama')->get();

        if (request()->wantsJson()) {
            return response()->json(['success' => true, 'data' => $facilities]);
        }

        return view('admin.fasilitas.index', compact('facilities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100', 'unique:facilities,nama'],
            'ikon' => ['nullable', 'string', 'max:50'],
            'kategori' => ['required', Rule::in(['kamar', 'umum'])],
        ]);

        $facility = Facility::create($validated);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Fasilitas berhasil ditambahkan.', 'data' => $facility], 201);
        }

        return back()->with('success', 'Fasilitas berhasil ditambahkan.');
    }

    public function update(Request $request, Facility $facility)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100', Rule::unique('facilities', 'nama')->ignore($facility->id)],
            'ikon' => ['nullable', 'string', 'max:50'],
            'kategori' => ['required', Rule::in(['kamar', 'umum'])],
        ]);

        $facility->update($validated);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Fasilitas berhasil diperbarui.', 'data' => $facility]);
        }

        return back()->with('success', 'Fasilitas berhasil diperbarui.');
    }

    public function destroy(Facility $facility)
    {
        $facility->kamars()->detach();
        $facility->delete();

        if (request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Fasilitas berhasil dihapus.']);
        }

        return back()->with('success', 'Fasilitas berhasil dihapus.');
    }
}