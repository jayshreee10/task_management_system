<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeamTaskController;
use App\Filament\Resources\TeamTaskResource\Pages\ViewTeamTask;
use App\Http\Controllers\BroadcastController;
use Illuminate\Support\Facades\Broadcast;

Route::get('/', function () {
    return redirect('/admin/login');
});

Route::post('/filament/login', [AuthController::class, 'loginFilament'])->name('filament.login');
Route::post('/filament/logout', [AuthController::class, 'logoutFilament'])->name('filament.logout');

Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::resource('tasks', TaskController::class);
    Route::get('/user/{userId}/{role}', [UserController::class, 'assignRoleToUser']);
});

Route::middleware(['auth', 'role:Manager'])->group(function () {
    Route::get('/assign-tasks', [TaskController::class, 'assign']);
    Route::get('/teams/{team}/tasks', [TaskController::class, 'teamTasks']);
});

Route::middleware(['auth', 'role:Team Member'])->group(function () {
    Route::get('/my-tasks', [TaskController::class, 'myTasks']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/team-tasks', [TeamTaskController::class, 'index'])->name('team.tasks.index');
    Route::post('/tasks/{task}/comment', [TeamTaskController::class, 'addComment'])->name('tasks.comment');
    Route::patch('/tasks/{task}/status', [TeamTaskController::class, 'updateStatus'])->name('tasks.updateStatus');
});

Route::get('/team-tasks/{record}/view', ViewTeamTask::class)->name('team-tasks.view');
Route::post('/team-task/{record}/store-comment', [ViewTeamTask::class, 'storeComment'])->name('teamtask.storeComment');
Route::post('/team-task/{record}/delete-comment', [ViewTeamTask::class, 'deleteComment'])->name('teamtask.deleteComment');
Route::post('/team-task/{record}/upload-attachment', [ViewTeamTask::class, 'uploadAttachment'])->name('teamtask.uploadAttachment');
Route::post('/team-task/{record}/delete-attachment', [ViewTeamTask::class, 'deleteAttachment'])->name('teamtask.deleteAttachment');

// For API login
Route::post('/login', [AuthController::class, 'loginApi'])->name('api.login');
Route::post('/logout', [AuthController::class, 'logoutApi'])->name('api.logout');
Route::post('/auth/check-user', [AuthController::class, 'checkUser'])->name('api.checkUser');



Route::post('/pusher/auth', [BroadcastController::class, 'authenticate'])->middleware('auth:api');
