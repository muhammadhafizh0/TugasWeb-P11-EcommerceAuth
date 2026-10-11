<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Post</h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <form action="{{ route('posts.update', $post) }}" method="POST" class="bg-white shadow-sm rounded p-6 space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block font-medium">Judul</label>
                <input type="text" name="title" value="{{ old('title', $post->title) }}" class="w-full border-gray-300 rounded">
                @error('title') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block font-medium">Isi</label>
                <textarea name="body" rows="6" class="w-full border-gray-300 rounded">{{ old('body', $post->body) }}</textarea>
                @error('body') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>
            <button class="px-4 py-2 bg-gray-800 text-white rounded">Update</button>
            <a href="{{ route('posts.index') }}" class="ml-3 text-gray-600">Batal</a>
        </form>
    </div>
</x-app-layout>
