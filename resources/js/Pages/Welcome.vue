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
            <section class="py-16">
                <div class="container mx-auto px-6">
                    <h2 class="text-2xl font-bold text-gray-800 text-center mb-8 animate-fade-in-down">
                        Equipos Con los que Contamos
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Tarjeta de Laptop HP EliteBook -->
                        <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-transform transform hover:scale-105 animate-fade-in-up">
                            <div class="text-center">
                                <i class="fas fa-laptop text-4xl text-blue-500 mb-4"></i>
                                <h3 class="text-xl font-semibold text-gray-800 mb-2">Laptop HP EliteBook</h3>
                                <p class="text-gray-600">
                                    Potentes laptops para trabajo y estudio.
                                </p>
                            </div>
                        </div>
                        <!-- Tarjeta de Proyector Epson -->
                        <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-transform transform hover:scale-105 animate-fade-in-up delay-100">
                            <div class="text-center">
                                <i class="fas fa-video text-4xl text-blue-500 mb-4"></i>
                                <h3 class="text-xl font-semibold text-gray-800 mb-2">Proyector Epson</h3>
                                <p class="text-gray-600">
                                    Proyectores de alta calidad para presentaciones.
                                </p>
                            </div>
                        </div>
                        <!-- Tarjeta de Cámara Canon EOS -->
                        <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-transform transform hover:scale-105 animate-fade-in-up delay-200">
                            <div class="text-center">
                                <i class="fas fa-camera text-4xl text-blue-500 mb-4"></i>
                                <h3 class="text-xl font-semibold text-gray-800 mb-2">Cámara Canon EOS</h3>
                                <p class="text-gray-600">
                                    Cámaras profesionales para fotografía y video.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Nueva Sección: Testimonios de Usuarios -->
            <section class="bg-blue-50 py-16">
                <div class="container mx-auto px-6">
                    <h2 class="text-2xl font-bold text-gray-800 text-center mb-8 animate-fade-in-down">
                        Lo que Dicen Nuestros Usuarios
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Testimonio 1 -->
                        <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-transform transform hover:scale-105 animate-fade-in-up">
                            <div class="text-center">
                                <i class="fas fa-user-circle text-4xl text-blue-500 mb-4"></i>
                                <h3 class="text-xl font-semibold text-gray-800 mb-2">Juan Pérez</h3>
                                <p class="text-gray-600">
                                    "Equipres ha simplificado la gestión de préstamos en nuestra biblioteca. ¡Muy recomendado!"
                                </p>
                            </div>
                        </div>
                        <!-- Testimonio 2 -->
                        <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-transform transform hover:scale-105 animate-fade-in-up delay-100">
                            <div class="text-center">
                                <i class="fas fa-user-circle text-4xl text-blue-500 mb-4"></i>
                                <h3 class="text-xl font-semibold text-gray-800 mb-2">María Gómez</h3>
                                <p class="text-gray-600">
                                    "La plataforma es muy intuitiva y fácil de usar. ¡Excelente servicio!"
                                </p>
                            </div>
                        </div>
                        <!-- Testimonio 3 -->
                        <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-transform transform hover:scale-105 animate-fade-in-up delay-200">
                            <div class="text-center">
                                <i class="fas fa-user-circle text-4xl text-blue-500 mb-4"></i>
                                <h3 class="text-xl font-semibold text-gray-800 mb-2">Carlos López</h3>
                                <p class="text-gray-600">
                                    "Gracias a Equipres, ahora podemos gestionar los préstamos de manera más eficiente."
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Sección de Galería de Imágenes -->
            <section class="py-16">
                <div class="container mx-auto px-6">
                    <h2 class="text-2xl font-bold text-gray-800 text-center mb-8 animate-fade-in-down">
                        Nuestros Espacios
                    </h2>
                    <div class="flex justify-center gap-4">
                        <img
                            src="/images/4_resultado.webp"
                            alt="Espacio de trabajo 4"
                            class="custom-img hover:scale-105 transition-transform duration-300"
                        />
                        <img
                            src="/images/3_resultado.webp"
                            alt="Espacio de trabajo 3"
                            class="custom-img hover:scale-105 transition-transform duration-300"
                        />
                        <img
                            src="/images/1_resultado.webp"
                            alt="Espacio de trabajo 1"
                            class="custom-img hover:scale-105 transition-transform duration-300"
                        />
                        <img
                            src="/images/2_resultado.webp"
                            alt="Espacio de trabajo 2"
                            class="custom-img hover:scale-105 transition-transform duration-300"
                        />
                    </div>
                </div>
            </section>

            <!-- Sección de Instrucciones -->
            <section class="bg-blue-50 py-16">
                <div class="container mx-auto px-6">
                    <h2 class="text-2xl font-bold text-gray-800 text-center mb-8 animate-fade-in-down">
                        ¿Cómo Solicitar un Préstamo?
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Paso 1 -->
                        <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-transform transform hover:scale-105 animate-fade-in-up">
                            <i class="fas fa-building text-4xl text-blue-500 mb-4"></i>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">1. Visita la Biblioteca</h3>
                            <p class="text-gray-600">
                                Dirígete a la biblioteca y regístrate como usuario. Asegúrate de llevar tu documento de identificación.
                            </p>
                        </div>
                        <!-- Paso 2 -->
                        <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-transform transform hover:scale-105 animate-fade-in-up delay-100">
                            <i class="fas fa-id-card text-4xl text-blue-500 mb-4"></i>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">2. Registra tu Documento</h3>
                            <p class="text-gray-600">
                                Proporciona tu número de documento para que el personal pueda identificarte y registrar tu solicitud.
                            </p>
                        </div>
                        <!-- Paso 3 -->
                        <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-transform transform hover:scale-105 animate-fade-in-up delay-200">
                            <i class="fas fa-laptop text-4xl text-blue-500 mb-4"></i>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">3. Solicita el Equipo</h3>
                            <p class="text-gray-600">
                                Indica el equipo que necesitas y el personal te lo entregará. ¡Así de fácil!
                            </p>
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
        <a href="https://wa.me/1234567890" target="_blank" class="fixed bottom-6 right-6 bg-green-500 text-white p-4 rounded-full shadow-lg hover:bg-green-600 transition duration-300 animate-bounce">
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

.animate-bounce {
    animation: bounce 2s infinite;
}

.custom-img {
    width: 100%; /* Ajusta el tamaño de las imágenes */
    max-width: 300px; /* Tamaño máximo */
    height: auto; /* Mantiene la proporción */
    border-radius: 8px; /* Bordes redondeados */
    transition: transform 0.3s ease, opacity 0.3s ease;
}

.custom-img:hover {
    transform: scale(1.05); /* Efecto de zoom al pasar el mouse */
    opacity: 0.9; /* Ligera transparencia al pasar el mouse */
}
</style>