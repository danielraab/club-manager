<div class="flex flex-col overflow-x-auto">
        <div class="inline-block min-w-full">
            <div class="overflow-x-auto">
                <table {{ $attributes->merge([ 'class' => "min-w-full text-left text-sm font-light"]) }}>
                    {{ $slot }}
                </table>
            </div>
    </div>
</div>
