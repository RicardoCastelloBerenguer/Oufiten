<x-app-layout>

    <form action="{{ route('login') }}" method="post" class="w-[400px] mx-auto p-6 my-16">
        @csrf
        <h2 class="text-2xl font-semibold text-center mb-5">
            Inicia sesión en tu cuenta
        </h2>
        <p class="text-center text-gray-500 mb-6">
            or
            <a
                href="{{route('register')}}"
                class="font-semibold text-sm text-dark-gray hover:underline"
            >Crear una cuenta nueva</a
            >
        </p>
        <x-auth-validation-errors class="mb-4" :errors="$errors"></x-auth-validation-errors>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />
        <div class="mb-4">
            <x-input
                id="loginEmail"
                type="email"
                name="email"
                :errors="$errors"
                placeholder="Tu email"
                :value="old('email')"
            />
        </div>
        <div class="mb-4">
            <x-input
                id="loginPassword"
                type="password"
                name="password"
                placeholder="Tu contraseña"
            />
        </div>

        <div class="flex justify-between items-center mb-5">
            <div class="flex items-center">
                <input
                    id="loginRememberMe"
                    type="checkbox"
                    name="remember"
                    class="mr-3 rounded border-gray-300 text-dark-gray focus:ring-black"
                />
                <label for="loginRememberMe">Recuerdame</label>
            </div>
            <a href="{{route('password.request')}}" class="font-semibold text-sm text-dark-gray hover:underline">Has olvidado la contraseña?</a>
        </div>
        <button
            class="btn-primary border-2 border-dark-gray hover:border-2 bg-gray-200 text-dark-gray hover:bg-dark-gray hover:text-white hover:border-black"
        >
            Iniciar sesión
        </button>
    </form>
</x-app-layout>
