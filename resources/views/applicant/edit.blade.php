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
                                এন আইডি নং <span class="text-danger">*</span>
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
                        <h5 class="fw-bold mb-4">পে অর্ডারের বিবরন (Pay Order Information)</h5>
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
                                <input type="text" name="amount" class="form-control form-control-lg @error('amount') is-invalid @enderror" placeholder="" value="{{ old('amount',$applicant->amount) }}">
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
                                    <div class="my-2" id="applicant_preview_box" >
                                        <img src="{{ asset('storage/'.$applicant->applicant_image) }}" alt="Applicant Image" width="200" id="applicant_image_preview">
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- <div class=" mb-3 align-items-center">
                            <label class="col-form-label fw-bold">
                                স্বাক্ষর
                            </label>
                            <div class="ms-5">
                                <input type="file" name="signature_image" class="form-control form-control-lg" placeholder="">
                            </div>
                        </div> -->

                        <div class=" mb-3 align-items-center">
                            <label class="col-form-label fw-bold">
                                নাগরিক সনদ
                            </label>
                            <div class="ms-5">
                                <input type="file" name="citizen_certificate_image" class="form-control form-control-lg" placeholder="" id="citizen_certificate_image">
                                @if($applicant->citizen_certificate_image)
                                    <div class="my-2" id="citizen_preview_box" >
                                        <img src="{{ asset('storage/'.$applicant->citizen_certificate_image) }}" alt="Citizen Certificate Image" width="200" id="citizen_image_preview">
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class=" mb-3 align-items-center">
                            <label class="col-form-label fw-bold">
                                ক্যাটাগরি প্রমানক
                            </label>
                            <div class="ms-5">
                                <input type="file" name="category_proof_image" class="form-control form-control-lg" placeholder="" id="category_proof_image">
                                @if($applicant->category_proof_image)
                                    <div class="my-2" id="category_preview_box" >
                                        <img src="{{ asset('storage/'.$applicant->category_proof_image) }}" alt="Category Proof Image" width="200" id="category_image_preview">
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
                                    <div class="my-2" id="nid_preview_box" >
                                        <img src="{{ asset('storage/'.$applicant->nid_image) }}" alt="NID Image" width="200" id="nid_image_preview">
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3 align-items-center">
                            <label class="col-form-label fw-bold">
                                পে অর্ডারের ছবি
                            </label>
                            <div class="ms-5">
                                <input type="file" name="py_order_image" class="form-control form-control-lg" placeholder="" id="py_order_image">
                                @if($applicant->py_order_image)
                                    <div class="my-2"  id="pay_order_preview_box" >
                                        <img src="{{ asset('storage/'.$applicant->py_order_image) }}" alt="Pay Order Image" width="200" id="pay_order_image_preview">
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
                document.getElementById('applicant_image_preview').src = URL.createObjectURL(file);
            }
        });
        document.getElementById('citizen_certificate_image').addEventListener('change', function(e) {
            const [file] = e.target.files;
            if (file) {
                document.getElementById('citizen_preview_box').style.display = 'block';
                document.getElementById('citizen_image_preview').src = URL.createObjectURL(file);
            }
        });
        document.getElementById('category_proof_image').addEventListener('change', function(e) {
            const [file] = e.target.files;
            if (file) {
                document.getElementById('category_preview_box').style.display = 'block';
                document.getElementById('category_image_preview').src = URL.createObjectURL(file);
            }
        });
        document.getElementById('nid_image').addEventListener('change', function(e) {
            const [file] = e.target.files;
            if (file) {
                document.getElementById('nid_preview_box').style.display = 'block';
                document.getElementById('nid_image_preview').src = URL.createObjectURL(file);
            }
        });
        document.getElementById('py_order_image').addEventListener('change', function(e) {
            const [file] = e.target.files;
            if (file) {
                document.getElementById('pay_order_preview_box').style.display = 'block';
                document.getElementById('pay_order_image_preview').src = URL.createObjectURL(file);
            }
        });
    </script>
@endsection