<div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-5 p-5 ">
        <section>
            <header>
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Field mapping') }}
                </h2>

                <p class="mt-1 text^-sm text-gray-600">
                    {{ __("Assign the available CSV Columns to the Member fields.") }}
                </p>
            </header>

            <div class="flex flex-wrap flex-row justify-around gap-3 mt-5">
                @foreach(\App\Models\Import\ImportedMember::ATTRIBUTE_LABEL_ARRAY as $field => $fieldLabel)
                    <div>
                        <x-input-label :for="$field" :value="__($fieldLabel)"/>
                        <select id="{{$field}}" name="{{$field}}" class="mt-2"
                                wire:model.defer="fieldMap.{{$field}}">
                            <option></option>
                            @foreach($csvColumns as $idx => $column)
                                <option value="{{$idx}}">{{$column}}</option>
                            @endforeach
                        </select>
                    </div>
                @endforeach
            </div>
            <div class="flex flex-row-reverse mt-5">
                <x-default-button class="btn-primary" wire:click="showSyncOverview"
                                  title="Show sync overview">{{ __('Show sync overview') }}</x-default-button>
            </div>
        </section>
    </div>

    @if(!empty($importedMemberList))
        <livewire:members.import.sync-overview :importedMemberList="$importedMemberList"
                                               :key="$importedMemberListHash"/>
    @endif
</div>
