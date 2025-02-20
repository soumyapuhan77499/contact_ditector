<?php
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\GroupAssignController;
use App\Http\Controllers\Admin\WhatsappController;

Route::controller(AdminController::class)->group(function() {
    Route::get('/', 'dashboard')->name('admin.AdminLogin');
});

Route::controller(ContactController::class)->group(function() {
    Route::get('admin/manage-contact', 'manageContact')->name('admin.manageContact');
    Route::delete('/contact/delete/{id}','deleteContact')->name('admin.deleteContact');
    Route::post('/contact/update/{id}','updateContact')->name('admin.updateContact');
    Route::get('/contacts/{filter?}','manageContact')->name('contacts.filter');
});
 
Route::prefix('admin')->controller(GroupController::class)->group(function() {
    Route::get('/add-group', 'addGroup')->name('admin.addGroup');
    Route::get('/manage-group', 'manageGroup')->name('admin.manageGroup');
    Route::post('/save-group', 'saveGroup')->name('admin.saveGroup');
    Route::post('/groups/update/{id}', 'updateGroup')->name('admin.updateGroup');
    Route::delete('/groups/delete/{id}', 'deleteGroup')->name('admin.deleteGroup');
});


Route::prefix('admin')->controller(GroupAssignController::class)->group(function() {
    Route::get('/assign-group', 'assignGroup')->name('admin.assignGroup');
    Route::post('/assign-contacts','saveAssignContacts')->name('assign.contacts');
    Route::get('/manage-assign-group', 'manageAssignGroup')->name('admin.manageAssignGroup');
});

Route::post('/send-whatsapp-message', [WhatsappController::class, 'sendMessage'])->name('sendWhatsappMessage');


