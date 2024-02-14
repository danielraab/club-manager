<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Ad options') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Select the ad options for this package") }}
        </p>
    </header>

    <div class="mt-6">
        <div>
            <x-input-label for="availableAdOptionArr" :value="__('available ad option:')"/>
            <select id="eventSelectionList" name="eventSelectionList" multiple size="8"
                    wire:model="selectedAdOptionArr"
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                @foreach($this->availableAdOptionArr as $id => $title)
                    <option value="{{$id}}">{{$title}}</option>
                @endforeach
            </select>
        </div>
    </div>
</section>
