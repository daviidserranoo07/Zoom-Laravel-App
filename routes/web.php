<?php

use App\Http\Controllers\ZoomController;
use App\Providers\ZoomServiceProvider;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/zoom_token', function (){
    $zoom = new ZoomServiceProvider();
    dd($zoom->getToken());
});

Route::get('/zoom/create-meeting',[ZoomController::class,'createMeeting'])->name('zoom.createMeeting');
Route::post('/zoom/create-meeting',[ZoomController::class,'createMeetingStore'])->name('zoom.createMeetingStore');
Route::get('/zoom/meeting/{id}', [ZoomController::class, 'showMeeting'])->name('zoom.showMeeting');