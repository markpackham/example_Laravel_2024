<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::with('employer')->latest()->paginate(3);

        return view('jobs.index', ['jobs' => $jobs]);
    }

    public function create()
    {
        return view('jobs.create');
    }

    public function show(Job $job)
    {
        return view('jobs.show', ['job' => $job]);
    }


    public function store()
    {
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
    }

    public function edit(Job $job)
    {

        // if (Auth::guest()) {
        //     return redirect('login');
        // }

        // // Only let the user who created the job, edit it
        // // use "isNot" check to prevent authorized from editing
        // if ($job->employer->user->isNot(Auth::user())) {
        //     // Give Http 403 Forbidden status code
        //     abort(403);
        // }

        // Only runs Gate made via Laravel Facade valid otherwise returns a 403
        // This Gate is found in the AppServiceProvider boot() so is available
        // everywhere we want to use it
        // However we can just use middleware in the routes for authorization checks
        // thus skip out of doing them in the controller
        // Gate::authorize('edit-job', $job);

        return view('jobs.edit', ['job' => $job]);
    }

    public function update(Job $job)
    {
        Gate::authorize('edit-job', $job);

        request()->validate([
            'title' => ['required', 'min:3'],
            'salary' => ['required'],
        ]);

        $job->update([
            'title' => request('title'),
            'salary' => request('salary'),
        ]);

        return redirect('/jobs/' . $job->id);

    }

    public function destroy(Job $job)
    {

        Gate::authorize('edit-job', $job);

        $job->delete();
        return redirect('/jobs');
    }
}
