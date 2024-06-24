<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container-recipe">
                        <div class="search-recipe">
                            <div class="search">
                                <div class="choose">
                                    <h1>Penyakit Khusus</h1>
                                    <select name="penyakit" id="penyakit">
                                        <option value="">None</option>
                                        <!-- Opsi kategori akan diisi dengan data dari database -->
                                    </select>
                                </div>
                                <div class="choose">
                                    <h1>Bahan Dasar</h1>
                                    <select name="bahan" id="bahan">
                                        <option value="">None</option>
                                        <!-- Opsi bahan dasar diisi dengan data dari database -->
                                        @foreach ($bahanDasarUnik as $bahan)
                                        <option value="{{ $bahan->bahan_dasar }}">{{ $bahan->bahan_dasar }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="choose">
                                    <h1>Kalori</h1>
                                    <select name="kalori" id="kalori">
                                        <option value="">None</option>
                                        <!-- Opsi kategori akan diisi dengan data dari database -->
                                    </select>
                                </div>
                            </div>
                            <div class="search-text">
                                <h1>Search for a recipe</h1>
                                <input type="text" placeholder="Cari Resep" id="search">
                                <button type="button" id="search-button">Cari</button>
                            </div>
                        </div>
                        <div class="recipe-result">
                            <div class="all-recipe" id="recipe-container">
                                @foreach ($recipes as $recipe)
                                <div class="recipe-item">
                                    <h3>{{ $recipe->title }}</h3>
                                    <p>{{ $recipe->description }}</p>
                                    <!-- Tambahkan detail lain sesuai kebutuhan -->
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>