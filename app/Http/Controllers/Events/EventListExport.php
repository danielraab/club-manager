<?php

namespace App\Http\Controllers\Events;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Filter\EventFilter;
use Illuminate\Support\Facades\Response;

class EventListExport extends Controller
{
    const CSV_SEPARATOR = ',';

    public function excel()
    {
        return Response::stream(function () {
            $yes = __("yes");
            $no = __("no");

            $sheetName = 'eventList';

            $header = [
                __('Enabled') => 'string',
                __('Logged in only') => 'string',
                __('Name') => 'string',
                __('Start') => 'datetime',
                __('End') => 'datetime',
                __('Whole day') => 'string',
                __('Duration [min]') => 'integer',
                __('Location') => 'string',
                __('Dress code') => 'string',
                __('Type') => 'string',
            ];
            $writer = new \XLSXWriter();

            $writer->writeSheetHeader($sheetName, $header);
            foreach (Event::getAllFiltered(EventFilter::getEventFilterFromRequest())->get() as $event) {
                /** @var Event $event */
                $writer->writeSheetRow($sheetName, [
                    $event->enabled ? $yes : $no,
                    $event->logged_in_only ? $yes : $no,
                    $event->title,
                    $event->whole_day ?
                        $event->start->setTimezone(config('app.displayed_timezone'))->format('Y-m-d') :
                        $event->start->setTimezone(config('app.displayed_timezone'))->format('Y-m-d H:i:s'),
                    $event->whole_day ?
                        $event->end->setTimezone(config('app.displayed_timezone'))->format('Y-m-d') :
                        $event->end->setTimezone(config('app.displayed_timezone'))->format('Y-m-d H:i:s'),
                    $event->whole_day ? $yes : $no,
                    $event->whole_day ? "" : $event->end->diffInMinutes($event->start),
                    $event->location,
                    $event->dress_code,
                    $event->eventType?->title
                ]);
            }

            $writer->writeToStdOut();
        }, 200, [
            'Content-Type' => 'text/xlsx',
            'Content-Disposition' => 'attachment; filename="eventList.xlsx"',
        ]);
    }

    public function csv()
    {
        return Response::stream(function () {
            $yes = __("yes");
            $no = __("no");
            $file = fopen('php://output', 'w');
            fwrite($file, 'sep='.self::CSV_SEPARATOR."\n");
            fputcsv($file, [
                __('Enabled'),
                __('Logged in only'),
                __('Name'),
                __('Start'),
                __('End'),
                __('Whole day'),
                __('Duration [min]'),
                __('Location'),
                __('Dress code'),
                __('Type'),
                ], self::CSV_SEPARATOR);

            foreach (Event::getAllFiltered(EventFilter::getEventFilterFromRequest())->get() as $event) {
                /** @var Event $event */
                fputcsv($file, [
                    $event->enabled ? $yes : $no,
                    $event->logged_in_only ? $yes : $no,
                    $event->title,
                    $event->whole_day ? $event->start->formatDateOnly() : $event->start->formatDateTimeWithSec(),
                    $event->whole_day ? $event->end->formatDateOnly() : $event->end->formatDateTimeWithSec(),
                    $event->whole_day ? $yes : $no,
                    $event->whole_day ? "" : $event->end->diffInMinutes($event->start),
                    $event->location,
                    $event->dress_code,
                    $event->eventType?->title
                ], self::CSV_SEPARATOR);
            }
            fclose($file);
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="eventList.csv"',
        ]);
    }


}
