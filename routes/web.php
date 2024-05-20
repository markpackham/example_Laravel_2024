<?php

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/jobs', function () {
    return view('jobs', ['jobs' => [['id' => 1, 'title' => 'Director', 'salary' => '$50,000'], ['id' => 2, 'title' => 'Janitor', 'salary' => '$10,000'], ['id' => 3, 'title' => 'Security', 'salary' => '$20,000']]]);
});

Route::get('/jobs/{id}', function ($id) {
    // die dump
    // dd($id);
$jobs = [['id' => 1, 'title' => 'Director', 'salary' => '$50,000'], ['id' => 2, 'title' => 'Janitor', 'salary' => '$10,000'], ['id' => 3, 'title' => 'Security', 'salary' => '$20,000']];

// Use short closure to access $id from above
   $job = Arr::first($jobs, fn($job)=> $job['id'] == $id);
   dd($job);
    return view('job', ['job' => $job]);
});

Route::get('/contact', function () {
    return view('contact');
});