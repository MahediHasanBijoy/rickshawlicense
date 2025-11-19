@extends('layouts.frontend')
@section('main_content')
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
    <h3 class="text-center fw-bold mb-4">
        ক্যান্টনমেন্ট এক্সিকিউটিভ অফিসারের কার্যালয়, ঢাকা
    </h3>

    <div class="text-center mb-4">
        <button id="showFormBtn" class="btn btn-primary btn-lg">আবেদন করুন</button>
    </div>
    <div class="card shadow border-0 rounded-4 mb-5" style="background: white;display: none;" id="applicantFormCard">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
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
                                <input type="text" name="phone" class="form-control form-control-lg @error('phone') is-invalid @enderror" placeholder="" value="{{ old('phone') }}">
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
                                ব্যাংকের নাম
                            </label>
                            <div class="ms-5">
                                <input type="text" name="bank_name" class="form-control form-control-lg" placeholder="" value="{{ old('bank_name') }}">
                            </div>
                        </div>

                        <div class=" mb-3 align-items-center">
                            <label class="col-form-label fw-bold">
                                পে অর্ডার নং
                            </label>
                            <div class="ms-5">
                                <input type="text" name="pay_order_no" class="form-control form-control-lg" placeholder="" value="{{ old('pay_order_no') }}">
                            </div>
                        </div>

                        <div class="mb-4 align-items-center">
                            <label class="col-form-label fw-bold">
                                পরিমান
                            </label>
                            <div class="ms-5">
                                <input type="text" name="amount" class="form-control form-control-lg" placeholder="" value="{{ old('amount') }}">
                            </div>
                        </div>
                        <div class="mb-3 align-items-center">
                            <label class="col-form-label fw-bold">
                                পরিশোধের তারিখ
                            </label>
                            <div class="ms-5">
                                <input type="date" name="order_date" class="form-control form-control-lg" placeholder="" value="{{ old('order_date') }}">
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
                                <input type="file" name="applicant_image" class="form-control form-control-lg @error('applicant_image') is-invalid @enderror" placeholder="" > 
                                @error('applicant_image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class=" mb-3 align-items-center">
                            <label class="col-form-label fw-bold">
                                স্বাক্ষর
                            </label>
                            <div class="ms-5">
                                <input type="file" name="signature_image" class="form-control form-control-lg" placeholder="">
                            </div>
                        </div>

                        <div class="mb-4 align-items-center">
                            <label class="col-form-label fw-bold">
                                এন আই ডি <span class="text-danger">*</span>
                            </label>
                            <div class="ms-5">
                                <input type="file" name="nid_image" class="form-control form-control-lg @error('nid_image') is-invalid @enderror" placeholder="">
                                @error('nid_image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 align-items-center">
                            <label class="col-form-label fw-bold">
                                পে অর্ডারের ছবি
                            </label>
                            <div class="ms-5">
                                <input type="file" name="py_order_image" class="form-control form-control-lg" placeholder="">
                            </div>
                        </div>
                    </div>
                    <!-- Submit Button -->
                    <div class="text-center mt-3">
                        <button class="btn btn-success btn-lg px-5">জমা দিন</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="text-center mb-4">
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
                    অনুসন্ধান করুন
                </button>
                <button type="button" class="btn btn-success btn-lg mx-auto" id="printBtn">
                    প্রিন্ট করুন
                </button>
            </form>

            <hr>

            <!-- Where result will show -->
            <div id="searchResult"></div>
        </div>
    </div>


    <script>
        // show application form
        document.getElementById('showFormBtn').addEventListener('click', function() {
            document.getElementById('applicantFormCard').style.display = 'block';
            this.style.display = 'none'; // hide the button after click
            window.scrollTo({ top: document.getElementById('applicantFormCard').offsetTop - 20, behavior: 'smooth' });
        });
        // show search form
        document.getElementById('showStatusBtn').addEventListener('click', function() {
            document.getElementById('searchCard').style.display = 'block';
            window.scrollTo({ top: document.getElementById('searchCard').offsetTop - 20, behavior: 'smooth' });
        });

        document.getElementById('searchForm').addEventListener('submit', function(e) {
            e.preventDefault();

            let nid = document.querySelector("#nid_search").value;
            let phone = document.querySelector("#phone_search").value;

            if (!nid && !phone) {
                alert("NID বা মোবাইল নম্বর দিন");
                return;
            }


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
                if (data.error) {
                    document.getElementById('searchError').innerHTML = data.error;
                    document.getElementById('searchError').classList.remove('d-none');
                    document.getElementById('searchResult').innerHTML = "";
                } else {
                    document.getElementById('searchError').classList.add('d-none');
                    document.getElementById('searchResult').innerHTML = data.html;
                }
            });
        });
        document.getElementById("printBtn").addEventListener("click", function() {
            let nid = document.querySelector("#nid_search").value;
            let phone = document.querySelector("#phone_search").value;

            if (!nid && !phone) {
                alert("NID বা মোবাইল নম্বর দিন");
                return;
            }

            let url = `{{ route('applicant.print') }}?nid=${nid}&phone=${phone}`;

            window.open(url, "_blank");
        });
    </script>
@endsection