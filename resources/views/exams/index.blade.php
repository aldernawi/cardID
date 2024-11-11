@extends('Home')

@section('content')
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-lg-12 d-flex justify-content-between align-items-center">
            <h2>الامتحانات</h2>
            <button class="btn btn-success mb-3" data-toggle="modal" data-target="#addExamModal">اضافة</button>
            <form action="{{ route('exams.deleteAll') }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف جميع الامتحانات؟')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger mb-3">حذف جميع الامتحانات</button>
            </form>
        </div>
    </div>

    <div id="responseMessage"></div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Subject Code</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th width="280px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($exams as $exam)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $exam->Subject ? $exam->Subject->subject_code : 'غير محدد' }}</td>
                            <td>{{ $exam->start_date }}</td>
                            <td>{{ $exam->end_date }}</td>
                            <td>
                                <form action="{{ route('exams.delete', $exam->id) }}" method="POST">
                                    <a class="btn btn-info btn-sm" href="{{ route('exams.edit', $exam->id) }}">تعديل</a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Adding Exam -->
<div class="modal fade" id="addExamModal" tabindex="-1" role="dialog" aria-labelledby="addExamModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addExamModalLabel">اضافة امتحان</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="modalResponseMessage"></div> <!-- Element for displaying errors -->
                <form id="addExamForm">
                    @csrf
                    <div class="form-group">
                        <label for="subject_code">رمز المادة</label>
                        <select name="subject_code" class="form-control" id="subject_code" required>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->subject_code }}">{{ $subject->subject_code }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="start_date">تاريخ البداية</label>
                        <input type="text" name="start_date" class="form-control datetimepicker" id="start_date" required>
                    </div>
                    <div class="form-group">
                        <label for="end_date">تاريخ النهاية</label>
                        <input type="text" name="end_date" class="form-control datetimepicker" id="end_date" required>
                    </div>
                    <button type="submit" class="btn btn-success">إرسال</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Include Bootstrap and flatpickr JS and CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr('.datetimepicker', {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: true
        });

        $('#addExamForm').on('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission
            $.ajax({
                url: '{{ route('exams.store') }}',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#modalResponseMessage').html('<div class="alert alert-success">' + response.success + '</div>');
                    $('#addExamModal').modal('hide');
                    location.reload(); // Refresh the page to show the new exam
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
