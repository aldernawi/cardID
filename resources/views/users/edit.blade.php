<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit User</title>
    <!-- تضمين Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Tajawal', sans-serif;
        }
        .container {
            max-width: 600px;
        }
        h1 {
            color: #04786e;
        }
        .form-control {
            border-radius: 0.375rem;
        }
        .btn-success {
            background-color: #04786e;
            border: none;
        }
        .btn-success:hover {
            background-color: #036956;
        }
        .alert {
            border-radius: 0.375rem;
        }
    </style>
</head>
<body class="text-right" style="background-color: #f8f9fa;" dir="rtl">
    
    <div class="container my-5 p-4 bg-white rounded shadow-sm">
        <h1 class="mb-4 text-center">تعديل مستخدم</h1>
    
        <!-- عرض رسائل الخطأ -->
        <div id="error-messages" class="alert alert-danger d-none">
            <ul id="error-list" class="mb-0"></ul>
        </div>
    
        <form id="updateForm" action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group mb-3">
                <label for="name" class="form-label fw-bold">الاسم:</label>
                <input type="text" class="form-control" name="name" id="name" value="{{ $user->name }}" required>
            </div>
    
            <div class="form-group mb-3">
                <label for="email" class="form-label fw-bold">البريد الإلكتروني:</label>
                <input type="email" class="form-control" name="email" id="email" value="{{ $user->email }}" required>
            </div>
    
            <div class="form-group mb-3">
                <label for="user_type" class="form-label fw-bold">نوع المستخدم:</label>
                <select class="form-control" name="user_type" id="user_type" required>
                    <option value="admin" {{ $user->user_type === 'admin' ? 'selected' : '' }}>مدير</option>
                    <option value="user" {{ $user->user_type === 'user' ? 'selected' : '' }}>موظف</option>
                </select>
            </div>
    
            <div class="form-group mb-4">
                <label for="password" class="form-label fw-bold">كلمة المرور (اتركها فارغة إذا لم ترغب في تغييرها):</label>
                <input type="password" class="form-control" name="password" id="password">
            </div>
    
            <button type="submit" class="btn btn-success btn-block">تحديث</button>
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
                        window.location.href = "{{ route('users') }}";
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
</body>
</html>
