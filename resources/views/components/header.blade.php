<!-- Modern Header with Backdrop Blur -->
<header class="bg-white/95 dark:bg-[#020721] backdrop-blur-md border-b border-gray-200 dark:border-gray-800 sticky top-0 z-50 transition-all duration-300">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-4">
            <!-- Logo Section -->
            <div class="flex items-center space-x-3">
                <div class="relative group">
                    <div class="absolute -inset-2 bg-gradient-to-r from-[#048dfd]/20 via-[#ea07a9]/20 to-yellow-500/20 rounded-xl blur opacity-0 group-hover:opacity-100 transition-all duration-300"></div>
                    <div class="relative rounded-xl p-2  transition-all duration-300">
                        <img src="{{asset('Logos/colored/LogoTextHorizontal_nobg.png')}}" 
                             alt="Sin Limite Logo" 
                             class="h-8 w-auto dark:hidden">
                        <img src="{{asset('Logos/white/LogoTextHorizontal.png')}}" 
                             alt="Sin Limite Logo" 
                             class="h-8 w-auto hidden dark:block">
                    </div>
                </div>
            </div>
            
            <!-- Modern Navigation - Solo visible para usuarios no autenticados -->
            @guest
            <nav class="hidden lg:flex items-center space-x-1">
                <a href="/" class="relative px-4 py-2 text-gray-700 dark:text-gray-300 hover:text-yellow-500 dark:hover:text-yellow-500 font-medium rounded-lg hover:bg-gray-50/80 dark:hover:bg-gray-800/80 transition-all duration-200 group">
                    <span class="relative z-10">Inicio</span>
                    <div class="absolute inset-x-0 bottom-0 h-0.5 bg-yellow-500 scale-x-0 group-hover:scale-x-100 transition-transform duration-300 rounded-full"></div>
                </a>
                <a href="#" class="relative px-4 py-2 text-gray-700 dark:text-gray-300 hover:text-yellow-500 dark:hover:text-yellow-500 font-medium rounded-lg hover:bg-gray-50/80 dark:hover:bg-gray-800/80 transition-all duration-200 group">
                    <span class="relative z-10">Catálogo</span>
                   <div class="absolute inset-x-0 bottom-0 h-0.5 bg-yellow-500 scale-x-0 group-hover:scale-x-100 transition-transform duration-300 rounded-full"></div>
                </a>
                <a href="#categorias" class="relative px-4 py-2 text-gray-700 dark:text-gray-300 hover:text-yellow-500 dark:hover:text-yellow-500 font-medium rounded-lg hover:bg-gray-50/80 dark:hover:bg-gray-800/80 transition-all duration-200 group">
                    <span class="relative z-10">Categorías</span>
                    <div class="absolute inset-x-0 bottom-0 h-0.5 bg-yellow-500 scale-x-0 group-hover:scale-x-100 transition-transform duration-300 rounded-full"></div>
                </a>
                <a href="#" class="relative px-4 py-2 text-gray-700 dark:text-gray-300 hover:text-yellow-500 dark:hover:text-yellow-500 font-medium rounded-lg hover:bg-gray-50/80 dark:hover:bg-gray-800/80 transition-all duration-200 group">
                    <span class="relative z-10">Quiénes somos</span>
                    <div class="absolute inset-x-0 bottom-0 h-0.5 bg-yellow-500 scale-x-0 group-hover:scale-x-100 transition-transform duration-300 rounded-full"></div>
                </a>
                <a href="#testimonio" class="relative px-4 py-2 text-gray-700 dark:text-gray-300 hover:text-yellow-500 dark:hover:text-yellow-500 font-medium rounded-lg hover:bg-gray-50/80 dark:hover:bg-gray-800/80 transition-all duration-200 group">
                    <span class="relative z-10">Testimonios</span>
                    <div class="absolute inset-x-0 bottom-0 h-0.5 bg-yellow-500 scale-x-0 group-hover:scale-x-100 transition-transform duration-300 rounded-full"></div>
                </a>
            </nav>
            @endguest
            
            <!-- Modern Action Buttons -->
            <div class="flex items-center space-x-3">
                <!-- Carrito y Favoritos -->
                <a href="{{ route('favoritos') }}" 
                   class="relative p-2 text-gray-700 dark:text-gray-300 hover:text-red-500 dark:hover:text-red-400 rounded-lg hover:bg-gray-50/80 dark:hover:bg-gray-800/80 transition-all duration-200 group">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200">♡</span>
                </a>
                
                <a href="{{ route('carrito') }}" 
                   class="relative p-2 text-gray-700 dark:text-gray-300 hover:text-indigo-500 dark:hover:text-indigo-400 rounded-lg hover:bg-gray-50/80 dark:hover:bg-gray-800/80 transition-all duration-200 group">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 6.5M7 13l2.5 6.5M17 13v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6"></path>
                    </svg>
                    <span class="absolute -top-1 -right-1 bg-indigo-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200">🛒</span>
                </a>

                <!-- Login Button -->
                @if (Route::has('login'))
                    @auth
                        <a class="relative px-4 py-2 text-gray-700 dark:text-gray-300 hover:text-yellow-500 dark:hover:text-yellow-500 font-medium rounded-lg hover:bg-gray-50/80 dark:hover:bg-gray-800/80 transition-all duration-200 group"
                            href="{{ url('/dashboard') }}">
                        <span class="relative z-10">Dashboard</span>
                        <div class="absolute inset-x-0 bottom-0 h-0.5 bg-yellow-500 scale-x-0 group-hover:scale-x-100 transition-transform duration-300 rounded-full"></div>
                        </a>
                        <a class="relative px-4 py-2 text-gray-700 dark:text-gray-300 hover:text-yellow-500 dark:hover:text-yellow-500 font-medium rounded-lg hover:bg-gray-50/80 dark:hover:bg-gray-800/80 transition-all duration-200 group"
                            href="{{ url('/productos') }}">
                        <span class="relative z-10">Productos</span>
                        <div class="absolute inset-x-0 bottom-0 h-0.5 bg-yellow-500 scale-x-0 group-hover:scale-x-100 transition-transform duration-300 rounded-full"></div>
                        </a>
                        <a class="relative px-4 py-2 text-gray-700 dark:text-gray-300 hover:text-yellow-500 dark:hover:text-yellow-500 font-medium rounded-lg hover:bg-gray-50/80 dark:hover:bg-gray-800/80 transition-all duration-200 group"
                            href="{{ route('mis-pedidos') }}">
                        <span class="relative z-10">Mis Pedidos</span>
                        <div class="absolute inset-x-0 bottom-0 h-0.5 bg-yellow-500 scale-x-0 group-hover:scale-x-100 transition-transform duration-300 rounded-full"></div>
                        </a>
                        <a class="relative px-4 py-2 text-gray-700 dark:text-gray-300 hover:text-yellow-500 dark:hover:text-yellow-500 font-medium rounded-lg hover:bg-gray-50/80 dark:hover:bg-gray-800/80 transition-all duration-200 group"
                            href="{{ route('pedidos.dashboard') }}">
                        <span class="relative z-10">Dashboard Admin</span>
                        <div class="absolute inset-x-0 bottom-0 h-0.5 bg-yellow-500 scale-x-0 group-hover:scale-x-100 transition-transform duration-300 rounded-full"></div>
                        </a>
                        <a class="relative px-4 py-2 text-gray-700 dark:text-gray-300 hover:text-yellow-500 dark:hover:text-yellow-500 font-medium rounded-lg hover:bg-gray-50/80 dark:hover:bg-gray-800/80 transition-all duration-200 group"
                            href="{{ route('reportes.ventas') }}">
                        <span class="relative z-10">Reportes</span>
                        <div class="absolute inset-x-0 bottom-0 h-0.5 bg-yellow-500 scale-x-0 group-hover:scale-x-100 transition-transform duration-300 rounded-full"></div>
                        </a>
                        <!-- Settings Dropdown -->
                        <div class="ms-3 relative">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                        <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                            <img class="size-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                        </button>
                                    @else
                                        <span class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                                {{ Auth::user()->name }}

                                                <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                </svg>
                                            </button>
                                        </span>
                                    @endif
                                </x-slot>

                                <x-slot name="content">
                                    <!-- Account Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Manage Account') }}
                                    </div>

                                    <x-dropdown-link href="{{ route('profile.show') }}">
                                        {{ __('Profile') }}
                                    </x-dropdown-link>

                                    @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                        <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                            {{ __('API Tokens') }}
                                        </x-dropdown-link>
                                    @endif

                                    <div class="border-t border-gray-200"></div>

                                    <!-- Authentication -->
                                    <form method="POST" action="{{ route('logout') }}" x-data>
                                        @csrf

                                        <x-dropdown-link href="{{ route('logout') }}"
                                                @click.prevent="$root.submit();">
                                            {{ __('Log Out') }}
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    @else
                        <!-- <a href="{{ route('register') }}" 
                            class="hidden sm:flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 hover:text-yellow-500 dark:hover:text-yellow-500 font-medium rounded-lg hover:bg-gray-50/80 dark:hover:bg-gray-800/80 transition-all duration-200">
                            Registrarme
                        </a> -->

                            
   
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" 
                                class="relative group overflow-hidden bg-yellow-500 text-white px-6 py-2.5 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                                <div class="absolute inset-0 bg-yellow-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <span class="relative flex items-center space-x-2">
                                    <span>Iniciar Sesión</span>
                                    <svg class="ml-2 w-4 h-4 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                        </path>
                                    </svg>
                                </span>
                            </a>
                        @endif
                    @endauth
                @endif
                
                <!-- Mobile Menu Button - Solo para usuarios no autenticados -->
                @guest
                <button class="lg:hidden p-2 rounded-lg hover:bg-gray-50/80 dark:hover:bg-gray-800/80 transition-colors duration-200" id="mobile-menu-button">
                    <svg class="w-6 h-6 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                @endguest
            </div>
        </div>
    </div>
    
    <!-- Mobile Navigation Menu - Solo visible para usuarios no autenticados -->
    @guest
    <div class="lg:hidden hidden bg-white/95 dark:bg-gray-900/95 backdrop-blur-md border-t border-gray-100/50 dark:border-gray-700/50" id="mobile-menu">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex flex-col space-y-3">
                <a href="#" class="px-4 py-3 text-gray-700 dark:text-gray-300 hover:text-yellow-500 dark:hover:text-yellow-500 hover:bg-gray-50/80 dark:hover:bg-gray-800/80 rounded-lg font-medium transition-all duration-200">Inicio</a>
                <a href="#" class="px-4 py-3 text-gray-700 dark:text-gray-300 hover:text-yellow-500 dark:hover:text-yellow-500 hover:bg-gray-50/80 dark:hover:bg-gray-800/80 rounded-lg font-medium transition-all duration-200">Catálogo</a>
                <a href="#categorias" class="px-4 py-3 text-gray-700 dark:text-gray-300 hover:text-yellow-500 dark:hover:text-yellow-500 hover:bg-gray-50/80 dark:hover:bg-gray-800/80 rounded-lg font-medium transition-all duration-200">Categorías</a>
                <a href="#" class="px-4 py-3 text-gray-700 dark:text-gray-300 hover:text-yellow-500 dark:hover:text-yellow-500 hover:bg-gray-50/80 dark:hover:bg-gray-800/80 rounded-lg font-medium transition-all duration-200">Quiénes somos</a>
                <a href="#testimonio" class="px-4 py-3 text-gray-700 dark:text-gray-300 hover:text-yellow-500 dark:hover:text-yellow-500 hover:bg-gray-50/80 dark:hover:bg-gray-800/80 rounded-lg font-medium transition-all duration-200">Testimonios</a>
                
                <!-- Carrito y Favoritos en móvil -->
                <div class="border-t border-gray-100 dark:border-gray-700 pt-3">
                    <a href="{{ route('carrito') }}" class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 hover:text-indigo-500 dark:hover:text-indigo-400 hover:bg-gray-50/80 dark:hover:bg-gray-800/80 rounded-lg font-medium transition-all duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 6.5M7 13l2.5 6.5M17 13v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6"></path>
                        </svg>
                        Mi Carrito
                    </a>
                    <a href="{{ route('favoritos') }}" class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-300 hover:text-red-500 dark:hover:text-red-400 hover:bg-gray-50/80 dark:hover:bg-gray-800/80 rounded-lg font-medium transition-all duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        Mis Favoritos
                    </a>
                </div>
                
                <div class="border-t border-gray-100 dark:border-gray-700 pt-3">
                    <a href="{{ route('login') }}" class="block px-4 py-3 text-gray-700 dark:text-gray-300 hover:text-yellow-500 dark:hover:text-yellow-500 hover:bg-gray-50/80 dark:hover:bg-gray-800/80 rounded-lg font-medium transition-all duration-200">Iniciar Sesión</a>
                    <a href="{{ route('login') }}" class="block mt-2 bg-yellow-500 text-white px-4 py-3 rounded-lg font-semibold text-center shadow-lg transition-all duration-300">Cotizar Producto </a>
                </div>
            </div>
        </div>
    </div>
    @endguest
</header>

<script>
// Mobile menu toggle functionality
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    }
});
</script>