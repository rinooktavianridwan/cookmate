<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <h1>{{ $recipe->title }}</h1>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" style="padding: 50px;">
                <div class="p-6 text-gray-900" style="padding: 0px;">
                    <h1 style="font-size: 28px; font-weight: 700;">{{ $recipe->title }}
                        <i class="far fa-bookmark bookmark-icon {{ $recipe->isFavoritedByUser(auth()->user()) ? 'fas' : 'far' }}" style="cursor: pointer; margin-left: 350px; padding: 7.5px; color: {{ $recipe->isFavoritedByUser(auth()->user()) ? 'black' : '' }};">
                        </i>
                        <div style="display: flex; align-items: center; padding-top: 20px;">
                            <img src="/assets/images/{{ $image }}" alt="Gambar {{ $recipe->title }}" style="width: 600px; height: 400px; object-fit: cover; margin-right: 20px; border: 3px solid white; border-radius: 8px; margin: 0 auto; border: 3px solid black">
                        </div>
                    </h1>
                    <p style="font-size: 18px; padding-top: 20px; text-align: justify;">{{ $recipe->description }}</p>
                    <!-- Tampilkan bahan-bahan -->
                    <h2 style="padding-top: 20px; font-size: 18px; font-weight: 700;">Bahan-bahan</h2>
                    <ul style="font-size: 18px;">
                        @foreach ($recipe->ingredients as $ingredient)
                        <li>{{ $ingredient->quantity }} {{ $ingredient->name }}</li>
                        @endforeach
                    </ul>
                    <!-- Tampilkan informasi gizi -->
                    @if ($recipe->nutritionFact)
                    <h2 style="padding-top: 20px; font-size: 18px; font-weight: 700;">Nutrisi</h2>
                    <ul style="font-size: 18px;">
                        <li>Kalori: {{ $recipe->nutritionFact->calories }}</li>
                        <li>Protein: {{ $recipe->nutritionFact->protein }}g</li>
                        <li>Lemak: {{ $recipe->nutritionFact->fat }}g</li>
                        <li>Karbohisrat: {{ $recipe->nutritionFact->carbohydrates }}g</li>
                        <li>Kadar gula: {{ $recipe->nutritionFact->sugar }}g</li>
                        <li>Sodium: {{ $recipe->nutritionFact->sodium }}mg</li>
                    </ul>
                    @endif
                    <!-- Tampilkan instruksi -->
                    <h2 style="padding-top: 20px; font-size: 18px; font-weight: 700;">Langkah Pembuatan</h2>
                    <ol style="font-size: 18px; text-align: justify">
                        @foreach ($recipe->instructions as $index => $instruction)
                        <li>{{ $index + 1 }}. {{ $instruction->content }}</li>
                        @endforeach
                    </ol>
                </div>
                <div class="button-des" style="display:flex; align-items: center; justify-content: center;">
                    <button id="start-cooking-btn" style="border-radius: 25px; margin-top: 20px; padding: 10px 20px; background-color: #EEE2BC; font-weight: 600">Mulai Memasak</button>
                </div>
                <div class="text-center">
                    <p style="font-size: 18px; padding-top: 30px;">Suka masakan ini? Berikan Review mu ya!</p>
                </div>
                <div class="rate-container" style="text-align: center;">
                    <div class="rate" style="margin: 0 auto; display: inline-block;">
                        @php
                        $userReview = auth()->user()->reviews()->where('recipe_id', $recipe->id)->first();
                        @endphp
                        @for ($i = 5; $i >= 1; $i--)
                        <input type="radio" id="star{{ $i }}" name="rate" value="{{ $i }}" {{ $userReview && $userReview->rating == $i ? 'checked' : '' }} />
                        <label for="star{{ $i }}" title="text">{{ $i }} stars</label>
                        @endfor
                    </div>
                    <div style="margin-bottom: 10px;">
                        <button id="submit-review">Submit Review</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            const bookmarkIcon = document.querySelector('.bookmark-icon');
            const recipeId = "{{ $recipe->id }}";

            bookmarkIcon.addEventListener('click', function() {
                const isFavorited = bookmarkIcon.classList.contains('fas');
                const action = isFavorited ? 'menghapus dari' : 'menambahkan ke';
                if (confirm(`Apakah Anda yakin ingin ${action} favorit?`)) {
                    $.ajax({
                        url: `/recipes/${recipeId}/favorite`,
                        type: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.status === 'added') {
                                bookmarkIcon.classList.remove('far');
                                bookmarkIcon.classList.add('fas');
                                bookmarkIcon.style.color = 'black';
                            } else {
                                bookmarkIcon.classList.remove('fas');
                                bookmarkIcon.classList.add('far');
                                bookmarkIcon.style.color = '';
                            }
                        }
                    });
                }
            });

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

            $(document).ready(function() {
                $('.rate label').click(function(event) {
                    event.preventDefault(); // Mencegah perilaku default dari label

                    // Lakukan apa pun yang diperlukan saat label bintang diklik
                    var starId = $(this).attr('for');
                    $('#' + starId).prop('checked', true); // Pastikan radio button tercentang
                });
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