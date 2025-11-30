<?php

namespace App\Http\Controllers;

use App\Models\ApplicationSetting;
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
        $app_setting = ApplicationSetting::latest()->first();
        return view('applicant.apply', compact('areas', 'categories','app_setting'));
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

            'bank_name'         => 'required|string|max:255',
            'pay_order_no'      => 'required|string|max:255',
            'amount'            => 'required|numeric',
            'order_date'        => 'required|date',

            // File validation
            'applicant_image'   => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            // 'signature_image'   => 'nullable|image|max:2048',
            'citizen_certificate_image'   => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'category_proof_image'   => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'nid_image'         => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'py_order_image'    => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ],[
            // Custom messages
            // Area & Category
            'area_id.required'  => 'এরিয়া নির্বাচন করুন।',
            'area_id.exists'    => 'নির্বাচিত এরিয়া সঠিক নয়।',

            'category_id.required' => 'ক্যাটাগরি নির্বাচন করুন।',
            'category_id.exists'   => 'নির্বাচিত ক্যাটাগরি সঠিক নয়।',

            // Applicant Information
            'applicant_name.required' => 'আবেদনকারীর নাম প্রদান করুন।',
            'applicant_name.string'   => 'আবেদনকারীর নাম অবশ্যই টেক্সট হতে হবে।',
            'applicant_name.max'      => 'আবেদনকারীর নাম সর্বোচ্চ ২৫৫ অক্ষর হতে পারে।',

            'guardian_name.required' => 'পিতা/স্বামীর নাম প্রদান করুন।',
            'guardian_name.string'   => 'পিতা/স্বামীর নাম অবশ্যই টেক্সট হতে হবে।',
            'guardian_name.max'      => 'পিতা/স্বামীর নাম সর্বোচ্চ ২৫৫ অক্ষর হতে পারে।',

            'present_address.required' => 'বর্তমান ঠিকানা প্রদান করুন।',
            'present_address.string'   => 'বর্তমান ঠিকানা অবশ্যই টেক্সট হতে হবে।',
            'present_address.max'      => 'বর্তমান ঠিকানা সর্বোচ্চ ২৫৫ অক্ষর হতে পারে।',

            'permanent_address.required' => 'স্থায়ী ঠিকানা প্রদান করুন।',
            'permanent_address.string'   => 'স্থায়ী ঠিকানা অবশ্যই টেক্সট হতে হবে।',
            'permanent_address.max'      => 'স্থায়ী ঠিকানা সর্বোচ্চ ২৫৫ অক্ষর হতে পারে।',

            // Email
            'email.email' => 'সঠিক ইমেইল এড্রেস প্রদান করুন।',
            'email.max'   => 'ইমেইল সর্বোচ্চ ২৫৫ অক্ষর হতে পারে।',

            'nid_no.required' => 'NID নম্বর দিন।',
            'nid_no.unique'   => 'এই NID দিয়ে ইতোমধ্যেই আবেদন করা হয়েছে।',

            'phone.required'  => 'মোবাইল নম্বর দিন।',
            'phone.unique'    => 'এই মোবাইল নম্বর দিয়ে ইতোমধ্যে আবেদন করা হয়েছে।',
            'phone.digits_between' => 'মোবাইল নম্বর অবশ্যই ১০ থেকে ১১ ডিজিটের হতে হবে।',

            'bank_name.required' => 'ব্যাংকের নাম প্রদান করুন।',
            'bank_name.string'   => 'ব্যাংকের নাম অবশ্যই সঠিক টেক্সট হতে হবে।',
            'bank_name.max'      => 'ব্যাংকের নাম সর্বোচ্চ ২৫৫ অক্ষর হতে পারে।',

            'pay_order_no.required' => 'পে অর্ডার নম্বর প্রদান করুন।',
            'pay_order_no.string'   => 'পে অর্ডার নম্বর অবশ্যই সঠিক টেক্সট হতে হবে।',
            'pay_order_no.max'      => 'পে অর্ডার নম্বর সর্বোচ্চ ২৫৫ অক্ষর হতে পারে।',

            'amount.required' => 'টাকার পরিমাণ প্রদান করুন।',
            'amount.numeric'  => 'টাকার পরিমাণ অবশ্যই সংখ্যায় হতে হবে।',

            'order_date.required' => 'অর্ডারের তারিখ নির্বাচন করুন।',
            'order_date.date'     => 'অর্ডারের তারিখটি সঠিক ফরম্যাটে দিন।',

            'applicant_image.required' => 'আবেদনকারীর ছবি আপলোড করুন।',
            'applicant_image.mimes'    => 'আবেদনকারীর ছবি অবশ্যই JPG, JPEG, PNG অথবা PDF হতে হবে।',

            'citizen_certificate_image.required' => 'নাগরিক সনদের ছবি আপলোড করুন।',
            'citizen_certificate_image.mimes'    => 'নাগরিক সনদের ছবি অবশ্যই JPG, JPEG, PNG অথবা PDF হতে হবে।',

            'category_proof_image.required' => 'ক্যাটাগরি প্রমানক ছবি আপলোড করুন।',
            'category_proof_image.mimes'    => 'ক্যাটাগরি প্রমানক ছবি অবশ্যই JPG, JPEG, PNG অথবা PDF হতে হবে।',

            'nid_image.required' => 'NID এর ছবি আপলোড করুন।',
            'nid_image.mimes'    => 'NID ছবি অবশ্যই JPG, JPEG, PNG বা PDF হতে হবে।',

            'py_order_image.required' => 'পে অর্ডারের ছবি আপলোড করুন।',
            'py_order_image.mimes'    => 'পে অর্ডারের ছবি অবশ্যই JPG, JPEG, PNG অথবা PDF হতে হবে।',
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
            $validated['py_order_image'] = $request->file('py_order_image')->store('pay_order', 'public');
        }

        if ($request->hasFile('citizen_certificate_image')) {
            $validated['citizen_certificate_image'] = $request->file('citizen_certificate_image')->store('citizen_certificate', 'public');
        }

        if ($request->hasFile('category_proof_image')) {
            $validated['category_proof_image'] = $request->file('category_proof_image')->store('category_proof', 'public');
        }

        $applicant = Applicant::create($validated);

        return redirect()->back()->with('success', 'আপনার আবেদন সফলভাবে জমা হয়েছে!')->with('nid', $applicant->nid_no)
        ->with('phone', $applicant->phone)
        ->with('id', $applicant->id);
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
        $id = $request->id;

        if (!$id ) {
            abort(404, "Invalid request.");
        }

        $applicant = Applicant::findOrFail($id);;

        if (!$applicant) {
            abort(404, "Application not found.");
        }

        $printUrl = url('/application/print') . '?id=' . $applicant->id;

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

    public function edit($id)
    {
        $applicant = Applicant::findOrFail($id);
        if($applicant->status!='pending'){
            return redirect()->route('home');
        }
        $areas = Area::select('id', 'area_name')->get();
        $categories = Category::select('id', 'category_name')->get();
        $app_setting = ApplicationSetting::select('application_fee')->latest()->first();
        return view('applicant.edit', compact('applicant','areas', 'categories','app_setting'));
    }

    public function update(Request $request, Applicant $applicant)
    {
        // Convert Bangla numbers before validation
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
                Rule::unique('applicants', 'nid_no')
                    ->ignore($applicant->id, 'id')
                    ->where(fn ($query) => $query->where('applicant_year', $applicant->applicant_year)),
            ],

            'email' => 'nullable|email|max:255',
            'phone' => [
                'required',
                'digits_between:10,11',
                Rule::unique('applicants',  'phone')
                    ->ignore($applicant->id, 'id')
                    ->where(fn ($query) => $query->where('applicant_year', $applicant->applicant_year)),
            ],

            'bank_name'    => 'required|string|max:255',
            'pay_order_no' => 'required|string|max:255',
            'amount'       => 'required|numeric',
            'order_date'   => 'required|date',

            // Images → optional during update
            'applicant_image'          => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            // 'signature_image'          => 'nullable|image|max:2048',
            'citizen_certificate_image'=> 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'category_proof_image'     => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'nid_image'                => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'py_order_image'           => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ],[
            // Custom messages
            // Area & Category
            'area_id.required'  => 'এরিয়া নির্বাচন করুন।',
            'area_id.exists'    => 'নির্বাচিত এরিয়া সঠিক নয়।',

            'category_id.required' => 'ক্যাটাগরি নির্বাচন করুন।',
            'category_id.exists'   => 'নির্বাচিত ক্যাটাগরি সঠিক নয়।',

            // Applicant Information
            'applicant_name.required' => 'আবেদনকারীর নাম প্রদান করুন।',
            'applicant_name.string'   => 'আবেদনকারীর নাম অবশ্যই টেক্সট হতে হবে।',
            'applicant_name.max'      => 'আবেদনকারীর নাম সর্বোচ্চ ২৫৫ অক্ষর হতে পারে।',

            'guardian_name.required' => 'পিতা/স্বামীর নাম প্রদান করুন।',
            'guardian_name.string'   => 'পিতা/স্বামীর নাম অবশ্যই টেক্সট হতে হবে।',
            'guardian_name.max'      => 'পিতা/স্বামীর নাম সর্বোচ্চ ২৫৫ অক্ষর হতে পারে।',

            'present_address.required' => 'বর্তমান ঠিকানা প্রদান করুন।',
            'present_address.string'   => 'বর্তমান ঠিকানা অবশ্যই টেক্সট হতে হবে।',
            'present_address.max'      => 'বর্তমান ঠিকানা সর্বোচ্চ ২৫৫ অক্ষর হতে পারে।',

            'permanent_address.required' => 'স্থায়ী ঠিকানা প্রদান করুন।',
            'permanent_address.string'   => 'স্থায়ী ঠিকানা অবশ্যই টেক্সট হতে হবে।',
            'permanent_address.max'      => 'স্থায়ী ঠিকানা সর্বোচ্চ ২৫৫ অক্ষর হতে পারে।',

            // Email
            'email.email' => 'সঠিক ইমেইল এড্রেস প্রদান করুন।',
            'email.max'   => 'ইমেইল সর্বোচ্চ ২৫৫ অক্ষর হতে পারে।',

            'nid_no.required' => 'NID নম্বর দিন।',
            'nid_no.unique'   => 'এই NID দিয়ে ইতোমধ্যেই আবেদন করা হয়েছে।',

            'phone.required'  => 'মোবাইল নম্বর দিন।',
            'phone.unique'    => 'এই মোবাইল নম্বর দিয়ে ইতোমধ্যে আবেদন করা হয়েছে।',
            'phone.digits_between' => 'মোবাইল নম্বর অবশ্যই ১০ থেকে ১১ ডিজিটের হতে হবে।',

            'bank_name.required' => 'ব্যাংকের নাম প্রদান করুন।',
            'bank_name.string'   => 'ব্যাংকের নাম অবশ্যই সঠিক টেক্সট হতে হবে।',
            'bank_name.max'      => 'ব্যাংকের নাম সর্বোচ্চ ২৫৫ অক্ষর হতে পারে।',

            'pay_order_no.required' => 'পে অর্ডার নম্বর প্রদান করুন।',
            'pay_order_no.string'   => 'পে অর্ডার নম্বর অবশ্যই সঠিক টেক্সট হতে হবে।',
            'pay_order_no.max'      => 'পে অর্ডার নম্বর সর্বোচ্চ ২৫৫ অক্ষর হতে পারে।',

            'amount.required' => 'টাকার পরিমাণ প্রদান করুন।',
            'amount.numeric'  => 'টাকার পরিমাণ অবশ্যই সংখ্যায় হতে হবে।',

            'order_date.required' => 'অর্ডারের তারিখ নির্বাচন করুন।',
            'order_date.date'     => 'অর্ডারের তারিখটি সঠিক ফরম্যাটে দিন।',

            'applicant_image.required' => 'আবেদনকারীর ছবি আপলোড করুন।',
            'applicant_image.mimes'    => 'আবেদনকারীর ছবি অবশ্যই JPG, JPEG, PNG অথবা PDF হতে হবে।',

            'citizen_certificate_image.required' => 'নাগরিক সনদের ছবি আপলোড করুন।',
            'citizen_certificate_image.mimes'    => 'নাগরিক সনদের ছবি অবশ্যই JPG, JPEG, PNG অথবা PDF হতে হবে।',

            'category_proof_image.required' => 'ক্যাটাগরি প্রমানক ছবি আপলোড করুন।',
            'category_proof_image.mimes'    => 'ক্যাটাগরি প্রমানক ছবি অবশ্যই JPG, JPEG, PNG অথবা PDF হতে হবে।',

            'nid_image.required' => 'NID এর ছবি আপলোড করুন।',
            'nid_image.mimes'    => 'NID ছবি অবশ্যই JPG, JPEG, PNG বা PDF হতে হবে।',

            'py_order_image.required' => 'পে অর্ডারের ছবি আপলোড করুন।',
            'py_order_image.mimes'    => 'পে অর্ডারের ছবি অবশ্যই JPG, JPEG, PNG অথবা PDF হতে হবে।',
        ]);

        // Convert date format if needed
        if (!empty($validated['order_date'])) {
            $validated['order_date'] = \Carbon\Carbon::parse($validated['order_date'])->format('Y-m-d');
        }

        // Handle file uploads (replace only if new file uploaded)
        foreach ([
            'applicant_image' => 'applicant',
            'signature_image' => 'signature',
            'nid_image'       => 'nid',
            'py_order_image'  => 'order',
            'citizen_certificate_image' => 'citizen_certificate',
            'category_proof_image' => 'category_proof',
        ] as $field => $folder) {

            if ($request->hasFile($field)) {

                // delete old file if exists
                if ($applicant->$field && \Storage::disk('public')->exists($applicant->$field)) {
                    \Storage::disk('public')->delete($applicant->$field);
                }

                $validated[$field] = $request->file($field)->store($folder, 'public');
            }
        }
        
        $applicant->update($validated);
        return redirect()->route('home')->with('success', 'আপনার আবেদন সফলভাবে সম্পাদন হয়েছে!')
        ->with('nid', $applicant->nid_no)
        ->with('phone', $applicant->phone)
        ->with('id', $applicant->id);
    }


}
