<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Management System</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('corona/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('corona/vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('corona/css/style.css') }}">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ asset('corona/images/favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('lgs/plugins/toastr/toastr.min.css') }}">
    <link href="{{ asset('lte/plugins/fontawesome-pro/css/all.css') }}" rel="stylesheet" type="text/css">
    <style>
        .loading {
            position: relative;
        }

        #overlay {
            display: none !important;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .loading #overlay {
            display: flex !important;
            justify-content: center;
            align-items: center;
            font-size: 45px;
            background-color: rgba(0, 0, 0, 0.45);
        }
        .transparent-bg {
   background-color: rgba(255, 255, 255, 0.7); /* تعديل القيمة الأخيرة للشفافية حسب الحاجة */
}

    </style>
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="row w-100 m-0">
                <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
                    <div id="login-container" class="card col-lg-4 mx-auto">
                        <div class="card-body px-5 py-5">
                            <h3 class="card-title text-left mb-3">Login</h3>
                            <form onsubmit="event.preventDefault(); preformLogin()">
                                <div class="form-group">
                                    <label>User name</label>
                                    <input id="username" type="text" class="form-control p_input text-light">
                                </div>
                                <div class="form-group">
                                    <label>Password *</label>
                                    <input id="password" type="password" class="form-control p_input text-light ">
                                </div>
                                <div class="form-group d-flex align-items-center justify-content-between">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input id="remember" type="checkbox" class="form-check-input"> Remember me
                                        </label>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" id="login-btn"
                                        class="btn btn-primary btn-block enter-btn">Login</button>
                                </div>
                                <p class="sign-up"> have an Account ?<a href="{{ route('login') }}"> Sign in</a></p>
                            </form>
                        </div>
                        <div class="overlay" id="overlay">
                            <span class="fad fa-spinner-third fa-spin"></span>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
            </div>
            <!-- row ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{ asset('corona/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('corona/js/off-canvas.js') }}"></script>
    <script src="{{ asset('corona/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('corona/js/misc.js') }}"></script>
    <script src="{{ asset('corona/js/settings.js') }}"></script>
    <script src="{{ asset('corona/js/todolist.js') }}"></script>
    <script src="{{ asset('js/axios.js') }}"></script>
    <script src="{{ asset('lgs/plugins/toastr/toastr.min.js') }}"></script>
    <!-- endinject -->
    <script>
        const container = document.getElementById('login-container');
        const btn = document.getElementById('login-btn');

        function preformLogin() {
            btn.disabled = true;
            container.classList.add('loading');
            axios.post('{{ route('login.post') }}', {
                username: document.getElementById('username').value,
                    password: document.getElementById('password').value,
                    remember: document.getElementById('remember').checked
                }).then((response) => {
                    toastr.success(response.data.message);
                    setTimeout(() => {
                        window.location.href = '{{ route('home') }}';
                    }, 500);
                })
                .catch((error) => {
                    toastr.error(error.response.data.message);
                }).finally(() => {
                    container.classList.remove('loading');
                    btn.disabled = false;
                });
        }
    </script>
</body>

</html>
