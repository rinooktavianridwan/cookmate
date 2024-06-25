<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container-recipe">
                        <div class="search-recipe">
                            <H1>Resep Favorit</H1>
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
            function loadRecipes() {
                var search = $('#search').val();

                $.ajax({
                    url: '/favorites',
                    type: 'GET',
                    data: {
                        search: search
                    },
                    success: function(data) {
                        var container = $('#recipe-container');
                        container.empty(); // Hapus konten sebelumnya
                        data.favorites.forEach(function(recipe) {
                            var item = `<div class="all-recipe" data-recipe-id="${recipe.id}">
                                            <div class="recipe-item">
                                                <h3>${recipe.title}</h3>
                                                <p>${recipe.description}</p>
                                                <a href="/recipes/${recipe.id}/description" class="btn btn-primary">Description</a>
                                                <button class="remove-favorite-btn">Hapus Favorit</button>
                                            </div>
                                        </div>`;
                            container.append(item);
                        });
                    }
                });
            }

            // Load recipes on page load
            loadRecipes();

            // Live search functionality
            $('#search').on('input', function() {
                loadRecipes();
            });

            // Remove favorite functionality
            $('#recipe-container').on('click', '.remove-favorite-btn', function() {
                var recipeId = $(this).closest('.all-recipe').data('recipe-id');
                var button = $(this);

                if (confirm('Apakah Anda yakin ingin menghapus dari favorit?')) {
                    $.ajax({
                        url: `/recipes/${recipeId}/favorite`,
                        type: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.status === 'removed') {
                                button.closest('.all-recipe').remove();
                            }
                        }
                    });
                }
            });
        });
    </script>
</x-app-layout>
