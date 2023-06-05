<a title="{{__($attributes->get("title"))}}"
    {{ $attributes->merge(['class' => 'inline-flex items-center px-2 py-2 rounded-md font-semibold text-xs focus:ring-offset-2 focus:outline-none focus:ring-2 tracking-wide']) }}>
    {{ $slot }}
</a>
