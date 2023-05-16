<div class="overflow-x-auto">
        <div class="min-w-full">
            <div class="overflow-x-auto p-1">
                <table {{ $attributes->merge([ 'class' => "min-w-full"]) }}>
                    {{ $slot }}
                </table>
            </div>
    </div>
</div>
