@extends('Home')

@section('content')
<div class="container mt-5">
    <style>
        body {
            direction: rtl;
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .table-responsive {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .modal-content {
            border-radius: 10px;
        }
        .btn {
            border-radius: 25px;
        }
        .qr-code {
            text-align: center;
        }
        .qr-code canvas {
            margin-top: 10px;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 5px;
        }
        .table td, .table th {
            vertical-align: middle;
        }
        .alert {
            margin-top: 10px;
        }
    </style>
    <h1 class="mb-4">قائمة الطلبة</h1>
    @if(auth()->user()->user_type == 'admin')
    <a href="#" class="btn btn-success mb-3" data-toggle="modal" data-target="#addStudentModal">إضافة طالب جديد</a>
    @endif
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>الاسم</th>
                    <th>رقم الطالب</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                <tr>
                    <td>{{ $student->name }}</td>
                    <td class="qr-code">
                        <div id="qrcode-{{ $student->student_number }}"></div>
                    </td>
                    <td>
                        <a href="{{ route('student.card', $student->id) }}" class="btn btn-warning"> إصدار بطاقة</a>
                        <a href="{{ route('students_edit', $student->id) }}" class="btn btn-info">تعديل</a>
                        <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">حذف</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal for adding a new student -->
<div class="modal fade" id="addStudentModal" tabindex="-1" role="dialog" aria-labelledby="addStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStudentModalLabel">إضافة طالب جديد</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="modalResponseMessage"></div> <!-- Element for displaying errors -->
                <form id="addStudentForm">
                    @csrf
                    <div class="form-group">
                        <label for="name">الاسم:</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="اسم الطالب" required>
                    </div>
                    <div class="form-group">
                        <label for="student_number">رقم الطالب:</label>
                        <input type="text" name="student_number" class="form-control" id="student_number" placeholder="رقم الطالب" required>
                    </div>
                    <button type="submit" class="btn btn-success">إضافة الطالب</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Generate QR codes for each student
        @foreach($students as $student)
        new QRCode(document.getElementById("qrcode-{{ $student->student_number }}"), {
            text: "{{ $student->student_number }}",
            width: 100,
            height: 100,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });
        @endforeach

        // Handle the form submission for adding a new student
        $('#addStudentForm').on('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission
            $.ajax({
                url: '{{ route('students.store') }}',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#modalResponseMessage').html('<div class="alert alert-success">' + response.success + '</div>');
                    $('#addStudentModal').modal('hide');
                    location.reload(); // Refresh the page to show the new student
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    var errorHtml = '<div class="alert alert-danger"><ul>';
                    $.each(errors, function(key, value) {
                        errorHtml += '<li>' + value[0] + '</li>';
                    });
                    errorHtml += '</ul></div>';
                    $('#modalResponseMessage').html(errorHtml);
                }
            });
        });
    });
</script>

@endsection
