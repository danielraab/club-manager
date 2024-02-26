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
            <select id="availablePackageArr" name="availablePackageArr" multiple size="8"
                    wire:model="selectedPackageArr"
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                @foreach($this->availablePackageArr as $id => $title)
                    <option value="{{$id}}">{{$title}}</option>
                @endforeach
            </select>
        </div>
    </div>
</section>
