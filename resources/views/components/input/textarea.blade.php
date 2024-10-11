@props([
    'disabled' => false,
    'required' => false,
    'label' => false,
    'errorBag' => ''
])

@if($label)
    <label for="{{$attributes->get('id')}}" class="block font-medium text-sm text-gray-700">
        {{ $label }}{{ $required ? '*' : '' }}
    </label>
@endif
<textarea {{ $disabled ? 'disabled' : '' }}
    {!! $attributes->merge(['class' => 'mt-1 block border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) !!}>
</textarea>
@error($errorBag)
    <x-input-error class="mt-2" :messages="$message"/>
@enderror
