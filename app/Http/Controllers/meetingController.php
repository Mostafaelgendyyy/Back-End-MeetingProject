<?php

namespace App\Http\Controllers;

use App\Models\meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class meetingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
//        $this->validate([
//            'initiatorid'=> 'required',
//            'location'=> 'required',
//            'date'=> 'required',
//            'topic'=> 'required'
//        ]);

        $Meeting = new meeting([
            'initiatorid' => $request->get('initiatorid'),
            'location'=> $request->get('location'),
            'date'=> $request->get('date'),
            'topic'=> $request->get('topic'),
            'islast'=>'1'
        ]);
        $Meeting->save();
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
        $Meeting=meeting::find($id);
        dd($Meeting);
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
//        $this->validate([
//            'initiatorid'=> 'required',
//            'location'=> 'required',
//            'date'=> 'required',
//            'topic'=> 'required'
//        ]);
        $Meeting = meeting::find($id);

        $Meeting->initiatorid = $request->get('initiatorid');
        $Meeting->location = $request->get('location');
        $Meeting->date = $request->get('date');
        $Meeting->topic = $request->get('topic');
        $Meeting->save();
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
        $Meeting=meeting::find($id);
        $Meeting->delete();
    }

    public function updatelastofInitiator($id){

        meeting::where([['initiatorid',$id],['islast',1]])->update(['islast'=>'0']);
    }
    public function getlastofInitiator($id){

        $filter = meeting::where([['initiatorid',$id],['islast',1]])->get();
        return $filter;
    }

    public function getUpcomingMeetings(){
        $NowDT = Carbon::now()->toDateString();
        return meeting::where('date', '>', $NowDT)->get();
    }


}
