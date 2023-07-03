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
        return meeting::find($id);

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

    public function updatePrev($id){
        meeting::where([['initiatorid',$id],['islast',-1]])->update(['islast'=>'0']);
    }
    public function updatelastofInitiator($id){

        meeting::where([['initiatorid',$id],['islast',1]])->update(['islast'=>'-1']);
    }
    public function getlastofInitiator($id){

        $filter = meeting::where([['initiatorid',$id],['islast',1]])->get();
        return $filter;
    }

    public function getUpcomingMeetings(){
        $NowDT = Carbon::now()->toDateString();
        return meeting::where('date', '>', $NowDT)->get();
    }

    public function getPrevious($id){
        return meeting::where([
            ['initiatorid',$id],
            ['islast',-1]
        ])->get();
    }

    public function isLast($id){
        $me= meeting::find($id);
        if ($me->islast==1){
            return true;
        }
        return false;
    }

    public function isPrevious($id){
        $me= meeting::find($id);
        if ($me->islast==-1){
            return true;
        }
        return false;
    }

    public function isDone($id){
        $me= meeting::find($id);
        $NowDT = Carbon::now()->toDateString();
        if ($me->date > $NowDT){
            return true;
        }
        return false;
    }
    public function showInitiator($Id){
        return meeting::where(['meetingid',$Id])->select('initiatorid');
    }
}
