<x-app-layout>

    <form
        action="{{route('register')}}"
        method="post"
        class="w-[400px] mx-auto p-6 my-16"
    >
        @csrf
        <h2 class="text-2xl font-semibold text-center mb-4">Crear una cuenta</h2>
        <p class="text-center text-gray-500 mb-3">
            o
            <a
                href="{{route('login')}}"
                class="text-sm text-purple-700 hover:text-purple-600"
            >Inicia sesión con una cuenta existente</a
            >
        </p>

        <x-auth-validation-errors class="mb-4" :errors="$errors"></x-auth-validation-errors>

        <div class="mb-4">
            <x-input
                placeholder="Tu nombre"
                type="text"
                name="name"
                :value="old('name')"
            />
        </div>
        </p>
        <div class="mb-4">
            <x-input
                placeholder="Tu Email"
                type="email"
                name="email"
                :value="old('email')"
            />
        </div>
        <div class="mb-4">
            <x-input
                placeholder="Contraseña"
                type="password"
                name="password"
            />
        </div>
        </div>
        <div class="mb-4">
            <x-input
                placeholder="Repite la contraseña"
                type="password"
                name="password_confirmation"
            />
        </div>

        <button
            class="btn-primary bg-emerald-500 hover:bg-emerald-600 active:bg-emerald-700 w-full"
        >
            Registrarse
        </button>
    </form>

</x-app-layout>
