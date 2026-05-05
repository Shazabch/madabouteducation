@props(['messages'])

@if ($messages)
    <div {{ $attributes->merge(['class' => 'text-sm text-danger']) }}>
        @foreach ((array) $messages as $message)
            <small>{{ $message }}</small> @if(!$loop->last) <br> @endif
        @endforeach
    </div>
@endif
