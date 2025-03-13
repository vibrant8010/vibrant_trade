
<section class="top-category section-margin" id="TopCategory">

    <div class="container">
        <div class="heading-section">
            <div class="main-heading">Top Categories</div>
            <a href="{{ route('innertopcategory') }}" class="btn-view primary-btn d-lg-block d-xl-block d-sm-none d-none d-md-block">View More</a>
        </div>

        {{-- <!--desktop view-->
            
        <div class="row g-1 desktop-grid"> --}}
            {{-- @if ($topCategoryProducts && $topCategoryProducts->isNotEmpty()) --}}
            {{-- @foreach ($topCategoryProducts as $product)
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 product-col">
                    <div class="card-view">
                        <a href="{{ route('product.show', $product->id) }}" class="card-link"></a>
                        <div class="image-container">
                            <div class="thumbnail_container">
                                <div class="thumbnail">
                                    <img src="{{ asset($product->image_url) }}" class="product-image swiper-img"
                                        alt="{{ $product->name }}" onclick="openPopup(this)">
                                </div>
                            </div>
                        </div>
                        <div class="main-logo-container">

                            <div class="logo-container">
                                @if ($product->company && $product->company->logo_url)
                                    <img src="{{ asset($product->company->logo_url) }}" class="logo-image"
                                        alt="{{ $product->company->name }}">
                                @else
                                    <span>No Logo</span>
                                @endif
                            </div>
                            <div class="image_overlay view-arrow-btn hide">
                                <i class="fas fa-arrow-circle-down"></i>
                            </div>
                        </div>
                        <div class="card-body product-card-body">
                            <p class="card-description content-txt" id="description-{{ $product->id }}">

                                <span class="visible-text">
                                    {{ Str::limit($product->description,60) }}
                                </span>
                                <span class="more-text">
                                    {{ substr($product->description, 40) }}
                                </span>
                            </p>
                            <div class="product-description-div">
                                <div class="text-wrapper">
                                    <h6 class="product-name text-product">
                                        {{-- <span class="title">Product: </span> --}}
                                        {{-- <span class="pro-name">{{ $product->name }}</span>
                                    </h6>
                                </div>
                                <h6 class="company-name">
                                    <span class="title">Company: </span>
                                    <span class="pro-company">{{ $product->company->name ?? 'N/A' }}</span>
                                </h6>
                                <h6 class="product-name">
                                    <span class="title">Category: </span>
                                    <span class="pro-name">{{ $product->category->name ?? 'N/A' }}</span>
                                </h6>


                                <h6 class="material-name">
                                    <span class="material-title">Material: </span>
                                    <span class="mt-name">{{ $product->material }}</span>
                                </h6>
                                <h6 class="product-size">
                                    <span class="size-title">Size: </span>
                                    <span class="sz-name">{{ $product->size }}</span>
                                </h6>

                                <a href="javascript:void(0)" class="read-more"
                                    onclick="toggleReadMore({{ $product->id }})"></a>



                            </div> --}}
                            <!-- CTA button within the card -->
                            {{-- <div class="d-flex justify-content-start mx-2 bottom-btn">
                                @auth
                                    <a href="{{ route('inquiryform', ['product_id' => $product->id, 'product_name' => $product->name]) }}"
                                        class="inqury-btn">
                                        <span>Inquiry</span>
                                    </a>
                                @else --}}
                                    {{-- <a href="{{ route('login') }}" class="inqury-btn"> --}}
                                    {{-- <a onclick="openModal()" style="cursor: pointer" class="inqury-btn">
                                        <span>Sign in to Inquire</span>
                                    </a>
                                @endauth
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div> --}}

        <!--mobile view-->
        <div id="topcategorycaresoule" class="owl-carousel owl-theme">
            @foreach ($topCategoryProducts as $product)
            <div class="item product-col">
                <div class="card-view">
                    <a href="{{ route('product.show', $product->id) }}" class="card-link"></a>
                    <div class="image-container">
                        <div class="thumbnail_container">
                            <div class="thumbnail">
                                <img src="{{ asset($product->image_url) }}" class="product-image swiper-img"
                                    alt="{{ $product->name }}" onclick="openPopup(this)">
                            </div>
                        </div>
                    </div>
                    <div class="main-logo-container">

                        <div class="logo-container">
                            @if ($product->company && $product->company->logo_url)
                                <img src="{{ asset($product->company->logo_url) }}" class="logo-image"
                                    alt="{{ $product->company->name }}">
                            @else
                                <span>No Logo</span>
                            @endif
                        </div>
                        <div class="image_overlay view-arrow-btn hide">
                            <i class="fas fa-arrow-circle-down"></i>
                        </div>
                    </div>
                    <div class="card-body product-card-body">
                        <p class="card-description content-txt" id="description-{{ $product->id }}">

                            <span class="visible-text">
                                {{ Str::limit($product->description, 20) }}
                            </span>
                            <span class="more-text">
                                {{ substr($product->description, 50) }}
                            </span>
                        </p>
                        <div class="product-description-div">
                            <div class="text-wrapper">
                                <h6 class="product-name text-product">
                                    {{-- <span class="title">Product: </span> --}}
                                    <span class="pro-name">{{ $product->name }}</span>
                                </h6>
                            </div>
                            <h6 class="company-name">
                                <span class="title">Company: </span>
                                <span class="pro-company">{{ $product->company->name ?? 'N/A' }}</span>
                            </h6>
                            <h6 class="product-name">
                                <span class="title">Category: </span>
                                <span class="pro-name">{{ $product->category->name ?? 'N/A' }}</span>
                            </h6>


                            <h6 class="material-name">
                                <span class="material-title">Material: </span>
                                <span class="mt-name">{{ $product->material }}</span>
                            </h6>
                            <h6 class="product-size">
                                <span class="size-title">Size: </span>
                                <span class="sz-name">{{ $product->size }}</span>
                            </h6>

                            <a href="javascript:void(0)" class="read-more"
                                onclick="toggleReadMore({{ $product->id }})"></a>



                        </div>
                        <!-- CTA button within the card -->
                        <div class="d-flex justify-content-start mx-2 bottom-btn">
                            @auth
                                <a href="{{ route('inquiryform', ['product_id' => $product->id, 'product_name' => $product->name]) }}"
                                    class="inqury-btn">
                                    <span>Inquiry</span>
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="inqury-btn">
                                    <span>Sign in to Inquire</span>
                                </a>
                            @endauth
                        </div>
                    </div>

                </div>
            </div>
        @endforeach
          </div>
          <div class="d-flex justify-content-center">
          <a href="{{ route('innertopcategory') }}" class="btn-view mobile-btn primary-btn d-lg-none d-xl-none d-sm-block d-block d-md-none text-center">View More</a>
        </div>
    </div>

    <script>
        // Toggle function
        function toggleReadMore(productId) {
            var description = document.getElementById('description-' + productId);
            var moreText = description.querySelector('.more-text');
            var readMoreBtn = description.parentNode.querySelector('.read-more');

            if (moreText.style.display === "none" || moreText.style.display === "") {
                moreText.style.display = "inline"; // Show the additional text
                readMoreBtn.textContent = "Read Less"; // Update button text
            } else {
                moreText.style.display = "none"; // Hide the additional text
                readMoreBtn.textContent = "Read More"; // Update button text
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            var descriptions = document.querySelectorAll('.card-description');
            descriptions.forEach(function(description) {
                var moreText = description.querySelector('.more-text');
                var readMoreBtn = description.parentNode.querySelector('.read-more');


                if (!moreText.textContent.trim()) {
                    readMoreBtn.style.display = "none";
                }
            });
        });
    </script>
</section>
