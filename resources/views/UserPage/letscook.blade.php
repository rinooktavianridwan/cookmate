<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <h1>{{ $recipe->title }}</h1>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 cook-container">
                    <h1 class="text-center" style="font-size: 28px; font-weight: 700;">{{ $recipe->title }}</h1>
                    <video id="recipe-video" src="{{ asset('assets/videos/betutu-pt1.mp4') }}" width="540" height="540" controls></video>
                    <p class="mt-4" style="font-size: 18px;">{{ $recipe->description }}</p>

                    <!-- Tampilkan instruksi satu per satu -->
                    <div id="instruction-container" class="mt-4">
                        <h2 style="font-size: 18px; font-weight: 700; text-align: left;">Instruction <span id="instruction-step">1</span></h2>
                        <p id="instruction-content" style="font-size: 18px; text-align: left;">{{ $recipe->instructions[0]->content }}</p>
                    </div>
                    <div class="navigation-buttons mt-4" id="nav-buttons">
                        <button id="prev-btn" style="display: none;">Previous</button>
                        <button id="next-btn">Next</button>
                        <button id="finish-btn" style="display: none;">Selesai Memasak</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            var instructions = @json($recipe->instructions);
            var currentStep = 0;

            function updateInstruction() {
                $('#instruction-step').text(currentStep + 1);
                $('#instruction-content').text(instructions[currentStep].content);

                if (currentStep === 0) {
                    $('#prev-btn').hide();
                } else {
                    $('#prev-btn').show();
                }

                if (currentStep === instructions.length - 1) {
                    $('#next-btn').hide();
                    $('#finish-btn').show();
                } else {
                    $('#next-btn').show();
                    $('#finish-btn').hide();
                }

                updateButtonLayout();
            }

            $('#next-btn').click(function() {
                if (currentStep < instructions.length - 1) {
                    currentStep++;
                    updateInstruction();
                }
            });

            $('#prev-btn').click(function() {
                if (currentStep > 0) {
                    currentStep--;
                    updateInstruction();
                }
            });

            $('#finish-btn').click(function() {
                window.location.href = "{{ route('description', ['id' => $recipe->id]) }}";
            });

            function updateButtonLayout() {
                const navButtons = document.getElementById("nav-buttons");
                const visibleButtons = Array.from(navButtons.getElementsByTagName("button")).filter(button => button.style.display !== "none");

                if (visibleButtons.length > 1) {
                    navButtons.classList.add("space-between");
                } else {
                    navButtons.classList.remove("space-between");
                }
            }

            updateInstruction();
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const videoElement = document.getElementById('recipe-video');
            const nextBtn = document.getElementById('next-btn');
            const prevBtn = document.getElementById('prev-btn');
            let currentStep = 1;

            nextBtn.addEventListener('click', function() {
                currentStep++;
                updateVideoSource();
            });

            prevBtn.addEventListener('click', function() {
                if (currentStep > 1) {
                    currentStep--;
                    updateVideoSource();
                }
            });

            function updateVideoSource() {
                const videoSrc = `/assets/videos/betutu-pt${currentStep}.mp4`;
                videoElement.src = videoSrc;
                document.getElementById('instruction-step').textContent = currentStep;
            }
        });
    </script>
    <style>
        .cook-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .cook-container h1 {
            text-align: center;
        }

        .cook-container video {
            max-width: 100%;
            height: auto;
        }

        #instruction-container {
            margin-top: 40px;
            width: 100%;
            text-align: left; /* Menjamin teks instruksi selalu rata kiri */
        }

        .navigation-buttons {
            display: flex;
            justify-content: flex-end;
        }

        .navigation-buttons.space-between {
            justify-content: space-between;
        }

        .navigation-buttons button {
            border-radius: 5px;
            height: 30px;
            width: 100px;
            margin-left: 10px;
            background-color: black;
            color: white;
        }
    </style>
</x-app-layout>
