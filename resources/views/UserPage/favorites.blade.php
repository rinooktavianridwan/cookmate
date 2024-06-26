<x-app-layout>
    <style>
        .search-text input[type="text"] {
            border-radius: 20px;
            /* Rounded corners */
            padding-left: 35px;
            /* Adjust based on the size of your search icon */
            background-image: url('/assets/images/search.png');
            /* Ensure correct path to your search icon */
            background-position: 10px center;
            /* Center vertically */
            background-repeat: no-repeat;
            /* Prevent the icon from repeating */
            background-size: 20px 20px;
            /* Size of the icon */
            border: 1px solid #ccc;
            /* Optional: adds a border */
            height: 40px;
            /* Adjust based on your design */
            width: 400px;
            /* Adjust based on your design */
        }

        /* Additional styling for focus state to improve UX */
        .search-text input[type="text"]:focus {
            outline: none;
            /* Removes the default focus outline */
            border-color: #4A90E2;
            /* Optional: changes border color on focus */
        }

        .recipe-result {
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .all-recipe {
            border-radius: 20px;
            height: 285px;
            background-color: #EEE2BC;
            padding: 25px;
        }

        .name-recipe {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }

        .detail-recipe {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }

        .image-recipe {
            width: 100%;
            height: 100%;
            background-color: blue;
        }

        .detail-descripe {
            width: 100%;

        }

        .detail-button {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            width: 250px;
        }
    </style>
    <div class="py-12" style="padding-top: 85px;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container-recipe">
                        <div class="search-recipe" style="padding: 0px 10px;">
                            <H1 style="font-size: 20px; font-weight: 700px">Resep Favorit</H1>
                            <div class="search-text">
                                <input type="text" placeholder="Cari Resep" id="search">
                            </div>
                        </div>
                        <div class="recipe-result" id="recipe-container" style="padding: 0px;">
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
                            var imageName = recipeImageMap[recipe.id] || 'default.jpg'; // Gunakan 'default.jpg' jika ID tidak ditemukan
                            var item = `<div class="all-recipe" data-recipe-id="${recipe.id}">
                                            <div class="recipe-item" style="display: flex; align-items: flex-start; justify-content: space-between;">
                                                <div style="flex: 3; margin-right: 20px;">
                                                    <h3 style="padding-bottom: 10px; font-size: 28px; font-weight: 700;">${recipe.title}</h3>
                                                    <p style="margin-bottom: 10px; font-size: 18px; font-weight: 600; text-align: justify;">Baik untuk penderita penyakit: ${recipe.penyakit}</p>
                                                    <p style="margin-bottom: 10px; font-size: 18px; text-align: justify">${recipe.description}</p>
                                                    <div class="detail-button">
                                                        <a href="/recipes/${recipe.id}/description" class="btn btn-primary" style="font-size: 20px; font-weight: 600">See more</a>
                                                        <h1 style="font-size: 20px; font-weight: 600"> | </h1>
                                                        <button class="remove-favorite-btn" style="font-size: 20px; font-weight: 600">Hapus Favorit</button>
                                                    </div>
                                                </div>
                                                <div style="flex: 1;">
                                                    <img src="/assets/images/${imageName}" alt="Gambar ${recipe.title}" style="width: 500px; height: 200px; object-fit: cover; margin-right: 20px; border: 3px solid white; border-radius: 8px;">
                                                    <p style="padding-top: 10px; text-align: center"; justify-content: center; align-items: center; font-size: 18px>Rating: ${recipe.review} (${recipe.count_review})</p>
                                                </div>
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