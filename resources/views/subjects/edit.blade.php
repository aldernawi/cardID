@extends('Home')

@section('content')

<div class="container my-5 p-4 bg-light rounded shadow-sm">
    <h1 class="mb-4 text-center text-primary">تعديل مادة</h1>

    <!-- عرض رسائل الخطأ -->
    <div id="error-messages" class="alert alert-danger d-none">
        <ul id="error-list"></ul>
    </div>

    <form id="updateForm" action="{{ route('subjects.update', $studentSubject->id) }}" method="POST">
        @csrf
        @method('POST')
        <div class="form-group mb-3">
            <label for="student_number" class="form-label fw-bold">رقم القيد:</label>
            <input type="text" class="form-control" name="student_number" id="student_number" value="{{ $studentSubject->student_number }}" required>
        </div>
        <div class="form-group mb-4">
            <label for="subject_code" class="form-label fw-bold">رمز المادة:</label>
            <input type="text" class="form-control" name="subject_code" id="subject_code" value="{{ $studentSubject->subject_code }}" required>
        </div>
        <div class="form-group mb-4">
            <label for="subject_name" class="form-label fw-bold">اسم المادة:</label>
            <input type="text" class="form-control" name="subject_name" id="subject_name" value="{{ $studentSubject->subject_name }}" required>
        </div>
        <button type="submit" class="btn btn-success w-100">حفظ</button>
    </form>
</div>

<!-- تضمين مكتبات JS -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        $('#updateForm').on('submit', function(event) {
            event.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    alert(response.message);
                    window.location.href = "{{ route('subjects') }}";
                },
                error: function(xhr) {
                    $('#error-messages').removeClass('d-none');
                    $('#error-list').empty();
                    var errors = xhr.responseJSON.errors;
                    if (errors) {
                        $.each(errors, function(key, value) {
                            $('#error-list').append('<li>' + value[0] + '</li>');
                        });
                    }
                }
            });
        });
    });
</script>

@endsection
 