<div class="overflow-x-auto min-w-full">
        <table {{ $attributes->merge([ 'class' => "min-w-full"]) }}>
            {{ $slot }}
        </table>
</div>
