<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageAdminController extends Controller
{
    public function index()
    {
        $pages = Page::latest()->paginate(10);
        return view('page.index', compact('pages'));
    }

    public function create()
    {
        return view('page.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date'
        ]);

        Page::create($validated);

        return redirect()->route('pages.index')
            ->with('success', 'Page created successfully.');
    }

    public function edit(Page $page)
    {
        return view('page.form', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|max:255|unique:pages,slug,' . $page->id,
            'content' => 'required',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date'
        ]);

        $page->update($validated);

        return redirect()->route('pages.index')
            ->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('pages.index')
            ->with('success', 'Page deleted successfully.');
    }
}
