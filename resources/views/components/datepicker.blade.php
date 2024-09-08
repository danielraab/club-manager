@props([
    'id'
])
<div x-data="{
    dateList:[],
    today: new Date((new Date()).getFullYear(), (new Date()).getMonth(), (new Date()).getDate()),
    currentMonthFirsts: new Date((new Date()).getFullYear(), (new Date()).getMonth(), 1),
    currentMonthLasts: new Date((new Date()).getFullYear(), (new Date()).getMonth()+1, 0),
    toggleDate(date) {
        const i = this.dateList.indexOf(date.getTime())
        if(i > -1) {
            this.dateList.splice(i, 1);
        } else {
            this.dateList.push(date.getTime());
        }
    },
    prevMonth() {
        this.currentMonthFirsts = new Date(this.currentMonthFirsts.getFullYear(), this.currentMonthFirsts.getMonth() - 1, 1)
        this.currentMonthLasts = new Date(this.currentMonthLasts.getFullYear(), this.currentMonthLasts.getMonth(), 0)
    },
    nextMonth() {
        this.currentMonthFirsts = new Date(this.currentMonthFirsts.getFullYear(), this.currentMonthFirsts.getMonth() + 1, 1)
        this.currentMonthLasts = new Date(this.currentMonthLasts.getFullYear(), this.currentMonthLasts.getMonth() + 2, 0)
    },
    getWeeks() {
        const weeks = [];
        let currentDay = new Date(this.currentMonthFirsts);

        while(currentDay.getMonth() == this.currentMonthFirsts.getMonth()) {
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
}" x-modelable="dateList"
     x-on:reset-date-list.window="$event.detail == '{{ $id }}' ? dateList = [] : null"
>
    <div class="border">
        <div class="border text-lg font-bold bg-gray-500 text-white flex">
            <button class="grow-0 p-2" type="button" x-on:click="prevMonth()"><</button>
            <div class="grow text-center p-2" colspan="5" x-text="new Intl.DateTimeFormat('{{config('app.locale')}}', {month:'long', year: 'numeric'}).format(currentMonthFirsts)"></div>
            <button class="grow-0 p-2" type="button" x-on:click="nextMonth()">></button>
        </div>
        <template x-for="week in getWeeks()" :key="'week'+week[0].getTime()">
            <div class="grid grid-cols-7">
                <template x-for="day in week" :key="'day'+day.getTime()">
                    <div class="text-center"
                         :class="{
                             'bg-gray-200': day.getDay() === 6,
                             'bg-gray-300': day.getDay() === 0,
                             'border bg-blue-500': day.getTime() === today.getTime()
                         }"
                        >
                        <button type="button" x-text="day?.getDate()"
                                class="h-10 w-10"
                                :class="{
                                    'text-gray-500': day.getTime() < currentMonthFirsts.getTime() || day.getTime() > currentMonthLasts.getTime(),
                                    'bg-gray-500 text-white rounded-full': dateList.includes(day.getTime())
                                }"
                                x-on:click="toggleDate(day)"></button>
                    </div>
                </template>
            </div>
        </template>
    </div>
</div>
