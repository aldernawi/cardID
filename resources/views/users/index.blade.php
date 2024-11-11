@extends('Home')

@section('content')
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-lg-12 d-flex justify-content-between align-items-center">
            <h2>قائمة المستخدمين</h2>
            <div>
                <button class="btn btn-success" data-toggle="modal" data-target="#addUserModal">اضافة</button>

            </div>
        </div>
    </div>
    
    <div id="alert-container">
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @elseif ($message = Session::get('error'))
        <div class="alert alert-danger">
            <p>{{ $message }}</p>
        </div>
    @endif
</div>


    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>الاسم</th>
                            <th>البريد الإلكتروني</th>
                            <th>نوع المستخدم</th>
                            <th width="280px">الإجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->user_type }}</td>
                            <td>
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-info btn-sm">تعديل</a>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذا المستخدم؟')">
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

<!-- Modal for Adding User -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">اضافة مستخدم</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4 bg-light rounded shadow ">
                <form id="addUserForm" action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">الاسم</label>
                        <input type="text" name="name" class="form-control" id="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">البريد الإلكتروني</label>
                        <input type="email" name="email" class="form-control" id="email" required>
                    </div>
                    <div class="form-group">
                        <label for="user_type">نوع المستخدم</label>
                        <select name="user_type" class="form-control  form-select  " id="user_type" required>
                            <option value="admin">مدير</option>
                            <option value="user">موظف</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="password">كلمة المرور</label>
                        <input type="password" name="password" class="form-control" id="password" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100 mt-3 ">إرسال</button>
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
        // Handle add user form submission
        $('#addUserForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: $(this).serialize(),
                success: function(response) {
                    $('#addUserModal').modal('hide');
                    alert(response.success);
                    location.reload(); 
                },
                error: function(response) {
                    let errors = response.responseJSON.errors;
                    let errorHtml = '<div class="alert alert-danger">';
                    $.each(errors, function(key, value) {
                        errorHtml += '<p>' + value[0] + '</p>';
                    });
                    errorHtml += '</div>';
                    $('#addUserModal .modal-body').prepend(errorHtml);
                }
            });
        });
    });
</script>
@endsection
