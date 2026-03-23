@extends('layouts.admin')

@section('title', 'Create Category')
@section('page-title', 'Create Category')

@section('extra-css')
<style>
.form-wrap{max-width:860px;margin:0 auto}
.form-card{background:#fff;border:1px solid #e5e7eb;border-radius:18px;padding:18px}
.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px}
.form-group{display:grid;gap:8px}
.form-group.full{grid-column:1 / -1}
.form-label{font-size:13px;font-weight:700;color:#374151}
.form-input,.form-textarea,.form-file{width:100%;padding:11px 12px;border:1px solid #d1d5db;border-radius:12px;background:#fff;font-size:14px}
.form-textarea{min-height:120px;resize:vertical}
.form-input:focus,.form-textarea:focus,.form-file:focus{outline:none;border-color:#d88411;box-shadow:0 0 0 3px #f8e8cf}
.preview{width:120px;height:120px;object-fit:cover;border:1px solid #ececec;border-radius:12px;background:#f6f6f6}
.actions{display:flex;gap:10px;justify-content:flex-end;margin-top:16px}
.btn{display:inline-flex;align-items:center;gap:8px;padding:10px 14px;border-radius:12px;text-decoration:none;font-weight:700;border:none;cursor:pointer}
.btn-cancel{background:#fff;border:1px solid #d1d5db;color:#374151}
.btn-save{background:#d88411;color:#fff}
.btn-save:hover{background:#be730f}
.error-text{font-size:12px;color:#b91c1c}

@media (max-width: 880px){
    .form-grid{grid-template-columns:1fr}
}
</style>
@endsection

@section('content')
<div class="form-wrap">
    <form class="form-card" method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-grid">
            <div class="form-group">
                <label class="form-label" for="name">Category Name</label>
                <input class="form-input" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')<div class="error-text">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="image_file">Category Image (optional)</label>
                <input class="form-file" id="image_file" type="file" name="image_file" accept="image/png,image/jpeg,image/jpg,image/webp,image/avif">
                @error('image_file')<div class="error-text">{{ $message }}</div>@enderror
            </div>

            <div class="form-group full">
                <label class="form-label" for="description">Description (optional)</label>
                <textarea class="form-textarea" id="description" name="description">{{ old('description') }}</textarea>
                @error('description')<div class="error-text">{{ $message }}</div>@enderror
            </div>

            <div class="form-group full">
                <label class="form-label">Image Preview</label>
                <img id="previewImage" class="preview" src="{{ asset('images/logo.png') }}" alt="Preview">
            </div>
        </div>

        <div class="actions">
            <a href="{{ route('admin.categories.index') }}" class="btn btn-cancel">Cancel</a>
            <button type="submit" class="btn btn-save"><i class="fa-solid fa-floppy-disk"></i> Save Category</button>
        </div>
    </form>
</div>

<script>
(() => {
    const input = document.getElementById('image_file');
    const preview = document.getElementById('previewImage');
    if (!input || !preview) {
        return;
    }

    input.addEventListener('change', (event) => {
        const file = event.target.files && event.target.files[0] ? event.target.files[0] : null;
        if (!file) {
            preview.src = "{{ asset('images/logo.png') }}";
            return;
        }

        const reader = new FileReader();
        reader.onload = () => {
            preview.src = String(reader.result);
        };
        reader.readAsDataURL(file);
    });
})();
</script>
@endsection
