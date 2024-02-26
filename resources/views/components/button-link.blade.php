<a title="{{__($attributes->get("title"))}}"
    {{ $attributes->merge(['class' => 'inline-flex items-center px-2 py-2 rounded-md font-semibold text-xs text-center focus:ring-offset-2 focus:outline-none focus:ring-2 hover:cursor-pointer tracking-wide disabled:opacity-75']) }}>
    {{ $slot }}
</a>
