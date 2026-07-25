<x-layout title="Iniciar Tests" hideNavigation="true">
    <div class="px-5 h-full py-10 rounded-t-3xl bg-white flex flex-col justify-between dark:bg-[#2A4043]">
        <article>
            <div class="text-center mb-12 mt-8">
                <picture class="h-24 mx-auto mb-6">
                <source srcset="{{ asset('images/logo-kalm-light.svg') }}" media="(prefers-color-scheme: dark)" type="image/svg+xml" />
                <img src="{{ asset('images/logo-kalm.svg') }}" alt="logo Kälm" class="h-24 mx-auto mb-6" />
            </picture>

                <h1 class="text-3xl font-bold text-[#306067] mb-3 dark:text-[#CCE2E5]">¡Bienvenido a Kälm!</h1>
                <p class="text-lg text-[#2A4043] mb-4 dark:text-[#E9E5E3]">
                    Ahora que aceptaste nuestros términos y condiciones, queremos ayudarte a conocer mejor tu piel y cabello.
                </p>
                <p class="text-md text-[#37A0AF] mb-6 dark:text-[#E9E5E3]">
                    Realiza nuestros tests personalizados para recibir recomendaciones específicas.
                </p>
            </div>

            <div class="bg-gradient-to-r from-[#E8F4F5] to-[#F0FAFB] p-8 rounded-2xl mb-8">
                <h2 class="text-xl font-semibold text-[#306067] mb-4">¿Qué incluyen los tests?</h2>
                <ul class="space-y-3 text-[#2A4043]">
                    <li class="flex items-start gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-[#37A0AF] flex-shrink-0 mt-1" viewBox="0 -960 960 960" fill="currentColor">
                            <path d="M382-240 154-468l51-51 177 177 360-360 51 51-411 411Z"/>
                        </svg>
                        <span><strong>Test de tipo de piel:</strong> Descubre si tu piel es normal, seca, grasa, mixta o sensible</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-[#37A0AF] flex-shrink-0 mt-1" viewBox="0 -960 960 960" fill="currentColor">
                            <path d="M382-240 154-468l51-51 177 177 360-360 51 51-411 411Z"/>
                        </svg>
                        <span><strong>Test de tipo de cabello:</strong> Identifica la textura y necesidades de tu cabello</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-[#37A0AF] flex-shrink-0 mt-1" viewBox="0 -960 960 960" fill="currentColor">
                            <path d="M382-240 154-468l51-51 177 177 360-360 51 51-411 411Z"/>
                        </svg>
                        <span><strong>Recomendaciones personalizadas:</strong> Rutinas y productos ideales para ti</span>
                    </li>
                </ul>
            </div>
        </article>

        <div class="flex flex-col gap-3 pb-6">
            <a href="{{ route('tests.index') }}"
                class="btn w-full px-6 py-4 bg-[#306067] text-white border-none rounded-lg font-bold text-center hover:bg-[#2A4043] transition dark:bg-[#CCE2E5] dark:text-[#2A4043] dark:hover:bg-[#E9E5E3]">
                Empezar Tests Ahora
            </a>

            <a href="{{ route('home') }}"
                class="btn w-full px-6 py-4 border-2 border-[#37A0AF] text-[#37A0AF] bg-transparent rounded-lg font-bold text-center hover:bg-[#37A0AF]/10 transition dark:border-[#CCE2E5] dark:text-[#CCE2E5] dark:hover:bg-[#CCE2E5]/10">
                Ahora no
            </a>
        </div>
    </div>
</x-layout>
