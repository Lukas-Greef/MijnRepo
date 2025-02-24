<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {

        return view('posts.index', [
            'posts' => Post::latest()->filter(
                request(['search', 'category', 'author'])
            )->paginate(6)->withQueryString() // Haalt alle posts op, gesorteerd van nieuwste naar oudste
        ]);
    }
    public function show(Post $post)
    {
        return view('posts.show', [
            'post' => $post
        ]);
    }
    public function make()
    {
        $categories = Category::all(); // Fetch all categories for the dropdown
        $posts = Post::all(); // Fetch all posts to display below the form

        return view('posts.make', compact('categories', 'posts'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:posts,slug',
            'body' => 'required|string',
            'excerpt' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Create the post and associate the user_id
        $post = Post::create([
            'user_id' => auth()->id(), // Get the authenticated user's ID
            'title' => $validatedData['title'],
            'slug' => $validatedData['slug'],
            'body' => $validatedData['body'],
            'excerpt' => $validatedData['excerpt'],
            'category_id' => $validatedData['category_id'],
        ]);

        return redirect()->route('home')->with('success', 'Post created successfully!');
    }









    //index, show, create, store, edit, update, destroy
}
