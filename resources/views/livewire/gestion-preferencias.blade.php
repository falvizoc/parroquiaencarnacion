<div class="max-w-lg mx-auto">
    @if(!$fiel)
        {{-- Token inválido o expirado --}}
        <div class="bg-red-50 border border-red-200 rounded-lg p-6 text-center">
            <svg class="w-12 h-12 text-red-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <h3 class="text-lg font-semibold text-red-800 mb-2">Enlace inválido</h3>
            <p class="text-red-700">El enlace que utilizaste no es válido o ha expirado.</p>
            <a href="{{ route('newsletter') }}" class="inline-block mt-4 text-amber-600 hover:text-amber-700 font-medium">
                Volver a suscribirse
            </a>
        </div>

    @elseif($cancelado)
        {{-- Confirmación de baja --}}
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 text-center">
            <svg class="w-12 h-12 text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Suscripción cancelada</h3>
            <p class="text-gray-600">{{ $mensaje }}</p>
            <p class="text-sm text-gray-500 mt-4">Lamentamos verte partir. Si cambias de opinión, siempre puedes volver a suscribirte.</p>
        </div>

    @elseif($guardado)
        {{-- Preferencias guardadas --}}
        <div class="bg-green-50 border border-green-200 rounded-lg p-6 text-center">
            <svg class="w-12 h-12 text-green-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h3 class="text-lg font-semibold text-green-800 mb-2">¡Preferencias actualizadas!</h3>
            <p class="text-green-700">{{ $mensaje }}</p>
        </div>

    @else
        {{-- Formulario de preferencias --}}
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Gestionar Preferencias</h2>
                <p class="text-gray-600 mt-2">Hola <strong>{{ $fiel->nombre }}</strong>, actualiza tus preferencias de comunicación.</p>
            </div>

            <form wire:submit="guardar" class="space-y-6">
                <div class="space-y-4">
                    <p class="font-medium text-gray-700">¿Qué comunicaciones deseas recibir?</p>

                    <label class="flex items-start p-4 border rounded-lg cursor-pointer hover:bg-gray-50 transition-colors {{ $recibir_newsletter ? 'border-amber-500 bg-amber-50' : 'border-gray-200' }}">
                        <input
                            type="checkbox"
                            wire:model.live="recibir_newsletter"
                            class="w-5 h-5 text-amber-600 border-gray-300 rounded focus:ring-amber-500 mt-0.5"
                        >
                        <div class="ml-3">
                            <span class="font-medium text-gray-800">Newsletter semanal</span>
                            <p class="text-sm text-gray-500">Reflexiones, mensajes del párroco y novedades de la parroquia.</p>
                        </div>
                    </label>

                    <label class="flex items-start p-4 border rounded-lg cursor-pointer hover:bg-gray-50 transition-colors {{ $recibir_eventos ? 'border-amber-500 bg-amber-50' : 'border-gray-200' }}">
                        <input
                            type="checkbox"
                            wire:model.live="recibir_eventos"
                            class="w-5 h-5 text-amber-600 border-gray-300 rounded focus:ring-amber-500 mt-0.5"
                        >
                        <div class="ml-3">
                            <span class="font-medium text-gray-800">Invitaciones a eventos</span>
                            <p class="text-sm text-gray-500">Retiros, celebraciones especiales, actividades comunitarias.</p>
                        </div>
                    </label>

                    <label class="flex items-start p-4 border rounded-lg cursor-pointer hover:bg-gray-50 transition-colors {{ $recibir_avisos ? 'border-amber-500 bg-amber-50' : 'border-gray-200' }}">
                        <input
                            type="checkbox"
                            wire:model.live="recibir_avisos"
                            class="w-5 h-5 text-amber-600 border-gray-300 rounded focus:ring-amber-500 mt-0.5"
                        >
                        <div class="ml-3">
                            <span class="font-medium text-gray-800">Avisos importantes</span>
                            <p class="text-sm text-gray-500">Cambios de horario, anuncios urgentes, información relevante.</p>
                        </div>
                    </label>
                </div>

                <button
                    type="submit"
                    class="w-full bg-amber-600 hover:bg-amber-700 text-white font-semibold py-3 px-4 rounded-lg transition-colors duration-200"
                    wire:loading.attr="disabled"
                    wire:loading.class="opacity-75"
                >
                    <span wire:loading.remove>Guardar preferencias</span>
                    <span wire:loading>Guardando...</span>
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-gray-200">
                <p class="text-sm text-gray-500 text-center mb-4">¿Ya no deseas recibir ninguna comunicación?</p>
                <button
                    wire:click="cancelarTodo"
                    wire:confirm="¿Estás seguro de que deseas cancelar todas las suscripciones? Ya no recibirás ningún correo de nuestra parte."
                    class="w-full text-red-600 hover:text-red-700 hover:bg-red-50 font-medium py-2 px-4 rounded-lg transition-colors duration-200 border border-red-200"
                >
                    Cancelar todas las suscripciones
                </button>
            </div>
        </div>
    @endif
</div>
