@extends('lgs.dashbord')

@section('title', 'Index')
@section('Large-title', 'Clothes Index')

@section('styles')
    <style>
        .color-box {
            display: inline-block;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: 1px solid #000;
        }

        .border-rad {
            border-radius: 10px !important;
            margin: 0 3px !important;
        }

        .dataTables_filter {
            text-align: right;
        }

        .dataTables_filter label {
            text-align: center;
        }

        .color-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            row-gap: 10px;
        }
    </style>
@endsection

@section('container')
    <div class="container-fluid">

        <!-- Page Heading -->
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">DataTables Clothes</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Emp_name</th>
                                <th>Emp_BirthDate</th>
                                <th>Emp_salary</th>
                                <th>Dept_id</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Update At</th>
                                <th>Settings</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $employee)
                                <tr>
                                    <td>{{ $loop->iteration}}</td>
                                    <td>{{ $employee->emp_name }}</td>
                                    <td>{{ $employee->emp_birthdate }}</td>
                                    <td>{{ $employee->emp_salary }}</td>
                                    <td>{{ $employee->department->dept_name }}</td>
                                    <td>{{ $employee->status }}</td>
                                    <td>{{ $employee->created_at }}</td>
                                    <td>{{ $employee->updated_at }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('employees.edit', $employee->id) }}"
                                                class="btn btn-square btn-outline-success m-2 border-rad">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" onclick="performDestroy('{{ $employee->id }}',this)"
                                                class="btn btn-square btn-outline-danger m-2 border-rad">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function performDestroy(id, reference) {
            confirmDestroy('/dashboard/employees', id, reference);
        }
    </script>

    <!-- Page level plugins -->
    <script src="{{ asset('lgs/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('lgs/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('lgs/js/demo/datatables-demo.js') }}"></script>

@endsection
