<button title="{{__($attributes->get("title"))}}"
    {{ $attributes->merge(['type' => 'submit',
'class' => 'inline-flex items-center px-2 py-2 rounded-md font-semibold text-xs text-center tracking-wide '.
'focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-75']) }}>
    {{ $slot }}
</button>
