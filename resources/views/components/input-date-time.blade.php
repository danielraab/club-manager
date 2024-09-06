@props(['disabledTime' => false])

<div x-data="{
    myDateTime: '',
    get dateStr() { return this.myDateTime.split('T')[0] },
    set dateStr(date) { this.myDateTime = date+'T'+this.timeStr; },
    get timeStr() { return this.myDateTime.split('T')[1] },
    set timeStr(time) { this.myDateTime = this.dateStr+'T'+time; },
    onBlur() { $dispatch('blur'); }
}" x-modelable="myDateTime" {{ $attributes->except(['id', 'disabled'])->merge(['class'=> 'flex gap-2']) }}>

    <x-input type="date" x-model="dateStr"
             x-on:blur="onBlur" :attributes="$attributes->only(['id', 'disabled', 'required'])"/>
    <x-input-label>
        <x-input type="time" x-model="timeStr"
                 :id="'time-'.$attributes->only('id')"
                 x-on:blur="onBlur" :attributes="$attributes->only(['disabled', 'required'])"
                 :disabled="$disabledTime" />
    </x-input-label>
</div>
