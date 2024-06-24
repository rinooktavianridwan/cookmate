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
                            <li>{{ $ingredient->name }} - {{ $ingredient->quantity }}</li>
                        @endforeach
                    </ul>
                    <!-- Tampilkan instruksi -->
                    <h2>Instructions</h2>
                    <ol>
                        @foreach ($recipe->instructions as $index => $instruction)
                            <li>{{ $index + 1 }}. {{ $instruction->content }}</li>
                        @endforeach
                    </ol>
                </div>
                <div class="button-des">
                    <button>Tambah Favorit</button>
                    <button id="start-cooking-btn">Mulai Memasak</button>
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Fungsi untuk menangani event click pada tombol "Mulai Memasak"
            $('#start-cooking-btn').click(function() {
                // Redirect ke halaman '/letscook'
                window.location.href = "{{ route('letscook') }}";
            });
        });
    </script>
</x-app-layout>
