@props(['items' => [], 'titulo' => 'Preguntas Frecuentes'])

@if(count($items) > 0)
<section class="py-16 bg-gray-50" itemscope itemtype="https://schema.org/FAQPage">
    <div class="container-main">
        <h2 class="font-serif text-3xl font-bold text-gray-900 mb-8 text-center">{{ $titulo }}</h2>

        <div class="max-w-3xl mx-auto space-y-4">
            @foreach($items as $item)
            <div class="card overflow-hidden" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                <details class="group">
                    <summary class="flex items-center justify-between p-6 cursor-pointer hover:bg-gray-50 transition-colors">
                        <h3 itemprop="name" class="font-semibold text-gray-900 pr-4">{{ $item['pregunta'] }}</h3>
                        <svg class="w-5 h-5 text-gray-500 shrink-0 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </summary>
                    <div class="px-6 pb-6" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                        <div itemprop="text" class="text-gray-600 prose prose-sm max-w-none">
                            {!! $item['respuesta'] !!}
                        </div>
                    </div>
                </details>
            </div>
            @endforeach
        </div>
    </div>
</section>

@push('schema')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "FAQPage",
    "mainEntity": [
        @foreach($items as $index => $item)
        {
            "@@type": "Question",
            "name": "{{ $item['pregunta'] }}",
            "acceptedAnswer": {
                "@@type": "Answer",
                "text": "{{ strip_tags($item['respuesta']) }}"
            }
        }@if(!$loop->last),@endif
        @endforeach
    ]
}
</script>
@endpush
@endif
