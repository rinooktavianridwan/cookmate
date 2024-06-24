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
                                        <!-- Opsi kota akan diisi dengan data dari database -->
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
                                <!-- Hasil resep akan dimuat secara dinamis di sini -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript khusus halaman resep -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Event listener untuk tombol cari
            $('#search-button').on('click', function() {
                let query = $('#search').val().trim();

                // Ambil data resep berdasarkan kata kunci dari server
                fetchRecipes(query);
            });

            // Fungsi untuk mengambil data resep dari server menggunakan Ajax
            function fetchRecipes(query) {
                $.ajax({
                    url: '/recipes/search', // Sesuaikan dengan endpoint di Laravel
                    method: 'GET',
                    data: { query: query },
                    success: function(data) {
                        displayRecipes(data);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching recipes:", status, error);
                    }
                });
            }

            // Fungsi untuk menampilkan data resep ke dalam kontainer
            function displayRecipes(recipes) {
                let recipeContainer = $('#recipe-container');
                recipeContainer.empty(); // Kosongkan kontainer sebelum menambahkan data baru

                recipes.forEach(recipe => {
                    let html = `
                        <div class="name-recipe">
                            <h1>${recipe.title}</h1>
                            <h1>Cocok Untuk ${recipe.penyakit ? recipe.penyakit : 'Umum'}</h1>
                            <h1>Review: ${recipe.count_review}</h1>
                        </div>
                        <div class="detail-recipe">
                            <div class="image-recipe">
                                <img src="${recipe.image}" alt="Gambar ${recipe.title}">
                            </div>
                            <div class="detail-descripe">
                                <h1>Deskripsi</h1>
                                <p>${recipe.description}</p>
                            </div>
                        </div>
                    `;
                    recipeContainer.append(html);
                });
            }
        });
    </script>
</x-app-layout>
