<?php

namespace Eastwest\Larabear\Traits;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

trait CoreDataDate
{
    /**
     * CoreData stores dates as an absolute
     * reference date to 00:00:00 UTC on 1 January 2001
     * instead of 1 January 1970.
     * https://developer.apple.com/documentation/foundation/nsdate

     */
    public function convertToCarbon($coreDataDate)
    {
        try {
            return Carbon::createFromTimestampUTC($coreDataDate)
                ->addYear(31);
        } catch (\Exception $e) {
            Log::error($e);
            return;
        }
    }

    public function convertToCoreData($dateString)
    {
        try {
            return Carbon::parse($dateString)
                ->subYear(31)
                ->timestamp;
        } catch (\Exception $e) {
            Log::error($e);
            return;
        }
    }
}
