<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        //        $collections = Payment::whereYear('created_at', $request->year)->get();
        //
        //        return view('Back.Reports.index', [
        //            'payments' => Collections::getMonthsTotalOnlyBarForYear($collections,'amount'),
        //            'years'    => Collections::getTableYearsList(Payment::class)
        //        ]);
    }
}
