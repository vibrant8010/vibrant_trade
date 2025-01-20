<header class="header-scroll">
    <section class="header-top">
        <!-- Left Part: Logo -->
        <div class="left-part">
            <div class="header-logo-container">
                <a href="{{ route('user.home') }}">
                    <img src="{{ asset('images/company-logo.png') }}" alt="company logo">
                </a>
            </div>
        </div>

        <!-- Center Part: Search and Dropdown (Desktop) -->
        <div class="d-lg-block d-md-block d-block">
        <div class="search-section">
            <div class="search-location-box">
                <div class="inputgroup_location">
                  <div class="input_location_box">
                    <input type="text" autocomplete="off"
                      class="input_location"
                      aria-label="City Auto-suggest"
                      placeholder="Enter Location"
                      id="city-auto-sug" value="Palanpur">
                    <ul class="dropdown-list" role="listbox">
                      <li class="dropdown-item" role="option">Ahmedabad</li>
                      <li class="dropdown-item" role="option">Mumbai</li>
                      <li class="dropdown-item" role="option">Palanpur</li>
                      <li class="dropdown-item" role="option">Surat</li>
                      <li class="dropdown-item" role="option">Rajkot</li>
                    </ul>
                  </div>
                </div>
              </div>

            <div class="search-container">
                {{-- <div class="select-box">
                    <div class="dropdown" id="desktop-dropdown">
                        <div class="dropdown-button" id="dropdownButton">
                            Products
                        </div>
                        <div class="dropdown-menu" id="dropdownMenu">
                             <div class="dropdown-item" onclick="selectDropdown('All')">All</div>

                            <div class="dropdown-item" onclick="selectDropdown('Products')">Products</div>
                            <div class="dropdown-item" onclick="selectDropdown('Companies')">Companies</div>
                        </div>
                    </div>
                </div> --}}

                <div class="search-input-box">
                    <form id="search-form" class="search-box-section" onsubmit="performSearch(event)">
                        <input type="text" name="query" id="search-bar" oninput="fetchSuggestions()"
                            autocomplete="off" placeholder="Search here ...">
                        <div class="search-btn-box">
                            <button type="submit" class="search-btn">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                    </form>
                    <div id="suggestions" class="suggestions-box"></div>
                </div>
            </div>
        </div>
        </div>

        <!-- Right Part: Authentication & Contact (Desktop) -->
        <div class="d-lg-block d-md-block d-none">
            <div class="right-part">
                @if (Auth::check())
                    <a href="{{ route('logout') }}" class="primary-btn"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn-links">
                        <span class="lg-img">
                            <img src="{{ asset('images/personicon.png') }}" alt="">
                        </span>
                        Sign in
                    </a>
                    <a href="{{ route('login') }}" class="btn-links">
                        <span class="lg-img">
                            <img src="{{ asset('images/INQUIRY.png') }}" alt="">
                        </span>
                        Inquiry
                    </a>
                    <a href="https://wa.me/+918511684938" class="contact-cheap">
                        +91 8511 6849 38
                    </a>
                @endif
            </div>
        </div>
    </section>

    <!-- Header Bottom: Mobile Menu and Navigation -->
    <div class="header-bottom">
        <button class="menu-btn d-lg-none d-sm-block d-md-none" id="menu-btn">
            <i class="fa-solid fa-bars"></i>
        </button>

        <nav class="nav-container">
            <span class="close-btn" id="close-btn">&times;</span>
            <ul class="menu">
                <li class="dropdown menu-item">
                    <a href="#"><span class="category-img mx-1 "><i class="fa-solid fa-list"></i></span>All
                        Category</a>
                    <ul class="submenu">
                        <li class="category-menu-item"><a href="#" class="category-menu-link">Option 1</a></li>
                        <li class="category-menu-item"><a href="#" class="category-menu-link">Option 2</a></li>
                        <li class="category-menu-item"><a href="#" class="category-menu-link">Option 3</a></li>
                        <li class="category-menu-item"><a href="#" class="category-menu-link">Option 4</a></li>
                        <li class="category-menu-item"><a href="#" class="category-menu-link">Option 5</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav-view">
                <li class="nav-item mobile-logo py-4 px-1 d-lg-none d-sm-block d-md-none">
                    <div class="header-logo-container d-md-block d-sm-block d-lg-none">
                        <a href="{{ route('user.home') }}">
                            <img src="{{ asset('images/mobile-logo.png') }}" alt="company logo"
                                style="height: 100%; width: 187px;">
                        </a>
                    </div>
                </li>
                <li class="nav-item"><a href="{{ route('innertopcategory') }}" class="nav-link">Top Category</a></li>
                <li class="nav-item"><a href="{{ route('newarrival') }}" class="nav-link">New Arrival</a></li>
                <li class="nav-item"><a href="{{ route('alltrendingcategory') }}" class="nav-link">Trending
                        Products</a></li>
                <li class="nav-item"><a href="#Blogs" class="nav-link">Blogs</a></li>
                <li class="s-box d-lg-none d-md-none d-sm-block">
                    <div class="right-part mt-5">
                        <a href="{{ route('login') }}" class="btn-links">
                            <span class="lg-img">
                                <img src="{{ asset('images/personmobile.png') }}" alt="">
                            </span>
                            Sign in
                        </a>
                        <a href="{{ route('login') }}" class="btn-links">
                            <span class="lg-img">
                                <img src="{{ asset('images/INQUIRYMOBILE.png') }}" alt="">
                            </span>
                            Inquiry
                        </a>
                    </div>
                </li>
            </ul>

            <!-- Mobile Search and Dropdown -->
            {{-- <div class="d-lg-none d-md-none d-block">
                <div class="search-container">
                    <div class="select-box">
                        <div class="dropdown" id="mobile-dropdown">
                            <div class="dropdown-button" id="dropdownButtonMobile">
                                Products
                            </div>
                            <div class="dropdown-menu" id="dropdownMenuMobile">
                                <div class="dropdown-item" onclick="selectDropdownMobile('Products')">Products</div>
                                <div class="dropdown-item" onclick="selectDropdownMobile('Companies')">Companies</div>
                            </div>
                        </div>
                    </div>
                    <div class="search-input-box">
                        <form id="search-form-mobile" class="search-box-section"
                            onsubmit="performSearchMobile(event)">
                            <input type="text" name="query" id="search-bar-mobile"
                                oninput="fetchSuggestionsMobile()" autocomplete="off" placeholder="Search here ...">
                            <div class="search-btn-box">
                                <button type="submit" class="search-btn">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </form>
                        <div id="suggestions-mobile" class="suggestions-box"></div>
                    </div>
                </div>
            </div> --}}
        </nav>
    </div>

    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="loginForm">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if (session('alert'))
        {{-- <div class="alert alert-warning">
        {{ session('alert') }}
    </div> --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                var loginModal = new bootstrap.Modal(document.getElementById('loginModal'), {
                    backdrop: 'static', // Prevent closing by clicking outside
                    keyboard: false // Prevent closing by pressing Esc
                });
                loginModal.show();

            });
        </script>
    @endif
</header>

<script>
    // Default category is 'Products'
    let selectedCategory = "All";

    // Update the dropdown button text
    function updateDropdownButtonText(buttonId, text) {
        document.getElementById(buttonId).textContent = text;
    }

    // Function to handle dropdown selection (desktop and mobile)
    function selectDropdown(category) {
        selectedCategory = category;
        updateDropdownButtonText('dropdownButton', category);
        document.getElementById('dropdownMenu').classList.remove('show');
        clearSuggestions(); // Clear previous suggestions
    }

    function selectDropdownMobile(category) {
        selectedCategory = category;
        updateDropdownButtonText('dropdownButtonMobile', category);
        document.getElementById('dropdownMenuMobile').classList.remove('show');
        clearSuggestions(); // Clear previous suggestions
    }

    // Toggle dropdown visibility (desktop and mobile)
    function toggleDropdown(menuId) {
        document.getElementById(menuId).classList.toggle('show');
    }

    // Clear suggestions box
    function clearSuggestions() {
        const desktopSuggestions = document.getElementById("suggestions");
        const mobileSuggestions = document.getElementById("suggestions-mobile");

        desktopSuggestions.innerHTML = "";
        desktopSuggestions.style.display = "none";

        mobileSuggestions.innerHTML = "";
        mobileSuggestions.style.display = "none";
    }

    // Display search suggestions
    function displaySuggestions(suggestions, isMobile = false) {
        const suggestionsBox = document.getElementById(isMobile ? "suggestions-mobile" : "suggestions");

        // Clear the suggestions box content before appending new suggestions
        suggestionsBox.style.display = "block";
        suggestionsBox.innerHTML = ""; // Only clear the contents, not the event listeners

        let hasResults = false;

        // Create a container for the suggestions
        const content = document.createElement('div');

        // Display companies first if available
        if (suggestions.companies && suggestions.companies.length > 0) {
            hasResults = true;
            const companiesHeader = document.createElement('div');
            companiesHeader.className = 'suggestion-header';
            companiesHeader.textContent = 'Companies';
            content.appendChild(companiesHeader);

            suggestions.companies.forEach((company) => {
                const suggestion = document.createElement('div');
                suggestion.className = "suggestion-item";
                suggestion.textContent = company.name;
                suggestion.onclick = () => {
                    window.location.href = `/company/${company.id}/products`;
                };
                content.appendChild(suggestion);
            });
        }

        // Display products second if available
        if (suggestions.products && suggestions.products.length > 0) {
            hasResults = true;
            const productsHeader = document.createElement('div');
            productsHeader.className = 'suggestion-header';
            productsHeader.textContent = 'Products';
            content.appendChild(productsHeader);

            suggestions.products.forEach((product) => {
                const suggestion = document.createElement('div');
                suggestion.className = "suggestion-item";
                suggestion.textContent = product.name;
                suggestion.onclick = () => {
                    window.location.href = `/product/${product.id}`;
                };
                content.appendChild(suggestion);
            });
        }

        // No results found
        if (!hasResults) {
            const noResults = document.createElement('div');
            noResults.className = 'suggestion-item';
            noResults.textContent = 'No results found';
            content.appendChild(noResults);
        }

        // Append the content to the suggestions box
        suggestionsBox.appendChild(content);
    }


    // Fetch search suggestions from server
    function fetchSuggestions(query, isMobile = false) {
        if (query.length > 2) {
            const endpoint = `/search-suggestions?query=${query}&category=${selectedCategory}`;

            fetch(endpoint)
                .then(response => response.json())
                .then(data => {
                    if (selectedCategory === "All") {
                        displaySuggestions({
                            products: data.products || [],
                            companies: data.companies || []
                        }, isMobile);
                    } else if (selectedCategory === "Products") {
                        displaySuggestions({
                            products: data.suggestions || []
                        }, isMobile);
                    } else if (selectedCategory === "Companies") {
                        displaySuggestions({
                            companies: data.suggestions || []
                        }, isMobile);
                    }
                })
                .catch(error => console.error("Error fetching suggestions:", error));
        } else {
            clearSuggestions();
        }
    }

    // Perform search on form submission
    function performSearch(event, isMobile = false) {
        event.preventDefault();
        const query = document.getElementById(isMobile ? "search-bar-mobile" : "search-bar").value.trim();
        if (query !== "") {
            window.location.href = `/search-results?query=${query}&category=${selectedCategory}`;
        }
    }

    // Event listeners for desktop and mobile dropdowns
    document.getElementById('dropdownButton').addEventListener('click', () => toggleDropdown('dropdownMenu'));
    document.getElementById('dropdownButtonMobile').addEventListener('click', () => toggleDropdown(
        'dropdownMenuMobile'));

    // Event listeners for search input
    document.getElementById('search-bar').addEventListener('input', (e) => fetchSuggestions(e.target.value));
    document.getElementById('search-bar-mobile').addEventListener('input', (e) => fetchSuggestions(e.target.value,
        true));

    // Event listeners for form submission
    document.getElementById('search-form').addEventListener('submit', (e) => performSearch(e));
    document.getElementById('search-form-mobile').addEventListener('submit', (e) => performSearch(e, true));

    // Initialize the default category
    selectDropdown("All");
</script>
