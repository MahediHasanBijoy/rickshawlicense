<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Helpers\Helper;
use BaconQrCode\Writer;
use App\Models\Category;
use App\Models\Applicant;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use BaconQrCode\Renderer\ImageRenderer;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;

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
        $request->merge([
            'amount' => Helper::bn2en($request->amount),
            'nid_no' => Helper::bn2en($request->nid_no),
            'phone'  => Helper::bn2en($request->phone),
        ]);
        $validated = $request->validate([
            'area_id'           => 'required|exists:areas,id',
            'category_id'       => 'required|exists:categories,id',

            'applicant_name'    => 'required|string|max:255',
            'guardian_name'     => 'required|string|max:255',
            'present_address'   => 'required|string|max:255',
            'permanent_address' => 'required|string|max:255',
            'nid_no' => [
                            'required',
                            'string',
                            'max:50',
                            Rule::unique('applicants')->where(function ($query) use ($request) {
                                return $query->where('applicant_year', date('Y'));
                            }),
                        ],
            'email'             => 'nullable|email|max:255',
            'phone' => [
                            'required',
                            'digits_between:10,11',
                            Rule::unique('applicants')->where(function ($query) use ($request) {
                                return $query->where('applicant_year', date('Y'));
                            }),
                        ],

            'bank_name'         => 'nullable|string|max:255',
            'pay_order_no'      => 'nullable|string|max:255',
            'amount'            => 'nullable|numeric',
            'order_date'        => 'nullable|date',

            // File validation
            'applicant_image'   => 'required|image|max:2048',
            // 'signature_image'   => 'nullable|image|max:2048',
            'citizen_certificate_image'   => 'nullable|image|max:2048',
            'category_proof_image'   => 'nullable|image|max:2048',
            'nid_image'         => 'required|image|max:2048',
            'py_order_image'    => 'nullable|image|max:2048',
        ]);

        // Convert date fields
        if (!empty($validated['order_date'])) {
            $validated['order_date'] = \Carbon\Carbon::createFromFormat('d-m-Y', $validated['order_date'])->format('Y-m-d');
        }

        
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

        if ($request->hasFile('citizen_certificate_image')) {
            $validated['citizen_certificate_image'] = $request->file('citizen_certificate_image')->store('citizen_certificate', 'public');
        }

        if ($request->hasFile('category_proof_image')) {
            $validated['category_proof_image'] = $request->file('category_proof_image')->store('category_proof', 'public');
        }

        $applicant = Applicant::create($validated);

        return redirect()->back()->with('success', 'আপনার আবেদন সফলভাবে জমা হয়েছে!')->with('nid', $applicant->nid_no)
        ->with('phone', $applicant->phone);
    }

    public function search(Request $request)
    {
        // Validate: at least one must be present
        $request->validate([
            'nid'   => 'nullable',
            'phone' => 'nullable',
        ]);

        if (!$request->nid && !$request->phone) {
            return response()->json([
                'error' => 'NID অথবা মোবাইল নম্বর অন্তত একটি দিতে হবে'
            ]);
        }

        $applicant = Applicant::when($request->nid, function ($query) use ($request) {
                                    return $query->where('nid_no', $request->nid);
                                })
                            ->when($request->phone, function ($query) use ($request) {
                                    return $query->where('phone', $request->phone);
                                })
                            ->first();

        if (!$applicant) {
            return response()->json([
                'error' => 'কোনো তথ্য পাওয়া যায়নি'
            ]);
        }
        $html = view('applicant.search', compact('applicant'))->render();

        return response()->json(['html' => $html]);
    }

    public function print(Request $request)
    {
        $nid = $request->nid;
        $phone = $request->phone;

        if (!$nid && !$phone) {
            abort(404, "Invalid request.");
        }

        $applicant = Applicant::when($nid, fn($q) => $q->where('nid_no', $nid))
                            ->when($phone, fn($q) => $q->where('phone', $phone))
                            ->first();

        if (!$applicant) {
            abort(404, "Application not found.");
        }

        $printUrl = url('/application/print') . '?nid=' . $applicant->nid_no . '&phone=' . $applicant->phone;

        // SVG-based QR code (no Imagick required)
        $renderer = new ImageRenderer(
            new RendererStyle(200),
            new SvgImageBackEnd()
        );

        $writer = new Writer($renderer);
        $qr = $writer->writeString($printUrl);


        $qrImage = 'data:image/svg+xml;base64,' . base64_encode($qr);

        return view('applicant.print', compact('applicant','qrImage'));
    }

}
