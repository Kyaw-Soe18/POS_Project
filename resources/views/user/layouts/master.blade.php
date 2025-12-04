<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>My POS Project User Side</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('customer/lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('customer/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">


    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('customer/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('customer/css/style.css') }}" rel="stylesheet">

    <!--custom css link-->
    <link rel="stylesheet" href="{{ asset('customer/css/custom.css') }}">
</head>

<body>

    <!-- Spinner Start -->
    <div id="spinner"
        class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->

    <!-- Navbar start -->
    <div class="container-fluid fixed-top">
        <div class="container topbar bg-primary d-none d-lg-block">
            <div class="d-flex justify-content-between">
                <div class="top-info ps-2">
                    <small class="me-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#"
                            class="text-white">Myanmar</a></small>
                    <small class="me-3"><i class="fas fa-envelope me-2 text-secondary"></i><a href="#"
                            class="text-white">example@gmail.com</a></small>
                </div>
                <div class="top-link pe-2">
                    <a href="#" class="text-white"><small class="text-white mx-2">Privacy Policy</small>/</a>
                    <a href="#" class="text-white"><small class="text-white mx-2">Terms of Use</small>/</a>
                    <a href="#" class="text-white"><small class="text-white ms-2">Sales and Refunds</small></a>
                </div>
            </div>
        </div>
        <div class="container px-0">
            <nav class="navbar navbar-light bg-white navbar-expand-xl">
                <a href="{{ route('userDashboard') }}" class="navbar-brand">
                    <h1 class="text-primary display-6">Spicy Vibes</h1>
                </a>
                <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars text-primary"></span>
                </button>
                <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                    <div class="navbar-nav mx-auto">
                        <a href="{{ route('userDashboard') }}" class="nav-item nav-link active">Home</a>
                        <a href="{{ route('shopList') }}" class="nav-item nav-link">Shop</a>
                        <a href="#" class="nav-item nav-link">Contact</a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <input type="submit" value="Logout" class="btn btn-outline-success mt-1">
                        </form>
                    </div>
                    <div class="d-flex m-3 me-0">
                        
                        <a href="{{ route('cart')}}" class="position-relative me-4 my-auto">
                            <i class="fa-solid fa-cart-shopping fa-2x"></i> 
                        </a>

                        <a href="orderList" class="position-relative me-4 my-auto">
                            <i class="fa fa-shopping-bag fa-2x"></i>
                        </a>

                        <!-- user profile start -->
                        <div class=" nav-item dropdown no-arrow">
                            <a  href="#" class="my-auto nav-link dropdown " data-bs-toggle="dropdown"
                                aria-expanded="false">

                                <i class="fas fa-user fa-2x"></i>
                                @if (auth()->user()->name != null)
                                    {{ auth()->user()->name }}
                                @else
                                    {{ auth()->user()->name }}
                                @endif
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('userprofileDetails')}}">
                                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Profile
                                    </a>
                                </li>
                                <li>
                                    @if (auth()->user()->provider == 'simple')
                                        <a class="dropdown-item" href="{{ route('userpasswordChange')}}">
                                            <i class="fa-solid fa-lock fa-sm fa-fw mr-2 text-gray-400"></i></i></i>
                                            Change Password
                                        </a>
                                    @endif
                                </li>

                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <span class="dropdown-item">
                                            <input type="submit" value="Logout" class="btn btn-primary w-100">
                                        </span>
                                    </form>
                                </li>
                            </ul>
                        </div>
                         <!-- user profile end -->

                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->

    @yield('content')

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5">
        <div class="container py-5">
            <div class="pb-4 mb-4" style="border-bottom: 1px solid rgba(226, 175, 24, 0.5) ;">
                <div class="row g-4">
                    <div class="col-lg-3 ">
                        <h1 class="text-primary mb-0">Foodies</h1>
                        <p class="text-secondary mb-0">Fresh products</p>
                    </div>
                </div>
            </div>
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <div class="footer-item">
                        <h4 class="text-light mb-3">Why People Like us!</h4>
                        <p class="mb-3">Fresh ingredients are used. </p>
                        <p class="mb-3">Packagings are neat. </p>
                        <p class="mb-3">Good customer services. </p>
                        <p class="mb-3">Fast delivery. </p>
                        <p class="mb-3">Safe payment security. </p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="d-flex flex-column text-start footer-item">
                        <h4 class="text-light mb-3">Shop Info</h4>
                        <a class="btn-link" href="#">About Us</a>
                        <a class="btn-link" href="#">Contact Us</a>
                        <a class="btn-link" href="#">Privacy Policy</a>
                        <a class="btn-link" href="#">Terms & Condition</a>
                        <a class="btn-link" href="#">FAQs & Help</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="d-flex flex-column text-start footer-item">
                        <h4 class="text-light mb-3">Account</h4>
                        <a class="btn-link" href="{{ route('userprofileDetails')}}">My Account</a>
                        <a class="btn-link" href="{{ route('orderList')}}">Order List</a>
                        <a class="btn-link" href="{{ route('cart')}}">Shopping Cart</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-item">
                        <h4 class="text-light mb-3">Contact</h4>
                        <p>Address: University Of Computer Studies,Yangon</p>
                        <p>Email: example@gmail.com</p>
                        <p>Phone: +95912345678</p>
                        <p>Payment Accepted</p>
                        <img style=" width:120px" src="{{asset('customer/img/pay.jpg')}}" class="img-fluid" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Copyright Start -->
    <div class="container-fluid copyright bg-dark py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <span class="text-light"><a href="#"><i class="fas fa-copyright text-light me-2"></i>Spicy Vibes</a>, All right reserved.</span>
                </div>
                <div class="col-md-6 my-auto text-center text-md-end text-white">
                    <!--/*** This template is free as long as you keep the below author’s credit link/attribution link/backlink. ***/-->
                    <!--/*** If you'd like to use the template without the below author’s credit link/attribution link/backlink, ***/-->
                    <!--/*** you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". ***/-->
                </div>
            </div>
        </div>
    </div>
    <!-- Copyright End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i
            class="fa fa-arrow-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('customer/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('customer/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('customer/lib/lightbox/js/lightbox.min.js') }}"></script>
    <script src="{{ asset('customer/lib/owlcarousel/owl.carousel.min.js') }}"></script>

    <!--jquery cdn link-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-JobWAqYk5CSjWuVV3mxgS+MmccJqkrBaDhk8SKS1BW+71dJ9gzascwzW85UwGhxiSyR7Pxhu50k+Nl3+o5I49A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('customer/js/main.js') }}"></script>

    <!-- For Image Preview -->
    <script>
        function loadFile(event){
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('output');
                output.src  = reader.result;
            }

            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>

@yield('js-section')

</html>