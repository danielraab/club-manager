<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Ad Options') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Select the ad options for this package.") }}
        </p>
    </header>

    <div class="mt-6">
        <div>
            <x-input-label for="availableAdOptionArr" :value="__('available ad option')"/>
            <x-select id="availableAdOptionArr" name="availableAdOptionArr" multiple size="8"
                    wire:model="selectedAdOptionArr"
                    class=" block mt-1 w-full">
                @foreach($this->availableAdOptionArr as $id => $title)
                    <option value="{{$id}}">{{$title}}</option>
                @endforeach
            </x-select>
        </div>
    </div>
</section>
