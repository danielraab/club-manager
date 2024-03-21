<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Packages') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Select the packages for this period.") }}
        </p>
    </header>

    <div class="mt-6">
        <div>
            <x-input-label for="availablePackageArr" :value="__('available packages:')"/>
            <x-select id="availablePackageArr" name="availablePackageArr" multiple size="8"
                    wire:model="selectedPackageArr"
                    class="block mt-1 w-full">
                @foreach($this->availablePackageArr as $id => $title)
                    <option value="{{$id}}">{{$title}}</option>
                @endforeach
            </x-select>
        </div>
    </div>
</section>
