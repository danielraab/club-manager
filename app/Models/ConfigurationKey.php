<?php

namespace App\Models;

enum ConfigurationKey: string
{
    /*
     * global settings
     */
    case EVENT_FILTER_DEFAULT_START_DATE = "eventFilter_defaultStartDate";
    case EVENT_FILTER_DEFAULT_END_DATE = "eventFilter_defaultEndDate";



    /*
     * user settings
     */
    case DASHBOARD_BTN_BIRTHDAY_LIST = "dashboardButtons_birthdayList";
    case DASHBOARD_BTN_IMPORT_MEMBERS = "dashboardButtons_importMembers";

}
