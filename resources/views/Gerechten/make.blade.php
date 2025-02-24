
<x-layout>
    <section class="max-w-4xl mx-auto px-6 py-8 bg-white rounded shadow-md">
        <h1 class="text-2xl font-bold text-center mb-6">Create a New Post</h1>

        {{-- Form to create a new post --}}
        <form method="POST" action="{{ route('posts.store') }}">
            @csrf

            <!-- Title -->
            <div class="mb-6">
                <label for="title" class="block mb-2 uppercase font-bold text-xs text-gray-700">
                    Title
                </label>
                <input type="text" name="title" id="title" class="border border-gray-300 p-2 w-full rounded" value="{{ old('title') }}" required>
                @error('title')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Slug -->
            <div class="mb-6">
                <label for="slug" class="block mb-2 uppercase font-bold text-xs text-gray-700">
                    Slug
                </label>
                <input type="text" name="slug" id="slug" class="border border-gray-300 p-2 w-full rounded" value="{{ old('slug') }}" required>
                @error('slug')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Body -->
            <div class="mb-6">
                <label for="body" class="block mb-2 uppercase font-bold text-xs text-gray-700">
                    Body
                </label>
                <textarea name="body" id="body" class="border border-gray-300 p-2 w-full rounded" rows="5" required>{{ old('body') }}</textarea>
                @error('body')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Excerpt -->
            <div class="mb-6">
                <label for="excerpt" class="block mb-2 uppercase font-bold text-xs text-gray-700">
                    Excerpt
                </label>
                <textarea name="excerpt" id="excerpt" class="border border-gray-300 p-2 w-full rounded" rows="3" required>{{ old('excerpt') }}</textarea>
                @error('excerpt')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <div class="mb-6">
                <label for="category_id" class="block mb-2 uppercase font-bold text-xs text-gray-700">
                    Category
                </label>
                <select name="category_id" id="category_id" class="border border-gray-300 p-2 w-full rounded">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end mt-6">
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                    Create Post
                </button>
            </div>
        </form>
    </section>

    <section class="max-w-4xl mx-auto px-6 py-8 bg-white rounded shadow-md mt-8">
        <h2 class="text-2xl font-bold text-center mb-6">Manage Posts</h2>

        <table class="min-w-full bg-white">
            <thead>
            <tr>
                <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Title</th>
                <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Category</th>
                <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($posts as $post)
                <tr>
                    <td class="py-3 px-4">{{ $post->title }}</td>
                    <td class="py-3 px-4">{{ $post->category->name }}</td>
                    <td class="py-3 px-4">
                        <a href="{{ route('posts.edit', $post) }}" class="text-blue-500 hover:text-blue-600">Edit</a>
                        <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-600" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </section>
</x-layout>
