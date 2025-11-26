@if(session('success'))
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 shadow">

      <div class="modal-header border-0 justify-content-center">
        <h5 class="modal-title fw-bold text-success">✅ আবেদন সফল হয়েছে</h5>
      </div>

      <div class="modal-body text-center">
        <p class="fw-bold fs-5">{{ session('success') }}</p>

        @if(session('id'))
        <a href="{{ route('applicant.print') }}?id={{ session('id') }}"
            target="_blank"
            class="btn btn-info mt-3">
            প্রিন্ট করুন
        </a>
        <a href="{{ route('applicant.edit', session('id')) }}" class="btn btn-warning mt-3">
            সম্পাদনা করুন
        </a>
        @endif
      </div>

      <div class="modal-footer border-0 justify-content-center">
        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
          বন্ধ করুন
        </button>
      </div>

    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    let successModal = new bootstrap.Modal(document.getElementById('successModal'));
    successModal.show();
});
</script>
@endif
