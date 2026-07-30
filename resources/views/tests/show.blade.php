<!DOCTYPE html>
<html lang="es" class="h-full">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
    <script>
        tailwind.config = {
            darkMode: 'media',
            theme: {
                extend: {
                    colors: {
                        kalm: {
                            base: '#306067',
                            dark: '#2A4043',
                            deep: '#164d4f',
                            accent: '#37A0AF',
                            light: '#CCE2E5',
                        }
                    },
                    fontFamily: {
                        sans: ['Mulish', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.2/dist/full.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        /* --- Tarjetas de opciones estáticas --- */
        .option-card {
            border: 2px solid transparent;
            box-sizing: border-box;
            box-shadow: none !important;
            transition: background-color 0.2s ease, border-color 0.2s ease;
            will-change: auto;
        }

        /* Selección Modo Claro */
        .option-card.selected {
            border-color: #37A0AF;
            background-color: rgba(55, 160, 175, 0.12);
            box-shadow: none !important;
        }

        /* Indicador circular */
        .option-dot {
            position: relative;
            flex-shrink: 0;
            transition: border-color 0.2s ease;
        }

        .option-dot::after {
            content: "";
            position: absolute;
            inset: 3px;
            border-radius: 9999px;
            background: #37A0AF;
            transform: scale(0);
            transition: transform 0.2s ease;
        }

        .option-card.selected .option-dot {
            border-color: #37A0AF;
        }

        .option-card.selected .option-dot::after {
            transform: scale(1);
        }

        /* Reglas Modo Oscuro */
        @media (prefers-color-scheme: dark) {
            .option-card.selected {
                border-color: #CCE2E5;
                background-color: rgba(204, 226, 229, 0.15);
                box-shadow: none !important;
            }

            .option-dot::after {
                background: #CCE2E5;
            }

            .option-card.selected .option-dot {
                border-color: #CCE2E5;
            }
        }

        /* Fade-in simple sin saltos verticales */
        .question {
            animation: fadeIn 0.25s ease both;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        #progressBar {
            transition: width 0.4s ease;
        }

        #nextBtn {
            transition: opacity 0.2s ease, background-color 0.2s ease;
        }

        #nextBtn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>
</head>

<body
    class="w-screen overflow-x-hidden select-none min-h-vh bg-[#F4F9F9] dark:bg-[#2A4043] text-[#2A4043] dark:text-white transition-colors duration-300">

    {{-- Contenedor Principal Adaptable a Cualquier Alto --}}
    <div
        class="flex flex-col justify-between w-full max-w-3xl min-h-dvh h-full px-4 py-6 mx-auto sm:px-6 bg-gradient-to-br from-[#E6F0F2] via-[#F4F9F9] to-[#CCE2E5] dark:from-[#306067] dark:via-[#2A4043] dark:to-[#164d4f] transition-colors duration-300">

        {{-- Header Superior (Solo botón Cruz) --}}
        <header class="flex items-center justify-end w-full pb-2 sm:pb-4 shrink-0">
            <a href="{{ route('home') }}"
                class="p-1.5 rounded-lg focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-kalm-accent"
                aria-label="Cerrar test">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6 sm:h-7 sm:w-7 fill-[#306067] dark:fill-[#CCE2E5]" viewBox="0 -960 960 960"
                    aria-hidden="true">
                    <path
                        d="M480-424 284-228q-11 11-28 11t-28-11q-11-11-11-28t11-28l196-196-196-196q-11-11-11-28t11-28q11-11 28-11t28 11l196 196 196-196q11-11 28-11t28 11q11 11 11 28t-11 28L536-480l196 196q11 11 11 28t-11 28q-11 11-28 11t-28-11L480-424Z" />
                </svg>
            </a>
        </header>

        {{-- Contenido central con scroll independiente si el dispositivo es pequeño --}}
        <main class="flex flex-col justify-center flex-1 w-full py-2 my-auto overflow-y-auto">
            <article class="flex flex-col justify-center w-full">
                <h2
                    class="text-xs sm:text-sm font-bold mb-2 text-[#306067] dark:text-[#CCE2E5] uppercase tracking-wider">
                    {{ $test->title }}
                </h2>

                <form id="testForm" action="{{ route('tests.submit') }}" method="POST" novalidate>
                    @csrf
                    <input type="hidden" name="type" value="{{ $test->key }}">

                    <div id="questions">
                        @foreach ($test->questions as $index => $question)
                            <div class="flex flex-col question" data-index="{{ $index }}"
                                @if ($index != 0) style="display:none" @endif>

                                <h1
                                    class="mb-3 text-lg font-bold leading-tight text-[#164d4f] dark:text-white sm:text-2xl sm:mb-4">
                                    {{ $question['text'] }}
                                </h1>

                                <div class="space-y-2.5 sm:space-y-3" role="radiogroup"
                                    aria-label="Opciones de respuesta">
                                    @foreach ($question['options'] as $option)
                                        <label
                                            class="flex items-center gap-3 p-3.5 cursor-pointer sm:gap-4 sm:p-4 rounded-xl option-card bg-white/80 dark:bg-white/5 border-gray-200 dark:border-transparent backdrop-blur-md hover:bg-white dark:hover:bg-white/10 focus-within:ring-2 focus-within:ring-kalm-accent">
                                            <input type="radio" name="q{{ $index + 1 }}"
                                                value="{{ $option['scoreKey'] }}" class="sr-only">
                                            <span
                                                class="option-dot flex-shrink-0 w-5 h-5 rounded-full border-2 border-[#306067]/40 dark:border-[#CCE2E5]/60"></span>
                                            <span
                                                class="text-sm font-medium leading-snug text-[#2A4043] dark:text-gray-100 sm:text-base">{{ $option['text'] }}</span>
                                        </label>
                                    @endforeach
                                </div>

                            </div>
                        @endforeach
                    </div>

                    <button type="submit" id="hiddenSubmit" class="hidden" aria-hidden="true">Enviar</button>
                </form>
            </article>
        </main>

        {{-- Footer Fijo Abajo --}}
        <footer class="flex flex-col w-full pt-4 pb-4 sm:pb-6 shrink-0">
            <button type="button" id="nextBtn"
                class="w-full bg-[#306067] dark:bg-[#CCE2E5] text-white dark:text-[#2A4043] font-bold text-sm sm:text-base px-4 py-3.5 rounded-xl focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-kalm-accent">
                Siguiente Pregunta
            </button>
            <div class="w-full h-2 mt-3 overflow-hidden bg-gray-200 rounded-full sm:mt-4 dark:bg-black/40"
                role="progressbar" aria-label="Progreso del test">
                <div id="progressBar" class="h-2 rounded-full bg-[#37A0AF] dark:bg-[#37A0AF] w-0"></div>
            </div>
        </footer>

    </div>

    <script>
        (function() {
            const questions = Array.from(document.querySelectorAll('.question'));
            const progressBar = document.getElementById('progressBar');
            const nextBtn = document.getElementById('nextBtn');
            const form = document.getElementById('testForm');

            let current = 0;

            function showQuestion(index) {
                questions.forEach((q, i) => q.style.display = i === index ? 'flex' : 'none');
                
                const isLast = index === questions.length - 1;
                nextBtn.textContent = isLast ? 'Finalizar Test' : 'Siguiente Pregunta';
                nextBtn.dataset.isLast = isLast ? '1' : '0';

                const percentage = ((index + 1) / questions.length * 100);
                progressBar.style.width = percentage + '%';
                progressBar.parentElement.setAttribute('aria-valuenow', percentage);
            }

            document.querySelectorAll('.option-card').forEach(card => {
                card.addEventListener('click', () => {
                    const parent = card.closest('.question');
                    const input = card.querySelector('input[type="radio"]');

                    parent.querySelectorAll('.option-card').forEach(c => {
                        c.classList.remove('selected');
                        const inp = c.querySelector('input[type="radio"]');
                        if (inp) inp.checked = false;
                    });

                    card.classList.add('selected');
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
                    alert('Por favor, selecciona una opción antes de continuar.');
                    return;
                }

                const isLast = nextBtn.dataset.isLast === '1';
                if (!isLast) {
                    current++;
                    showQuestion(current);
                    return;
                }

                if (!allAnswered()) {
                    alert('Por favor, responde todas las preguntas antes de finalizar.');
                    return;
                }

                nextBtn.disabled = true;
                form.submit();
            });

            showQuestion(current);
        })();
    </script>
</body>

</html>