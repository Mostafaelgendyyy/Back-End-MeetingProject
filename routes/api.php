<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\adminController;

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

//Route::get('/get',[adminController::class,'ShowMyName']);

/****************** ADMIN *****************/
Route::get('/getAdmin/{adminid?}',[adminController::class,'show']);

Route::get('/getAdminByemail/{email}',[adminController::class,'showbyEmail']);

Route::get('/getAdminByusername/{username}',[adminController::class,'showbyUsername']);

Route::post('/adddoctor',[adminController::class,'addDoctor']);

Route::post('/addSubjectController',[adminController::class,'addSubjectController']);

Route::post('/addInitiator',[adminController::class,'addInitiator']);

Route::post('/addAdmin',[adminController::class,'addAdmin']);

Route::delete('/DELETE/{adminid}',[adminController::class,'destroy']);

Route::get('/generate', [adminController::class, 'generatePDF']);




/****************** Subject Controller *****************/
Route::post('/updateSub/{id}', [\App\Http\Controllers\subjectController::class,'archive']);
Route::post('/sc',[\App\Http\Controllers\subjectControllerController::class,'store']);
Route::post('/archive/{id}',[\App\Http\Controllers\subjectControllerController::class,'ArchiveSubject']);
/****************** SUbject *****************/

Route::post('/addsub',[\App\Http\Controllers\subjectController::class,'store']);

Route::post('/sendEMail',[\App\Http\Controllers\MeetingMailController::class,'sendMeetingMail']);

/********************** Meeting initiator ******************/
Route::post('/create-meeting',[\App\Http\Controllers\MeetingInitiatorController::class,'createMeeting']);

Route::post('/request-Doctor',[\App\Http\Controllers\MeetingInitiatorController::class,'RequestDoctor']);


/*
 *
 *
 *  {
        "meetingid": 14,
        "initiatorid": 2,
        "location": "Dokki",
        "date": "2023-06-01",
        "topic": "magls gam3a",
        "islast": 1
    }
 */
