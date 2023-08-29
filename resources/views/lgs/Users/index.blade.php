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
                                <th>Users Image</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>TypeUser</th>
                                <th>Gender</th>
                                <th>Created At</th>
                                <th>Update At</th>
                                <th>Settings</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td class="align-middle white-space-nowrap py-0">
                                        <img src="{{ Storage::url($user->image) }}" alt="user-image" width="53"
                                            style="border-radius: 10px;">
                                    </td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if (auth()->user()->id == $user->id)
                                            <button type="button" style="cursor: not-allowed"
                                                class="btn btn-{{ $user->role == 'admin' ? 'primary' : 'success' }} mr-2"
                                                disabled>
                                                {{ $user->role }}
                                            </button>
                                        @else
                                            <button type="button" onclick="toggleRole({{ $user->id }}, this)"
                                                class="btn btn-{{ $user->role == 'admin' ? 'primary' : 'success' }} mr-2">
                                                {{ $user->role }}
                                            </button>
                                        @endif
                                    </td>
                                    <td>{{ $user->gender }}</td>
                                    <td>{{ $user->created_at }}</td>
                                    <td>{{ $user->updated_at }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('users.edit', $user->id) }}"
                                                class="btn btn-square btn-outline-success m-2 border-rad">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" onclick="performDestroy('{{ $user->id }}',this)"
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
            confirmDestroy('/dashboard/users', id, reference);
        }

        function toggleRole(id, ref) {
            ref.disabled = true;
            axios.put(`/dashboard/users/${id}/toggle`)
                .then((response) => {
                    toastr.success(response.data.message);
                    ref.innerHTML = response.data.role;
                    if (response.data.role == 'admin') {
                        ref.setAttribute('class', 'btn btn-primary mr-2');
                    } else {
                        ref.setAttribute('class', 'btn btn-success mr-2');
                    }
                }).catch((error) => {
                    toastr.success(error.response.data.message);
                }).finally(() => {
                    ref.disabled = false;
                });
        }
    </script>

    <!-- Page level plugins -->
    <script src="{{ asset('lgs/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('lgs/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('lgs/js/demo/datatables-demo.js') }}"></script>

@endsection
