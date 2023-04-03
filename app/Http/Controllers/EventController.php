<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Event::all()->sortByDesc("id");
        return view('event\index')->withData($data);
    }
    public function list()
    {
        $data = Event::get();
        return response()->json($data, 200);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('event\create');
        //dd($request->all()); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $event = new Event;
 
        $event->id_event = $request->id_event;
        $event->event_name = $request->eventname;
        $event->day_event = $request->eventday;
        $event->description = $request->eventdescription;
        $event->ubication = $request->eventdir;
        $event->place = $request->eventplace;
        $event->max_register = $request->eventmax;
        $event->register_begin = Carbon::createFromFormat('d/m/Y', $request->starlottery)->format('Y-m-d');
        $event->register_end = Carbon::createFromFormat('d/m/Y', $request->endlottery)->format('Y-m-d');
        $event->event_begin = Carbon::createFromFormat('d/m/Y', $request->starevent)->format('Y-m-d');
        $event->event_end = Carbon::createFromFormat('d/m/Y', $request->endevent)->format('Y-m-d');
        $event->hour = $request->hour;
 
        $event->save();
        return redirect()->action([EventController::class, 'index']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
