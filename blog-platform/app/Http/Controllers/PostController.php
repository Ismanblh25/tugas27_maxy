<?php

namespace App\Http\Controllers;

use App\Models\Post; // Pastikan model Post sudah ada
use Illuminate\Http\Request;
use SEOTools; // Import SEOTools

class PostController extends Controller
{
    public function show($id)
    {
        // Mengambil postingan berdasarkan ID
        $post = Post::findOrFail($id);

        // Mengatur metadata SEO
        SEOTools::setTitle($post->title);
        SEOTools::setDescription($post->description);
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->setTitle($post->title);
        SEOTools::opengraph()->setDescription($post->description);
        SEOTools::jsonLd()->addImage(url($post->image));

        // Mengembalikan view dengan data postingan
        return view('posts.show', compact('post'));
    }
}
