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
                    <h1>{{ $recipe->title }}</h1>
                    <img src="https://media.istockphoto.com/id/1313021528/id/foto/kucing-berburu-tikus-di-rumah-kucing-burma-menghadapi-sebelum-menyerang-close-up.jpg?s=1024x1024&w=is&k=20&c=mn5XtMPMgKpNPJG9WmxooFHYNnQK0LpV2ALL0KIKiwM=" alt="">
                    <p>{{ $recipe->description }}</p>

                    <!-- Tampilkan instruksi satu per satu -->
                    <div id="instruction-container">
                        <h2>Instruction <span id="instruction-step">1</span></h2>
                        <p id="instruction-content">{{ $recipe->instructions[0]->content }}</p>
                    </div>
                    <div class="navigation-buttons" id="nav-buttons">
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

                // Show/hide navigation buttons based on current step
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

                // Update button layout based on visible buttons
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
    <style>
        .cook-container{
            display: flex;
            flex-direction: column;
            height: 600px;
            gap: 10px;
            
        }
        .cook-container h1{
            text-align: center
        }
        .cook-container img{
            height: 300px;
            background-color: skyblue;

        }
        #instruction-container {
            margin-top: 40px;
            height: 180px;
        }
        .navigation-buttons {
            display: flex;
            justify-content: flex-end; /* Default posisi tombol di kanan */
        }
        .navigation-buttons.space-between {
            justify-content: space-between; /* Distribusi tombol jika ada dua */
        }
        .navigation-buttons button {
            border-radius: 5px;
            height: 30px;
            width: 100px;
            margin-left: 10px; /* Spasi antar tombol */
            background-color: black;
            color: white
        }
    </style>
</x-app-layout>
