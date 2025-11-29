<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use Illuminate\Http\Request;

class PrintReportController extends Controller
{
    public function PrintApplicationReport(Request $request)
    {
        $area_id = $request->query('area_id');
        $category_id = $request->query('category_id');
        $application_status = $request->query('application_status');
        $year = $request->query('year'); 
        // Fetch filtered applicants based on the query parameters
        $applicants = Applicant::query()
            ->when($area_id, fn ($query) => $query->where('area_id', $area_id))
            ->when($category_id, fn ($query) => $query->where('category_id', $category_id))
            ->when($application_status, fn ($query) => $query->where('status', $application_status))
            ->when($year, fn ($query) => $query->whereYear('created_at', $year))
            ->get();
        $area =  \App\Models\Area::find($area_id)?->area_name ; 
        $category = \App\Models\Category::find($category_id)?->category_name;
        return view('reports.application_report', compact('applicants', 'area', 'category', 'application_status', 'year'));      
    }
}
