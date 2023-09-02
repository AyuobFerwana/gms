@extends('lgs.dashbord')

@section('title', 'Edit')
@section('Large-title', 'Edit Employees')

@section('styles')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link href="{{ asset('boots/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('boots/css/bootstrap-multiselect.css') }}" rel="stylesheet">
@endsection

@section('container')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Employees</h4>
                <form class="forms-sample" id="form" onsubmit="event.preventDefault(); performEdit();">

                    <div class="form-group">
                        <label for="name">Emp_Name</label>
                        <input type="text" class="form-control" id="emp_name" placeholder="emp_name" value="{{ $employee->emp_name }}">
                    </div>

                    <div class="form-group">
                        <label for="date">Emp_BirthDate</label>
                        <input type="date" class="form-control" id="emp_birthdate" value="{{ $employee->emp_birthdate }}">
                    </div>

                    <div class="form-group">
                        <label for="Emp_Salary">Emp_Salary</label>
                        <input type="number" class="form-control" id="emp_salary" placeholder="emp_salary" value="{{ $employee->emp_salary }}" >
                    </div>


                    <div class="form-group">
                        <label for="Department">Department</label>
                        <select class="form-control" id="dept_id">
                            @foreach ($department as $depart)
                            <option value="{{ $depart->id }}" @selected($employee->department->dept_name)>{{ $depart->dept_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="Status">Status</label>
                        <select class="form-control" id="status">
                            <option value="active" @selected($employee->status == "active")>active</option>
                            <option value="expired" @selected($employee->status == "expired")>expired</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary mr-2">Create</button>
                    <button class="btn btn-dark">Cancel</button>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('corona/js/file-upload.js') }}"></script>
    <script>
        function performEdit() {
            let formData = new FormData();
            formData.append('emp_name', document.getElementById('emp_name').value);
            formData.append('emp_birthdate', document.getElementById('emp_birthdate').value);
            formData.append('emp_salary', document.getElementById('emp_salary').value);
            formData.append('dept_id', document.getElementById('dept_id').value);
            formData.append('status', document.getElementById('status').value);
            formData.append('_method',"PUT");

            axios.post('{{ route('employees.update', $employee )}}', formData )
                .then(function(response) {
                    toastr.success(response.data.message);
                    document.getElementById('form');
                    setTimeout(() => {
                      window.location.href = '{{ route('employees.index') }}';
                  }, 1000);
                })
                .catch(function(error) {
                    toastr.error(error.response.data.message);
                    console.log(error);
                });
        }

    </script>
@endsection
