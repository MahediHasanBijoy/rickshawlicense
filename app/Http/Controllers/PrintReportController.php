<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Category;
use App\Models\Payment;
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



    public function PrintCategoryApplicationReport(Request $request)
    {
        $area_id = $request->query('area_id');
       
        $year = $request->query('year'); 
        // Fetch filtered applicants based on the query parameters
        $applicants = Category::query()
            ->withCount([
            'applicants as pending_count' => function ($q) use ($area_id, $year) {
                $q->when($area_id, fn ($q) => $q->where('area_id', $area_id))
                  ->when($year, fn ($q) => $q->whereYear('created_at', $year))
                  ->where('status', 'pending');
            },

            'applicants as selected_count' => function ($q) use ($area_id, $year) {
                $q->when($area_id, fn ($q) => $q->where('area_id', $area_id))
                  ->when($year, fn ($q) => $q->whereYear('created_at', $year))
                  ->where('status', 'selected')->orWhere(function($query){
                     return $query->where('status', 'approved');
                  });
            },

            'applicants as approved_count' => function ($q) use ($area_id, $year) {
                $q->when($area_id, fn ($q) => $q->where('area_id', $area_id))
                  ->when($year, fn ($q) => $q->whereYear('created_at', $year))
                  ->where('status', 'approved');
            },

            'applicants as confirmed_count' => function ($q) use ($area_id, $year) {
                $q->when($area_id, fn ($q) => $q->where('area_id', $area_id))
                  ->when($year, fn ($q) => $q->whereYear('created_at', $year))
                  ->where('status','!=', 'pending');
            },

            'applicants as rejected_count' => function ($q) use ($area_id, $year) {
                $q->when($area_id, fn ($q) => $q->where('area_id', $area_id))
                  ->when($year, fn ($q) => $q->whereYear('created_at', $year))
                  ->where('status', 'rejected');
            },

            // total count
            'applicants as total_count' => function ($q) use ($area_id, $year) {
                $q->when($area_id, fn ($q) => $q->where('area_id', $area_id))
                  ->when($year, fn ($q) => $q->whereYear('created_at', $year));
            },
        ])->get();
        $area =  \App\Models\Area::find($area_id)?->area_name ; 
        return view('reports.category_application_report', compact('applicants', 'area', 'year'));      
    }


    public function PrintSummeryApplicationReport(Request $request){

        $area_id = $request->query('area_id');
        $category_id = $request->query('category_id');
        $year = $request->query('year'); 
        // Fetch filtered applicants based on the query parameters
        $payments = Payment::query()
            ->whereHas('applicant', function ($query) use($area_id, $category_id,$year) {
              return  $query->when($area_id, fn ($query) => $query->where('area_id', $area_id))
            ->when($category_id, fn ($query) => $query->where('category_id', $category_id))
            ->when($year, fn ($query) => $query->whereYear('created_at', $year));
            })->get();
        $area =  \App\Models\Area::find($area_id)?->area_name ; 
        $category = \App\Models\Category::find($category_id)?->category_name;
        return view('reports.summery_application_report', compact('payments', 'area', 'category', 'year'));

    }

    
}
