@extends('Home')

@section('content')
<div class="container">
    <h1>تحقق من امتحان الطالب</h1>
    
    <!-- Form for entering student number -->
    <form id="checkExamForm">
        @csrf
        <div class="form-group">
            <label for="student_number">رقم الطالب:</label>
            <input type="text" id="student_number" name="student_number" class="form-control" placeholder="أدخل رقم الطالب" required>
        </div>
        <button type="submit" class="btn btn-success mt-3 w-100">تحقق</button>
    </form>

    <!-- Results container -->
    <div id="result" dir="" class="mt-4"></div>
</div>
<style>
.highlight-text {
    font-size: 1.2em; /* تغيير حجم الخط */
}

.table th {
    font-size: 1.2em; /* تغيير حجم الخط في رأس الجدول */
}
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#checkExamForm').on('submit', function(e) {
            e.preventDefault();

            const studentNumber = $('#student_number').val();
            
            $.ajax({
                url: '/check-exam',
                method: 'POST',
                data: {
                    student_number: studentNumber,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    let examsInfo = data.exams.map(exam => `
                        <tr>
                            <td>${exam.subject_code}</td>
                            <td>${exam.start_date}</td>
                            <td>${exam.end_date}</td>
                        </tr>
                    `).join('');

                    $('#result').html(`
                        <div class="alert alert-success">
                            <button id="printButton" class="btn btn-primary mb-3 w-100">طباعة</button>
                            <strong class="highlight-text">الاسم:</strong> ${data.name}<br>
                            <strong class="highlight-text">رقم الطالب:</strong> ${data.student_number}<br>
                            <strong class="highlight-text">صورة الطالب:</strong> <img src="/images/${data.image}" alt="Student Image" width="100" height="100"><br>
                            <strong class="highlight-text">رسالة:</strong> ${data.message}<br>
                            <strong class="highlight-text">تفاصيل الامتحانات:</strong><br>
                            <table class="table table-bordered table-striped table-hover mt-3 mb-5 text-center table-responsive text-white" style="background-color: #343a40;">
                                <thead>
                                    <tr>
                                        <th>رمز المادة</th>
                                        <th>بداية الامتحان</th>
                                        <th>نهاية الامتحان</th>
                                    </tr>
                                </thead>
                                <tbody class="text-white" style="background-color: #f8f9fa;">
                                    ${examsInfo}
                                </tbody>
                            </table>
                        </div>
                    `);

                    // Add print functionality
                    $('#printButton').on('click', function() {
                        let printContents = `
                            <div>
                                <strong>الاسم:</strong> ${data.name}<br>
                                <strong>رقم الطالب:</strong> ${data.student_number}<br>
                                <strong>اسم المادة:</strong><br>
                                <ul>
                                    ${data.exams.map(exam => `<li>${exam.subject_name}</li>`).join('')}
                                </ul>
                            </div>
                        `;
                        let originalContents = document.body.innerHTML;
                        document.body.innerHTML = printContents;
                        window.print();
                        document.body.innerHTML = originalContents;
                    });
                },
                error: function(xhr) {
                    const error = xhr.responseJSON.error;
                    $('#result').html(`
                        <div class="alert alert-danger">
                            ${error}
                        </div>
                    `);
                }
            });
        });
    });
</script>
@endsection
