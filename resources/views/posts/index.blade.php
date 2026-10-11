<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Daftar Post</h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        @auth
            <a href="{{ route('posts.create') }}" class="inline-block mb-4 px-4 py-2 bg-gray-800 text-white rounded">+ Post Baru</a>
        @endauth

        @forelse ($posts as $post)
            <div class="bg-white shadow-sm rounded p-4 mb-3">
                <a href="{{ route('posts.show', $post) }}" class="text-lg font-semibold text-blue-700">{{ $post->title }}</a>
                <p class="text-sm text-gray-500">oleh {{ $post->user->name }} · {{ $post->created_at->diffForHumans() }}</p>
                <p class="mt-2 text-gray-700">{{ \Illuminate\Support\Str::limit($post->body, 120) }}</p>

                @can('update', $post)
                    <div class="mt-3 flex gap-3">
                        <a href="{{ route('posts.edit', $post) }}" class="text-yellow-700">Edit</a>
                        <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Hapus post ini?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600">Hapus</button>
                        </form>
                    </div>
                @endcan
            </div>
        @empty
            <p class="text-gray-500">Belum ada post.</p>
        @endforelse

        {{ $posts->links() }}
    </div>
</x-app-layout>
