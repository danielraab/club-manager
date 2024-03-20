<label for="{{$attributes->get('id')}}" class="inline-flex items-center">
    <x-input type="checkbox"
        {{ $attributes->merge(['class' => 'rounded text-indigo-600']) }} />
    <span class="ml-2 text-sm text-gray-600">{{$slot}}</span>
</label>
