@props(['active'])

@php
    $classes = 'block w-full pl-3 pr-4 py-2 text-left text-base font-medium ' . (($active ?? false)
                ? 'text-indigo-700 bg-indigo-50 focus:outline-none focus:text-indigo-800 focus:bg-indigo-100 transition duration-150 ease-in-out'
                : 'text-gray-600 hover:text-gray-800 hover:bg-gray-50 focus:outline-none focus:text-gray-800 focus:bg-gray-50 transition duration-150 ease-in-out');
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    @if($attributes->has('iconClasses'))
        <i class="w-6 text-center {{$attributes->get('iconClasses')}}"></i>
    @endif
    {{ $slot }}
</a>
