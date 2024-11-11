@extends('Home')

@section('content')
    <div class="container mt-5 mb-5">
        <h1 class="mb-4">استيراد الملفات</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-header bg-sacondary text-white">
                <h5 class="mb-0">استيراد الطلاب</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('import.students') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="students_file">اختر ملف Excel (الطلاب):</label>
                        <input type="file" class="form-control-file" id="students_file" name="file" required>
                    </div>
                    <button type="submit" class="btn btn-success">استيراد الطلاب</button>
                </form>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-header bg-sacondary text-white">
                <h5 class="mb-0">استيراد مواد الطلاب</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('import.subjects') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="subjects_file">اختر ملف Excel (مواد الطلاب):</label>
                        <input type="file" class="form-control-file" id="subjects_file" name="file" required>
                    </div>
                    <button type="submit" class="btn btn-success">استيراد مواد الطلاب</button>
                </form>
            </div>
        </div>
    </div>
@endsection
