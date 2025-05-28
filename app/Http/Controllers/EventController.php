<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function events_on_map()
    {
        $events = Event::where('approval_status', 'approved')
            ->select('id', 'title', 'event_date', 'event_type', 'event_status', 'sector_id')
            ->with([
                'sector:id,name',
            ])
            ->get();
        return view('events_map', compact('events'));
    }
}