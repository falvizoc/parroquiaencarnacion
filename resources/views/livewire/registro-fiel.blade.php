<div>
    @if($registroCompletado)
        {{-- Mensaje de éxito --}}
        <div class="card p-8 text-center">
            <div class="w-20 h-20 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-6">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ __('general.register.success_title') }}!</h2>
            <p class="text-gray-600 mb-6">
                {{ __('general.register.success_message') }}
            </p>
            <p class="text-sm text-gray-500 mb-8">
                {{ __('general.register.verify_email') }}
            </p>
            <a href="{{ route('inicio', ['locale' => app()->getLocale()]) }}" class="btn-primary">
                {{ __('general.actions.back') }}
            </a>
        </div>
    @else
        <div class="card overflow-hidden">
            {{-- Indicador de pasos --}}
            <div class="bg-gray-50 px-8 py-4 border-b">
                <div class="flex items-center justify-between">
                    @foreach([1 => __('general.register.step1'), 2 => __('general.register.step2'), 3 => __('general.register.step3')] as $num => $label)
                        <button
                            type="button"
                            wire:click="irAPaso({{ $num }})"
                            {{ $num > $paso ? 'disabled' : '' }}
                            class="flex items-center gap-2 {{ $num <= $paso ? 'cursor-pointer' : 'cursor-not-allowed opacity-50' }}"
                        >
                            <span class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-medium
                                {{ $paso == $num ? 'bg-primary-600 text-white' : ($paso > $num ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-600') }}">
                                @if($paso > $num)
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                @else
                                    {{ $num }}
                                @endif
                            </span>
                            <span class="hidden sm:inline text-sm {{ $paso == $num ? 'text-primary-600 font-medium' : 'text-gray-500' }}">
                                {{ $label }}
                            </span>
                        </button>
                        @if($num < 3)
                            <div class="flex-1 mx-4 h-0.5 {{ $paso > $num ? 'bg-green-500' : 'bg-gray-200' }}"></div>
                        @endif
                    @endforeach
                </div>
            </div>

            <form wire:submit="{{ $paso == $totalPasos ? 'registrar' : 'siguientePaso' }}" class="p-8">
                {{-- Paso 1: Datos Personales --}}
                @if($paso == 1)
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('general.register.personal_info') }}</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">
                                    {{ __('general.register.first_name') }} <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="nombre"
                                    wire:model="nombre"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('nombre') border-red-500 @enderror"
                                >
                                @error('nombre') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="apellido_paterno" class="block text-sm font-medium text-gray-700 mb-1">
                                    {{ __('general.register.last_name') }} <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="apellido_paterno"
                                    wire:model="apellido_paterno"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('apellido_paterno') border-red-500 @enderror"
                                >
                                @error('apellido_paterno') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700 mb-1">
                                    {{ __('general.register.birth_date') }}
                                </label>
                                <input
                                    type="date"
                                    id="fecha_nacimiento"
                                    wire:model="fecha_nacimiento"
                                    max="{{ now()->format('Y-m-d') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                >
                            </div>

                            <div>
                                <label for="genero" class="block text-sm font-medium text-gray-700 mb-1">
                                    {{ __('general.register.gender') }}
                                </label>
                                <select
                                    id="genero"
                                    wire:model="genero"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                >
                                    <option value="">{{ __('general.forms.select_option') }}</option>
                                    @foreach(\App\Models\FaithfulMember::GENEROS as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Paso 2: Contacto --}}
                @if($paso == 2)
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('general.register.contact_info') }}</h3>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('general.contact.email') }} <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="email"
                                id="email"
                                wire:model="email"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('email') border-red-500 @enderror"
                            >
                            @error('email') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                            <p class="mt-1 text-xs text-gray-500">{{ __('general.register.verify_email') }}</p>
                        </div>

                        <div>
                            <label for="telefono" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('general.contact.phone') }}
                            </label>
                            <input
                                type="tel"
                                id="telefono"
                                wire:model="telefono"
                                placeholder="(833) 123-4567"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                            >
                        </div>

                        <div>
                            <label for="direccion" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('general.register.address') }}
                            </label>
                            <textarea
                                id="direccion"
                                wire:model="direccion"
                                rows="2"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                            ></textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="colonia" class="block text-sm font-medium text-gray-700 mb-1">
                                    {{ __('general.register.city') }}
                                </label>
                                <input
                                    type="text"
                                    id="colonia"
                                    wire:model="colonia"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                >
                            </div>

                            <div>
                                <label for="codigo_postal" class="block text-sm font-medium text-gray-700 mb-1">
                                    {{ __('general.register.zip_code') }}
                                </label>
                                <input
                                    type="text"
                                    id="codigo_postal"
                                    wire:model="codigo_postal"
                                    maxlength="10"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                >
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Paso 3: Preferencias --}}
                @if($paso == 3)
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('general.register.step3') }}</h3>

                        <div>
                            <label for="chapel_id" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('general.register.select_chapel') }}
                            </label>
                            <select
                                id="chapel_id"
                                wire:model="chapel_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                            >
                                <option value="">{{ __('general.places.main_temple') }}</option>
                                @foreach($this->capillas as $id => $nombre)
                                    <option value="{{ $id }}">{{ $nombre }}</option>
                                @endforeach
                            </select>
                            <p class="mt-1 text-xs text-gray-500">{{ __('general.forms.select_option') }}</p>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm font-medium text-gray-700 mb-3">{{ __('general.register.preferences_title') }}</p>
                            <div class="space-y-3">
                                <label class="flex items-start gap-3">
                                    <input
                                        type="checkbox"
                                        wire:model="recibir_newsletter"
                                        class="mt-1 w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500"
                                    >
                                    <div>
                                        <span class="text-gray-900 font-medium">{{ __('general.register.receive_newsletter') }}</span>
                                        <p class="text-xs text-gray-500">{{ __('general.footer.newsletter_description') }}</p>
                                    </div>
                                </label>

                                <label class="flex items-start gap-3">
                                    <input
                                        type="checkbox"
                                        wire:model="recibir_eventos"
                                        class="mt-1 w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500"
                                    >
                                    <div>
                                        <span class="text-gray-900 font-medium">{{ __('general.register.receive_events') }}</span>
                                        <p class="text-xs text-gray-500">{{ __('general.home.events_intro') }}</p>
                                    </div>
                                </label>

                                <label class="flex items-start gap-3">
                                    <input
                                        type="checkbox"
                                        wire:model="recibir_avisos"
                                        class="mt-1 w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500"
                                    >
                                    <div>
                                        <span class="text-gray-900 font-medium">{{ __('general.register.receive_notices') }}</span>
                                        <p class="text-xs text-gray-500">{{ __('general.schedules.holidays_note') }}</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="border-t pt-4">
                            <label class="flex items-start gap-3 @error('acepta_privacidad') text-red-600 @enderror">
                                <input
                                    type="checkbox"
                                    wire:model="acepta_privacidad"
                                    class="mt-1 w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500 @error('acepta_privacidad') border-red-500 @enderror"
                                >
                                <div>
                                    <span class="text-gray-900">
                                        {{ __('general.contact.privacy_notice') }}
                                        <a href="#" class="text-primary-600 hover:underline">{{ __('general.footer.privacy') }}</a>
                                        <span class="text-red-500">*</span>
                                    </span>
                                </div>
                            </label>
                            @error('acepta_privacidad') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>
                @endif

                {{-- Botones de navegación --}}
                <div class="flex justify-between mt-8 pt-6 border-t">
                    @if($paso > 1)
                        <button
                            type="button"
                            wire:click="pasoAnterior"
                            class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition"
                        >
                            {{ __('general.actions.previous') }}
                        </button>
                    @else
                        <div></div>
                    @endif

                    <button
                        type="submit"
                        class="btn-primary flex items-center gap-2"
                        wire:loading.attr="disabled"
                        wire:loading.class="opacity-50 cursor-not-allowed"
                    >
                        <span wire:loading.remove>
                            {{ $paso == $totalPasos ? __('general.actions.submit') : __('general.actions.next') }}
                        </span>
                        <span wire:loading>
                            {{ __('general.messages.loading') }}
                        </span>
                        @if($paso < $totalPasos)
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        @endif
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>
