<x-app-layout>

    <form action="{{ route('password.email') }}" method="post" class="w-[400px] mx-auto p-6 my-16">
        @csrf
        <h2 class="text-2xl font-semibold text-center mb-5">
            Entra en tu email para reiniciar la contraseña
        </h2>
        <p class="text-center text-gray-500 mb-6">
            or
            <a
                href="{{route('login')}}"
                class="font-semibold text-dark-gray hover:underline"
            >Iniciar sesión con una cuenta existente</a
            >
        </p>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />


        <div class="mb-3">
            <x-input
                id="loginEmail"
                type="email"
                name="email"
                :value="old('email')"
                placeholder="Tu correo electrónico"
                autofocus
                required
            />
        </div>
        <button
            class="btn-primary border-2 border-dark-gray hover:border-2 bg-gray-200 text-dark-gray hover:bg-dark-gray hover:text-white hover:border-black w-full"
        >
            Enviar
        </button>
    </form>

</x-app-layout>
