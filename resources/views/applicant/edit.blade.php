@extends('layouts.frontend')
@section('main_content')
    <div class="card shadow border-0 rounded-4 mb-5" style="background: white;" id="applicantFormCard">
        <div class="card-header">
            <h3 class="text-center fw-bold">আপনার আবেদন সম্পাদন করুন</h3>
        </div>
        <div class="card-body">
            <div class="container mt-5">
                <form action="{{ route('applicant.update', $applicant->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="border p-4 rounded shadow-sm mb-2">
                        <h5 class="fw-bold mb-4">রুট ও ক্যাটাগরি নির্বাচন (Route & Category)</h5>
                        <div class=" mb-3 align-items-center">
                            <label class="col-form-label fw-bold">
                                রুট <span class="text-danger">*</span>
                            </label>
                            <div class="ms-5">
                                @foreach($areas as $area)
                                <div class="form-check form-check">
                                    <input 
                                        type="radio"
                                        class="form-check-input @error('area_id') is-invalid @enderror"
                                        name="area_id"
                                        value="{{ $area->id }}"
                                        id="area{{ $area->id }}"
                                        {{ old('area_id', $applicant->area_id) == $area->id ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label" for="area{{ $area->id }}">
                                        {{ $area->area_name }}
                                    </label>
                                </div>
                                @endforeach
                                @error('area_id')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 align-items-center">
                            <label class=" col-form-label fw-bold">
                                ক্যাটাগরি <span class="text-danger">*</span>
                            </label>
                            <div class="ms-5">
                                @foreach($categories as $category)
                                <div class="form-check form-check ">
                                    <input 
                                        type="radio"
                                        class="form-check-input @error('category_id') is-invalid @enderror"
                                        name="category_id"
                                        value="{{ $category->id }}"
                                        id="category{{ $category->id }}"
                                        {{ old('category_id', $applicant->category_id) == $category->id ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label" for="category{{ $category->id }}">
                                        {{ $category->category_name }}
                                    </label>
                                </div>
                                @endforeach
                                @error('category_id')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        
                    </div>
                    <div class="border p-4 rounded shadow-sm mb-2">
                        <h5 class="fw-bold mb-4">ব্যক্তিগত তথ্য (Personal Information)</h5>
                        <div class="mb-3 align-items-center">
                            <label class="col-form-label fw-bold">
                                আবেদনকারীর নাম <span class="text-danger">*</span>
                            </label>
                            <div class="ms-5">
                                <input type="text" name="applicant_name" class="form-control form-control-lg @error('applicant_name') is-invalid @enderror" placeholder="" value="{{ old('applicant_name', $applicant->applicant_name) }}">
                                @error('applicant_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class=" mb-3 align-items-center">
                            <label class="col-form-label fw-bold">
                                পিতা/স্বামীর নাম<span class="text-danger">*</span>
                            </label>
                            <div class="ms-5">
                                <input type="text" name="guardian_name" class="form-control form-control-lg @error('guardian_name') is-invalid @enderror" placeholder="" value="{{ old('guardian_name', $applicant->guardian_name) }}">
                                @error('guardian_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4 align-items-center">
                            <label class="col-form-label fw-bold">
                                বর্তমান ঠিকানা <span class="text-danger">*</span>
                            </label>
                            <div class="ms-5">
                                <input type="text" name="present_address" class="form-control form-control-lg @error('present_address') is-invalid @enderror" placeholder="" value="{{ old('present_address',$applicant->present_address) }}">
                                @error('present_address')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 align-items-center">
                            <label class="col-form-label fw-bold">
                                স্থায়ী ঠিকানা <span class="text-danger">*</span>
                            </label>
                            <div class="ms-5">
                                <input type="text" name="permanent_address" class="form-control form-control-lg @error('permanent_address') is-invalid @enderror"  placeholder="" value="{{ old('permanent_address',$applicant->permanent_address) }}">
                                @error('permanent_address')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 align-items-center">
                            <label class="col-form-label fw-bold">
                                এন আইডি/জন্মনিবন্ধন নং <span class="text-danger">*</span>
                            </label>
                            <div class="ms-5">
                                <input type="text" name="nid_no" class="form-control form-control-lg @error('nid_no') is-invalid @enderror" placeholder="" value="{{ old('nid_no',$applicant->nid_no) }}">
                                @error('nid_no')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 align-items-center">
                            <label class="col-form-label fw-bold">
                                ইমেইল
                            </label>
                            <div class="ms-5">
                                <input type="email" name="email" class="form-control form-control-lg" placeholder="" value="{{ old('email',$applicant->email) }}">
                            </div>
                        </div>
                        <div class="mb-3 align-items-center">
                            <label class="col-form-label fw-bold">
                                মোবাইল<span class="text-danger">*</span>
                            </label>
                            <div class="ms-5">
                                <input type="text" name="phone" class="form-control form-control-lg @error('phone') is-invalid @enderror " placeholder="" value="{{ old('phone',$applicant->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="border p-4 rounded shadow-sm mb-2">
                        <h5 class="fw-bold mb-4">পে অর্ডারের বিবরণ (Pay Order Information)</h5>
                        <div class="mb-3 align-items-center">
                            <label class="col-form-label fw-bold">
                                ব্যাংকের নাম<span class="text-danger">*</span>
                            </label>
                            <div class="ms-5">
                                <input type="text" name="bank_name" class="form-control form-control-lg @error('bank_name') is-invalid @enderror" placeholder="" value="{{ old('bank_name',$applicant->bank_name) }}">
                                @error('bank_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class=" mb-3 align-items-center">
                            <label class="col-form-label fw-bold">
                                পে অর্ডার নং<span class="text-danger">*</span>
                            </label>
                            <div class="ms-5">
                                <input type="text" name="pay_order_no" class="form-control form-control-lg @error('pay_order_no') is-invalid @enderror" placeholder="" value="{{ old('pay_order_no',$applicant->pay_order_no) }}">
                                @error('pay_order_no')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4 align-items-center">
                            <label class="col-form-label fw-bold">
                                পরিমান<span class="text-danger">*</span>
                            </label>
                            <div class="ms-5">
                                <input type="text" name="amount" class="form-control form-control-lg @error('amount') is-invalid @enderror" placeholder="" value="{{ old('amount',$applicant->amount) }}" readonly>
                                @error('amount')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 align-items-center">
                            <label class="col-form-label fw-bold">
                                পরিশোধের তারিখ<span class="text-danger">*</span>
                            </label>
                            <div class="ms-5">
                                <input type="text" name="order_date" class="form-control form-control-lg @error('order_date') is-invalid @enderror" id="order_date" placeholder="" value="{{ old('order_date',\Carbon\Carbon::parse($applicant->order_date)->format('d-m-Y')) }}" readonly>
                                @error('order_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="border p-4 rounded shadow-sm mb-2">
                        <h5 class="fw-bold mb-4">প্রয়োজনীয় ডকুমেন্ট সংযুক্তকরণ</h5>
                        <div class="mb-3 align-items-center">
                            <label class="col-form-label fw-bold">
                                আবেদনকারীর ছবি <span class="text-danger">*</span>
                            </label>
                            <div class="ms-5">
                                <input type="file" name="applicant_image" class="form-control form-control-lg @error('applicant_image') is-invalid @enderror" placeholder="" id="applicant_image"> 
                                @error('applicant_image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                @if($applicant->applicant_image)
                                @php
                                    $filePath = $applicant->applicant_image;
                                    $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                                    $pdf_display = $extension=='pdf'?'':'display:none;';
                                    $img_display = $extension!='pdf'?'':'display:none;';
                                @endphp
                                    <div class="my-2" id="applicant_preview_box" >
                                            <!-- PDF Preview -->
                                            <iframe 
                                                src="{{ asset('storage/'.$filePath) }}" 
                                                width="100%" 
                                                height="300" 
                                                style="border:1px solid #ccc;{{ $pdf_display }}"
                                                id="applicant_pdf_preview">
                                            </iframe>
                                            <!-- Image Preview -->
                                            <img 
                                                src="{{ asset('storage/'.$filePath) }}" 
                                                alt="Applicant Image" 
                                                width="200"
                                                style="{{ $img_display }}" 
                                                id="applicant_image_preview">
                                    </div>
                                @else
                                    <div class="my-2" id="applicant_preview_box" >
                                        <!-- PDF Preview -->
                                        <iframe 
                                            src="" 
                                            width="100%" 
                                            height="300" 
                                            style="border:1px solid #ccc;display:none;"
                                            id="applicant_pdf_preview">
                                        </iframe>
                                        <!-- Image Preview -->
                                        <img 
                                            src="" 
                                            alt="Applicant Image" 
                                            width="200"
                                            style="display:none;" 
                                            id="applicant_image_preview">
                                    </div>
                                @endif
                            </div>
                        </div>

                        

                        <div class=" mb-3 align-items-center">
                            <label class="col-form-label fw-bold">
                                ক্যাটাগরি প্রমানক<span class="text-danger">*</span>
                            </label>
                            <div class="ms-5">
                                <input type="file" name="category_proof_image" class="form-control form-control-lg @error('category_proof_image') is-invalid @enderror" placeholder="" id="category_proof_image">
                                @error('category_proof_image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                @if($applicant->category_proof_image)
                                @php
                                    $filePath = $applicant->category_proof_image;
                                    $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                                    $pdf_display = $extension=='pdf'?'':'display:none;';
                                    $img_display = $extension!='pdf'?'':'display:none;';
                                @endphp
                                    <div class="my-2" id="category_preview_box" >
                                        <!-- PDF Preview -->
                                        <iframe 
                                            src="{{ asset('storage/'.$filePath) }}" 
                                            width="100%" 
                                            height="300" 
                                            style="border:1px solid #ccc;{{ $pdf_display }}"
                                            id="category_pdf_preview">
                                        </iframe>
                                        <!-- Image Preview -->
                                        <img 
                                            src="{{ asset('storage/'.$filePath) }}" 
                                            alt="Applicant Image" 
                                            width="200" 
                                            style="{{ $img_display }}"
                                            id="category_image_preview">
                                    </div>
                                @else
                                    <div class="my-2" id="category_preview_box" >
                                        <!-- PDF Preview -->
                                        <iframe 
                                            src="" 
                                            width="100%" 
                                            height="300" 
                                            style="border:1px solid #ccc;display:none;"
                                            id="category_pdf_preview">
                                        </iframe>
                                        <!-- Image Preview -->
                                        <img 
                                            src="" 
                                            alt="Applicant Image" 
                                            width="200" 
                                            style="display:none;"
                                            id="category_image_preview">
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="mb-4 align-items-center">
                            <label class="col-form-label fw-bold">
                                এন আই ডি <span class="text-danger">*</span>
                            </label>
                            <div class="ms-5">
                                <input type="file" name="nid_image" class="form-control form-control-lg @error('nid_image') is-invalid @enderror" placeholder="" id="nid_image">
                                @error('nid_image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                @if($applicant->nid_image)
                                @php
                                    $filePath = $applicant->nid_image;
                                    $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                                    $pdf_display = $extension=='pdf'?'':'display:none;';
                                    $img_display = $extension!='pdf'?'':'display:none;';
                                @endphp
                                    <div class="my-2" id="nid_preview_box" >
                                        <!-- PDF Preview -->
                                        <iframe 
                                            src="{{ asset('storage/'.$filePath) }}" 
                                            width="100%" 
                                            height="300" 
                                            style="border:1px solid #ccc;{{ $pdf_display }}"
                                            id="nid_pdf_preview">
                                        </iframe>
                                        <!-- Image Preview -->
                                        <img 
                                            src="{{ asset('storage/'.$filePath) }}" 
                                            alt="Nid Image" 
                                            width="200" 
                                            style="{{ $img_display }}"
                                            id="nid_image_preview">
                                    </div>
                                @else
                                    <div class="my-2" id="nid_preview_box" >
                                        <!-- PDF Preview -->
                                        <iframe 
                                            src="" 
                                            width="100%" 
                                            height="300" 
                                            style="border:1px solid #ccc;display:none;"
                                            id="nid_pdf_preview">
                                        </iframe>
                                        <!-- Image Preview -->
                                        <img 
                                            src="" 
                                            alt="Nid Image" 
                                            width="200" 
                                            style="display:none;"
                                            id="nid_image_preview">
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3 align-items-center">
                            <label class="col-form-label fw-bold">
                                পে অর্ডারের ছবি<span class="text-danger">*</span>
                            </label>
                            <div class="ms-5">
                                <input type="file" name="py_order_image" class="form-control form-control-lg @error('py_order_image') is-invalid @enderror" placeholder="" id="py_order_image">
                                @error('py_order_image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                @if($applicant->py_order_image)
                                @php
                                    $filePath = $applicant->py_order_image;
                                    $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                                    $pdf_display = $extension=='pdf'?'':'display:none;';
                                    $img_display = $extension!='pdf'?'':'display:none;';
                                @endphp
                                    <div class="my-2"  id="pay_order_preview_box" >
                                        <!-- PDF Preview -->
                                        <iframe 
                                            src="{{ asset('storage/'.$filePath) }}" 
                                            width="100%" 
                                            height="300" 
                                            style="border:1px solid #ccc;{{ $pdf_display }}"
                                            id="pay_order_pdf_preview">
                                        </iframe>
                                        <!-- Image Preview -->
                                        <img 
                                            src="{{ asset('storage/'.$filePath) }}" 
                                            alt="Pay Order Image" 
                                            width="200" 
                                            style="{{ $img_display }}"
                                            id="pay_order_image_preview">
                                    </div>
                                @else
                                    <div class="my-2"  id="pay_order_preview_box" >
                                        <!-- PDF Preview -->
                                        <iframe 
                                            src="" 
                                            width="100%" 
                                            height="300" 
                                            style="border:1px solid #ccc;display:none;"
                                            id="pay_order_pdf_preview">
                                        </iframe>
                                        <!-- Image Preview -->
                                        <img 
                                            src="" 
                                            alt="Pay Order Image" 
                                            width="200" 
                                            style="display:none;"
                                            id="pay_order_image_preview">
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class=" mb-3 align-items-center citizen_certificate_block" style="{{ in_array(old('category_id',$applicant->category_id), [3,5]) ? 'display:none;' : '' }}">
                            <label class="col-form-label fw-bold">
                                নাগরিক সনদ<span class="text-danger">*</span><br>
                                <small class="text-danger">মুক্তিযোদ্ধা ও ক্যান্টনমেন্ট বোর্ডের অবসর প্রাপ্ত কর্মকর্তা/কর্মচারীর জন্য প্রযোজ্য নয়</small>
                            </label>
                            <div class="ms-5">
                                <input type="file" name="citizen_certificate_image" class="form-control form-control-lg @error('citizen_certificate_image') is-invalid @enderror" placeholder="" id="citizen_certificate_image">
                                @error('citizen_certificate_image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                @if($applicant->citizen_certificate_image)
                                @php
                                    $filePath = $applicant->citizen_certificate_image;
                                    $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                                    $pdf_display = $extension=='pdf'?'':'display:none;';
                                    $img_display = $extension!='pdf'?'':'display:none;';
                                @endphp
                                    <div class="my-2" id="citizen_preview_box" >
                                        <!-- PDF Preview -->
                                        <iframe 
                                            src="{{ asset('storage/'.$filePath) }}" 
                                            width="100%" 
                                            height="300" 
                                            style="border:1px solid #ccc;{{ $pdf_display }}"
                                            id="citizen_pdf_preview">
                                        </iframe>
                                        <!-- Image Preview -->
                                        <img 
                                            src="{{ asset('storage/'.$filePath) }}" 
                                            alt="Citizen Image" 
                                            width="200" 
                                            style="{{ $img_display }}"
                                            id="citizen_image_preview">
                                    </div>
                                @else
                                    <div class="my-2" id="citizen_preview_box" >
                                        <!-- PDF Preview -->
                                        <iframe 
                                            src="" 
                                            width="100%" 
                                            height="300" 
                                            style="border:1px solid #ccc;display:none;"
                                            id="citizen_pdf_preview">
                                        </iframe>
                                        <!-- Image Preview -->
                                        <img 
                                            src="" 
                                            alt="Citizen Image" 
                                            width="200" 
                                            style="display:none;"
                                            id="citizen_image_preview">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- Submit Button -->
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-success btn-lg px-5">জমা দিন</button>
                        <a href="{{ route('home') }}" class="btn btn-secondary btn-lg px-5" >ফিরে যান</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        // image preview
        document.getElementById('applicant_image').addEventListener('change', function(e) {
            const [file] = e.target.files;
            if (file) {
                document.getElementById('applicant_preview_box').style.display = 'block';
                if (file.type.startsWith("image/")) {
                    document.getElementById('applicant_image_preview').style.display = "block";
                    document.getElementById('applicant_pdf_preview').style.display = "none";
                    document.getElementById('applicant_image_preview').src = URL.createObjectURL(file);
                }else if (file.type === "application/pdf") {
                    document.getElementById('applicant_image_preview').style.display = "none";
                    document.getElementById('applicant_pdf_preview').style.display = "block";
                    document.getElementById('applicant_pdf_preview').src = URL.createObjectURL(file);
                }
                //document.getElementById('applicant_image_preview').src = URL.createObjectURL(file);
            }
        });
        document.getElementById('citizen_certificate_image').addEventListener('change', function(e) {
            const [file] = e.target.files;
            if (file) {
                document.getElementById('citizen_preview_box').style.display = 'block';
                if (file.type.startsWith("image/")) {
                    document.getElementById('citizen_image_preview').style.display = "block";
                    document.getElementById('citizen_pdf_preview').style.display = "none";
                    document.getElementById('citizen_image_preview').src = URL.createObjectURL(file);
                }else if (file.type === "application/pdf") {
                    document.getElementById('citizen_image_preview').style.display = "none";
                    document.getElementById('citizen_pdf_preview').style.display = "block";
                    document.getElementById('citizen_pdf_preview').src = URL.createObjectURL(file);
                }
                //document.getElementById('citizen_image_preview').src = URL.createObjectURL(file);
            }
        });
        document.getElementById('category_proof_image').addEventListener('change', function(e) {
            const [file] = e.target.files;
            if (file) {
                document.getElementById('category_preview_box').style.display = 'block';
                if (file.type.startsWith("image/")) {
                    document.getElementById('category_image_preview').style.display = "block";
                    document.getElementById('category_pdf_preview').style.display = "none";
                    document.getElementById('category_image_preview').src = URL.createObjectURL(file);
                }else if (file.type === "application/pdf") {
                    document.getElementById('category_image_preview').style.display = "none";
                    document.getElementById('category_pdf_preview').style.display = "block";
                    document.getElementById('category_pdf_preview').src = URL.createObjectURL(file);
                }
                //document.getElementById('category_image_preview').src = URL.createObjectURL(file);
            }
        });
        document.getElementById('nid_image').addEventListener('change', function(e) {
            const [file] = e.target.files;
            if (file) {
                document.getElementById('nid_preview_box').style.display = 'block';
                if (file.type.startsWith("image/")) {
                    document.getElementById('nid_image_preview').style.display = "block";
                    document.getElementById('nid_pdf_preview').style.display = "none";
                    document.getElementById('nid_image_preview').src = URL.createObjectURL(file);
                }else if (file.type === "application/pdf") {
                    document.getElementById('nid_image_preview').style.display = "none";
                    document.getElementById('nid_pdf_preview').style.display = "block";
                    document.getElementById('nid_pdf_preview').src = URL.createObjectURL(file);
                }
                //document.getElementById('nid_image_preview').src = URL.createObjectURL(file);
            }
        });
        document.getElementById('py_order_image').addEventListener('change', function(e) {
            const [file] = e.target.files;
            if (file) {
                document.getElementById('pay_order_preview_box').style.display = 'block';
                if (file.type.startsWith("image/")) {
                    document.getElementById('pay_order_image_preview').style.display = "block";
                    document.getElementById('pay_order_pdf_preview').style.display = "none";
                    document.getElementById('pay_order_image_preview').src = URL.createObjectURL(file);
                }else if (file.type === "application/pdf") {
                    document.getElementById('pay_order_image_preview').style.display = "none";
                    document.getElementById('pay_order_pdf_preview').style.display = "block";
                    document.getElementById('pay_order_pdf_preview').src = URL.createObjectURL(file);
                }
                //document.getElementById('pay_order_image_preview').src = URL.createObjectURL(file);
            }
        });
        // based on category_id hide or show citizen_certificate_image
        document.querySelectorAll('input[name="category_id"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                console.log("Selected Category:", this.value);
                let block = document.querySelector('.citizen_certificate_block');

                if (this.value == 3 || this.value == 5) {
                    block.style.display = "none";
                } else {
                    block.style.display = "block";
                }
            });
        });
    </script>
    @if ($errors->any())
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let firstError = document.querySelector('.is-invalid');

            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
    </script>
    @endif
@endsection