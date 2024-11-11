@extends('Home')

@section('content')
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-lg-12 d-flex justify-content-between align-items-center">
            <h2>قائمة مواد الطالب</h2>
            <div>
                <button class="btn btn-success" data-toggle="modal" data-target="#addSubjectModal">اضافة</button>
                <form action="{{ route('subjects.deleteAll') }}" method="POST" style="display:inline;" onsubmit="return confirm('هل أنت متأكد من حذف جميع المواد؟')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">حذف جميع المواد</button>
                </form>
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>رقم الطالب</th>
                            <th>اسم المادة</th>
                            <th>رمز المادة</th>
                            <th width="280px">الإجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($studentSubjects as $studentSubject)
                        <tr>
                            <td>{{ $studentSubject->student->student_number }}</td>
                            <td>{{ $studentSubject->subject_name  ?? 'غير محدد'}}</td>
                            <td>{{ $studentSubject->subject_code }}</td>
                            <td>
                                <form action="{{ route('subjects_destroy', $studentSubject->id) }}" method="POST" style="display:inline;">
                                    <a class="btn btn-info btn-sm" href="{{ route('subjects.edit', $studentSubject) }}">تعديل</a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                                </form>
                            </td>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Adding Subject -->
<div class="modal fade" id="addSubjectModal" tabindex="-1" role="dialog" aria-labelledby="addSubjectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSubjectModalLabel">اضافة مادة</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('subjects.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="student_number">رقم الطالب</label>
                        <input type="text" name="student_number" class="form-control" id="student_number" required>
                    </div>
                    <div class="form-group">
                        <label for="subject_code">رمز المادة</label>
                        <input type="text" name="subject_code" class="form-control" id="subject_code" required>
                    </div>
                    <div class="form-group">
                        <label for="subject_name">اسم المادة</label>
                        <input type="text" name="subject_name" class="form-control" id="subject_name" required>
                    </div>
                    <button type="submit" class="btn btn-success">إرسال</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Include jQuery and Bootstrap JS for modal functionality -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        $('#addSubjectModal form').on('submit', function(e) {
            e.preventDefault();

            // إزالة الرسائل القديمة
            $('#addSubjectModal .alert').remove();

            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: $(this).serialize(),
                success: function(response) {
                    // عرض رسالة نجاح
                    $('#addSubjectModal').modal('hide');
                    alert(response.success);
                    location.reload(); // إعادة تحميل الصفحة لتحديث البيانات
                },
                error: function(response) {
                    // عرض رسائل الأخطاء
                    let errors = response.responseJSON.errors;
                    let errorHtml = '<div class="alert alert-danger">';
                    $.each(errors, function(key, value) {
                        errorHtml += '<p>' + value[0] + '</p>';
                    });
                    errorHtml += '</div>';
                    $('#addSubjectModal .modal-body').prepend(errorHtml);
                }
            });
        });
    });
</script>
@endsection
