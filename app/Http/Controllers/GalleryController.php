<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        return view('gallery.index', [
            'gallery' => Gallery::latest()->paginate(12)
        ]);
    }

    public function store(Request $request)
    {
        $formFields = $request->validate([
            'g_title' => ['required', 'string', 'max:64'],
            'home_page' => ['sometimes', 'boolean'],
            'g_image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:4096'] // Add validation rules for image
        ]);

        if ($request->hasFile('g_image')) {
            $formFields['g_image'] = $request->file('g_image')->store('images', 'public');
        }

        Gallery::create($formFields);

        return back()->with(['message' => 'Slika dodana v galerijo']);
    }


    public function edit(Request $request, Gallery $gallery)
    {
        $formFields = $request->validate([
            'g_title' => ['required', 'string', 'max:64'],
            'g_image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:4096'], // Add validation rules for image
            'home_page' => ['sometimes', 'boolean'],
        ]);

        if ($request->hasFile('g_image')) {
            $formFields['g_image'] = $request->file('g_image')->store('images', 'public');
        }

        $gallery->update($formFields);

        //TODO: delete files that are no longer used

        return back()->with(['message' => 'Slika posodobljena']);
    }

    public function destroy(Gallery $gallery)
    {
        // Delete the image from the server
        Storage::disk('public')->delete($gallery->g_image);
        // Delete the gallery item from the database
        $gallery->delete();

        return back()->with(['message' => 'Novica uspešno zbirsana(a)']);
    }
}
