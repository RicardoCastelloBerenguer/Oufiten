<x-app-layout>

    <div class="w-[400px] mx-auto py-32">
        <div class="mb-4 text-sm text-gray-600">
            {{ __('Gracias por registrarte! Antes de empezar, puedes verificar tu email haciendo click en el link que te acabamos de enviar? Si no has recibido ninguno estaremos encantados de reenviártelo') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('Un nuevo link de verificación se ha enviado al correo introducido en el registro') }}
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <x-button>
                        {{ __('Reenviar email de confirmación') }}
                    </x-button>
                </div>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ __('Cerrar sesión') }}
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
