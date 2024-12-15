<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MenuController extends Controller
{
    // Display a listing of the menu items
    public function index()
    {
        $menuItems = MenuItem::whereNull('parent_id')->with('children')->orderBy('order')->get();
        return view('menu.index', compact('menuItems'));
    }

    // Show the form for creating a new menu item
    public function create()
    {
        $menuItems = MenuItem::whereNull('parent_id')->get(); // For parent selection
        return view('menu.create', compact('menuItems'));
    }

    // Store a newly created menu item in the database
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:menu_items,id',
            'order' => 'nullable|integer',
            'status' => 'required|boolean',
        ]);

        MenuItem::create($request->all());

        // Refresh cache
        $this->cacheMenuItems();

        return redirect()->route('menu.index')->with('success', 'Menu item created successfully!');
    }

    // Show the form for editing the specified menu item
    public function edit($id)
    {
        $menuItem = MenuItem::findOrFail($id);

        $menuItems = MenuItem::whereNull('parent_id')->where('id', '!=', $menuItem->id)->get(); // Avoid self-selection as parent
        return view('menu.edit', compact('menuItem', 'menuItems'));
    }

    // Update the specified menu item in the database
    public function update(Request $request, $id)
    {
        $menuItem = MenuItem::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:menu_items,id',
            'order' => 'nullable|integer',
            'status' => 'required|boolean',
        ]);

        $menuItem->update($request->all());

        // Refresh cache
        $this->cacheMenuItems();

        return redirect()->route('menu.index')->with('success', 'Menu item updated successfully!');
    }

    // Remove the specified menu item from the database
    public function destroy($id)
    {
        $menuItem = MenuItem::findOrFail($id);
        $menuItem->delete();

        // Refresh cache
        $this->cacheMenuItems();

        return redirect()->route('menu.index')->with('success', 'Menu item deleted successfully!');
    }

    // Cache the menu items
    private function cacheMenuItems()
    {
        $menuItems = MenuItem::whereNull('parent_id')
            ->with('children')
            ->where('status', true)
            ->orderBy('order')
            ->get();

        Cache::put('navbar_menu', $menuItems, 60 * 60 * 24);
    }
}
