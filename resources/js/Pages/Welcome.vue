<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
</script>

<template>
    <Head title="Bienvenido a Equipres" />
    <div class="bg-white text-gray-800 min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow-sm fixed w-full z-50">
            <div class="container mx-auto px-6 py-4 flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center">
                    <img
                        src="https://cdn-icons-png.flaticon.com/512/2232/2232688.png"
                        alt="Logo de Equipres"
                        class="h-12 w-auto"
                    />
                    <span class="ml-2 text-xl font-semibold text-gray-800">Equipres</span>
                </div>

                <!-- Navegación -->
                <nav v-if="canLogin" class="flex items-center space-x-4">
                    <Link
                        v-if="$page.props.auth.user"
                        :href="route('dashboard')"
                        class="text-gray-800 hover:text-blue-500 transition duration-300"
                    >
                        Dashboard
                    </Link>

                    <template v-else>
                        <Link
                            :href="route('login')"
                            class="text-gray-800 hover:text-blue-500 transition duration-300"
                        >
                            Iniciar Sesión
                        </Link>

                        <Link
                            v-if="canRegister"
                            :href="route('register')"
                            class="text-gray-800 hover:text-blue-500 transition duration-300"
                        >
                            Registrarse
                        </Link>
                    </template>
                </nav>
            </div>
        </header>

        <!-- Contenido Principal -->
        <main class="pt-20">
            <!-- Sección de Bienvenida con Imagen de Fondo -->
            <section class="relative bg-blue-50 py-32 overflow-hidden">
                <div class="absolute inset-0 bg-cover bg-center opacity-50" style="background-image: url('/images/1_resultado.webp');"></div>
                <div class="container mx-auto px-6 text-center relative z-10">
                    <h1 class="text-4xl font-bold text-gray-800 mb-4 animate-text-pop">
                        Bienvenido a <span class="text-blue-600">Equipres</span>
                    </h1>
                    <p class="text-lg text-gray-600 animate-text-fade-in">
                        Gestiona y presta equipos de la biblioteca de manera eficiente. 
                        <span class="font-semibold text-blue-600">Regístrate o inicia sesión para comenzar.</span>
                    </p>
                    <div class="mt-8 animate-fade-in-up">
                        <Link
                            :href="route('login')"
                            class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition duration-300"
                        >
                            Iniciar Sesión
                        </Link>
                    </div>
                </div>
            </section>

            <!-- Sección de Alerta Importante -->
            <section class="bg-yellow-100 py-6 animate-fade-in">
                <div class="container mx-auto px-6 text-center">
                    <p class="text-red-600 font-semibold">
                        ⚠️ Es importante tener en cuenta que los usuarios que prestan el equipo deben ser los mismos que lo devuelven. Esto evita sanciones, ya que el sistema detecta cualquier inconsistencia como una infracción.
                    </p>
                </div>
            </section>

            <!-- Sección de Equipos Disponibles -->
           
            <section class="py-12 bg-white sm:py-16 lg:py-20">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <!-- Contenedor del título con fondo degradado -->
        <div class="text-center">
            <div class="relative inline-block">
                <!-- Fondo degradado con efecto de desenfoque -->
                <span class="bg-gradient-to-r from-[#44BCFF] via-[#FF44EC] to-[#FF675E] blur-lg filter opacity-30 w-full h-full absolute inset-0 rounded-lg"></span>
                <!-- Título con posición relativa para que aparezca sobre el fondo -->
                <h2 class="relative text-3xl font-bold leading-tight text-gray-900 sm:text-4xl xl:text-5xl font-pj">Equipos Con los que Contamos</h2>
            </div>
        </div>

        <!-- Cuadrícula de tarjetas -->
        <div class="grid grid-cols-1 mt-10 text-center sm:mt-16 sm:grid-cols-2 sm:gap-x-12 gap-y-12 md:grid-cols-3 md:gap-0 xl:mt-24">
            <!-- Tarjeta 1 -->
            <div class="md:p-8 lg:p-14">
                <svg class="mx-auto" width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M45 29V23C45 10.85 35.15 1 23 1C10.85 1 1 10.85 1 23V29" stroke="#161616" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M13 29H1V41C1 43.209 2.791 45 5 45H13V29Z" fill="#D4D4D8" stroke="#161616" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M45 29H33V45H41C43.209 45 45 43.209 45 41V29Z" fill="#D4D4D8" stroke="#161616" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <h3 class="mt-12 text-xl font-bold text-gray-900 font-pj">Laptop HP EliteBook</h3>
                <p class="mt-5 text-base text-gray-600 font-pj">Potentes laptops para trabajo y estudio.</p>
            </div>

            <!-- Tarjeta 2 -->
            <div class="md:p-8 lg:p-14 md:border-l md:border-gray-200">
                <svg class="mx-auto" width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M27 27H19V45H27V27Z" stroke="#161616" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M9 37H1V45H9V37Z" fill="#D4D4D8" stroke="#161616" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M45 17H37V45H45V17Z" fill="#D4D4D8" stroke="#161616" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M5 17L15 7L23 15L37 1" stroke="#161616" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M28 1H37V10" stroke="#161616" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <h3 class="mt-12 text-xl font-bold text-gray-900 font-pj">Proyector Epson</h3>
                <p class="mt-5 text-base text-gray-600 font-pj">Proyectores de alta calidad para presentaciones.</p>
            </div>

            <!-- Tarjeta 3 -->
            <div class="md:p-8 lg:p-14 md:border-l md:border-gray-200">
                <svg class="mx-auto" width="42" height="42" viewBox="0 0 42 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M41 1H1V41H41V1Z" stroke="#161616" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M18 7H7V20H18V7Z" stroke="#161616" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M18 26H7V35H18V26Z" stroke="#161616" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M35 7H24V35H35V7Z" fill="#D4D4D8" stroke="#161616" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <h3 class="mt-12 text-xl font-bold text-gray-900 font-pj">Cámara Canon EOS</h3>
                <p class="mt-5 text-base text-gray-600 font-pj">Cámaras profesionales para fotografía y video.</p>
            </div>

         
           
        </div>
    </div>
</section>


            <!-- Nueva Sección: Testimonios de Usuarios -->
            <section class="py-12 bg-gray-50 sm:py-16 lg:py-20">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex flex-col items-center">
            <div class="text-center">
                <p class="text-lg font-medium text-gray-600 font-pj">715 Registros en el sistema</p>
                <h2 class="mt-4 text-3xl font-bold text-gray-900 sm:text-4xl xl:text-5xl font-pj">Lo que Dicen Nuestros Usuarios </h2>
            </div>

          

            <div class="relative mt-10 md:mt-24 md:order-2">
                <div class="absolute -inset-x-1 inset-y-16 md:-inset-x-2 md:-inset-y-6">
                    <div class="w-full h-full max-w-5xl mx-auto rounded-3xl opacity-30 blur-lg filter" style="background: linear-gradient(90deg, #44ff9a -0.55%, #44b0ff 22.86%, #8b44ff 48.36%, #ff6644 73.33%, #ebff70 99.34%)"></div>
                </div>

                <div class="relative grid max-w-lg grid-cols-1 gap-6 mx-auto md:max-w-none lg:gap-10 md:grid-cols-3">
                    <div class="flex flex-col overflow-hidden shadow-xl">
                        <div class="flex flex-col justify-between flex-1 p-6 bg-white lg:py-8 lg:px-7">
                            <div class="flex-1">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-[#FDB241]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                                        />
                                    </svg>
                                    <svg class="w-5 h-5 text-[#FDB241]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                                        />
                                    </svg>
                                    <svg class="w-5 h-5 text-[#FDB241]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                                        />
                                    </svg>
                                    <svg class="w-5 h-5 text-[#FDB241]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                                        />
                                    </svg>
                                    <svg class="w-5 h-5 text-[#FDB241]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                                        />
                                    </svg>
                                </div>

                                <blockquote class="flex-1 mt-8">
                                    <p class="text-lg leading-relaxed text-gray-900 font-pj">“Equipres ha simplificado la gestión de préstamos en nuestra biblioteca. ¡Muy recomendado!”</p>
                                </blockquote>
                            </div>

                            <div class="flex items-center mt-8">
                                <div class="ml-4">
                                    <p class="text-base font-bold text-gray-900 font-pj">Mariana Gusman</p>
                                    <p class="mt-0.5 text-sm font-pj text-gray-600">Aprendiz</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col overflow-hidden shadow-xl">
                        <div class="flex flex-col justify-between flex-1 p-6 bg-white lg:py-8 lg:px-7">
                            <div class="flex-1">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-[#FDB241]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                                        />
                                    </svg>
                                    <svg class="w-5 h-5 text-[#FDB241]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                                        />
                                    </svg>
                                    <svg class="w-5 h-5 text-[#FDB241]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                                        />
                                    </svg>
                                    <svg class="w-5 h-5 text-[#FDB241]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                                        />
                                    </svg>
                                    <svg class="w-5 h-5 text-[#FDB241]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                                        />
                                    </svg>
                                </div>

                                <blockquote class="flex-1 mt-8">
                                    <p class="text-lg leading-relaxed text-gray-900 font-pj">“La plataforma es muy intuitiva y fácil de usar. ¡Excelente servicio!”</p>
                                </blockquote>
                            </div>

                            <div class="flex items-center mt-8">
                                <div class="ml-4">
                                    <p class="text-base font-bold text-gray-900 font-pj">María Gómez</p>
                                    <p class="mt-0.5 text-sm font-pj text-gray-600">Instructora</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col overflow-hidden shadow-xl">
                        <div class="flex flex-col justify-between flex-1 p-6 bg-white lg:py-8 lg:px-7">
                            <div class="flex-1">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-[#FDB241]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                                        />
                                    </svg>
                                    <svg class="w-5 h-5 text-[#FDB241]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                                        />
                                    </svg>
                                    <svg class="w-5 h-5 text-[#FDB241]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                                        />
                                    </svg>
                                    <svg class="w-5 h-5 text-[#FDB241]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                                        />
                                    </svg>
                                    <svg class="w-5 h-5 text-[#FDB241]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                                        />
                                    </svg>
                                </div>

                                <blockquote class="flex-1 mt-8">
                                    <p class="text-lg leading-relaxed text-gray-900 font-pj">“Gracias a Equipres, ahora podemos gestionar los préstamos de manera más eficiente”</p>
                                </blockquote>
                            </div>

                            <div class="flex items-center mt-8">
                                <div class="ml-4">
                                    <p class="text-base font-bold text-gray-900 font-pj">Carlos López</p>
                                    <p class="mt-0.5 text-sm font-pj text-gray-600">Bibliotecario</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

            <!-- Sección de Galería de Imágenes -->
            
          <section class="py-16">
    <div class="container mx-auto px-6">
        <!-- Título con fondo degradado -->
        <div class="text-center mb-8">
            <div class="relative inline-block">
                <!-- Fondo degradado con efecto de desenfoque -->
                <span class="bg-gradient-to-r from-[#44BCFF] via-[#FF44EC] to-[#FF675E] blur-lg filter opacity-30 w-full h-full absolute inset-0 rounded-lg"></span>
                <!-- Título con posición relativa -->
                <h2 class="relative text-2xl font-bold text-gray-800 sm:text-3xl lg:text-4xl animate-fade-in-down">
                    Nuestros Espacios
                </h2>
            </div>
        </div>

        <!-- Galería en Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <div class="overflow-hidden rounded-lg shadow-lg">
                <img src="/images/4_resultado.webp" alt="Espacio de trabajo 4"
                    class="w-full h-64 object-cover hover:scale-105 transition-transform duration-300">
            </div>
            <div class="overflow-hidden rounded-lg shadow-lg">
                <img src="/images/3_resultado.webp" alt="Espacio de trabajo 3"
                    class="w-full h-64 object-cover hover:scale-105 transition-transform duration-300">
            </div>
            <div class="overflow-hidden rounded-lg shadow-lg">
                <img src="/images/1_resultado.webp" alt="Espacio de trabajo 1"
                    class="w-full h-64 object-cover hover:scale-105 transition-transform duration-300">
            </div>
            <div class="overflow-hidden rounded-lg shadow-lg">
                <img src="/images/2_resultado.webp" alt="Espacio de trabajo 2"
                    class="w-full h-64 object-cover hover:scale-105 transition-transform duration-300">
            </div>
        </div>
    </div>
</section>


             <!-- Sección de Instrucciones -->
          
           
<section class="py-10 bg-white sm:py-16 lg:py-24">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto text-center">
            <!-- Contenedor relativo para el fondo y el título -->
            <div class="relative inline-block">
                <!-- Fondo degradado con efecto de desenfoque -->
                <span class="bg-gradient-to-r from-[#44BCFF] via-[#FF44EC] to-[#FF675E] blur-lg filter opacity-30 w-full h-full absolute inset-0 rounded-lg"></span>
                <!-- Título con posición relativa para que aparezca sobre el fondo -->
                <h2 class="relative text-3xl font-bold leading-tight text-black sm:text-4xl lg:text-5xl">¿Cómo Solicitar un Préstamo?</h2>
            </div>
        </div>

        <div class="relative mt-12 lg:mt-20">
            <div class="absolute inset-x-0 hidden xl:px-44 top-2 md:block md:px-20 lg:px-28">
                <img class="w-full" src="https://cdn.rareblocks.xyz/collection/celebration/images/steps/2/curved-dotted-line.svg" alt="" />
            </div>

            <div class="relative grid grid-cols-1 text-center gap-y-12 md:grid-cols-3 gap-x-12">
                <div>
                    <div class="flex items-center justify-center w-16 h-16 mx-auto bg-white border-2 border-gray-200 rounded-full shadow">
                        <span class="text-xl font-semibold text-gray-700"> 1 </span>
                    </div>
                    <h3 class="mt-6 text-xl font-semibold leading-tight text-black md:mt-10">Visita la Biblioteca</h3>
                    <p class="mt-4 text-base text-gray-600">Dirígete a la biblioteca y regístrate como usuario. Asegúrate de llevar tu documento de identificación.</p>
                </div>

                <div>
                    <div class="flex items-center justify-center w-16 h-16 mx-auto bg-white border-2 border-gray-200 rounded-full shadow">
                        <span class="text-xl font-semibold text-gray-700"> 2 </span>
                    </div>
                    <h3 class="mt-6 text-xl font-semibold leading-tight text-black md:mt-10"> Registra tu Documento</h3>
                    <p class="mt-4 text-base text-gray-600">Proporciona tu número de documento para que el personal pueda identificarte y registrar tu solicitud.</p>
                </div>

                <div>
                    <div class="flex items-center justify-center w-16 h-16 mx-auto bg-white border-2 border-gray-200 rounded-full shadow">
                        <span class="text-xl font-semibold text-gray-700"> 3 </span>
                    </div>
                    <h3 class="mt-6 text-xl font-semibold leading-tight text-black md:mt-10">Solicita el Equipo</h3>
                    <p class="mt-4 text-base text-gray-600">Indica el equipo que necesitas y el personal te lo entregará. ¡Así de fácil!</p>
                </div>
            </div>
        </div>
    </div>
</section>


           
        </main>


        <!-- Footer -->
        <footer class="bg-gray-50 py-8">
            <div class="container mx-auto px-6 text-center">
                <p class="text-gray-600 mb-4">© 2023 Equipres ADSO noche. Todos los derechos reservados.</p>
                <div class="flex justify-center space-x-6">
                    <a href="#" class="text-gray-600 hover:text-blue-500 transition duration-300">Política de Privacidad</a>
                    <a href="#" class="text-gray-600 hover:text-blue-500 transition duration-300">Términos de Servicio</a>
                    <a href="#" class="text-gray-600 hover:text-blue-500 transition duration-300">Contacto</a>
                </div>
            </div>
        </footer>

        <!-- Botón flotante de WhatsApp -->
        <a href="https://wa.me/3192575612" target="_blank" class="fixed bottom-6 right-6 bg-green-500 text-white p-4 rounded-full shadow-lg hover:bg-green-600 transition duration-300 animate-bounce">
            <i class="fab fa-whatsapp text-2xl"></i>
        </a>
    </div>
</template>

<style>


@keyframes textPop {
    0% {
        opacity: 0;
        transform: scale(0.8);
    }
    50% {
        opacity: 1;
        transform: scale(1.1);
    }
    100% {
        opacity: 1;
        transform: scale(1);
    }
}

.animate-text-pop {
    animation: textPop 1.5s ease-out;
}

@keyframes textFadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-text-fade-in {
    animation: textFadeIn 2s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-up {
    animation: fadeInUp 1s ease-out;
}

@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-down {
    animation: fadeInDown 1s ease-out;
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
    }
    40% {
        transform: translateY(-10px);
    }
    60% {
        transform: translateY(-5px);
    }
}


</style>