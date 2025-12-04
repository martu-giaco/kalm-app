<x-layout :title="'Test de ' . ucfirst($test->key)">
    <div class="max-w-3xl mx-auto px-4 py-8">
        <article class="bg-white rounded-2xl p-6 shadow-lg">
            <h1 class="text-2xl font-semibold text-[#164d4f] mb-4">{{ $test->title }}</h1>
            <p class="text-gray-600 mb-6">{{ $test->description }}</p>

            <form id="testForm" action="{{ route('tests.submit') }}" method="POST" novalidate>
                @csrf
                <input type="hidden" name="type" value="{{ $test->key }}">

                <div id="questions">
                    @foreach($test->questions as $index => $question)
                        <div class="question mb-6" data-index="{{ $index }}" @if($index != 0) style="display:none" @endif>
                            <p class="block text-gray-700 font-medium mb-4">{{ $index + 1 }}. {{ $question['text'] }}</p>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($question['options'] as $option)
                                    <label class="option-card cursor-pointer border border-gray-300 rounded-lg p-4 flex items-center justify-center transition-colors duration-200">
                                        <input type="radio" name="q{{ $index + 1 }}" value="{{ $option['scoreKey'] }}" class="sr-only">
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

                {{-- Hidden submit --}}
                <button type="submit" id="hiddenSubmit" class="hidden" aria-hidden="true">Enviar</button>
            </form>
        </article>
    </div>

    <script>
        (function () {
            const questions = Array.from(document.querySelectorAll('.question'));
            const progressBar = document.getElementById('progressBar');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const form = document.getElementById('testForm');

            let current = 0;

            function showQuestion(index) {
                questions.forEach((q, i) => q.style.display = i === index ? 'block' : 'none');
                prevBtn.disabled = index === 0;
                const isLast = index === questions.length - 1;
                nextBtn.textContent = isLast ? 'Finalizar Test' : 'Siguiente';
                nextBtn.dataset.isLast = isLast ? '1' : '0';
                progressBar.style.width = ((index + 1) / questions.length * 100) + '%';
            }

            prevBtn.addEventListener('click', () => {
                if (current > 0) current--;
                showQuestion(current);
            });

            document.querySelectorAll('.option-card').forEach(card => {
                card.addEventListener('click', () => {
                    const parent = card.parentNode;
                    parent.querySelectorAll('.option-card').forEach(c => {
                        c.classList.remove('bg-[#164d4f]', 'text-white', 'border-[#164d4f]');
                        const inp = c.querySelector('input[type="radio"]');
                        if (inp) inp.checked = false;
                    });
                    card.classList.add('bg-[#164d4f]', 'text-white', 'border-[#164d4f]');
                    const input = card.querySelector('input[type="radio"]');
                    if (input) input.checked = true;
                });
            });

            function hasAnswerFor(index) {
                return !!questions[index].querySelector('input[type="radio"]:checked');
            }

            function allAnswered() {
                return questions.every((_, i) => hasAnswerFor(i));
            }

            nextBtn.addEventListener('click', () => {
                if (!hasAnswerFor(current)) {
                    alert('Debes seleccionar una opción antes de continuar.');
                    return;
                }

                const isLast = nextBtn.dataset.isLast === '1';
                if (!isLast) {
                    current++;
                    showQuestion(current);
                    return;
                }

                if (!allAnswered()) {
                    alert('Debes responder todas las preguntas antes de finalizar.');
                    return;
                }

                nextBtn.disabled = true;
                prevBtn.disabled = true;
                form.submit();
            });

            showQuestion(current);
        })();
    </script>
</x-layout>
