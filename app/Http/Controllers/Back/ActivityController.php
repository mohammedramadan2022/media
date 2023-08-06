<?php

namespace App\Http\Controllers\Back;

use App\Exports\ActivitiesExport;
use App\Facade\Support\Core\Crud;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Activitylog\Models\Activity;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::latest()->get()->groupBy(fn ($item) => $item->created_at->format('Y-m-d'));

        return view('Back.Activities.index', ['activities' => $activities, 'search' => false]);
    }

    public function day($day)
    {
        $day = carbon()->parse($day);

        $activities = Activity::latest()->whereDate('created_at', $day)->get();

        return view('Back.Activities.day', ['activities' => $activities, 'search' => false, 'date' => $day]);
    }

    public function search(Request $request)
    {
        if (is_null($request->term)) return redirect()->route('activities.index');

        $data = ['activities' => Activity::search($request->term)->get(), 'search' => true];

        return view('Back.Activities.index', $data);
    }

    public function export()
    {
        return Excel::download(new ActivitiesExport(), 'activities.xlsx');
    }

    public function delete(Request $request)
    {
        return Crud::delete(Activity::class, $request->id);
    }

    public function show(Activity $activity)
    {
        return view('Back.Activities.show', compact('activity'));
    }
}
