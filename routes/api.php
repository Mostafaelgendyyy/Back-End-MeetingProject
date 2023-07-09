<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\GroupUserController;
use App\Http\Controllers\InvitedController;
use App\Http\Controllers\meetingController;
use App\Http\Controllers\PlaceController;
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

Route::prefix('admin')->middleware('auth:sanctum')->group(function (){
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

    Route::post('UpdateUSER/{id}',[UserController::class,'UpdateUserROle']);

    Route::post('addPlace',[adminController::class,'addPlace']);

    Route::get('deletePlace/{id}',[adminController::class,'deletePlace']);

    Route::get('places',[PlaceController::class,'getall']);

    Route::post('addAdminstration',[adminController::class,'addAdminstration']);

    Route::get('deleteAdminstration/{id}',[adminController::class,'deleteAdminstration']);

    Route::post('addInvited',[InvitedController::class,'store']);

    Route::delete('deleteInvited/{id}',[InvitedController::class,'destroy']);


});


/****************** Doctor *****************/

Route::prefix('doctor')->middleware('auth:sanctum')->group(function (){
    Route::get('/Interface',[doctorController::class, 'index']);

    Route::post('/update-profile/{id}',[UserController::class,'update']);

    Route::post('/change-password/{id}',[UserController::class,'changePassword']);

    Route::post('voteaccept-meeting',[containerSubjectController::class,'voteAccept']);

    Route::post('votereject-meeting',[containerSubjectController::class,'voteReject']);

    Route::get('/subjects/{containerID}',[containerSubjectController::class,'getSubjectsofContainer']);

    Route::get('/notifications/{id}',[doctorController::class,'getNotification']);

    Route::get('upcomingMeeting/{id}',[meetingController::class,'getUpcomingMeetingsforDoctor']);


});
Route::post('/create-Meeting',[MeetingInitiatorController::class,'createMeeting']);

/********************** Meeting initiator ******************/
Route::prefix('meeting-initiator')->middleware('auth:sanctum')->group(function (){
    Route::get('/Interface',[MeetingInitiatorController::class, 'index']);

    Route::post('create-subject',[subjectController::class,'store']);

    Route::post('/create-Meeting',[MeetingInitiatorController::class,'createMeeting']);

    Route::post('/request-doctor/{id}',[MeetingInitiatorController::class,'RequestDoctor']);

    Route::post('CreateGroup',[MeetingInitiatorController::class,'makegroup']);

    Route::post('addGroupUsers/{initiatorid}',[MeetingInitiatorController::class,'adduserstogroup']);

    Route::get('GroupUser/{id}',[GroupUserController::class,'RetreiveGroupUsers']);

    Route::delete('deleted/{initiatorid}/{userid}', [MeetingInitiatorController::class,'deletefromGroup']);

    Route::delete('deletegroup/{initiatorid}',[MeetingInitiatorController::class,'deleteGroup']);

    Route::get('RequestGroup/{initiatorid}/{meetingid}',[MeetingInitiatorController::class,'requestGroupforMeeting']);

    Route::post('Request-invited',[MeetingInitiatorController::class,'RequestInvited']);

    Route::get('invited',[InvitedController::class,'viewall']);

    Route::get('Adminstrationsdoctors/{id}',[UserController::class,'usersbyAdminstration']);

    Route::delete('/delete-Meeting',[MeetingInitiatorController::class,'deleteMeeting']);

    Route::post('/update-profile/{id}',[UserController::class,'update']);

    Route::post('/change-password/{id}',[UserController::class,'changePassword']);

    Route::get('/previous-Meeting/{id}',[MeetingInitiatorController::class,'getPreviousMeeting']);

    Route::get('Archived/{initiatorid}',[subjectController::class,'showArchive']);

    Route::get('SubjectsData/{id}',[subjectController::class,'show']);

    Route::get('currentMeeting/{id}',[meetingController::class,'RetreivedataforLast']);

    Route::post('end-meeting',[meetingController::class,'FinalizeMeeting']);

    Route::get('InitPDFData/{initiatorid}',[meetingController::class,'DataPreviousforPDF']);

    Route::get('upcoming/{initiatorid}',[meetingController::class,'getUpcomingMeetingsforInitiator']);

    Route::get('search/{desc}',[subjectControllerController::class,'SearchSubject']);

    Route::get('DoctorsandInitiator/{initiatorid}',[UserController::class,'getDoctorsandInitiator']);

    Route::get('searchusers/{name}',[UserController::class,'searchbyname']);

    Route::get('SubjectForMeetings/{meetingid}',[\App\Http\Controllers\MeetingSubjectsController::class,'getSubjectsofMeeting']);

});

Route::get('MeetingOfSubjects/{subjectid}',[\App\Http\Controllers\MeetingSubjectsController::class,'getMeetings']);

/****************** Subject Controller *****************/

Route::prefix('subjectController')->middleware('auth:sanctum')->group(function (){

    Route::get('/Interface',[subjectControllerController::class, 'index']);

    Route::post('create-subject',[subjectController::class,'store']);

    Route::get('subjects-for-controller/{id}',[subjectControllerController::class,'getSubjects']);

    Route::post('/addSubject-in-Meeting',[subjectControllerController::class,'AddSubjecttoMeeting']);

    Route::post('redirect/{id}',[subjectController::class,'redirectSubject']);

    Route::delete('/remove-subject',[subjectControllerController::class,'RemoveSubjectFromMeeting']);

    Route::post('/update-profile/{id}',[UserController::class,'update']);

    Route::post('/change-password/{id}',[UserController::class,'changePassword']);

    Route::get('Subjects/{controllerid}',[subjectControllerController::class,'getSubjects']);

    Route::get('ControllerPDFData/{id}',[subjectControllerController::class,'getPrevPDF']);

    Route::get('upcomings/{id}',[meetingController::class,'getUpcomingMeetingsforcontroller']);

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

//Route::post('/addInitiator',[adminController::class,'addInitiator']);



//Route::post('reset',route('password.email'));

//---->Route::post('/password/reset/email', [\App\Http\Controllers\Auth\ForgotPasswordController::class,'reset']);

/*
 *
 *
 *
    {

        "initiatorid": 2,
        "location": "Dokki",
        "date": "2023-06-01",
        "topic": "magls gam3a",
        "id":[1,2,3,4,5] --> REquested doctors


    }
{
    "name":"mohamedNour",
    "email":"mohNour@gmail.com",
    "password":"123456789",
"adminstration":"نظم المعلومات"
}
 *
 *
 *
 */

Route::post('login',[UserController::class,'login']);

Route:: middleware('auth:sanctum')->group(function (){

    Route::post('logout',[UserController::class,'logout']);

});
//Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgotpassword', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
////Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
////Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');



