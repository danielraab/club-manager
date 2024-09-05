<div class="relative mt-2 rounded-md shadow-sm">
    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
        <span class="text-gray-500 sm:text-sm">{{\App\Facade\Currency::getCurrencySymbol()}}</span>
    </div>

    <x-input type="number" placeholder="0.00"
        {{ $attributes->merge(['class' => 'pl-8']) }} />
</div>
