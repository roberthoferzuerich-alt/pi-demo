<?php

use App\Models\Person;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $people = Person::latest()->get();

    return view('welcome', compact('people'));
});
