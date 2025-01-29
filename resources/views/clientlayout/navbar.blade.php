

<nav class="navbar navbar-expand-lg navbar-light navbar-default pt-0 pb-0">

    <div class="container px-0 px-md-3">

        <div class="dropdown me-3 d-none d-lg-block">

            <button class="btn btn-primary px-6 " type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"

                aria-expanded="false">

                <span class="me-1">

                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"

                    stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"

                    class="feather feather-grid">

                    <rect x="3" y="3" width="7" height="7"></rect>

                    <rect x="14" y="3" width="7" height="7"></rect>

                    <rect x="14" y="14" width="7" height="7"></rect>

                    <rect x="3" y="14" width="7" height="7"></rect>

                </svg></span> All Departments

            </button>

            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">

                @if(getCategories()->isNotEmpty())
                    @foreach (getCategories() as $category)
                        <li><a class="dropdown-item" href="{{ route('home_category', strtolower($category->name)) }}">{{ $category->name }}</a></li>
                    @endforeach
                @endif

            </ul>

        </div>

        <div class="offcanvas offcanvas-start p-4 p-lg-0" id="navbar-default">

            <div class="d-flex justify-content-between align-items-center mb-2 d-block d-lg-none">

                <div><img src="{{ asset('') }}public/client_asset/images/cc-logo.png" alt="eCommerce HTML Template"></div>

                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>

            </div>

            <div class="d-block d-lg-none mb-2 pt-2">

                <a class="btn btn-primary w-100 d-flex justify-content-center align-items-center" data-bs-toggle="collapse"

                    href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">

                    <span class="me-2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"

                    fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"

                    class="feather feather-grid">

                    <rect x="3" y="3" width="7" height="7"></rect>

                    <rect x="14" y="3" width="7" height="7"></rect>

                    <rect x="14" y="14" width="7" height="7"></rect>

                    <rect x="3" y="14" width="7" height="7"></rect>

                    </svg></span> All Departments

                </a>

                <div class="collapse mt-2" id="collapseExample">

                <div class="card card-body">

                    <ul class="mb-0 list-unstyled">

                        @if(getCategories()->isNotEmpty())
                            @foreach (getCategories() as $category)
                                <li><a class="dropdown-item" href="{{ route('home_category', strtolower($category->name)) }}">{{ $category->name }}</a></li>
                            @endforeach
                        @endif

                    </ul>

                </div>

                </div>

            </div>

            <div class="d-lg-none d-block mb-3">

                <button type="button" class="btn  btn-outline-gray-400 text-muted w-100 " data-bs-toggle="modal"

                data-bs-target="#locationModal">

                <i class="feather-icon icon-map-pin me-2"></i>Pick Location

                </button>

            </div>

            <div class="d-none d-lg-block">

                <ul class="navbar-nav ">

                    <li class="nav-item">

                        <a class="nav-link" href="{{ route('home') }}">

                        Home

                        </a>

                    </li>
                    <li class="nav-item">

                        <a class="nav-link" href="{{ route('home_shop') }}">

                        Shop

                        </a>

                    </li>

                </ul>

            </li>

                </li>

                </ul>

                </li>

                <!--  <li class="nav-item ">

                <a class="nav-link" href="./docs/index.html">

                    Docs

                </a>

                </li> -->

                </ul>

            </div>

            <div class="d-block d-lg-none">

                    <ul class="navbar-nav ">

                        <li class="nav-item dropdown">

                            <a class="nav-link" href="{{ route('home') }}" >

                            Home

                            </a>

                        </li>
                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('home_shop') }}">
    
                            Shop
    
                            </a>
    
                        </li>

                    </ul>

                </li>

                </li>

                <!--   <li class="nav-item ">

                <a class="nav-link" href="./docs/index.html">

                    Docs

                </a>

                </li> -->

                </ul>

            </div>

        </div>

    </div>

    </nav>
