<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with('pembuat')->latest()->get();

        if (request()->wantsJson()) {
            return response()->json(['success' => true, 'data' => $announcements]);
        }

        return view('admin.pengumuman.index', compact('announcements'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:150'],
            'isi' => ['required', 'string'],
            'is_aktif' => ['nullable', 'boolean'],
        ]);

        $announcement = Announcement::create([
            'dibuat_oleh' => Auth::id(),
            'judul' => $validated['judul'],
            'isi' => $validated['isi'],
            'is_aktif' => $request->boolean('is_aktif', true),
        ]);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Pengumuman berhasil diterbitkan.', 'data' => $announcement], 201);
        }

        return back()->with('success', 'Pengumuman berhasil diterbitkan.');
    }

    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:150'],
            'isi' => ['required', 'string'],
            'is_aktif' => ['nullable', 'boolean'],
        ]);

        $announcement->update([
            'judul' => $validated['judul'],
            'isi' => $validated['isi'],
            'is_aktif' => $request->boolean('is_aktif', true),
        ]);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Pengumuman berhasil diperbarui.', 'data' => $announcement]);
        }

        return back()->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        if (request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Pengumuman berhasil dihapus.']);
        }

        return back()->with('success', 'Pengumuman berhasil dihapus.');
    }
}