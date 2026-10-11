<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $post->title }}</h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded p-6">
            <p class="text-sm text-gray-500 mb-4">oleh {{ $post->user->name }} · {{ $post->created_at->format('d M Y') }}</p>
            <p class="text-gray-800 whitespace-pre-line">{{ $post->body }}</p>
        </div>
        <a href="{{ route('posts.index') }}" class="inline-block mt-4 text-blue-700">&larr; Kembali</a>
    </div>
</x-app-layout>
