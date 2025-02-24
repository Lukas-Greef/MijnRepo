<x-ingelogt-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}

                    {{-- Check if the user is an admin and show the link to make.blade.php --}}
                    @if(auth()->user() && auth()->user()->name === 'appel') {{-- or use role-based check --}}
                    <a href="{{ route('posts.create') }}" class="text-blue-500 underline">Create New Post</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-ingelogt-layout>
