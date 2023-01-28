<header
    x-data="{
    mobileMenuOpen: false,
    cartItemsCount : {{\App\Http\Helpers\Cart::getCartItemsCount()}}
    }"
    @cart-change.window = "cartItemsCount = $event.detail.count"
    class=" flex justify-between bg-gray-200 shadow-md text-dark-gray border-b-2 border-dark-gray"
>
    <div>
        <a href="{{route('home')}}" class="block py-1 pl-5">
            <img
                src='http://localhost:8000/storage/images/Logo/logo.png'
                alt=""
                class="rounded-lg hover:scale-105 hover:rotate-1 transition-transform w-16 h-16"
            />
        </a>
    </div>
    <!-- Responsive Menu -->
    <div
        class="block fixed z-10 top-0 bottom-0 height h-full w-[220px] transition-all bg-gray-200 border-r-2 border-dark-gray md:hidden"
        :class="mobileMenuOpen ? 'left-0' : '-left-[220px]'"
    >
        <ul>
            <li>
                <a
                    href="{{route('cart.index')}}"
                    class="relative flex items-center justify-between py-2 px-3 transition-colors hover:bg-dark-gray hover:text-white"
                >
                    <div class="flex items-center">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 mr-2 -mt-1"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
                            />
                        </svg>
                        Carrito
                    </div>
                    <!-- Cart Items Counter -->
                    <small
                        x-show="cartItemsCount"
                        x-transition
                        x-text="cartItemsCount"
                        class="py-[2px] px-[8px] rounded-full text-gray-200 bg-dark-gray"
                    ></small>
                    <!--/ Cart Items Counter -->
                </a>
            </li>
            @if(!Auth::guest())
            <li x-data="{open: false}" class="relative">
                <a
                    @click="open = !open"
                    class="cursor-pointer flex justify-between items-center py-2 px-3 hover:bg-dark-gray hover:text-white"
                >
              <span class="flex items-center">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 mr-2"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                  <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                  />
                </svg>
                Mi cuenta
              </span>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </a>
                <ul
                    x-show="open"
                    x-transition
                    class="z-10 right-0 bg-gray-200 border-t-2 border-b-2 border-dark-gray py-2 border-dashed"
                >
                    <li>
                        <a
                            href="{{route('profile')}}"
                            class="flex px-3 py-2 hover:bg-dark-gray hover:text-white"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 mr-2"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                />
                            </svg>
                            Mi perfil
                        </a>
                    </li>
                    <li class="hover:bg-slate-900">
                        <a
                            href="{{route('orders.index')}}"
                            class="flex items-center px-3 py-2 hover:bg-dark-gray hover:text-white"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 mr-2"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"
                                />
                            </svg>
                            Mis pedidos
                        </a>
                    </li>
                    <li class="hover:bg-dark-gray hover:text-dark-beige">
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button type="submit"
                                    class="flex w-full px-3 py-2 hover:bg-dark-gray hover:text-white"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 mr-2"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                                    />
                                </svg>
                                Cerrar sesión
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
            @else
            <li>
                <a
                    href="{{route('login')}}"
                    class="flex items-center py-2 px-3 transition-colors hover:bg-slate-800"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6 mr-2"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"
                        />
                    </svg>
                    Iniciar sesión
                </a>
            </li>
            <li class="px-3 py-3">
                <a
                    href="{{route('register')}}"
                    class="block text-center text-white bg-emerald-600 py-2 px-3 rounded shadow-md hover:bg-emerald-700 active:bg-emerald-800 transition-colors w-full"
                >
                    Registro
                </a>
            </li>
            @endif
        </ul>
    </div>
    <nav class="hidden md:block">
        <ul class="grid grid-flow-col items-center">
            <li>

                <a href="{{route('home')}}" class="h-20 relative inline-flex items-center py-navbar-item px-navbar-item hover:bg-dark-gray hover:text-white">
                    &nbsp;
                    &nbsp;
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"  class="h-5 w-5 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    Inicio
                    &nbsp;
                    &nbsp;
                </a>
            </li>
            <li>
                <a
                    href="{{route('cart.index')}}"
                    class="h-20 relative inline-flex items-center py-navbar-item px-navbar-item hover:bg-dark-gray hover:text-white"
                >
                    &nbsp;
                    &nbsp;
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 mr-2"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
                        />
                    </svg>
                    Carrito
                    <small
                        x-show="cartItemsCount"
                        x-transition
                        x-cloak
                        x-text="cartItemsCount"
                        class="absolute z-[100] top-4 py-[2px] px-[8px] rounded-full bg-dark-gray text-beige"
                    ></small>
                    &nbsp;
                    &nbsp;

                </a>
            </li>
            @if(!Auth::guest())
                <li x-data="{open: false}" class="relative">
                <a
                    @click="open = !open"
                    class="h-20 cursor-pointer flex items-center py-navbar-item px-navbar-item pr-5 hover:bg-dark-gray hover:text-white"
                >
              <span class="flex items-center">
                  &nbsp;
                  &nbsp;
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 mr-2"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                  <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                  />
                </svg>
                Mi cuenta
                  &nbsp;
                    &nbsp;
              </span>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 ml-2"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </a>
                <ul
                    @click.outside="open = false"
                    x-show="open"
                    x-transition
                    x-cloak
                    class="absolute z-10 right-0 bg-gray-200 border-l-2 border-b-2 border-dark-gray py-2 w-48 border-dashed"
                >
                    <li>
                        <a
                            href="{{route('profile')}}"
                            class="flex px-3 py-2 hover:bg-dark-gray hover:text-white"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 mr-2"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                />
                            </svg>
                            Mi perfil
                        </a>
                    </li>
                    <li>
                        <a
                            href="{{route('orders.index')}}"
                            class="flex px-3 py-2 hover:bg-dark-gray hover:text-white"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 mr-2"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"
                                />
                            </svg>
                            Mis pedidos
                        </a>
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit"
                                class="flex w-full px-3 py-2 hover:bg-dark-gray hover:text-white"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 mr-2"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                                />
                            </svg>
                            Cerrar sesión
                        </button>
                        </form>
                    </li>
                </ul>
            </li>
            @else
            <li>
                <a
                    href="{{route('login')}}"
                    class="h-20 flex items-center py-navbar-item px-navbar-item hover:bg-dark-gray hover:text-white"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 mr-2"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"
                        />
                    </svg>
                    Iniciar sesión
                </a>
            </li>
            <li>
                <a
                    href="{{route('register')}}"
                    class="inline-flex items-center py-2 px-3 rounded shadow-md border-2 border-dark-gray hover:border-2 bg-dark-gray text-gray-200 hover:text-white hover:border-black transition-colors mx-5"
                >
                    Registro
                </a>
            </li>
            @endif
        </ul>
    </nav>
    <button
        @click="mobileMenuOpen = !mobileMenuOpen"
        class="p-4 block md:hidden"
    >
        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M4 6h16M4 12h16M4 18h16"
            />
        </svg>
    </button>
</header>

