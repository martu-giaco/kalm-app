<x-layout title="Kälm | Iniciar Tests" hideNavigation="true">
    {{-- resources\views\tests\intro.blade.php --}}
    <div
        class="px-3 sm:px-5 h-[95vh] py-3 sm:py-6 rounded-t-3xl bg-white flex flex-col justify-between dark:bg-[#2A4043] font-['Mulish'] max-w-lg mx-auto overflow-hidden">

        <!-- CONTENIDO SCROLLEABLE (HEADER, CARRUSEL Y BADGES) -->
        <article class="flex-1 overflow-y-auto no-scrollbar pr-0.5">
            <!-- Header con Logo y Bienvenida -->
            <div class="mb-4 text-center">
                <picture class="block h-10 mx-auto my-5 sm:h-12">
                    <source srcset="{{ asset('images/logo-kalm-light.svg') }}" media="(prefers-color-scheme: dark)"
                        type="image/svg+xml" />
                    <img src="{{ asset('images/logo-kalm.svg') }}" alt="logo Kälm" class="h-10 mx-auto sm:h-12" />
                </picture>

                <span
                    class="inline-block px-2.5 py-0.5 mb-1.5 text-[10px] sm:text-[11px] font-bold tracking-wider uppercase rounded-full bg-[#306067]/10 text-[#306067] dark:bg-[#CCE2E5]/15 dark:text-[#CCE2E5]">
                    Diagnóstico Inicial
                </span>

                <h1
                    class="text-xl sm:text-2xl font-extrabold text-[#306067] my-5 dark:text-[#CCE2E5] tracking-tight leading-snug">
                    Descubre lo que tu Piel y Cabello necesitan
                </h1>
            </div>

            <!-- Banner Carrusel Automático (Slider) -->
            <div class="relative w-full my-2 overflow-hidden shadow-md rounded-2xl group">
                <div id="testCarousel" class="flex transition-transform duration-500 ease-out">

                    <!-- Slide 1: Test de Piel -->
                    <div class="relative flex-shrink-0 w-full h-56 sm:h-48">
                        <img src="{{ asset('images/test-piel.png') }}" ...>
                        <div
                            class="absolute inset-0 flex flex-col justify-end p-3 text-white bg-gradient-to-t from-black/80 via-black/30 to-transparent">
                            <span
                                class="bg-[#306067] text-[9px] sm:text-[10px] font-bold uppercase tracking-wider px-1.5 py-0.5 rounded w-max mb-1">
                                Test de Skincare
                            </span>
                            <h2 class="text-xs font-bold leading-tight sm:text-base">Test de Tipo de Piel</h2>
                            <p class="text-[10px] sm:text-xs text-white/90 font-light mt-0.5">Identifica si tu piel es
                                seca, mixta, grasa o sensible.</p>
                        </div>
                    </div>

                    <!-- Slide 2: Test de Haircare -->
                    <div class="relative flex-shrink-0 w-full h-56 sm:h-48">
                        <img src="{{ asset('images/test-cabello.png') }}" alt="Test de tipo de cabello"
                            class="object-cover w-full h-full" />
                        <div
                            class="absolute inset-0 flex flex-col justify-end p-3 text-white bg-gradient-to-t from-black/80 via-black/30 to-transparent">
                            <span
                                class="bg-[#37A0AF] text-[9px] sm:text-[10px] font-bold uppercase tracking-wider px-1.5 py-0.5 rounded w-max mb-1">
                                Test de Haircare
                            </span>
                            <h2 class="text-xs font-bold leading-tight sm:text-base">Análisis Capilar</h2>
                            <p class="text-[10px] sm:text-xs text-white/90 font-light mt-0.5">Conoce la porosidad,
                                textura y necesidades de tu pelo.</p>
                        </div>
                    </div>

                    <!-- Slide 3: Rutina Personalizada -->
                    <div class="relative flex-shrink-0 w-full h-56 sm:h-48">
                        <img src="{{ asset('images/test.png') }}" alt="Rutinas y productos"
                            class="object-cover w-full h-full" />
                        <div
                            class="absolute inset-0 flex flex-col justify-end p-3 text-white bg-gradient-to-t from-black/80 via-black/30 to-transparent">
                            <span
                                class="bg-[#2A4043] text-[9px] sm:text-[10px] font-bold uppercase tracking-wider px-1.5 py-0.5 rounded w-max mb-1">
                                Resultado Inmediato
                            </span>
                            <h2 class="text-xs font-bold leading-tight sm:text-base">Rutina & Productos Ideales</h2>
                            <p class="text-[10px] sm:text-xs text-white/90 font-light mt-0.5">Obtén la combinación
                                perfecta de ingredientes activos.</p>
                        </div>
                    </div>

                </div>

                <!-- Indicadores (Dots) del Carrusel -->
                <div class="absolute bottom-2 right-3 flex space-x-1.5 z-10">
                    <button class="w-2 h-2 transition-all duration-300 bg-white rounded-full opacity-100 carousel-dot"
                        data-index="0" aria-label="Slide 1"></button>
                    <button class="w-2 h-2 transition-all duration-300 rounded-full carousel-dot bg-white/50"
                        data-index="1" aria-label="Slide 2"></button>
                    <button class="w-2 h-2 transition-all duration-300 rounded-full carousel-dot bg-white/50"
                        data-index="2" aria-label="Slide 3"></button>
                </div>
            </div>

            <!-- Beneficios Rápidos -->
            <div class="grid grid-cols-3 gap-1.5 sm:gap-2 my-3 text-center">
                <div
                    class="p-2 rounded-xl bg-[#E8F4F5] dark:bg-black/20 border border-[#306067]/10 dark:border-white/10">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mx-auto text-[#306067] dark:text-[#CCE2E5] mb-0.5" fill="none"
                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="block text-[10px] sm:text-[11px] font-bold text-[#2A4043] dark:text-[#E9E5E3]">Solo 2
                        min</span>
                </div>
                <div
                    class="p-2 rounded-xl bg-[#E8F4F5] dark:bg-black/20 border border-[#306067]/10 dark:border-white/10">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mx-auto text-[#306067] dark:text-[#CCE2E5] mb-0.5" fill="none"
                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span
                        class="block text-[10px] sm:text-[11px] font-bold text-[#2A4043] dark:text-[#E9E5E3]">Preciso</span>
                </div>
                <div
                    class="p-2 rounded-xl bg-[#E8F4F5] dark:bg-black/20 border border-[#306067]/10 dark:border-white/10">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mx-auto text-[#306067] dark:text-[#CCE2E5] mb-0.5" fill="none"
                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                    </svg>
                    <span
                        class="block text-[10px] sm:text-[11px] font-bold text-[#2A4043] dark:text-[#E9E5E3]">Gratuito</span>
                </div>
            </div>
        </article>

        <!-- BOTONES DE ACCIÓN (SIEMPRE VISIBLES ABAJO) -->
        <div
            class="flex flex-col gap-2 pt-2 pb-2 shrink-0 border-t border-gray-100 dark:border-gray-700/50 bg-white dark:bg-[#2A4043]">
            <a href="{{ route('tests.index') }}"
                class="btn w-full px-5 py-2.5 sm:py-3.5 bg-[#306067] text-white border-none rounded-xl font-bold text-center hover:bg-[#2A4043] transition shadow-md flex items-center justify-center gap-2 text-xs sm:text-base dark:bg-[#CCE2E5] dark:text-[#2A4043] dark:hover:bg-[#E9E5E3] min-h-[42px]">
                <span>Empezar Tests ahora</span>
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>

            <a href="{{ route('home') }}"
                class="btn w-full px-5 py-2 sm:py-2.5 border border-[#37A0AF]/40 text-[#306067] bg-transparent rounded-xl font-bold text-center hover:bg-[#37A0AF]/10 transition text-xs sm:text-sm dark:border-[#CCE2E5]/40 dark:text-[#CCE2E5]">
                Empezar Tests más tarde
            </a>
        </div>
    </div>

    <!-- Script del carrusel intacto -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const carousel = document.getElementById('testCarousel');
            const dots = document.querySelectorAll('.carousel-dot');
            const totalSlides = 3;
            let currentSlide = 0;
            let carouselInterval;

            function updateCarousel(index) {
                currentSlide = index;
                carousel.style.transform = `translateX(-${currentSlide * 100}%)`;

                dots.forEach((dot, idx) => {
                    if (idx === currentSlide) {
                        dot.classList.remove('bg-white/50');
                        dot.classList.add('bg-white', 'w-4');
                    } else {
                        dot.classList.remove('bg-white', 'w-4');
                        dot.classList.add('bg-white/50', 'w-2');
                    }
                });
            }

            function nextSlide() {
                const nextIndex = (currentSlide + 1) % totalSlides;
                updateCarousel(nextIndex);
            }

            function startAutoSlide() {
                carouselInterval = setInterval(nextSlide, 3500);
            }

            dots.forEach(dot => {
                dot.addEventListener('click', (e) => {
                    clearInterval(carouselInterval);
                    const index = parseInt(e.target.getAttribute('data-index'));
                    updateCarousel(index);
                    startAutoSlide();
                });
            });

            startAutoSlide();
        });
    </script>
</x-layout>
