<?php

namespace Eastwest\Larabear\Traits;

use Illuminate\Support\Carbon;

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
        return Carbon::createFromTimestampUTC($coreDataDate)
                ->addYear(31);
    }

    public function convertToCoreData($dateString)
    {
        return Carbon::parse($dateString)
                ->subYear(31)
                ->timestamp;
    }
}
