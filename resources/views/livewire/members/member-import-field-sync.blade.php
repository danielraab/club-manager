
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-5 p-5 ">
        <section>
            <header>
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Field mapping') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    {{ __("Assign the available CSV Columns to the Member fields.") }}
                </p>
            </header>

            @if($columnArray)
                <div class="flex flex-wrap flex-row justify-around gap-3 mt-5">
                    @foreach([
        "firstname"=>"Firstname",
        "lastname"=>"Lastname",
        "external_id" => "External Id",
        "title_pre" => "Prefixed Title",
        "title_post" => "Postfixed Title",
        "street" => "Street",
        "zip" => "ZIP",
        "city" => "City",
        "phone" => "Phone number",
        "email" => "Email",
        "birthday" => "Birthday"
        ]
          as $field => $fieldLabel)
                        <div>
                            <x-input-label :for="$field" :value="__($fieldLabel)"/>
                            <select :id="$field" :name="$field" class="mt-2">
                                <option></option>
                                @foreach($columnArray as $column)
                                    <option value="{{$column}}">{{$column}}</option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach
                </div>
                <div class="flex justify-end mt-5">

                    <x-default-button class="btn-danger" wire:click="import"
                                      title="Import file">{{ __('import file') }}</x-default-button>
                </div>
            @endif
        </section>
    </div>
