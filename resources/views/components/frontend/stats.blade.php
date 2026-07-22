@props(['statistics'])

@if($statistics->count())
<section class="vb-section vb-section--dark" id="stats">
    <div class="vb-container">
        <div class="vb-stats" data-stagger>
            @foreach($statistics as $stat)
                <div class="vb-stat">
                    <div class="vb-stat__value">
                        <span data-count="{{ $stat->value }}" data-suffix="{{ $stat->suffix ?? '' }}">0{{ $stat->suffix ?? '' }}</span>
                    </div>
                    <div class="vb-stat__label">{{ $stat->label }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
