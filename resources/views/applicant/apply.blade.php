@extends('layouts.frontend')
@section('main_content')
    @include('applicant.success_modal')
    <!-- load a Bengali-capable webfont (optional but recommended) -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif&display=swap" rel="stylesheet">

    <style>
        .arc-text {
            font-family: "Noto Serif", "Noto Sans", sans-serif;
            font-weight: 700;
            font-size: 47px;
            fill: #111;
            stroke: #111;
            stroke-width: 0.4;
            letter-spacing: -4px;
        }

        .logo-centered {
            width: 120px;
            height: 120px;
            object-fit: contain;
            display: block;
            margin: -150px auto 0;
            border-radius: 50%;
            background: transparent;
        }

        /* container spacing */
        .arch-wrap {
            margin-bottom: 10px;
        }
    </style>

    <!-- Top Heading -->
    <h3 class="text-center fw-bold mb-1">
        ক্যান্টনমেন্ট এক্সিকিউটিভ অফিসারের কার্যালয়
    </h3>
    <h5 class="text-center fw-bold mb-2">
        ঢাকা ক্যান্টনমেন্ট, ঢাকা
    </h5>

    <section id="application-instructions" style="border:1px solid #e0e0e0;border-radius:8px;padding:16px;margin-bottom:16px;background:#fafafa;">
        <h3 style="margin-top:0;font-size:1.1rem;">নির্দেশনাসমূহঃ</h3>
        <ul style="padding-left:1.25rem;line-height:1.5;margin-bottom:12px; color:red;">
            <li>একজন ব্যক্তি একের অধিক কোটায় আবেদন করতে পারবেন না। আবেদনকারী মনোনীত হলে ১টি লাইসেন্স ইজারা/বরাদ্দ পাবেন।</li>
            <li>আবেদনের সাথে সিইও, ঢাকা ক্যান্টনমেন্ট এর অনুকূলে লাইসেন্স ফি বাবদ ৭৩০০/- (সাত হাজার তিনশত) টাকার পে-অর্ডারের কপিসহ তথ্য প্রদান করতে হবে। আবেদনকারী মনোনীত হলে পে-অর্ডার জমা প্রদান করতে হবে।</li>
            <li>রিক্সার লাইসেন্সের জন্য অনুমতিপ্রাপ্ত হলে লাইসেন্স ফি এর উপর 15% ভ্যাট ও 10% উৎসকর প্রদান করতে হবে। এছাড়া প্রতিটি লাইসেন্সের জন্য ৩০০০/- (তিন হাজার) টাকা জমা রাখতে হবে। এর মধ্যে জামানত বাবদ ২০০০/- টাকা লাইসেন্সের মেয়াদ শেষে ফেরতযোগ্য। অবশিষ্ট ১০০০/- টাকা রিক্সা মনিটরিং ফি বাবদ কর্তন করা হবে।</li>
            <li>রিক্সার লাইসেন্স বিক্রয় করা যাবে না, তবে ভাড়া প্রদান করতে পারবেন। কোনো অনিয়ম পরিলক্ষিত হলে জামানত বাজেয়াপ্ত ও প্রয়োজনীয় আইনানুগ ব্যবস্থা গ্রহণ করা হবে।</li>
            <li>আবেদনকারী ঢাকা সিটিকর্পোরেশন বা ঢাকা ক্যান্টনমেন্ট বোর্ডের আওতাধীন এলাকায় বসবাসকারী হতে হবে। প্রমানক হিসেবে সংশ্লিষ্ট এলাকার নাগরিক সনদপত্র দাখিল করতে হবে।</li>
            <li>সকল কোটার আবেদনের ক্ষেত্রে কোটার প্রমানক সংযুক্ত করতে হবে।</li>
        </ul>
    </section>
    <div class="text-center mb-2" id="showFormBtnContainer">
        <button id="showFormBtn" class="btn btn-primary btn-lg">আবেদন করুন</button>
        <!-- @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif -->
    </div>
    <div class="card shadow border-0 rounded-4 mb-5" style="background: white;{{ $errors->any() ? '' : 'display:none;' }}" id="applicantFormCard">
        <div class="card-body">
            <div class="container mt-5">
                <form action="{{ route('applicant.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
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
                                        {{ old('area_id') == $area->id ? 'checked' : '' }}
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
                                        {{ old('category_id') == $category->id ? 'checked' : '' }}
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
                                <input type="text" name="applicant_name" class="form-control form-control-lg @error('applicant_name') is-invalid @enderror" placeholder="" value="{{ old('applicant_name') }}">
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
                                <input type="text" name="guardian_name" class="form-control form-control-lg @error('guardian_name') is-invalid @enderror" placeholder="" value="{{ old('guardian_name') }}">
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
                                <input type="text" name="present_address" class="form-control form-control-lg @error('present_address') is-invalid @enderror" placeholder="" value="{{ old('present_address') }}">
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
                                <input type="text" name="permanent_address" class="form-control form-control-lg @error('permanent_address') is-invalid @enderror"  placeholder="" value="{{ old('permanent_address') }}">
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
                                <input type="text" name="nid_no" class="form-control form-control-lg @error('nid_no') is-invalid @enderror" placeholder="" value="{{ old('nid_no') }}">
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
                                <input type="email" name="email" class="form-control form-control-lg" placeholder="" value="{{ old('email') }}">
                            </div>
                        </div>
                        <div class="mb-3 align-items-center">
                            <label class="col-form-label fw-bold">
                                মোবাইল<span class="text-danger">*</span>
                            </label>
                            <div class="ms-5">
                                <input type="text" name="phone" class="form-control form-control-lg @error('phone') is-invalid @enderror " placeholder="" value="{{ old('phone') }}">
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
                                <input type="text" name="bank_name" class="form-control form-control-lg @error('bank_name') is-invalid @enderror" placeholder="" value="{{ old('bank_name') }}">
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
                                <input type="text" name="pay_order_no" class="form-control form-control-lg @error('pay_order_no') is-invalid @enderror" placeholder="" value="{{ old('pay_order_no') }}">
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
                                <input type="text" name="amount" class="form-control form-control-lg @error('amount') is-invalid @enderror" placeholder="" value="{{ $app_setting->yearly_fee ?? '' }}" readonly>
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
                                <input type="text" name="order_date" class="form-control form-control-lg @error('order_date') is-invalid @enderror" id="order_date" placeholder="" value="{{ old('order_date') }}" readonly>
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
                                <input type="file" name="applicant_image" class="form-control form-control-lg @error('applicant_image') is-invalid @enderror" placeholder=""  id="applicant_image"> 
                                @error('applicant_image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="my-2" id="applicant_preview_box" style="display:none;">
                                    <img src="" id="applicant_image_preview" alt="Applicant Image" width="200" style="display: none;">
                                    <iframe id="applicant_pdf_preview" style="width:100%; height:300px; display:none;"></iframe>
                                </div>
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
                                <input type="file" name="citizen_certificate_image" class="form-control form-control-lg @error('citizen_certificate_image') is-invalid @enderror" placeholder="" id="citizen_certificate_image">
                                @error('citizen_certificate_image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="my-2" id="citizen_preview_box" style="display:none;">
                                    <img src="" id="citizen_image_preview" alt="Citizen Image" width="200" style="display:none;">
                                    <iframe id="citizen_pdf_preview" style="width:100%; height:300px; display:none;"></iframe>
                                </div>
                            </div>
                        </div>

                        <div class=" mb-3 align-items-center">
                            <label class="col-form-label fw-bold">
                                ক্যাটাগরি প্রমানক
                            </label>
                            <div class="ms-5">
                                <input type="file" name="category_proof_image" class="form-control form-control-lg @error('category_proof_image') is-invalid @enderror" placeholder="" id="category_proof_image">
                                @error('category_proof_image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="my-2" id="category_preview_box" style="display:none;">
                                    <img src="" id="category_image_preview" alt="Citizen Image" width="200" style="display:none;">
                                    <iframe id="category_pdf_preview" style="width:100%; height:300px; display:none;"></iframe>
                                </div>
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
                                <div class="my-2" id="nid_preview_box" style="display:none;">
                                    <img src="" id="nid_image_preview" alt="Citizen Image" width="200" style="display:none;">
                                    <iframe id="nid_pdf_preview" style="width:100%; height:300px; display:none;"></iframe>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 align-items-center">
                            <label class="col-form-label fw-bold">
                                পে অর্ডারের ছবি
                            </label>
                            <div class="ms-5">
                                <input type="file" name="py_order_image" class="form-control form-control-lg @error('py_order_image') is-invalid @enderror" placeholder="" id="py_order_image">
                                @error('py_order_image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="my-2" id="pay_order_preview_box" style="display:none;">
                                    <img src="" id="pay_order_image_preview" alt="Pay Order Image" style="width:200px; display:none;">
                                    <iframe id="pay_order_pdf_preview" style="width:100%; height:300px; display:none;"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Submit Button -->
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-success btn-lg px-5">জমা দিন</button>
                        <button type="button" class="btn btn-secondary btn-lg px-5" id="close_application">ফিরে যান</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="text-center mb-4" id="application_status">
        <button id="showStatusBtn" class="btn btn-info btn-lg">আবেদনের অবস্থা</button>
    </div>
    <div class="card shadow border-0 rounded-4 mb-5" 
     id="searchCard" 
     style="background:white; display:none;">
        <div class="card-body">
            <h4 class="text-center mb-3">আবেদনের অবস্থা অনুসন্ধান করুন</h4>

            <div id="searchError" class="alert alert-danger d-none"></div>

            <form id="searchForm">
                <div class="mb-3">
                    <label class="fw-bold">এন আই ডি নং</label>
                    <input type="text" class="form-control form-control-lg" id="nid_search">
                </div>

                <div class="mb-3">
                    <label class="fw-bold">মোবাইল</label>
                    <input type="text" class="form-control form-control-lg" id="phone_search">
                </div>

                <button type="submit" class="btn btn-primary btn-lg mx-auto">
                    <span class="spinner-border spinner-border-sm d-none" id="searchLoader"></span>
                    <span id="searchBtnText">অনুসন্ধান করুন</span>
                </button>
                <button type="button" class="btn btn-secondary btn-lg px-5" id="close_status_form">ফিরে যান</button>
                
            </form>

            <hr>

            <!-- Where result will show -->
            <div id="searchResult"></div>
        </div>
    </div>


    <script>
        // show application form
        document.getElementById('showFormBtn').addEventListener('click', function() {
            
             const formCard = document.getElementById('applicantFormCard');

            if (formCard.style.display === 'none' || formCard.style.display === '') {
                // Show the form
                formCard.style.display = 'block';
                window.scrollTo({
                    top: formCard.offsetTop - 20,
                    behavior: 'smooth'
                });
                // hide application status button
                document.getElementById('application_status').style.display = 'none';
                document.getElementById('searchCard').style.display = 'none';
            } else {
                // Hide the form
                formCard.style.display = 'none';
                this.textContent = 'আবেদন করুন'; // original button text
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
                // show application status button
                document.getElementById('application_status').style.display = 'block';
            }
        });
        // close application form
        document.getElementById('close_application').addEventListener('click', function(){
            document.getElementById('applicantFormCard').style.display = 'none';
            // show application status button
            document.getElementById('application_status').style.display = 'block';
        })
        // show status search form
        document.getElementById('showStatusBtn').addEventListener('click', function() {
            // hide application button
            document.getElementById('showFormBtnContainer').style.display = 'none';
            // show status search form
            document.getElementById('searchCard').style.display = 'block';
            window.scrollTo({ top: document.getElementById('searchCard').offsetTop - 20, behavior: 'smooth' });
        });
        // close status form
        document.getElementById('close_status_form').addEventListener('click', function(){
            // hide search status form
            document.getElementById('searchCard').style.display = 'none';
            // show application button
            document.getElementById('showFormBtnContainer').style.display = 'block';
        })

        document.addEventListener('click', function(e) {
            if (e.target && e.target.id === 'close_search_card') {
                document.getElementById('searchResult').innerHTML = '';
                document.getElementById('searchCard').style.display = 'none';
                document.getElementById('showFormBtnContainer').style.display = 'block';
            }
        });

        document.getElementById('searchForm').addEventListener('submit', function(e) {
            e.preventDefault();

            let nid = document.querySelector("#nid_search").value;
            let phone = document.querySelector("#phone_search").value;

            if (!nid && !phone) {
                alert("NID বা মোবাইল নম্বর দিন");
                return;
            }
            // show loader
            document.getElementById('searchLoader').classList.remove('d-none');
            fetch("{{ route('applicant.search') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    nid: nid,
                    phone: phone
                })
            })
            .then(res => res.json())
            .then(data => {
                // hide loader
                document.getElementById('searchLoader').classList.add('d-none');
                if (data.error) {
                    document.getElementById('searchError').innerHTML = data.error;
                    document.getElementById('searchError').classList.remove('d-none');
                    document.getElementById('searchResult').innerHTML = "";
                } else {
                    document.getElementById('searchError').classList.add('d-none');
                    document.getElementById('searchResult').innerHTML = data.html;
                }
                window.scrollTo({ top: document.getElementById('searchResult').offsetTop + 470, behavior: 'smooth' });
            });
        });
        // document.getElementById("printBtn").addEventListener("click", function() {
        //     let nid = document.querySelector("#nid_search").value;
        //     let phone = document.querySelector("#phone_search").value;

        //     if (!nid && !phone) {
        //         alert("NID বা মোবাইল নম্বর দিন");
        //         return;
        //     }

        //     let url = `{{ route('applicant.print') }}?nid=${nid}&phone=${phone}`;

        //     window.open(url, "_blank");
        // });
        $('#order_date').datepicker({
            format: 'dd-mm-yyyy',
            todayHighlight: true,
            autoclose: true
        });

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
                
            }
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