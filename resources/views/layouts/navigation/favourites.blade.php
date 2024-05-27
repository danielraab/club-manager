<?php
    /** @var $user \App\Models\User */
    $user = auth()->user();
    $hasMemberShowPermission = (bool)$user?->hasPermission(\App\Models\Member::MEMBER_SHOW_PERMISSION);
    $showBirthdayListConfig = \App\Models\Configuration::getBool(\App\Models\ConfigurationKey::NAVIGATION_FAV_BIRTHDAY_LIST, $user, true);
    $showCustomLinkConfig = \App\Models\Configuration::getBool(\App\Models\ConfigurationKey::NAVIGATION_FAV_CUSTOM_LINK_ENABLED, $user, false);
    $customLinkName = null;
    $customLink = null;
    if($showCustomLinkConfig) {
        $customLink = \App\Models\Configuration::getString(\App\Models\ConfigurationKey::NAVIGATION_FAV_CUSTOM_LINK, $user, '');
        $customLinkName = \App\Models\Configuration::getString(\App\Models\ConfigurationKey::NAVIGATION_FAV_CUSTOM_LINK_NAME, $user, '');
    }
?>
@if($showCustomLinkConfig && $customLink && $customLinkName)
    <x-responsive-nav-link
        href="{{$customLink}}"
        iconClasses="fa-regular fa-star"
        title="Custom favourite link">
        {{ $customLinkName }}
    </x-responsive-nav-link>
@endif
@if($hasMemberShowPermission && $showBirthdayListConfig)
    <x-responsive-nav-link
        href="{{route('member.birthdayList')}}"
        iconClasses="fa-regular fa-star"
        title="Show list of member birthdays">
        {{ __('Birthday list') }}
    </x-responsive-nav-link>
@endif
