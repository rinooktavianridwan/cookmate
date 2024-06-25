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
                    <!-- Tampilkan informasi gizi -->
                    @if ($recipe->nutritionFact)
                        <h2>Nutrition Facts</h2>
                        <ul>
                            <li>Calories: {{ $recipe->nutritionFact->calories }}</li>
                            <li>Protein: {{ $recipe->nutritionFact->protein }}g</li>
                            <li>Fat: {{ $recipe->nutritionFact->fat }}g</li>
                            <li>Carbohydrates: {{ $recipe->nutritionFact->carbohydrates }}g</li>
                            <li>Sugar: {{ $recipe->nutritionFact->sugar }}g</li>
                            <li>Sodium: {{ $recipe->nutritionFact->sodium }}mg</li>
                        </ul>
                    @endif
                    <!-- Tampilkan instruksi -->
                    <h2>Instructions</h2>
                    <ol>
                        @foreach ($recipe->instructions as $index => $instruction)
                            <li>{{ $index + 1 }}. {{ $instruction->content }}</li>
                        @endforeach
                    </ol>
                </div>
                <div class="button-des">
                    <button id="favorite-btn" data-recipe-id="{{ $recipe->id }}">
                        {{ $recipe->isFavoritedByUser(auth()->user()) ? 'Hapus Favorit' : 'Tambah Favorit' }}
                    </button>
                    <button id="start-cooking-btn">Mulai Memasak</button>
                    <div class="rate">
                        @php
                            $userReview = auth()
                                ->user()
                                ->reviews()
                                ->where('recipe_id', $recipe->id)
                                ->first();
                        @endphp
                        @for ($i = 5; $i >= 1; $i--)
                            <input type="radio" id="star{{ $i }}" name="rate"
                                value="{{ $i }}"
                                {{ $userReview && $userReview->rating == $i ? 'checked' : '' }} />
                            <label for="star{{ $i }}" title="text">{{ $i }} stars</label>
                        @endfor
                    </div>
                    <button id="submit-review">Submit Review</button>
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#start-cooking-btn').click(function() {
                window.location.href = "{{ route('letscook', ['id' => $recipe->id]) }}";
            });

            $('#submit-review').click(function() {
                var rating = $('input[name="rate"]:checked').val();
                if (!rating) {
                    alert('Please select a rating');
                    return;
                }

                $.ajax({
                    url: "{{ route('reviews.store', ['recipe' => $recipe->id]) }}",
                    type: 'POST',
                    data: {
                        rating: rating,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert(response.success);
                    },
                    error: function(xhr) {
                        if (xhr.status === 400) {
                            alert(xhr.responseJSON.error);
                        } else {
                            alert('An error occurred. Please try again.');
                        }
                    }
                });
            });

            $('#favorite-btn').click(function() {
                var recipeId = $(this).data('recipe-id');
                var button = $(this);
                var action = button.text() === 'Tambah Favorit' ? 'menambahkan ke' : 'menghapus dari';

                if (confirm(`Apakah Anda yakin ingin ${action} favorit?`)) {
                    $.ajax({
                        url: `/recipes/${recipeId}/favorite`,
                        type: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.status === 'added') {
                                button.text('Hapus Favorit');
                            } else {
                                button.text('Tambah Favorit');
                            }
                        }
                    });
                }
            });
        });
    </script>
    <style>
        .rate {
            height: 46px;
            padding: 0 10px;
        }

        .rate:not(:checked)>input {
            position: absolute;
            top: -9999px;
        }

        .rate:not(:checked)>label {
            float: right;
            width: 1em;
            overflow: hidden;
            white-space: nowrap;
            cursor: pointer;
            font-size: 30px;
            color: #ccc;
        }

        .rate:not(:checked)>label:before {
            content: '★ ';
        }

        .rate>input:checked~label {
            color: #ffc700;
        }

        .rate:not(:checked)>label:hover,
        .rate:not(:checked)>label:hover~label {
            color: #deb217;
        }

        .rate>input:checked+label:hover,
        .rate>input:checked+label:hover~label,
        .rate>input:checked~label:hover,
        .rate>input:checked~label:hover~label,
        .rate>label:hover~input:checked~label {
            color: #c59b08;
        }
    </style>
</x-app-layout>
