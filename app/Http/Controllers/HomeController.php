<?php

namespace App\Http\Controllers;

use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $tireCategories = Category::withCount('products')
            ->where('group', Category::GROUP_TIRES)
            ->orderBy('sort_order')
            ->get();

        $wheelCategories = Category::withCount('products')
            ->where('group', Category::GROUP_WHEELS)
            ->orderBy('sort_order')
            ->get();

        $categories = $tireCategories->concat($wheelCategories);

        return view('shop.index', compact('categories', 'tireCategories', 'wheelCategories'));
    }

    public function about()
    {
        return view('shop.about');
    }

    public function privacy()
    {
        return view('shop.legal.privacy');
    }

    public function offer()
    {
        return view('shop.legal.offer');
    }
}
