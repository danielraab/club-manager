@props(['disabledTime' => false])

<div x-data="{
    myDateTime: '',
    get dateStr() { return this.myDateTime.split('T')[0] },
    get timeStr() { return this.myDateTime.split('T')[1] },
    updateDate(date) { this.myDateTime = date+'T'+this.timeStr;},
    updateTime(time) { this.myDateTime = this.dateStr+'T'+time;},
    onBlur() { $dispatch('blur'); }
}" x-modelable="myDateTime" {{ $attributes->except('disabled')->merge(['class'=> 'flex gap-2']) }}>

    <x-input type="date" x-model="dateStr" x-on:change="updateDate($event.target.value)"
             x-on:blur="onBlur" :attributes="$attributes->only(['disabled', 'required'])"/>
    <x-input-label>
        <x-input type="time" x-model="timeStr" x-on:change="updateTime($event.target.value)"
                 x-on:blur="onBlur" :attributes="$attributes->only(['disabled', 'required'])"
                 :disabled="$disabledTime" />
    </x-input-label>
</div>
