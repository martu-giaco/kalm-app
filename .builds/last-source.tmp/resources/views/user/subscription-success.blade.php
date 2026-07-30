<x-layout>
    @slot('title', '¡Bienvenido a Kälm Premium!')

    <div class="max-w-md mx-auto px-4 py-8 text-center flex flex-col items-center justify-center min-h-[75vh]">
        
        <!-- Icono de Éxito / Corona Premium -->
        <div class="relative mb-6">
            <div class="w-24 h-24 rounded-full bg-[#CCE2E5] flex items-center justify-center animate-bounce">
                <svg xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 -960 960 960" width="48px" fill="#306067">
                    <path d="M205-400h550q14 0 19 12t-5 22L536-136q-23 23-56 23t-56-23L191-366q-10-10-5-22t19-12Zm-22-113 113-138q11-14 27.5-21.5T358-680h244q18 0 34.5 7.5T664-651l113 138q8 10 3 21.5T762-480H198q-13 0-18-11.5t3-21.5Z"/>
                </svg>
            </div>
            <div class="absolute p-1 text-white bg-green-500 rounded-full shadow-md -top-1 -right-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>
        </div>

        <!-- Encabezado de Suscripción Exitosa -->
        <span class="badge badge-lg border-0 font-bold px-4 py-3 mb-2 text-[#2A4043]" style="background-image: linear-gradient(45deg, #37A0AF , #CCE2E5 88%);">
            ¡TU PLAN HA CAMBIADO!
        </span>
        <h1 class="text-3xl font-extrabold text-[#2A4043] tracking-tight">¡Ya sos Premium!</h1>
        <p class="max-w-sm mt-2 text-sm text-gray-600">
            Tu cuenta se ha actualizado con éxito de <span class="font-bold text-gray-500 line-through">Free</span> a <span class="font-bold text-[#306067]">Premium</span>. Disfrutá de una experiencia consciente sin límites.
        </p>

        <!-- Contenedor de Beneficios Activos -->
        <div class="w-full mt-6 bg-white rounded-2xl p-5 shadow-sm border border-[#CCE2E5] text-left">
            <h2 class="text-xs font-bold text-[#37A0AF] uppercase tracking-wider mb-3">Tus nuevos beneficios incluidos:</h2>
            
            <div class="space-y-3">
                <div class="flex items-start gap-3">
                    <img src="{{ asset('images/icons/assignment.svg') }}" alt="rutinas" class="w-5 h-5 mt-0.5 filter-teal"/>
                    <div>
                        <h3 class="text-sm font-bold text-[#2A4043]">Rutinas personalizables ilimitadas</h3>
                        <p class="text-xs text-gray-500">Renová y guardá todo tu historial sin límites de espacio.</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <img src="{{ asset('images/icons/add_circle.svg') }}" alt="productos" class="w-5 h-5 mt-0.5"/>
                    <div>
                        <h3 class="text-sm font-bold text-[#2A4043]">Productos ilimitados en rutinas</h3>
                        <p class="text-xs text-gray-500">Agregá más de 20 productos orientados a tu tratamiento diario.</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <img src="{{ asset('images/icons/experiment.svg') }}" alt="diagnóstico" class="w-5 h-5 mt-0.5"/>
                    <div>
                        <h3 class="text-sm font-bold text-[#2A4043]">Diagnóstico a fondo de piel y cabello</h3>
                        <p class="text-xs text-gray-500">Acceso libre a todos los tests de diagnóstico avanzado.</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <img src="{{ asset('images/icons/news.svg') }}" alt="artículos" class="w-5 h-5 mt-0.5"/>
                    <div>
                        <h3 class="text-sm font-bold text-[#2A4043]">Artículos escritos por profesionales</h3>
                        <p class="text-xs text-gray-500">Leé tips y explicaciones actualizadas por dermatólogos expertos.</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <img src="{{ asset('images/icons/mail.svg') }}" alt="self-pack" class="w-5 h-5 mt-0.5"/>
                    <div>
                        <h3 class="text-sm font-bold text-[#2A4043]">Self-pack de bienvenida*</h3>
                        <p class="text-xs text-gray-500">Exclusivo para residentes de Argentina. Prepararemos tu envío.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botón de Acción Principal -->
        <div class="w-full mt-8">
            <a href="{{ route('home') }}" class="btn w-full border-0 rounded-xl text-white font-bold bg-[#306067] hover:bg-[#2A4043] shadow-md transition-all">
                Comenzar mi experiencia Premium
            </a>
        </div>
    </div>
</x-layout>