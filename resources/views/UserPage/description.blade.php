<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <h1>{{ $recipe->title }}</h1>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1>{{ $recipe->title }}</h1>
                    <p>{{ $recipe->description }}</p>
                    <!-- Tampilkan bahan-bahan -->
                    <h2>Ingredients</h2>
                    <ul>
                        @foreach ($recipe->ingredients as $ingredient)
                            <li>{{ $ingredient->quantity }} {{ $ingredient->name }} </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
