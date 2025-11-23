<div class="print-area border p-4 rounded mt-4 shadow-sm bg-white">

    <div class="text-center mb-4">
        <h3 class="fw-bold">আবেদনকারীর তথ্য</h3>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <p><strong>নাম:</strong> {{ $applicant->applicant_name }}</p>
            <p><strong>পিতার নাম:</strong> {{ $applicant->guardian_name }}</p>
            <p><strong>বর্তমান ঠিকানা:</strong> {{ $applicant->present_address }}</p>
            <p><strong>স্থায়ী ঠিকানা:</strong> {{ $applicant->permanent_address }}</p>
        </div>

        <div class="col-md-6">
            <p><strong>NID:</strong> {{ $applicant->nid_no }}</p>
            <p><strong>মোবাইল:</strong> {{ $applicant->phone }}</p>
            <p><strong>ইমেইল:</strong> {{ $applicant->email ?? '—' }}</p>
        </div>
    </div>

    <hr>

    <h5 class="fw-bold mt-4 mb-3">রুট ও ক্যাটাগরি</h5>
    <p><strong>রুট:</strong> {{ $applicant->area->area_name ?? '' }}</p>
    <p><strong>ক্যাটাগরি:</strong> {{ $applicant->category->category_name ?? '' }}</p>

    <hr>

    <h5 class="fw-bold mt-4 mb-3">আবেদনের অবস্থা</h5>
    <p><strong>{{ $applicant->status??'' }}</strong> </p>
    <!-- <hr>

    <h5 class="fw-bold mt-4 mb-3">পে অর্ডার তথ্য</h5>
    <p><strong>ব্যাংকের নাম:</strong> {{ $applicant->bank_name ?? '—' }}</p>
    <p><strong>পে অর্ডার নং:</strong> {{ $applicant->pay_order_no ?? '—' }}</p>
    <p><strong>পরিমাণ:</strong> {{ $applicant->amount ?? '—' }}</p>
    <p><strong>তারিখ:</strong> {{ $applicant->order_date ?? '—' }}</p> -->
</div>
