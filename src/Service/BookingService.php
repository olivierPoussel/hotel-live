<?php

namespace App\Service;

use App\Entity\Booking;
use DateInterval;
use DatePeriod;

class BookingService {

    /**
     * getBookingsRangeDates
     *
     * @param Booking[] $bookings
     * 
     * @return string[]
     */
    public function getBookingsRangeDates($bookings)
    {
        $dates = [];
        /** @var Booking */
        foreach ($bookings as $booking) {
            $startDate = $booking->getStartDate();
            $endDate = $booking->getEndDate();
            $interval = new DateInterval('P1D'); 
            $endDate->add($interval);
            $period = new DatePeriod($startDate, $interval, $endDate); 
            // $nbJour = $endDate->diff($startDate)->days;
            foreach ($period as $date) {
                $dates[] = $date->format('d/m/Y');
            }
        }

        return $dates;
    }
}
