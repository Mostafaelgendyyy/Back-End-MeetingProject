<?php

namespace App\Http\Controllers;

use App\Models\InvitationNotifications;
use App\Models\meeting;
use App\Models\User;
use Illuminate\Http\Request;

class MeetingInitiatorController extends doctorController
{
    //
    public function index()
    {
        return view('Initiator');
    }
    public function store(Request $request)
    {
//        $this->validate($request,
//            [
//                'name' =>'required',
//                'email' =>'required',
//                'password' =>'required',
//                'adminstration' =>'required',
//            ]);
        $Doctor = new User([
            'adminstration' =>$request->get('adminstration'),
            'email' =>$request->get('email'),
            'password' =>$request->get('password'),
            'role' =>'3',
            'name' =>$request->get('name')]);
        $Doctor->save();
        ///////Return ROUTING SUCCESSSS
    }

    public function show($id)
    {
        $Doctor= User::find($id);
        if ($Doctor->role!=3)
        {
            return "No Doctor with this ID";
        }

    }
    public function showbyEmail($EMail)
    {
        $Doctor= User::where('email',$EMail);
        dd($Doctor);
    }

    public function update(Request $request, $id)
    {
//        $this->validate($request,
//            ['adminid'=>'required',
//                'name' =>'required',
//                'email' =>'required',
//                'password' =>'required',
//                'department' =>'required',
//                'isinitiator'=>'required'
//            ]);
        $Doctor = User::find($id);
        if ($Doctor->role=="3")
        {
            $Doctor->name =$request->get('name');
            $Doctor->email =$request->get('email');
            $Doctor->password =$request->get('password');
            $Doctor->adminstration =$request->get('adminstration');
            $Doctor->save();
        }
        // ROUTINGGGGGGGGGG
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $Doctor = User:: find($id);
        if ($Doctor->role=="3")
        {
            $Doctor->delete();
        }
        else{
            return 'cannot delete this User';
        }

        // ROUTING
    }

    ///////////////////////////////////     CLASS DIAGRAM Initiator FUNCTIONALITYYY

    public function createMeeting(Request $request){
        $Initiatorid = $request->get('initiatorid');
        $MC= new meetingController();
        $last =$MC->getlastofInitiator($Initiatorid);
        $MC->updatePrev($Initiatorid);
        $MC->updatelastofInitiator($Initiatorid);
        $MC->store($request);
        return $last;
    }

    public function createContainer(Request $request){
        $CC= new containerController();
        $CC->store($request);
    }
    public function RequestDoctor(Request $request){
        $Invitation= new InvitationNotificationsController();
        $Invitation->store($request);
    }

    public function AddSubjecttoContainer(Request $request){
        $CS= new containerSubjectController();
        $CS->store($request);
    }

    public function RemoveSubjectFromContainer($id){
        $CS= new containerSubjectController();
        $CS->destroy($id);
    }

    public function deleteContainer($id){
        $CC= new containerController();
        $CC->destroy($id);
    }

    public function deleteMeeting($id){
        $MC= new meetingController();
        $MC->destroy($id);
    }

    public function UpdateProfile(Request $request,$Id){
        $user= new UserController();
        $user->update($request,$Id);
    }

    public function ChangePassword(Request $request,$Id){
        $user= new UserController();
        $user->update($request,$Id);
    }

    public function addAttendee(Request $request){
        $INV = new InvitationNotificationsController();
        $INV->putAttendance($request);
    }

    public function addAbsent(Request $request){
        $INV = new InvitationNotificationsController();
        $INV->putAbsent($request);
    }

    public function getPreviousMeeting($id){
        $MC= new meetingController();
        return $MC->getPrevious($id);
    }




}
