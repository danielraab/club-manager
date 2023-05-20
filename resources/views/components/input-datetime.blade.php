@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} type="datetime-local"
    {!! $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) !!}>
