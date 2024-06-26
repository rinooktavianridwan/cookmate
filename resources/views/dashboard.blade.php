<x-app-layout>
    <link rel="stylesheet" href="assets/css/dashboard.css" type="text/css">
    <div class="py-12" style="padding-top: 85px;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container-recipe">
                        <div class="search-recipe">
                            <div class="search">
                                <div class="choose">
                                    <h1 style="margin-bottom: 5px">Bahan Dasar</h1>
                                    <select name="bahan" id="bahan" style="padding: 7.5px 10px; border-radius: 10px;">
                                        <option value="">None</option>
                                    </select>
                                </div>
                                <div class="choose">
                                    <h1 style="margin-bottom: 5px">Penyakit Khusus</h1>
                                    <select name="penyakit" id="penyakit" style="padding: 7.5px 10px; border-radius: 10px;">
                                        <option value="">None</option>
                                    </select>
                                </div>
                            </div>
                            <div class="search-text">
                                <input type="text" placeholder="Cari Resep" id="search">
                            </div>
                        </div>
                        <div class="recipe-result" id="recipe-container" style="border: none; padding:5px;">
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
                                                    <h3 style="padding-bottom: 10px; font-size: 28px; font-weight: 700; ">${recipe.title}</h3>
                                                    <p style="margin-bottom: 10px; font-size: 18px; font-weight: 600; text-align: justify;">Baik untuk penderita penyakit: ${recipe.penyakit}</p>
                                                    <p style="margin-bottom: 10px; font-size: 18px; text-align: justify">${recipe.description}</p>
                                                    <a href="/recipes/${recipe.id}/description" class="btn btn-primary" style="margin-top: 50px; font-size: 20px; font-weight: 600">See more</a>
                                                </div>
                                                <div style="flex: 1;">
                                                    <img src="/assets/images/${imageName}" alt="Gambar ${recipe.title}" style="width: 500px; height: 200px; object-fit: cover; margin-right: 20px; border: 3px solid white; border-radius: 8px;">
                                                    <p style="padding-top: 10px; text-align: center"; justify-content: center; align-items: center; font-size: 18px>Rating: ${recipe.review} (${recipe.count_review})</p>
                                                </div>
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