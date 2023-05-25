<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;

use function PHPSTORM_META\type;

class ExsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // set current timezone to Asia/Kuala_Lumpur
        date_default_timezone_set('Asia/Kuala_Lumpur');

        $now    = date('Y-m-d H:i:s');
        $timeIn = new DateTime('2023-05-25 20:00:00');
        $timeOut = new DateTime('2023-05-25 23:40:00');

        $duration = $timeIn->diff($timeOut);

        $type = 'Weekday';
        $amount = 0;
        $subsamount = 0;
        $calcMinutes = 0;

        // exit within 15 minutes
        if (!empty($duration->i) && empty($duration->h)) {
            $minutes = $duration->i;

            if ($minutes <= 15) {
                $amount = 0;
                $subsamount = 0;
            }
        }

        // exit after 15 minutes
        if ($type == 'Weekday') {
            if (!empty($duration->h) || !empty($duration->i)) {
                $hours = $duration->h;
                $minutes = $duration->i;

                // first 3 hours + RM1.5 per hour even though it is not a full hour
                if ($hours <= 3) {
                    $amount = ($hours * 3) + 1.5;
                }
                else {
                    // more than 3 hours
                    $amount = 3 * 3;

                    if (!empty($minutes) && ($minutes > 0 && $minutes < 60)) {
                        $calcMinutes = 1.5;
                    }

                    $left = $hours - 3;
                    $subsamount = ($left * 1.5) + $calcMinutes;
                }
            }
        }
        else {
            if (!empty($duration->h) || !empty($duration->i)) {
                $hours = $duration->h;
                $minutes = $duration->i;

                // first 3 hours + RM2 per hour even though it is not a full hour
                if ($hours <= 3) {
                    $amount = ($hours * 5) + 2;
                }
                else {
                    $amount = 3 * 5;

                    if (!empty($minutes) && ($minutes > 0 && $minutes < 60)) {
                        $calcMinutes = 2;
                    }

                    $left = $hours - 3;
                    $subsamount = ($left * 2) + $calcMinutes;
                }
            }
        }

        // calculation parking fees
        $totalAmount = $amount + $subsamount;

        // maximum parking fees
        if ($type == 'Weekday' && $totalAmount > 20) {
            $finalTotalAmount = 20;
        }
        else if ($type == 'Weekend' && $totalAmount > 40) {
            $finalTotalAmount = 40;
        }
        else {
            $finalTotalAmount = $totalAmount;
        }

        // grace period
        $gracePeriod = $timeOut->modify('+5 minutes');
        $strGracePeriod = $gracePeriod->format('Y-m-d H:i:s');

        if ($now > $strGracePeriod) {
            $message = 'You have exceeded the grace period!';
        } else {
            $message = null;
        }

        return view('index', [
            'totalAmount' => $totalAmount,
            'finalTotalAmount' => $finalTotalAmount,
            'message' => $message,
            'timeIn' => $timeIn->format('Y-m-d H:i:s'),
            'timeOut' => $timeOut->format('Y-m-d H:i:s'),
            'duration' => $duration,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
