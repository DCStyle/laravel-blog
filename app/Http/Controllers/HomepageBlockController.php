<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\HomepageBlock;
use Illuminate\Http\Request;

class HomepageBlockController extends Controller
{
    private $allowedBlockTypes = [
        'highlight_posts' => [
            'settings.number_of_posts' => 'required|integer|min:1',
        ],
        'category' => [
            'settings.display_style' => 'required|in:list,2_columns,3_columns,grid',
            'settings.number_of_posts' => 'required|integer|min:1',
        ],
        'html' => [
            'settings.html' => 'required|string',
        ]
    ];

    public function index()
    {
        $blocks = HomepageBlock::orderBy('order')->get();
        return view('homepage-blocks.index', compact('blocks'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('homepage-blocks.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:' . implode(',', array_keys($this->allowedBlockTypes)),
            'settings' => 'nullable|array',
        ]);

        // Validate settings based on block type
        $request->validate($this->allowedBlockTypes[$request->type]);

        // Store block
        HomepageBlock::create([
            'title' => $request->title,
            'type' => $request->type,
            'is_visible' => $request->has('is_visible'),
            'settings' => $request->settings,
            'order' => HomepageBlock::max('order') + 1,
        ]);

        return redirect()->route('homepage-blocks.index')->with('success', 'Thêm block thành công!');
    }

    public function edit(HomepageBlock $homepageBlock)
    {
        $categories = Category::all();

        return view('homepage-blocks.form', compact('homepageBlock', 'categories'));
    }

    public function update(Request $request, HomepageBlock $homepageBlock)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:' . implode(',', array_keys($this->allowedBlockTypes)),
            'settings' => 'nullable|array',
        ]);

        // Validate settings based on block type
        $request->validate($this->allowedBlockTypes[$request->type]);

        $homepageBlock->update([
            'title' => $request->title,
            'type' => $request->type,
            'is_visible' => $request->has('is_visible'),
            'settings' => $request->settings,
        ]);

        return redirect()->route('homepage-blocks.index')->with('success', 'Cập nhật block thành công!');
    }

    public function destroy(HomepageBlock $homepageBlock)
    {
        $homepageBlock->delete();
        return redirect()->route('homepage-blocks.index')->with('success', 'Xóa block thành công!');
    }

    public function updateOrder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'required|integer|exists:homepage_blocks,id'
        ]);

        foreach ($request->order as $index => $id) {
            HomepageBlock::where('id', $id)->update(['order' => $index]);
        }

        return response()->json(['success' => true]);
    }
}
