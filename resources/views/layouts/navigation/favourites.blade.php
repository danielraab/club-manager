
@if($hasShowPermission && $showBirthdayListConfig)
    <x-responsive-nav-link
        href="{{route('member.birthdayList')}}"
        iconClasses="fa-regular fa-star"
        title="Show list of member birthdays">
        {{ __('Birthday list') }}
    </x-responsive-nav-link>
@endif
