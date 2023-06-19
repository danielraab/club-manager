<x-backend-layout>
    <x-slot name="headline">
        <div class="flex justify-between items-center">
            <span>{{ __('Member Birthday list') }}</span>
        </div>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
        <x-always-responsive-table class="table-auto mx-auto text-center">
            <thead class="font-bold">
            <tr>
                <td class="px-4 py-2">Name</td>
                <td class="px-4 py-2">{{__("Birthday")}}</td>
                <td class="px-4 py-2">{{__("Age")}}</td>
            </tr>
            </thead>
            <tbody>
            @foreach($members as $member)
                <tr class="[&:nth-child(2n)]:bg-indigo-200">
                    <td class="border px-4 py-2">{{ $member->lastname }} {{ $member->firstname }}</td>
                    <td class="border px-4 py-2">{{ $member->birthday }}</td>
                    <td class="border px-4 py-2">{{ $member->email }}</td>
                </tr>
            @endforeach
            </tbody>
        </x-always-responsive-table>
    </div>


    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-5 p-5">
        <div class="flex flex-wrap gap-2 justify-start w-full sm:w-auto">
            <x-button-link class="bg-cyan-700 hover:bg-cyan-500 focus:bg-cyan-500 text-white" href="{{route('member.birthdayList')}}"
                              title="Show list of member birthdays">{{ __('Birthday list') }}</x-button-link>
            <x-button-link class="btn-primary normal-case" href="{{route('member.birthdayList.csv')}}"
                              title="Download birthday list as CSV file">{{ __('Birthday CSV') }}</x-button-link>
        </div>
    </div>
</x-backend-layout>
