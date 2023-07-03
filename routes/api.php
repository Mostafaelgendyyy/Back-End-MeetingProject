<?php

use App\Http\Controllers\InvitationNotificationsController;
use App\Http\Controllers\meetingController;
use App\Http\Controllers\subjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\adminController;
use App\Http\Controllers\MeetingInitiatorController;
use App\Http\Controllers\subjectControllerController;
use App\Http\Controllers\doctorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\containerSubjectController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('Auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


/****************** ADMIN *****************/

Route::prefix('admin')->middleware(['auth','admin'])->group(function (){
    Route::get('/Interface',[App\Http\Controllers\adminController::class, 'index']);

    Route::get('/getAdmin/{adminid?}',[adminController::class,'show']);

    Route::get('/getAdminByemail/{email}',[adminController::class,'showbyEmail']);

    Route::get('/getAdminByusername/{username}',[adminController::class,'showbyUsername']);

    Route::post('/adddoctor',[adminController::class,'addDoctor']);

    Route::post('/addSubjectController',[adminController::class,'addSubjectController']);

    Route::post('/addInitiator',[adminController::class,'addInitiator']);

    Route::post('/addAdmin',[adminController::class,'addAdmin']);

    Route::delete('/delete-doctor/{id}',[adminController::class,'deleteDoctor']);

    Route::delete('/delete-initiator/{id}',[adminController::class,'deleteInitiator']);

    Route::delete('/delete-admin/{id}',[adminController::class,'deleteAdmin']);

    Route::delete('/delete-controller/{id}',[adminController::class,'deleteSubjectController']);

    Route::delete('delete-user/{id}',[UserController::class,'destroy']);

    Route::get('/controllers',[adminController::class,'getControllers']);

    Route::get('/admins',[adminController::class,'getAdmins']);

    Route::get('/doctors',[adminController::class,'getDoctors']);

    Route::get('/initiators',[adminController::class,'getInitiators']);

    Route::post('/update-profile/{id}',[UserController::class,'update']);

    Route::post('/change-password/{id}',[UserController::class,'changePassword']);

    Route::get('/subjects/{containerID}',[containerSubjectController::class,'getSubjectsofContainer']);

});


/****************** Doctor *****************/

Route::prefix('doctor')->middleware(['auth','doctor'])->group(function (){
    Route::get('/Interface',[doctorController::class, 'index']);

    Route::post('/update-profile/{id}',[UserController::class,'update']);

    Route::post('/change-password/{id}',[UserController::class,'changePassword']);

    Route::post('voteaccept-meeting',[containerSubjectController::class,'voteAccept']);

    Route::post('votereject-meeting',[containerSubjectController::class,'voteReject']);

    Route::get('/subjects/{containerID}',[containerSubjectController::class,'getSubjectsofContainer']);

    Route::get('upcoming-Meetings',[meetingController::class,'getUpcomingMeetings']);
});


/********************** Meeting initiator ******************/

Route::prefix('meeting-initiator')->middleware(['auth','initiator'])->group(function (){
    Route::get('/Interface',[MeetingInitiatorController::class, 'index']);

    Route::post('create-subject',[subjectController::class,'store']);

    Route::post('/create-Meeting',[MeetingInitiatorController::class,'createMeeting']);

    Route::post('/meetingContainer',[MeetingInitiatorController::class,'createContainer']);

    Route::post('/addSubject-in-Container',[MeetingInitiatorController::class,'AddSubjecttoContainer']);

    Route::post('/request-doctor',[MeetingInitiatorController::class,'RequestDoctor']);

    Route::delete('/remove-subject',[MeetingInitiatorController::class,'RemoveSubjectFromContainer']);

    Route::delete('/delete-Container',[MeetingInitiatorController::class,'deleteContainer']);

    Route::delete('/delete-Meeting',[MeetingInitiatorController::class,'deleteMeeting']);

    Route::post('/update-profile/{id}',[UserController::class,'update']);

    Route::post('/change-password/{id}',[UserController::class,'changePassword']);

    Route::post('/voteaccept-meeting',[containerSubjectController::class,'voteAccept']);

    Route::post('/votereject-meeting',[containerSubjectController::class,'voteReject']);

    Route::post('/add-attendee',[MeetingInitiatorController::class,'addAttendee']);

    Route::post('/add-absent',[MeetingInitiatorController::class,'addAbsent']);

    Route::get('upcoming-Meetings',[meetingController::class,'getUpcomingMeetings']);

    Route::get('/previous-Meeting/{id}',[MeetingInitiatorController::class,'getPreviousMeeting']);

});


/****************** Subject Controller *****************/

Route::prefix('subjectController')->middleware(['auth','subjectController'])->group(function (){

    Route::get('/Interface',[subjectControllerController::class, 'index']);

    Route::post('create-subject',[subjectController::class,'store']);

    Route::get('subjects-for-controller/{id}',[subjectControllerController::class,'getSubjects']);

    Route::post('/archive/{id}',[subjectControllerController::class,'ArchiveSubject']);

    Route::post('/addSubject-in-Container',[subjectControllerController::class,'AddSubjecttoContainer']);

    Route::post('redirect/{id}',[subjectController::class,'redirectSubject']);

    Route::delete('/remove-subject',[subjectControllerController::class,'RemoveSubjectFromContainer']);

    Route::post('/update-profile/{id}',[UserController::class,'update']);

    Route::post('/change-password/{id}',[UserController::class,'changePassword']);

    Route::get('subjects/{dept}',[subjectController::class,'getSubjectsforController']);

});

//Route::get('/attachment/{id}',[subjectController::class,'getAttachments']);
//
//Route::post('create-subject',[subjectController::class,'store']);
//
//Route::post('redirect/{id}',[subjectController::class,'redirectSubject']);
//
//Route::get('subjects/{dept}',[subjectController::class,'getSubjectsforController']);
//
//Route::get('subjects-for-controller/{id}',[subjectControllerController::class,'getSubjects']);
//
//Route::get('upcoming-Meetings',[meetingController::class,'getUpcomingMeetings']);
//
//Route::post('/create-Meeting',[MeetingInitiatorController::class,'createMeeting']);

//Route::get('/previous-Meeting/{id}',[MeetingInitiatorController::class,'getPreviousMeeting']);

//Route::get('prev/{id}',[InvitationNotificationsController::class,'findlastfordoctor']);
//
//Route::get('docprev/{id}',[doctorController::class,'getPreviousMeeting']);
//
//Route::get('DOne/{id}',[meetingController::class,'isDone']);
/*
 *
 *
 *
    {
        "meetingid": 14,
        "initiatorid": 2,
        "location": "Dokki",
        "date": "2023-06-01",
        "topic": "magls gam3a",
        "islast": 1
    }
 *
 *
 *
 */
