<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;

class ExsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $now = date('Y-m-d H:i:s');
        $timeIn = new DateTime('2023-05-24 17:16:00');
        $timeOut = new DateTime('2023-05-24 21:27:00');

        $duration = $timeIn->diff($timeOut);

        $type = 'Weekend';

        // dd($duration);

        if (!empty($duration->i)) {
            $minutes = $duration->i;

            if ($minutes <= 15) {
                $amount = 0;
                $subsamount = 0;
            }
        }

        if ($type == 'Weekday') {
            if (!empty($duration->h)) {
                $hours = $duration->h;

                // first 3 hours
                if ($hours <= 3) {
                    $amount = $hours * 3;
                }
                else {
                    // more than 3 hours
                    $amount = 3 * 3;

                    $left = $hours - 3;
                    $subsamount = $left * 1.5;
                }
            }
        }
        else {
            if (!empty($duration->h)) {
                $hours = $duration->h;

                if ($hours <= 3) {
                    $amount = $hours * 5;
                }
                else {
                    $amount = 3 * 5;

                    $left = $hours - 3;
                    $subsamount = $left * 2;
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

        return view('index', [
            'totalAmount' => $totalAmount,
            'finalTotalAmount' => $finalTotalAmount,
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
