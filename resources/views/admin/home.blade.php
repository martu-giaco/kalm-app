<x-layout :title="'Admin Dashboard'">
    <div class="container my-5 px-5 bg-white rounded-t-3xl min-h-full pt-7">
        <h1 class="text-3xl font-bold text-[#306067] mb-4">Bienvenido al panel de administración</h1>

        <ul>
            <li>
                <a href="{{ route('admin.users.index') }}" class="bg-white shadow-md rounded-xl w-full p-5 flex items-center justify-between mb-4">
                    <div class="flex items-end gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px" fill="#306067"><path d="M367-527q-47-47-47-113t47-113q47-47 113-47t113 47q47 47 47 113t-47 113q-47 47-113 47t-113-47ZM160-240v-32q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v32q0 33-23.5 56.5T720-160H240q-33 0-56.5-23.5T160-240Z"/></svg>
                        <h2 class="ps-2 text-xl font-bold text-[#306067]">Usuarios</h2>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#306067"><path d="M579-480 285-774q-15-15-14.5-35.5T286-845q15-15 35.5-15t35.5 15l307 308q12 12 18 27t6 30q0 15-6 30t-18 27L356-115q-15 15-35 14.5T286-116q-15-15-15-35.5t15-35.5l293-293Z"/></svg>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.products.index') }}" class="bg-white shadow-md rounded-xl w-full p-5 flex items-center justify-between mb-4">
                    <div class="flex items-end gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px" fill="#306067"><path d="M202.87-71.87q-37.78 0-64.39-26.61t-26.61-64.39V-612.2q-18.24-12.43-29.12-31.48-10.88-19.06-10.88-43.02v-110.43q0-37.78 26.61-64.39t64.39-26.61h634.26q37.78 0 64.39 26.61t26.61 64.39v110.43q0 23.96-10.88 43.02-10.88 19.05-29.12 31.48v449.33q0 37.78-26.61 64.39t-64.39 26.61H202.87Zm-40-614.83h634.5v-110.43h-634.5v110.43Zm236.17 292.44H561.2q18.19 0 30.65-12.46 12.45-12.45 12.45-30.65t-12.45-30.65q-12.46-12.46-30.65-12.46H399.04q-18.19 0-30.65 12.46-12.46 12.45-12.46 30.65t12.46 30.65q12.46 12.46 30.65 12.46Z"/></svg>
                        <h2 class="ps-2 text-xl font-bold text-[#306067]">Productos</h2>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#306067"><path d="M579-480 285-774q-15-15-14.5-35.5T286-845q15-15 35.5-15t35.5 15l307 308q12 12 18 27t6 30q0 15-6 30t-18 27L356-115q-15 15-35 14.5T286-116q-15-15-15-35.5t15-35.5l293-293Z"/></svg>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.blog.index') }}" class="bg-white shadow-md rounded-xl w-full p-5 flex items-center justify-between mb-4">
                    <div class="flex items-end gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px" fill="#306067"><path
                                                d="M202.87-111.87q-37.78 0-64.39-26.61t-26.61-64.39v-554.26q0-37.78 26.61-64.39t64.39-26.61h399.59q18.15 0 34.68 6.84 16.53 6.83 29.21 19.51l155.43 155.43q12.68 12.68 19.51 29.21 6.84 16.53 6.84 34.68v399.59q0 37.78-26.61 64.39t-64.39 26.61H202.87ZM593.3-757.13v118.33q0 19.15 13.18 32.32 13.17 13.18 32.32 13.18h118.33L593.3-757.13Zm48.61 475.22q17.24 0 28.98-11.86 11.74-11.86 11.74-29.1 0-17.24-11.74-28.98-11.74-11.74-28.98-11.74H318.09q-17.24 0-28.98 11.74-11.74 11.74-11.74 28.98 0 17.24 11.86 29.1 11.86 11.86 29.1 11.86h323.58ZM446.46-594.5q17.24 0 29.09-11.86 11.86-11.86 11.86-29.1 0-17.24-11.86-29.09-11.85-11.86-29.09-11.86H318.33q-17.24 0-29.1 11.86-11.86 11.85-11.86 29.09 0 17.24 11.86 29.1 11.86 11.86 29.1 11.86h128.13Zm195.21 156.41q17.24 0 29.1-11.86 11.86-11.85 11.86-29.09 0-17.24-11.86-29.1Q658.91-520 641.67-520H318.33q-17.24 0-29.1 11.86-11.86 11.86-11.86 29.1 0 17.24 11.86 29.09 11.86 11.86 29.1 11.86h323.34Z" /></svg>
                        <h2 class="ps-2 text-xl font-bold text-[#306067]">Blog</h2>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#306067"><path d="M579-480 285-774q-15-15-14.5-35.5T286-845q15-15 35.5-15t35.5 15l307 308q12 12 18 27t6 30q0 15-6 30t-18 27L356-115q-15 15-35 14.5T286-116q-15-15-15-35.5t15-35.5l293-293Z"/></svg>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.brands.index') }}" class="bg-white shadow-md rounded-xl w-full p-5 flex items-center justify-between mb-4">
                    <div class="flex items-end gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px" fill="#306067"><path d="M40-200v-560h80v560H40Zm120 0v-560h80v560h-80Zm120 0v-560h40v560h-40Zm120 0v-560h80v560h-80Zm120 0v-560h120v560H520Zm160 0v-560h40v560h-40Zm120 0v-560h120v560H800Z"/></svg>
                        <h2 class="ps-2 text-xl font-bold text-[#306067]">Marcas</h2>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#306067"><path d="M579-480 285-774q-15-15-14.5-35.5T286-845q15-15 35.5-15t35.5 15l307 308q12 12 18 27t6 30q0 15-6 30t-18 27L356-115q-15 15-35 14.5T286-116q-15-15-15-35.5t15-35.5l293-293Z"/></svg>
                </a>
            </li>
            <li>
    <a href="{{ route('admin.reviews.index') }}" class="bg-white shadow-md rounded-xl w-full p-5 flex items-center justify-between mb-4">
        <div class="flex items-end gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px" fill="#306067">
                <path d="m233-120 65-281L80-590l288-25 112-265 112 265 288 25-218 189 65 281-247-149-247 149Z"/>
            </svg>
            <h2 class="ps-2 text-xl font-bold text-[#306067]">Reseñas</h2>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#306067">
            <path d="M579-480 285-774q-15-15-14.5-35.5T286-845q15-15 35.5-15t35.5 15l307 308q12 12 18 27t6 30q0 15-6 30t-18 27L356-115q-15 15-35 14.5T286-116q-15-15-15-35.5t15-35.5l293-293Z"/>
        </svg>
    </a>
</li>
        </ul>
    </div>
</x-layout>
