<x-layout :title="'Test de ' . ucfirst($test->key)">
    <div class="max-w-3xl mx-auto px-4 py-8">
        <article class="bg-white rounded-2xl p-6 shadow-lg">
            <h1 class="text-2xl font-semibold text-[#164d4f] mb-4">{{ $test->title }}</h1>
            <p class="text-gray-600 mb-6">{{ $test->description }}</p>

            <form id="testForm" action="{{ route('tests.submit') }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="{{ $test->key }}">

                <div id="questions">
                    @foreach($test->questions as $index => $question)
                        <div class="question mb-6" data-index="{{ $index }}" @if($index != 0) style="display:none" @endif>
                            <p class="block text-gray-700 font-medium mb-4">{{ $index + 1 }}. {{ $question['text'] }}</p>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($question['options'] as $option)
                                    <label class="option-card cursor-pointer border border-gray-300 rounded-lg p-4 flex items-center justify-center transition-colors duration-200">
                                        <input type="radio" name="q{{ $index + 1 }}" value="{{ $option['scoreKey'] }}" class="hidden" required>
                                        {{ $option['text'] }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Barra de progreso --}}
                <div class="w-full bg-gray-200 rounded-full h-3 mb-6">
                    <div id="progressBar" class="bg-[#164d4f] h-3 rounded-full w-0"></div>
                </div>

                {{-- Botones --}}
                <div class="flex justify-between">
                    <button type="button" id="prevBtn" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg" disabled>Anterior</button>
                    <button type="button" id="nextBtn" class="bg-[#164d4f] text-white px-4 py-2 rounded-lg">Siguiente</button>
                </div>
            </form>
        </article>
    </div>

    <script>
        const questions = document.querySelectorAll('.question');
        const progressBar = document.getElementById('progressBar');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const form = document.getElementById('testForm');
        let current = 0;

        function showQuestion(index) {
            questions.forEach((q, i) => {
                q.style.display = i === index ? 'block' : 'none';
            });

            prevBtn.disabled = index === 0;
            nextBtn.textContent = (index === questions.length - 1) ? 'Finalizar Test' : 'Siguiente';
            progressBar.style.width = ((index + 1) / questions.length * 100) + '%';
        }

        prevBtn.addEventListener('click', () => {
            if(current > 0) current--;
            showQuestion(current);
        });

        nextBtn.addEventListener('click', () => {
            const selected = questions[current].querySelector('input[type="radio"]:checked');
            if(!selected) {
                alert('Debes seleccionar una opción antes de continuar');
                return;
            }

            if(current < questions.length - 1) {
                current++;
                showQuestion(current);
            } else {
                form.submit();
            }
        });

        // Manejar selección visual de las opciones
        document.querySelectorAll('.option-card').forEach(card => {
            card.addEventListener('click', () => {
                const parent = card.parentNode;
                // Deseleccionar todas las opciones del mismo grupo
                parent.querySelectorAll('.option-card').forEach(c => {
                    c.classList.remove('bg-[#164d4f]', 'text-white', 'border-[#164d4f]');
                });
                // Seleccionar la opción clickeada
                card.classList.add('bg-[#164d4f]', 'text-white', 'border-[#164d4f]');
                card.querySelector('input[type="radio"]').checked = true;
            });
        });

        showQuestion(current);
    </script>
</x-layout>
