<?php

namespace Modules\Stats\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Stats\Models\Statistics as stats;


class StatsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [];
        $data['numOfAircrafts'] = stats::getNumOfAircrafts();
        $data['TotalFlightTime'] = stats::getTotalFlightTime();
        $data['TotalFlights'] = stats::getTotalFlights();
        $data['MostActivePilots'] = stats::getMostActivePilots();
        $data['NumberOfPilots'] = stats::getNumberOfPilots();
        $data['NumOfSchedules'] = stats::getNumOfSchedules();
        $data['TotalDistanceFlown'] = stats::getTotalDistanceFlown();
        $data['LongestFlightFlown'] = stats::getLongestFlightFlown();
        $data['ShortestFlightFlown'] = stats::getShortestFlightFlown();
        return view('stats::index', $data);
    }
}
