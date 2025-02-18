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
        <main class="pt-20"> <!-- Ajuste para el header fijo -->
            <!-- Sección de Bienvenida -->
            <section class="bg-blue-50 py-20">
                <div class="container mx-auto px-6 text-center">
                    <h1 class="text-4xl font-bold text-gray-800 mb-4">Bienvenido a Equipres</h1>
                    <p class="text-lg text-gray-600">
                        Gestiona y presta equipos de la biblioteca de manera eficiente. Regístrate o inicia sesión para comenzar.
                    </p>
                    <div class="mt-8">
                        <Link
                            :href="route('login')"
                            class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition duration-300"
                        >
                            Iniciar Sesión
                        </Link>
                    </div>
                </div>
            </section>

            <!-- Sección de Equipos Disponibles -->
            <section class="py-16">
                <div class="container mx-auto px-6">
                    <h2 class="text-2xl font-bold text-gray-800 text-center mb-8">Equipos Disponibles</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-shadow">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Laptop HP EliteBook</h3>
                            <p class="text-gray-600 mb-4">Número de Serie: 123456789</p>
                            <button class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition duration-300">
                                Solicitar Préstamo
                            </button>
                        </div>
                        <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-shadow">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Proyector Epson</h3>
                            <p class="text-gray-600 mb-4">Número de Serie: 987654321</p>
                            <button class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition duration-300">
                                Solicitar Préstamo
                            </button>
                        </div>
                        <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-shadow">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Cámara Canon EOS</h3>
                            <p class="text-gray-600 mb-4">Número de Serie: 456789123</p>
                            <button class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition duration-300">
                                Solicitar Préstamo
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Sección de Instrucciones -->
            <section class="bg-blue-50 py-16">
                <div class="container mx-auto px-6">
                    <h2 class="text-2xl font-bold text-gray-800 text-center mb-8">¿Cómo Solicitar un Préstamo?</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-shadow">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">1. Regístrate o Inicia Sesión</h3>
                            <p class="text-gray-600">Para solicitar un préstamo, primero debes registrarte o iniciar sesión en tu cuenta.</p>
                        </div>
                        <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-shadow">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">2. Selecciona el Equipo</h3>
                            <p class="text-gray-600">Busca el equipo que necesitas y haz clic en "Solicitar Préstamo".</p>
                        </div>
                        <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-shadow">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">3. Confirma tu Solicitud</h3>
                            <p class="text-gray-600">Revisa los detalles del préstamo y confirma tu solicitud.</p>
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
        <a href="https://wa.me/1234567890" target="_blank" class="fixed bottom-6 right-6 bg-green-500 text-white p-4 rounded-full shadow-lg hover:bg-green-600 transition duration-300">
            <i class="fab fa-whatsapp text-2xl"></i>
        </a>
    </div>
</template>