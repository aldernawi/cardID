@extends('Home')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="mb-4">Create New Exam</h2>
            <a class="btn btn-success mb-3" href="{{ route('exams') }}"> Back</a>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('exams.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="subject_name">Subject Name:</label>
                    <input type="text" name="subject_name" class="form-control" id="subject_name" placeholder="Subject Name">
                </div>
                <div class="form-group">
                    <label for="start_datetime">Start Date & Time:</label>
                    <input type="text" name="start_datetime" class="form-control datetimepicker" id="start_datetime" placeholder="Start Date & Time">
                </div>
                <div class="form-group">
                    <label for="end_datetime">End Date & Time:</label>
                    <input type="text" name="end_datetime" class="form-control datetimepicker" id="end_datetime" placeholder="End Date & Time">
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>
    </div>
</div>

<!-- Include flatpickr CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr('.datetimepicker', {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: true
        });
    });
</script>
@endsection
