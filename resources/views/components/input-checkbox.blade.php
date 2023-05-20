@props(['disabled' => false])

<label for="{{$attributes->get('id')}}" class="inline-flex items-center">
    <input {{ $disabled ? 'disabled' : '' }} type="checkbox"
        {!! $attributes->merge(['class' => 'rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500']) !!} />
    <span class="ml-2 text-sm text-gray-600">{{$slot}}</span>
</label>
