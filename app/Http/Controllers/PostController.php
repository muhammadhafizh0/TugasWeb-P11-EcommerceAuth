<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

/**
 * PostController (Blog sederhana) dengan:
 * - $request->user()->id disimpan sebagai pemilik post saat store()
 * - authorize() memanggil PostPolicy sebelum edit/update/destroy
 * - middleware auth diterapkan di routes/web.php (lihat file routes)
 */
class PostController extends Controller
{
    public function index(Request $request): View
    {
        $posts = Post::with('user')->latest()->paginate(6);

        return view('posts.index', compact('posts'));
    }

    public function create(): View
    {
        return view('posts.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body'  => 'required|string|min:10',
        ]);

        $validated['user_id'] = $request->user()->id;

        Post::create($validated);

        return redirect()
            ->route('posts.index')
            ->with('success', 'Post berhasil ditambahkan.');
    }

    public function show(Post $post): View
    {
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post): View
    {
        $this->authorize('update', $post);

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        $this->authorize('update', $post);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body'  => 'required|string|min:10',
        ]);

        $post->update($validated);

        return redirect()
            ->route('posts.show', $post)
            ->with('success', 'Post berhasil diperbarui.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $this->authorize('delete', $post);

        $post->delete();

        return redirect()
            ->route('posts.index')
            ->with('success', 'Post berhasil dihapus.');
    }
}
