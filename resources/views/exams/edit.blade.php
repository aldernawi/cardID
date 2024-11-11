@extends('Home')

@section('content')
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-lg-12 d-flex justify-content-between align-items-center">
            <h2 class="mb-4">تعديل الامتحان</h2>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('exams.update', $exam->id) }}" method="POST">
                @csrf
                @method('POST')
                <div class="form-group">
                    <label for="subject_code">رمز المادة</label>
                    <select name="subject_code" class="form-control" id="subject_code" required>
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->subject_code }}" {{ $subject->subject_code == $exam->Subject->subject_code ? 'selected' : '' }}>
                                {{ $subject->subject_code }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-5">
                    <label for="start_date">تاريخ ووقت البداية</label>
                    <input type="text" name="start_date" class="form-control datetimepicker" id="start_date" value="{{ $exam->start_date }}" required>
                </div>
                <div class="form-group mb-5">
                    <label for="end_date">تاريخ ووقت النهاية</label>
                    <input type="text" name="end_date" class="form-control datetimepicker" id="end_date" value="{{ $exam->end_date }}" required>
                </div>
                <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
            </form>
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
            time_24hr: true,
            defaultHour: 9,
            defaultMinute: 0,
            minuteIncrement: 15,
            altInput: true,
            altFormat: "F j, Y (H:i)",
            locale: {
                firstDayOfWeek: 0, // Start week on Sunday
                weekdays: {
                    shorthand: ['أحد', 'إثنين', 'ثلاثاء', 'أربعاء', 'خميس', 'جمعة', 'سبت'],
                    longhand: ['الأحد', 'الإثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت']
                },
                months: {
                    shorthand: ['ينا', 'فبر', 'مار', 'أبر', 'ماي', 'يون', 'يول', 'أغس', 'سبت', 'أكت', 'نوف', 'ديس'],
                    longhand: ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر']
                }
            }
        });
    });
</script>
@endsection
