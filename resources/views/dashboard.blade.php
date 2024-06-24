<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Recipe') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 ">
                    <div class="container-recipe">
                        <div class="search-recipe">
                            <div class="search">
                                <div class="choose">
                                    <h1>Penyakit Khusus</h1>
                                    <select name="penyakit" id="penyakit">
                                        <option value="">Semua Kategori</option>
                                        <!-- Opsi kategori akan diisi dengan data dari database -->
                                    </select>
                                </div>
                                <div class="choose">
                                    <h1>Bahan Dasar</h1>
                                    <select name="bahan" id="bahan">
                                        <option value="">Semua Kota</option>
                                        <!-- Opsi kota akan diisi dengan data dari database -->
                                    </select>
                                </div>
                                <div class="choose">
                                    <h1>Kalori</h1>
                                    <select name="kalori" id="kalori">
                                        <option value="">Semua Status</option>
                                        <!-- Opsi kategori akan diisi dengan data dari database -->
                                    </select>
                                </div>
                            </div>
                            <div class="search-text">
                                <h1>Search for a recipe</h1>
                                <input type="text" placeholder="Cari Resep" id="search">
                                <button type="submit" id="search-button">Cari</button>
                            </div>

                        </div>
                        <div class="recipe-result">
                            <div class="all-recipe">
                                
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
</x-app-layout>
