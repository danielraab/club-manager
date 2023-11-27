import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import deLocale from '@fullcalendar/core/locales/de';

document.Calendar = Calendar;
document.dayGridPlugin = dayGridPlugin;
document.timeGridPlugin = timeGridPlugin;
document.listPlugin = listPlugin;
document.deLocale = deLocale;
