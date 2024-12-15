<?php

namespace App\Http\Controllers;

use App\Models\HomepageBlock;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        $blocks = HomepageBlock::where('is_visible', true)->orderBy('order')->get();

        return view('index.index', compact('blocks'));
    }
}
