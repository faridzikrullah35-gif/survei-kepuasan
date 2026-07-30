<?php

namespace App\Http\Controllers;

use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SlideController extends Controller
{
    /**
     * Tampilkan daftar slide (admin)
     */
    public function index()
    {
        $slides = Slide::orderBy('order')->get();
        return view('slide-gambar.index', compact('slides')); // ubah path view
    }

    /**
     * Tampilkan form tambah slide (tidak dipakai karena pakai modal)
     */
    public function create()
    {
        // tidak dipakai, tapi tetap ada jika suatu saat butuh
        return view('slide-gambar.create');
    }

    /**
     * Simpan slide baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'image'     => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'order'     => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $path = $request->file('image')->store('slides', 'public');

        Slide::create([
            'image'     => $path,
            'order'     => $request->order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Slide berhasil ditambahkan.']);
        }

        return redirect()->route('slides.index')->with('success', 'Slide berhasil ditambahkan.');
    }

    /**
     * Tampilkan detail slide (opsional)
     */
    public function show(Slide $slide)
    {
        return view('slide-gambar.show', compact('slide'));
    }

    /**
     * Tampilkan form edit slide (untuk AJAX, mengembalikan JSON)
     */
    public function edit(Slide $slide)
    {
        $image = null;

        if ($slide->image && Storage::disk('public')->exists($slide->image)) {

            $path = storage_path('app/public/' . $slide->image);

            $image = 'data:' .
                mime_content_type($path) .
                ';base64,' .
                base64_encode(file_get_contents($path));
        }

        return response()->json([
            'id'        => $slide->id,
            'image'     => $image,
            'title'     => $slide->title,
            'caption'   => $slide->caption,
            'order'     => $slide->order,
            'is_active' => $slide->is_active,
        ]);
    }

    /**
     * Update slide
     */
    public function update(Request $request, Slide $slide)
    {
        $request->validate([
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'order'     => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->only(['order']);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($slide->image && Storage::disk('public')->exists($slide->image)) {
                Storage::disk('public')->delete($slide->image);
            }
            $data['image'] = $request->file('image')->store('slides', 'public');
        }

        $slide->update($data);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Slide berhasil diperbarui.']);
        }

        return redirect()->route('slides.index')->with('success', 'Slide berhasil diperbarui.');
    }

    /**
     * Hapus slide
     */
    public function destroy(Request $request, Slide $slide)
    {
        if ($slide->image && Storage::disk('public')->exists($slide->image)) {
            Storage::disk('public')->delete($slide->image);
        }
        $slide->delete();

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Slide berhasil dihapus.']);
        }

        return redirect()->route('slides.index')->with('success', 'Slide berhasil dihapus.');
    }
}