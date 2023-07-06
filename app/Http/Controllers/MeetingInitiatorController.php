<?php

namespace App\Http\Controllers;

use App\Models\group;
use App\Models\groupuser;
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
/********* new **********/
    public function makegroup(Request $request){
        $GC= new GroupController();
        $GC->store($request);
    }

    public function adduserstogroup(Request $request){
        $GC= new GroupUserController();

        $data = $request->all();

        foreach ($data as $key => $value) {
            $newRequest= new Request();
            $newRequest->merge(['name'=>$value['name'],'email'=>$value['email'],'jobdescription'=>$value['jobdescription']]);
            $GC->store($newRequest);
        }
    }

    public function requestGroupforMeeting($initiatorid, $meetingid){
        $GC= new GroupController();
        $data= $GC->searchbyinitiator($initiatorid);
        $Invitation= new InvitationNotificationsController();
        $initiatorAdminstration = User::select('adminstration')->find($initiatorid);
        foreach ($data as $id){
            $request = new Request();
            $doctorAdminstration= User::select('adminstration')->find($id['id']);
            $fromOutside=1;
            if($initiatorAdminstration == $doctorAdminstration){
                $fromOutside= 0;
            }
            $request->merge(['doctorid'=>strval($id['id']),'meetingid'=>$meetingid, 'fromoutside'=>strval($fromOutside)]);
//            return $request;
            $Invitation->store($request);
        }

    }


    public function RequestDoctor(Request $request,$initiatorid){
        $Invitation= new InvitationNotificationsController();
        $initiatorAdminstration = User::select('adminstration')->find($initiatorid);
        $data = $request->all();


        if(count($data)>1)
        {
            foreach ($data as $key => $value) {
                $newrequest = new Request();
                $fromOutside=1;
                $doctorAdminstration= User::select('adminstration')->find($value['doctorid']);
                if($initiatorAdminstration == $doctorAdminstration){
                    $fromOutside= 0;
                }
                $newrequest->merge(['doctorid'=>strval($value['doctorid']),'meetingid'=>strval($value['meetingid']), 'fromoutside'=>strval($fromOutside)]);
//                return $newrequest;
                $Invitation->store($newrequest);
            }
        }
//        else if (count($data)==1){
//            $doctorAdminstration='';
//            $newrequest = new Request();
//            foreach ($data as $id){
//                $doctorAdminstration= User::select('adminstration')->find($id['doctorid']);
//                if($initiatorAdminstration == $doctorAdminstration){
//                    $fromOutside= 0;
//                }
//
//                $newrequest->merge(['doctorid'=>strval($id['doctorid']),'meetingid'=>strval($id['meetingid']), 'fromoutside' => strval(0)]);
//            }
////            return $newrequest;
//            $Invitation->store($newrequest);
//        }

    }

    public function RequestInvited(Request $request){
        $Invitation= new InvitationNotificationInvitedController();
//        $Invitation->store($request);
        $data = $request->all();

        if(count($data)>1){
            foreach ($data as $key => $value){
                $newRequest= new Request();
                $newRequest->merge(['invitedid'=>strval($value['invitedid']),'meetingid'=>strval($value['meetingid'])]);
                $Invitation->store($newRequest);
            }
        }
//        else if (count($data) == 1) {
//            $Invitation->store($request);
//        }

    }

    public function deletefromGroup($initiatorid, $userid){
        $groupid=group::select('id')->where('initiatorid',$initiatorid)->get();
        $GU= new GroupUserController();
        foreach ($groupid as $key =>$value){
            //return $value['id'];
            $newRequest = new Request();
            $newRequest->merge(['groupid'=>strval($value['id']),'doctorid'=>strval($userid)]);
            return $GU->destroyBYRequest($newRequest);
        }

    }

}

/*
 * ,
    {
    "invitedid":"2",
    "meetingid":"1"
    },
    {
        "invitedid":"3",
        "meetingid":"1"
    }
 */
/*
 * {
        "doctorid":"1",
        "meetingid":"1"
    },
    {
        "doctorid":"2",
        "meetingid":"1"
    }
 */
