<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-green']) }}>
    {{ $slot }}
</button>
