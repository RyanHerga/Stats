<?php

namespace Modules\Stats\Models;

use App\Interfaces\Model;

/* We load these so that we can interact with the databases */
use App\Models\Aircraft as AircraftData;
use App\Models\Airport as AirportData;
use App\Models\Pirep as PirepData;
use App\Models\User as UserData;
use App\Models\Flight as ScheduleData;

class Statistics extends Model
{
    /* Get the Number of Aircrafts in the Database */
    public static function getNumOfAircrafts(){
        return AircraftData::count();
        /* Count() is a standard Model function that can be
           used to count rows */
    }

    public static function getTotalFlightTime(){
        return PirepData::sum('flight_time');
    }

    public static function getTotalFlights(){
        return PirepData::where('state', 2)->get()->count();
    }

    public static function getMostActivePilots(){
        return UserData::where('state', 1)->orderBy('flight_time', 'DESC')->limit(10)->get();
    }

    public static function getNumberOfPilots(){
        return UserData::where('state',1)->count();
    }

    public static function getNumOfSchedules(){
        return ScheduleData::count();
    }

    public static function getTotalDistanceFlown(){
        return PirepData::sum('distance');
    }

    public static function getMostUsedAircraft(){

    }

    public static function getLongestFlightFlown(){
        return PirepData::where('state', 2)->orderBy('flight_time', 'DESC')->limit(1)->get();
    }

    public static function getShortestFlightFlown(){
        return PirepData::where('state', 2)->orderBy('flight_time', 'ASC')->limit(1)->get();
    }

    public static function getFleet(){
        return AircraftData::select('name')->distinct()->get();
    }
}
