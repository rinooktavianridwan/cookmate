<x-app-layout>
    <link rel="stylesheet" href="assets/css/dashboard.css" type="text/css">
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
                                    </select>
                                </div>
                                <div class="choose">
                                    <h1>Bahan Dasar</h1>
                                    <select name="bahan" id="bahan">
                                        <option value="">None</option>
                                    </select>
                                </div>
                                <div class="choose">
                                    <h1>Kalori</h1>
                                    <select name="kalori" id="kalori">
                                        <option value="">None</option>
                                    </select>
                                </div>
                            </div>
                            <div class="search-text">
                                <h1>Search for a recipe</h1>
                                <input type="text" placeholder="Cari Resep" id="search">
                            </div>
                        </div>
                        <div class="recipe-result" id="recipe-container">
                            <!-- Hasil pencarian akan dimuat di sini -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {

            var recipeImageMap = {
                '1': 'ayam-betutu.jpg',
                '2': 'cah-sawi-hijau.jpeg',
                // Tambahkan lebih banyak pemetaan sesuai kebutuhan
            };

            function loadRecipes() {
                var penyakit = $('#penyakit').val();
                var bahan = $('#bahan').val();
                var search = $('#search').val();

                $.ajax({
                    url: '/recipes',
                    type: 'GET',
                    data: {
                        penyakit: penyakit,
                        bahan: bahan,
                        search: search
                    },
                    success: function(data) {
                        var container = $('#recipe-container');
                        container.empty(); // Hapus konten sebelumnya
                        data.forEach(function(recipe) {
                            // Dapatkan nama file gambar dari peta menggunakan ID resep
                            var imageName = recipeImageMap[recipe.id] || 'default.jpg'; // Gunakan 'default.jpg' jika ID tidak ditemukan
                            var item = `<div class="all-recipe">
                        <div class="recipe-item" style="display: flex; align-items: flex-start; justify-content: space-between;">
                            <div style="flex: 3; margin-right: 20px;">
                                <h3>${recipe.title}</h3>
                                <p>${recipe.description}</p>
                                <a href="/recipes/${recipe.id}/description" class="btn btn-primary">See more</a>
                            </div>
                            <div style="flex: 1;">
                                <img src="/assets/images/${imageName}" alt="Gambar ${recipe.title}" style="max-width: 100%; height: auto; border-radius: 8px;">
                            </div>
                        </div>
                    </div>`;
                            container.append(item);
                        });
                    }
                });
            }

            function loadUniqueValues() {
                $.ajax({
                    url: '/unique-values',
                    type: 'GET',
                    success: function(data) {
                        var penyakitDropdown = $('#penyakit');
                        var bahanDropdown = $('#bahan');

                        // Kosongkan dropdown sebelumnya
                        penyakitDropdown.empty();
                        bahanDropdown.empty();

                        // Tambahkan opsi default
                        penyakitDropdown.append('<option value="">None</option>');
                        bahanDropdown.append('<option value="">None</option>');

                        // Tambahkan opsi unik dari database
                        data.penyakit.forEach(function(item) {
                            penyakitDropdown.append(`<option value="${item.penyakit}">${item.penyakit}</option>`);
                        });
                        data.bahan.forEach(function(item) {
                            bahanDropdown.append(`<option value="${item.bahan_dasar}">${item.bahan_dasar}</option>`);
                        });
                    }
                });
            }

            // Load unique values and recipes on page load
            loadUniqueValues();
            loadRecipes();

            // Reload recipes when dropdown value changes
            $('#penyakit, #bahan').change(function() {
                loadRecipes();
            });

            // Live search functionality
            $('#search').on('input', function() {
                loadRecipes();
            });
        });
    </script>
</x-app-layout>