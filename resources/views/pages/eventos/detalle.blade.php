@extends('layouts.app')

@section('title', 'Evento | ' . __('general.site.short_name'))

@section('content')
    <section class="py-16">
        <div class="container-main">
            <p class="text-gray-600">Detalle de evento: {{ $slug }}</p>
        </div>
    </section>
@endsection
