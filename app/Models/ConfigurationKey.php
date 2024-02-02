<?php

namespace App\Models;

enum ConfigurationKey: string
{
    /*
     * global settings
     */
    case EVENT_FILTER_DEFAULT_START_TODAY = "eventFilter_defaultStartToday";
    case EVENT_FILTER_DEFAULT_START_DATE = "eventFilter_defaultStartDate";
    case EVENT_FILTER_DEFAULT_END_DATE = "eventFilter_defaultEndDate";
    case POLL_PUBLIC_FILTER_BEFORE_ENTRANCE = "publicPoll_beforeEntrance";
    case POLL_PUBLIC_FILTER_AFTER_RETIRED = "publicPoll_afterRetired";
    case POLL_PUBLIC_FILTER_SHOW_PAUSED = "publicPoll_showPaused";



    /*
     * user settings
     */
    case DASHBOARD_BTN_BIRTHDAY_LIST = "dashboardButtons_birthdayList";
    case DASHBOARD_BTN_IMPORT_MEMBERS = "dashboardButtons_importMembers";

}
