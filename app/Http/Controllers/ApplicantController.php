<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Category;
use App\Models\Applicant;
use Illuminate\Http\Request;

class ApplicantController extends Controller
{
    public function create()
    {
        $areas = Area::select('id', 'area_name')->get();
        $categories = Category::select('id', 'category_name')->get();
        return view('applicant.apply', compact('areas', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'area_id'           => 'required|exists:areas,id',
            'category_id'       => 'required|exists:categories,id',

            'applicant_name'    => 'required|string|max:255',
            'guardian_name'     => 'required|string|max:255',
            'present_address'   => 'required|string|max:255',
            'permanent_address' => 'required|string|max:255',
            'nid_no'            => 'required|string|max:50',
            'email'             => 'nullable|email|max:255',
            'phone'             => 'required|digits_between:10,11',

            'bank_name'         => 'nullable|string|max:255',
            'pay_order_no'      => 'nullable|string|max:255',
            'amount'            => 'nullable|numeric',
            'order_date'        => 'nullable|date',

            // File validation
            'applicant_image'   => 'required|image|max:2048',
            'signature_image'   => 'nullable|image|max:2048',
            'nid_image'         => 'required|image|max:2048',
            'py_order_image'    => 'nullable|image|max:2048',
        ]);

        
        if ($request->hasFile('applicant_image')) {
            $validated['applicant_image'] = $request->file('applicant_image')->store('applicant', 'public');
        }

        if ($request->hasFile('signature_image')) {
            $validated['signature_image'] = $request->file('signature_image')->store('signature', 'public');
        }

        if ($request->hasFile('nid_image')) {
            $validated['nid_image'] = $request->file('nid_image')->store('nid', 'public');
        }

        if ($request->hasFile('py_order_image')) {
            $validated['py_order_image'] = $request->file('py_order_image')->store('order', 'public');
        }

        Applicant::create($validated);

        return redirect()->back()->with('success', 'আপনার আবেদন সফলভাবে জমা হয়েছে!');
    }
}
