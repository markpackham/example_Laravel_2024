<?php

use App\Models\Job;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('home');
});

// Index
Route::get('/jobs', function () {
    // Use eager loading rather than lazy loading for better performance
    // use "with" with employer() method in Job class
    // had we used lazy loading then we'd have the N+1 problem
    // so the more records we added the more SQL queries would need to be run
    // making performance get progressively worse
    // previously we used Job::all()

    // Use pagination to save memory instead of get which fetches ALL, no limit
    //$jobs = Job::with('employer')->get();

    // Example of pagination query - http://127.0.0.1:8000/jobs?page=2
    // For performance reasons simplePaginate works better than paginate
    // but this offers only Previous & Next buttons
    //$jobs = Job::with('employer')->simplePaginate(3);

    // cursorPaginate means ugly links like this
    // http://127.0.0.1:8000/jobs?cursor=eyJqb2JfbGlzdGluZ3MuaWQiOjMsIl9wb2ludHNUb05leHRJdGVtcyI6dHJ1ZX0
    // but it is great if you can't stand people with web crawlers stealing your site data
    // by incrementing up predictable url paths
    // cursorPaginate works well for large data sets
    // $jobs = Job::with('employer')->cursorPaginate(3);

    // latest() adds an Order By clause so we can reverse the results by Timestamp
    $jobs = Job::with('employer')->latest()->paginate(3);

    // Before we made a "jobs" directory it was 
    // return view('jobs', ['jobs' => $jobs]);

    // You can use "." instead of "/" which is more common in Laravel for views directories
    //return view('jobs/index', ['jobs' => $jobs]);
    return view('jobs.index', ['jobs' => $jobs]);
});

// Create
// http://127.0.0.1:8000/jobs/create
Route::get('/jobs/create', function () {
    return view('jobs.create');
});

// Show
Route::get('jobs/{id}', function ($id) {
    // die dump
    // dd($id);

    // Use short closure to access $id from above
    // closures use a similar style to JavaScript's arrow function but need "fn" at the start
    $job = Job::find($id);

    return view('jobs.show', ['job' => $job]);
});

// Store
Route::post('/jobs', function () {
    // dd(request()->all());
    // dd(request('title'));

    request()->validate([
        'title' => ['required', 'min:3'],
        'salary' => ['required'],
    ]);

    Job::create([
        'title' => request('title'),
        'salary' => request('salary'),
        'employer_id' => 1
    ]);
    return redirect('/jobs');
});

// Edit
Route::get('jobs/{id}/edit', function ($id) {
    $job = Job::find($id);

    return view('jobs.edit', ['job' => $job]);
});

// Update (using Patch instead of Put)
// We don't need to have jobs/{id}/update since the
// Patch behavior is implicit & understood by the framework
// we'd have to use /update if we were using Post instead
Route::patch('jobs/{id}', function ($id) {
    // validate
    request()->validate([
        'title' => ['required', 'min:3'],
        'salary' => ['required'],
    ]);

    // Authorize

    // Update job & Persist
    $job = Job::find($id);

    // Identical to doing $job->update([])
    // $job->title = request('title');
    // $job->salary = request('salary');
    // $job->save();

    $job->update([
        'title' => request('title'),
        'salary' => request('salary'),
    ]);

    // Redirect to jobs page
});

// Destroy
Route::delete('jobs/{id}', function ($id) {

});

Route::get('/contact', function () {
    return view('contact');
});