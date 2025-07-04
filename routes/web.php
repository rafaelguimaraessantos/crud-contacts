<?php

use App\Http\Controllers\ContactController;
use App\Models\Contact;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/contacts/create', function () {
    return Inertia::render('Contacts/Create');
})->name('contacts.create');

Route::resource('contacts', ContactController::class)->except(['create', 'show']);
