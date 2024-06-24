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
                    <!-- Tampilkan instruksi satu per satu -->
                    <div id="instruction-container">
                        <h2>Instruction <span id="instruction-step">1</span></h2>
                        <p id="instruction-content">{{ $recipe->instructions[0]->content }}</p>
                    </div>
                    <div class="navigation-buttons">
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

            updateInstruction();
        });
    </script>
</x-app-layout>
