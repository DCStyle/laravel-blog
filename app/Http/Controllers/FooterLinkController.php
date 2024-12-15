<?php

namespace App\Http\Controllers;

use App\Models\FooterLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class FooterLinkController extends Controller
{
    public function index()
    {
        $footerLinks = FooterLink::orderBy('order')->get();
        return view('footer-link.index', compact('footerLinks'));
    }

    public function create()
    {
        return view('footer-link.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'order' => 'nullable|integer',
            'status' => 'required|boolean',
        ]);

        FooterLink::create($request->all());
        $this->cacheFooterLinks(); // Update cache

        return redirect()->route('footer-links.index')->with('success', 'Footer link created successfully.');
    }

    public function edit(FooterLink $footerLink)
    {
        return view('footer-link.edit', compact('footerLink'));
    }

    public function update(Request $request, FooterLink $footerLink)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'order' => 'nullable|integer',
            'status' => 'required|boolean',
        ]);

        $footerLink->update($request->all());
        $this->cacheFooterLinks(); // Update cache

        return redirect()->route('footer-links.index')->with('success', 'Footer link updated successfully.');
    }

    public function destroy(FooterLink $footerLink)
    {
        $footerLink->delete();
        $this->cacheFooterLinks(); // Update cache

        return redirect()->route('footer-links.index')->with('success', 'Footer link deleted successfully.');
    }

    private function cacheFooterLinks()
    {
        // Cache footer links
        $footerLinks = FooterLink::where('status', true)->orderBy('order')->get();
        Cache::put('footer_links', $footerLinks, now()->addHours(24));
    }
}
