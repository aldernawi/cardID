@extends('Home')

@section('content')

<div class="container mt-5">
    <!-- عرض رسالة النجاح -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- عرض رسالة الخطأ -->
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <h1>تعديل طالب</h1>
    <form action="{{ route('students_update', $student->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')

        <!-- عرض الأخطاء الخاصة بكل حقل -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-group">
            <label for="name">الاسم:</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $student->name) }}" required>
        </div>

        <div class="form-group">
            <label for="student_number">رقم القيد:</label>
            <input type="text" class="form-control" name="student_number" id="student_number" value="{{ old('student_number', $student->student_number) }}" required>
        </div>

        <div class="form-group">
            <label for="image">صورة الطالب:</label>
            <input type="file" class="form-control" name="image" id="image">
        </div>

        <button type="submit" class="btn btn-success">حفظ</button>
    </form>
</div>

@endsection
