<header>
    <section class="header-top">
        <div class="left-part">
            <div class="header-logo-container">
                <a href="#">
                    <img src="{{ asset('images/company-logo.png') }}" alt="company logo">
                </a>
            </div>
            {{-- <div class="search-box">


                <form id="search-form" class="search-box-section" onsubmit="performSearch(event)">
                    <input type="text" name="query" id="search-bar" placeholder="Search here ...">
             <button type="submit">Search</button>
        </form>
            </div> --}}
        </div>

        <!--center part-->

        <div class="search-container">
            <!-- Dropdown to select Products or Companies -->
            <div class="select-box">
                <div class="dropdown" id="dropdown">
                    <div class="dropdown-button" id="dropdownButton">Products</div>
                    <div class="dropdown-menu" id="dropdownMenu">
                        <div class="dropdown-item" onclick="selectDropdown('Products')">Products</div>
                        <div class="dropdown-item" onclick="selectDropdown('Companies')">Companies</div>
                    </div>
                </div>
            </div>
        
            <!-- Search Input Box -->
            <div class="search-input-box">
                <form id="search-form" class="search-box-section" onsubmit="performSearch(event)">
                    <input type="text" name="query" id="search-bar" oninput="fetchSuggestions()" autocomplete="off" placeholder="Search here ...">
                    <div class="search-btn-box">
                        <button type="submit" class="search-btn">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </form>
                <!-- Suggestions List -->
                <div id="suggestions" class="suggestions-box"></div>
            </div>
        </div>
        
        <!--this work right side-->
        <div class="d-lg-block d-md-block d-sm-none d-none">
            <div class="right-part d-sm-none d-md-block">

                @if (Auth::check())
                    <!-- If user is logged in, show Sign Out button -->
                    <a href="{{ route('logout') }}" class="primary-btn"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @else
                    <!-- If user is not logged in, show Sign In button -->
                    <a href="{{ route('login') }}" class="primary-btn">Sign in</a>
                    <div class="inqiry-box">
                        <a href="{{ route('admin.login') }}" class="primary-btn py-2">

                            Admin login
                        </a>
                    </div>
            </div>
            @endif

            <!--inqury btn-->


        </div>
    </section>

    <div class="header-bottom header-scroll">
        <button class="menu-btn d-lg-none d-sm-block d-md-none" id="menu-btn">
            <i class="fa-solid fa-bars"></i>
        </button>

        <nav class="nav-container">
            <span class="close-btn" id="close-btn">&times;</span>

            <ul class="nav-view">
                <li class="nav-item mobile-logo py-4 px-1 d-lg-none d-sm-block d-md-none">
                    <div class="logo-container d-md-block d-sm-block d-lg-none">
                        <a href="{{ route('user.home') }}">
                            <img src="{{ asset('images/mobile-logo.png') }}" alt="company logo"
                                style="height: 100%; width:187px;">
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="#TopCategory" class="nav-link">Top Category</a>
                </li>
                <li class="nav-item">
                    <a href="#NewArrival" class="nav-link">New Arrival</a>
                </li>
                <li class="nav-item">
                    <a href="#TrendingProducts" class="nav-link">Trending Products</a>
                </li>
                <li class="nav-item">
                    <a href="#Blogs" class="nav-link">Blogs</a>
                </li>
                {{-- <li class="s-box d-none d-lg-block d-md-block">
                        <form action="" class="search-box">
                            <input type="text" id="search-bar" placeholder="Search here ...">
                            <i class="fa fa-search magnifier"></i>
                          </form>
                          <ul id="suggestions"></ul>

                </li> --}}
                <li class="s-box d-lg-none d-md-none d-sm-block">
                    <div class="right-part mt-5">

                        <!--login-btn-->
                        <a href="#" class="primary-btn">Sign in</a>
                        <!--inqury btn-->
                        {{-- <div class="inqiry-box">
                        <a href="#" class="nav-link nav-link-m text-dark nav-link-fw position-relative d-flex align-items-center">
                            <span class="inqury-logo">
                                <img src="http://127.0.0.1:8000/images/INQUIRY.png" alt="inquiry">
                            </span>
                            <span class="inqury-txt">
                                inquiry
                            </span>
                        </a>
                    </div> --}}
                    </div>
                </li>
            </ul>


            {{-- <div class="search-box">
                <div class="search-container">
                    <input type="text" id="search-bar" placeholder="Search..." autocomplete="off">
                    <ul id="suggestions"></ul>
                </div>

            </div> --}}
        </nav>
        {{-- <div class="s-box d-md-none d-sm-block d-lg-none d-xl-none">
             <form action="" class="search-box">
                <input type="text" id="search-bar" placeholder="Search here ...">
                <i class="fa fa-search magnifier"></i>
              </form>
              <ul id="suggestions" style="display: none;"></ul>
        </div> --}}

        <div class="s-box d-md-none d-sm-block d-lg-none d-xl-none">
            <form id="search-form"  onsubmit="performSearch(event)" class="search-box">
                <input type="text" id="search-bar" placeholder="Search here ...">
                <i class="fa fa-search magnifier"></i>
            </form>
            <ul id="suggestions"></ul>

        </div>
    </div>
</header>