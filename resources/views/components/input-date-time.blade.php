<div x-data="{
    myDateTime: '',
    get dateStr() { return this.myDateTime.split('T')[0] },
    get timeStr() { return this.myDateTime.split('T')[1] },
    updateDate(date) { this.myDateTime = date+'T'+this.timeStr;},
    updateTime(time) { this.myDateTime = this.dateStr+'T'+time;}
}" x-modelable="myDateTime" {{ $attributes->except('disabled') }}
     class="flex gap-2">

    <x-input type="date" placeholder="0.00" x-model="dateStr" x-on:change="updateDate($event.target.value)"
             :attributes="$attributes->only('disabled')"/>
    <x-input-label>
        <x-input type="time" placeholder="0.00" x-model="timeStr" x-on:change="updateTime($event.target.value)"
                 :attributes="$attributes->only('disabled')"/>
    </x-input-label>
</div>
