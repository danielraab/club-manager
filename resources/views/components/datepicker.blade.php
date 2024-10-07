@props([
    'id',
    'multiple' => false,
    'showList' => false,
    'markedDays' => [],
])
<div x-data="{
    dateList:[],
    markedDays: @js($markedDays),
    multiDate: @js($multiple),
    today: new Date((new Date()).getFullYear(), (new Date()).getMonth(), (new Date()).getDate()),
    currentMonthFirstDay: new Date((new Date()).getFullYear(), (new Date()).getMonth(), 1),
    currentMonthLastDay: new Date((new Date()).getFullYear(), (new Date()).getMonth()+1, 0),
    toggleDate(date) {
        const i = this.dateList.indexOf(date.toLocaleDateString());
        if(i > -1) {
            this.dateList.splice(i, 1);
        } else {
            if(!this.multiDate) {
                this.dateList = [];
            }
            this.dateList.push(date.toLocaleDateString());
        }
    },
    prevMonth() {
        this.currentMonthFirstDay = new Date(this.currentMonthFirstDay.getFullYear(), this.currentMonthFirstDay.getMonth() - 1, 1)
        this.currentMonthLastDay = new Date(this.currentMonthLastDay.getFullYear(), this.currentMonthLastDay.getMonth(), 0)
    },
    nextMonth() {
        this.currentMonthFirstDay = new Date(this.currentMonthFirstDay.getFullYear(), this.currentMonthFirstDay.getMonth() + 1, 1)
        this.currentMonthLastDay = new Date(this.currentMonthLastDay.getFullYear(), this.currentMonthLastDay.getMonth() + 2, 0)
    },
    getWeeks() {
        const weeks = [];
        let currentDay = new Date(this.currentMonthFirstDay);

        while(currentDay.getMonth() == this.currentMonthFirstDay.getMonth()) {
            let week = [];
            currentDay.setDate(currentDay.getDate() - (6 + currentDay.getDay()) % 7);

            while(week.length < 7) {
                week.push(currentDay);
                currentDay = new Date(currentDay);
                currentDay.setDate(currentDay.getDate() + 1);
            }
            weeks.push(week)
        }
        return weeks;
    }
}"
     x-init="markedDays = markedDays.map((dateStr) => {
     const date = new Date(dateStr);
     date.setHours(0,0,0,0);
     return date.getTime();
     })"
     x-modelable="dateList" {{ $attributes }}
     x-on:reset-date-list.window="$event.detail == '{{ $id }}' ? dateList = [] : null"
>
    <div class="border">
        <div class="border text-lg font-bold bg-gray-500 text-white flex">
            <button class="grow-0 py-2 px-4" type="button" x-on:click="prevMonth()"><</button>
            <div class="grow text-center p-2" colspan="5" x-text="new Intl.DateTimeFormat('{{config('app.locale')}}', {month:'long', year: 'numeric'}).format(currentMonthFirstDay)"></div>
            <button class="grow-0 py-2 px-4" type="button" x-on:click="nextMonth()">></button>
        </div>
        <template x-for="week in getWeeks()" :key="'week'+week[0].getTime()">
            <div class="grid grid-cols-7">
                <template x-for="day in week" :key="'day'+day.getTime()">
                    <div class="text-center"
                         :class="{
                             'border border-blue-500': day.getTime() === today.getTime(),
                             'bg-gray-200': day.getDay() === 6,
                             'bg-gray-300': day.getDay() === 0
                         }"
                        >
                        <button type="button" x-text="day?.getDate()"
                                class="h-10 w-10 rounded-full"
                                :class="{
                                    'border border-red-500': markedDays.includes(day.getTime()),
                                    'text-gray-500': day.getTime() < currentMonthFirstDay.getTime() || day.getTime() > currentMonthLastDay.getTime(),
                                    'bg-gray-500 text-white': dateList.includes(day.toLocaleDateString())
                                }"
                                x-on:click="toggleDate(day)"></button>
                    </div>
                </template>
            </div>
        </template>
    </div>
    @if($showList)
        <div class="m-3">
            <div x-show="dateList.length > 0" class="font-bold text-lg">{{__('selected dates:')}}</div>
            <ul x-show="dateList.length > 0" class="list-disc ml-6">
                <template x-for="date in dateList">
                    <li x-text="new Intl.DateTimeFormat('{{config('app.locale')}}', {
                        weekday:'short',
                        day:'numeric',
                        month:'short',
                        year:'numeric'
                    }).format(new Date(date))"></li>
                </template>
            </ul>
        </div>
    @endif
</div>
