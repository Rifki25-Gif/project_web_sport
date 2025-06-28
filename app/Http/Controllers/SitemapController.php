<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $categories = Category::all();

        $sitemap = view('sitemap', compact('products', 'categories'))->render();

        return Response::make($sitemap, 200, [
            'Content-Type' => 'application/xml'
        ]);
    }
}
