<?php

namespace App\Utils;

use Carbon\Carbon;

trait WithReadableDates {

    function formatTimestamp($timestamp) {
        // Parse the timestamp using Carbon
        $date = Carbon::parse($timestamp);

        // Check if the year is different from the current year
        if ($date->year !== Carbon::now()->year) {
            // Return the date in 'd M Y' format for different year
            return $date->format('d M Y');
        }

        // If it's the same year, return a human-readable "ago" format
        return $date->diffForHumans();
    }
}