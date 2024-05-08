<?php

namespace App\Models;

enum ConfigurationKey: string
{
    /*
     * global settings
     */
    case APPEARANCE_APP_NAME = 'appearance_app_name';
    case APPEARANCE_APP_LOGO_ID = 'appearance_app_logo_id';
    case IMPRINT_TEXT = 'imprint_text';
    case PRIVACY_POLICY_TEXT = 'privacy_policy_text';
    case DEVELOPMENT_PAGE_AVAILABLE = 'is_dev_page_available';
    case GUEST_LAYOUT_TEXT = 'guest_layout_text';
    case EVENT_FILTER_DEFAULT_START_TODAY = 'eventFilter_defaultStartToday';
    case EVENT_FILTER_DEFAULT_START_DATE = 'eventFilter_defaultStartDate';
    case EVENT_FILTER_DEFAULT_END_DATE = 'eventFilter_defaultEndDate';
    case EVENT_BIRTHDAYS_IN_ICS_EXPORT = 'eventFilter_birthdaysInIcsExport';
    case POLL_PUBLIC_FILTER_BEFORE_ENTRANCE = 'publicPoll_beforeEntrance';
    case POLL_PUBLIC_FILTER_AFTER_RETIRED = 'publicPoll_afterRetired';
    case POLL_PUBLIC_FILTER_SHOW_PAUSED = 'publicPoll_showPaused';

    /*
     * user settings
     */
    case NAVIGATION_FAV_BIRTHDAY_LIST = 'dashboardButtons_birthdayList';
    case NAVIGATION_FAV_CUSTOM_LINK_ENABLED = 'favourite_customLinkEnabled';
    case NAVIGATION_FAV_CUSTOM_LINK_NAME = 'favourite_customLinkName';
    case NAVIGATION_FAV_CUSTOM_LINK = 'favourite_customLink';

    case MEMBER_FILTER_SHOW_BEFORE_ENTRANCE = 'memberFilterShowBeforeEntrance';
    case MEMBER_FILTER_SHOW_AFTER_RETIRED = 'memberFilterShowAfterRetired';
    case MEMBER_FILTER_SHOW_PAUSED = 'memberFilterShowPaused';
    case MEMBER_FILTER_GROUP_ID = 'memberFilterGroupId';
}
