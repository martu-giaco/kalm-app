<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Kälm | Test</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon/favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon/favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ asset('favicon/favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-touch-icon.png') }}" />
    <link rel="manifest" href="{{ asset('favicon/site.webmanifest') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.2/dist/full.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="flex flex-col flex-wrap justify-between min-h-screen bg-center bg-cover px-5 py-10 header-bg">
        <div class="flex items-center justify-between max-w-3xl pb-8 mx-auto w-full">
            <button type="button" id="prevBtn" disabled>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 fill-[#2A4043] dark:fill-[#CCE2E5]" height="24px" viewBox="0 -960 960 960" width="24px" ><path d="m326.15-434.5 186.68 186.67q13.67 13.68 13.29 32.07-.38 18.39-14.05 32.06-13.68 12.68-32.07 13.06-18.39.38-32.07-13.29l-264-264q-6.71-6.72-9.81-14.92-3.1-8.19-3.1-17.15 0-8.96 3.1-17.15 3.1-8.2 9.81-14.92L448.17-776.3q12.92-12.92 31.57-12.92t32.33 12.92q13.67 13.67 13.67 32.44 0 18.77-13.67 32.45L326.15-525.5h436.48q19.15 0 32.33 13.17 13.17 13.18 13.17 32.33t-13.17 32.33q-13.18 13.17-32.33 13.17H326.15Z"/></svg>
            </button>
            <a href="{{ route('home') }}" class="self-end cursor-pointer" aria-label="close sidebar">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 fill-[#2A4043] dark:fill-[#CCE2E5]" viewBox="0 -960 960 960"  aria-hidden="true">
                    <path d="M480-424 284-228q-11 11-28 11t-28-11q-11-11-11-28t11-28l196-196-196-196q-11-11-11-28t11-28q11-11 28-11t28 11l196 196 196-196q11-11 28-11t28 11q11 11 11 28t-11 28L536-480l196 196q11 11 11 28t-11 28q-11 11-28 11t-28-11L480-424Z" />
                </svg>
            </a>
        </div>

        <div class="max-w-3xl mx-auto ">
            <article class="pb-7 rounded-2xl">
                <h2 class="text-md font-semibold text-[#37A0AF] dark:text-[#CCE2E5]">{{ $test->title }}</h2>

                <form id="testForm" action="{{ route('tests.submit') }}" method="POST" novalidate>
                    @csrf
                    <input type="hidden" name="type" value="{{ $test->key }}">

                    <div id="questions">
                        @foreach ($test->questions as $index => $question)
                            <div class="mb-10 question" data-index="{{ $index }}"
                                @if ($index != 0) style="display:none" @endif>

                                <h1 class="text-2xl font-semibold text-[#164d4f] dark:text-[#E9E5E3] mb-4">
                                    {{ $question['text'] }}
                                </h1>

                                <div class="space-y-3">
                                    @foreach ($question['options'] as $option)
                                        <label class="option-card flex items-center gap-5 cursor-pointer bg-white/70 shadow-lg p-5 rounded-lg transition-all duration-300">
                                            <input type="radio" class="hidden" name="q{{ $index + 1 }}"
                                                value="{{ $option['scoreKey'] }}"
                                                class="h-4 w-4 text-[#164d4f] focus:ring-[#164d4f]">
                                            <span class="text-gray-700">{{ $option['text'] }}</span>
                                        </label>
                                    @endforeach
                                </div>

                            </div>
                        @endforeach
                    </div>

                    {{-- Hidden submit --}}
                    <button type="submit" id="hiddenSubmit" class="hidden" aria-hidden="true">Enviar</button>
                </form>
            </article>
        </div>

        <div class="w-full">
            {{-- Botones --}}
            <button type="button" id="nextBtn" class="w-full bg-[#306067] text-white dark:text-[#2A4043] dark:bg-[#CCE2E5] px-4 py-3 rounded-lg">
                Siguiente pregunta
            </button>
            {{-- Barra de progreso --}}
            <div class="w-full h-2 mt-4 bg-white rounded-full shadow-xl">
                <div id="progressBar" class="bg-[#306067] dark:bg-[#37A0AF] h-2 rounded-full w-0"></div>
            </div>
        </div>

    <script>
        (function() {
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
                nextBtn.textContent = isLast ? 'Finalizar Test' : 'Siguiente pregunta';
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

                    // Si ya está activa, no hacer nada
                    const input = card.querySelector('input[type="radio"]');
                    if (input && input.checked) return;

                    // Limpiar todas
                    parent.querySelectorAll('.option-card').forEach(c => {
                        c.classList.remove('shadow-xl', 'scale-105');
                        const inp = c.querySelector('input[type="radio"]');
                        if (inp) inp.checked = false;
                    });

                    // Activar la clickeada
                    card.classList.add('transition-all', 'duration-300', 'scale-105');
                    card.classList.add('shadow-xl');
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
</body>
</html>
