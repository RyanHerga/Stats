@extends('stats::layouts.frontend')

@section('content')
    <h1>Statistics</h1>
   
    <div class="row">
        <div class="col-md-6 col-lg-6 col-sm-12">
            <h2>General Information</h2>
            
            <table class="table table-bordered">
            <tr>
                <th>Total Active Pilots</th>
                <td>{{  $NumberOfPilots }}</td>
            </tr>
            <tr>
                <th>Total Flights</th>
                <td>{{  $TotalFlights }}</td>
            </tr>
            <tr>
                <th>Number of Schedules</th>
                <td>{{  $NumOfSchedules }}</td>
            </tr>
            <tr>
                <th>Total Distance Flown</th>
                <td>{{  $TotalDistanceFlown }} nm</td>
            </tr>
            <tr>
                <th>Total Flight Time Flown</th>
                <td>{{  floor($TotalFlightTime/60) }}:{{ sprintf("%02d", $TotalFlightTime%60)  }} hrs</td>
            </tr>
            @if($LongestFlightFlown->first())
            <tr>
                <th>Longest Flight Flown</th>
                <td>
                    {{$LongestFlightFlown[0]->dpt_airport_id}} 
                    <i class="fas fa-plane"></i>
                    {{$LongestFlightFlown[0]->arr_airport_id}}
                    ({{  floor($LongestFlightFlown[0]->flight_time/60) }}:{{ sprintf("%02d", $LongestFlightFlown[0]->flight_time%60)  }} hrs) 
                    by  <a href="{{ route('frontend.profile.show.public', ['id' => $LongestFlightFlown[0]->user()->get()[0]->id]) }}">{{$LongestFlightFlown[0]->user()->get()[0]->name}}</a>
                 </td>
            </tr>
            @endif
            @if($ShortestFlightFlown->first())
            <tr>
                <th>Shortest Flight Flown</th>
                <td>
                    {{$ShortestFlightFlown[0]->dpt_airport_id}} 
                    <i class="fas fa-plane"></i>
                    {{$ShortestFlightFlown[0]->arr_airport_id}}
                    ({{  floor($ShortestFlightFlown[0]->flight_time/60) }}:{{ sprintf("%02d", $ShortestFlightFlown[0]->flight_time%60)  }} hrs) 
                    by  <a href="{{ route('frontend.profile.show.public', ['id' => $ShortestFlightFlown[0]->user()->get()[0]->id]) }}">{{$ShortestFlightFlown[0]->user()->get()[0]->name}}</a>
                 </td>
            </tr>
            @endif
            </table>
        </div>
        <div class="col-md-6 col-lg-6 col-sm-12">
            <h2>Most Active Pilots <small style="font-size:50%" class="description">By Flight Time</small></h2>
            <table class="table table-bordered">
                <tr>
                    <th>Name</th>
                    <th>Hub</th>
                    <td>Flight Time</td>
                    <td>Flights</td>
                </tr>
        @foreach($MostActivePilots as $pilot)
                <tr>
                    <td>
                    <a href="{{ route('frontend.profile.show.public', ['id' => $pilot->id]) }}">
                        {{$pilot->name}}
                    </a>
                        @if(filled($pilot->country))
                            <span class="flag-icon flag-icon-{{ $pilot->country }}"
                                title="{{ $pilot->country }}"></span>
                        @endif
                    </td>
                    <td>{{$pilot->home_airport_id}}</td>
                    <td>{{$pilot->flight_time/60}}:{{ sprintf("%02d", $pilot->flight_time%60)  }} hrs</td>
                    <td>{{$pilot->flights}}</td>
                </tr>
        @endforeach
            </table>
        </div>
    </div>
  
@endsection
