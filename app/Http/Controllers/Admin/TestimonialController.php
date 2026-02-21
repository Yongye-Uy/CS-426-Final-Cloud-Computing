<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $testimonials = Testimonial::latest()->get();
        return response()->json($testimonials);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.testimonials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'donor_name' => 'required|string|max:255',
            'donor_title' => 'nullable|string|max:255',
            'content' => 'required|string',
            'rating' => 'required|numeric|min:1|max:5',
            'is_featured' => 'boolean',
            'is_active' => 'boolean'
        ]);

        $testimonial = Testimonial::create([
            'donor_name' => $request->donor_name,
            'donor_title' => $request->donor_title,
            'content' => $request->content,
            'rating' => $request->rating,
            'is_featured' => $request->boolean('is_featured'),
            'is_active' => $request->boolean('is_active', true)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Testimonial created successfully!',
            'testimonial' => $testimonial
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Testimonial $testimonial)
    {
        return response()->json($testimonial);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            'donor_name' => 'required|string|max:255',
            'donor_title' => 'nullable|string|max:255',
            'content' => 'required|string',
            'rating' => 'required|numeric|min:1|max:5',
            'is_featured' => 'boolean',
            'is_active' => 'boolean'
        ]);

        $testimonial->update([
            'donor_name' => $request->donor_name,
            'donor_title' => $request->donor_title,
            'content' => $request->content,
            'rating' => $request->rating,
            'is_featured' => $request->boolean('is_featured'),
            'is_active' => $request->boolean('is_active')
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Testimonial updated successfully!',
            'testimonial' => $testimonial
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();

        return response()->json([
            'success' => true,
            'message' => 'Testimonial deleted successfully!'
        ]);
    }
}
