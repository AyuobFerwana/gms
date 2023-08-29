@extends('lgs.dashbord')

@section('title', 'Edit')
@section('Large-title', 'Edit Admins & Users')

@section('styles')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link href="{{ asset('boots/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('boots/css/bootstrap-multiselect.css') }}" rel="stylesheet">

    {{--  sneat page  --}}
    <link rel="stylesheet" href="{{ asset('snea/assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('snea/assets/vendor/css/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('snea/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('snea/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <style>
        .btn-primary {
            color: rgb(255, 255, 255);
            background-color: #395fcf;
            border-color: #395fcf;
            box-shadow: 0 0.125rem 0.25rem 0 rgb(105 108 255 / 40%);
        }
    </style>
@endsection

@section('container')
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Admins & Users</h4>
                <form class="forms-sample" id="form" onsubmit="event.preventDefault(); performEdit();">
                    {{--  image  --}}
                    <div class="card mb-4">
                        <h5 class="card-header">Image User</h5>
                        <!-- Account -->
                        <div class="card-body">
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <img src="{{ Storage::url($user->image) }}"alt="user-avatar" class="d-block rounded"
                                    height="100"width="100"id="uploadedAvatar" />
                                <div class="button-wrapper">
                                    <label for="upload" class="btn btn-primary me-2 mb-4 " tabindex="0">
                                        <span class="d-none d-sm-block">Upload new photo</span>
                                        <i class="bx bx-upload d-block d-sm-none"></i>
                                        <input type="file"  class="account-file-input" name="image"
                                            id="upload" hidden accept="image/png, image/jpeg , image/jpg , image/svg">

                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-0"><br>

                    <div class="form-group">
                        <label for="exampleInputName1">Name</label>
                        <input type="text" class="form-control" id="name" placeholder="Name"
                            value="{{ $user->name }}">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail3">Phone</label>
                        <input type="text" class="form-control" id="phone" placeholder="Phone"
                            value="{{ $user->phone }}">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail3">Email address</label>
                        <input type="email" class="form-control" id="email" placeholder="Email"
                            value="{{ $user->email }}">
                    </div>
                    <div class="form-group">
                        <label for="exampleSelectGender">Gender</label>
                        <select class="form-control" id="gender">
                            <option value="male" @selected($user->gender== "male" )>Male</option>
                            <option value="female" @selected($user->gender =="female")>Female</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <a href="{{ url()->previous() }}" class="btn btn-dark">Cancel</a>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('corona/js/file-upload.js') }}"></script>
    {{--  sneat  --}}
    <script src="{{ asset('snea/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('snea/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('snea/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>


    <script>
        function performEdit() {
            let formData = new FormData();
            formData.append('name', document.getElementById('name').value);
            formData.append('phone', document.getElementById('phone').value);
            formData.append('email', document.getElementById('email').value);
            formData.append('gender', document.getElementById('gender').value);
            formData.append('_method',"PUT");

            if (document.getElementById('upload').files.length > 0) {
                formData.append('image', document.getElementById('upload').files[0]);
            }
            axios.post('{{ route('users.update', $user )}}', formData )
                .then(function(response) {
                    toastr.success(response.data.message);
                    document.getElementById('form').reset();
                })
                .catch(function(error) {
                    toastr.error(error.response.data.message);
                    console.log(error);
                });
        }

    </script>
@endsection
