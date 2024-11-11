@extends('Home')
@section('content')
<div class="container">
    <h1 class="mt-5">إضافة طالب جديد</h1>
    <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">الاسم:</label>
            <input type="text" class="form-control" name="name" id="name" required>
        </div>
        <div class="form-group">
            <label for="student_number">رقم القيد:</label>
            <input type="text" class="form-control" name="student_number" id="student_number" required>
        </div>
        <button type="submit" class="btn btn-primary">حفظ</button>
    </form>
</div>

@endSection