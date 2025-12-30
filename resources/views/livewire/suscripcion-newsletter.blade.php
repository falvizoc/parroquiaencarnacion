<div class="w-full">
    @if($exito)
        {{-- Mensaje de éxito --}}
        <div class="bg-green-50 border border-green-200 rounded-lg p-6 text-center">
            <svg class="w-12 h-12 text-green-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h3 class="text-lg font-semibold text-green-800 mb-2">
                @if($yaRegistrado)
                    ¡Preferencias actualizadas!
                @else
                    ¡Gracias por suscribirte!
                @endif
            </h3>
            <p class="text-green-700">{{ $mensaje }}</p>
        </div>
    @else
        {{-- Formulario de suscripción --}}
        <form wire:submit="suscribirse" class="space-y-4">
            {{-- Nombre --}}
            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">
                    Nombre
                </label>
                <input
                    type="text"
                    id="nombre"
                    wire:model="nombre"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors @error('nombre') border-red-500 @enderror"
                    placeholder="Tu nombre"
                >
                @error('nombre')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                    Correo electrónico
                </label>
                <input
                    type="email"
                    id="email"
                    wire:model="email"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors @error('email') border-red-500 @enderror"
                    placeholder="tu@email.com"
                >
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Preferencias --}}
            <div>
                <p class="block text-sm font-medium text-gray-700 mb-2">¿Qué te gustaría recibir?</p>
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input
                            type="checkbox"
                            wire:model="recibir_newsletter"
                            class="w-4 h-4 text-amber-600 border-gray-300 rounded focus:ring-amber-500"
                        >
                        <span class="ml-2 text-sm text-gray-600">Newsletter semanal</span>
                    </label>
                    <label class="flex items-center">
                        <input
                            type="checkbox"
                            wire:model="recibir_eventos"
                            class="w-4 h-4 text-amber-600 border-gray-300 rounded focus:ring-amber-500"
                        >
                        <span class="ml-2 text-sm text-gray-600">Invitaciones a eventos</span>
                    </label>
                    <label class="flex items-center">
                        <input
                            type="checkbox"
                            wire:model="recibir_avisos"
                            class="w-4 h-4 text-amber-600 border-gray-300 rounded focus:ring-amber-500"
                        >
                        <span class="ml-2 text-sm text-gray-600">Avisos importantes</span>
                    </label>
                </div>
                @error('preferencias')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Botón --}}
            <button
                type="submit"
                class="w-full bg-amber-600 hover:bg-amber-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center"
                wire:loading.attr="disabled"
                wire:loading.class="opacity-75 cursor-wait"
            >
                <span wire:loading.remove>Suscribirme</span>
                <span wire:loading class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Procesando...
                </span>
            </button>

            <p class="text-xs text-gray-500 text-center">
                Puedes cancelar tu suscripción en cualquier momento.
            </p>
        </form>
    @endif
</div>
