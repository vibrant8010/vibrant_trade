<!DOCTYPE html>
<html lang="en">
<x-head />

<body>
    <x-header />
    <section class="content product-detail-container">
        <div class="product-container container-fluid">
            <div class="row">
                <div class="col-xl-8 col-lg-7 col-md-8 col-sm-12">
                    <div class="row">
                        <div class="col-lg-5 col-md-6 col-sm-12">
                            <article class="demo-area">
                                <div class="product-img">
                                    <a class="demo-trigger" href="{{ asset($product->image_url) }}">
                                        <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}">
                                    </a>
                                </div>
                            </article>
                        </div>
                        <div class="p-0 col-lg-7 col-md-6 col-sm-12">
                            <div class="detail">
                                <div class="product-details mt-3">
                                    <img src="{{ asset($product->company->logo_url) }}"
                                        style="width: 100px;height:100%;" alt="{{ $product->companyname }}">

                                    <h2 class="product-title">{{ $product->name }}</h2>
                                    <p class="product-subtitle">{{ $product->description }}</p>

                                    <!-- Product Information -->
                                    <div class="product-info">

                                        <div class="info-item">
                                            <div class="info-label">Companyname:</div>
                                            <div class="info-value">{{ $product->company->name }}
                                            </div>
                                        </div>

                                        <div class="info-item">
                                            <div class="info-label">Category:</div>
                                            <div class="info-value">{{ $product->category->name }}
                                            </div>
                                        </div>


                                        <div class="info-item">
                                            <div class="info-label">Subcategory:</div>
                                            <div class="info-value">{{ $product->subcategory->name }}
                                            </div>
                                        </div>


                                        <div class="info-item">
                                            <div class="info-label">Material:</div>
                                            <div class="info-value">{{ $product->material }}</div>
                                        </div>

                                        <div class="info-item">
                                            <div class="info-label">Size:</div>
                                            <div class="info-value">{{ $product->size }}</div>

                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="info-item">
                                    <div class="bottom-btn my-3">
                                        @auth
                                            <a href="{{ route('inquiryform', ['product_id' => $product->id, 'product_name' => $product->name]) }}"
                                                class="cta">
                                                <span>Inquiry</span>
                                                <i class="fa-solid fa-arrow-right"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('login') }}" class="inqury-btn">
                                                <span>Product Inquire</span>
                                                <!-- <i class="fa-solid fa-arrow-right"></i> -->
                                            </a>
                                        @endauth


                                    </div>
                                </div> --}}


                            </div>
                        </div>
                        @php
                            $fullAddress = implode(
                                ', ',
                                array_filter([
                                    $product->company->city ?? '',
                                    $product->company->state ?? '',
                                    $product->company->pincode ?? '',
                                ]),
                            );
                            // print_r($fullAddress);
                        @endphp
                        @php
                            use Carbon\Carbon;
                            $registrationDate = Carbon::parse($product->company->gst_registration_date);
                            $currentYear = Carbon::now();
                            $yearsSinceRegistration = $registrationDate->diffInYears($currentYear);
                            $registrationYear = $registrationDate->year;
                        @endphp
                        <div class="col-lg-12 d-block d-lg-none d-sm-block d-md-none">
                            <div class="company-personal-details sticky-top-new">
                                <div class="product-details mt-3">
                                    <img src="{{ asset($product->company->logo_url) }}"
                                        style="width: 100px;height:100%;margin-bottom: 10px;"
                                        alt="{{ $product->companyname }}">
                                </div>
                                <h6 class="company-product-title detail-text">{{ $product->name }}</h6>
                                <h6 class="detail-text company-address">{{ $fullAddress }}</h6>
                                <div class="company-start-date"><span class="title">since:</span> <span
                                        class="title-ans">
                                        <p>Registration Year: {{ $registrationYear }}</p>
                                        <p>Years Since Registration: {{ $yearsSinceRegistration }} years</p>
                                    </span></div>
                                <div class="company-business-category"><span class="title">Business Category :</span>
                                    <span class="title-ans">{{ $product->company->nature_of_business ?? '' }}</span>
                                </div>
                                <div class="company-product-count"><span class="title">Number of Product :</span> <span
                                        class="title-ans"> {{ $product->company->products->count() ?? '0' }}</span>
                                </div>
                                <div class="mobile-no-content">
                                    <ul class="mobile-no-data">
                                        <li class="company-no">
                                            <div class="action_button_filled">
                                                <span class="telephone-icon">
                                                    <i class="fa-solid fa-phone" style="color: #ffffff;"></i>
                                                </span>
                                                <a href="tel:8511684938" class="no-link">
                                                    8511684938
                                                </a>
                                            </div>
                                        </li>
                                        <li class="whatsup-content">
                                            <div class="action_whatsup_filled">
                                                <a target="_blank" rel="noopener noreferrer" role="button"
                                                    title="Whats App Chat" aria-label="Whats app chat" class="no-link">
                                                    <span class="whatus-icon"><i class="fa-brands fa-whatsapp"
                                                            style="color: #2aa81a;"></i></span>
                                                    <span class="whatsup-link">WhatsApp</span>
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                @if (Auth::check())

                @else
                <div class="btn-area my-4">
                    <a style="cursor: pointer" onclick="openInquiryModal()" class="inqury-btn d-block text-center">Inqury now</a>
                </div>
                @endif
                            </div>
                        </div>

                        <div class="col-lg-12 col-12 d-lg-block product-desc-section">
                            <ul class="nav nav-tabs" id="productDesc" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link fw-bold py-2 px-0 active" data-tab="about-info"
                                        type="button" role="tab">
                                        <span class="tab-nav-link-text fw-bold">About Company</span>
                                </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link fw-bold py-2 px-0" data-tab="more-product" type="button"
                                        role="tab">
                                        <span class="tab-nav-link-text fw-bold">More Products</span>
                                </a>
                                </li>
                            </ul>
                        </div>

                        <div class="prdoct-details-showbox">
                            <!-- Company About Info -->
                            <div class="tab-content about-info active" id="about-info">
                                <div class="productdetail-container container p-0">
                                    <div class="company-details">
                                        <div class="row">
                                            <div class="col-lg-12 d-flex justify-content-between">
                                                <p class="description-title">GST Registration Date: <span
                                                        class="description-txt">{{ $product->company->gst_registration_date }}</span>
                                                </p>
                                                <p class="description-title">Legal Status: <span
                                                        class="description-txt">{{ $product->company->legal_status }}</span>
                                                </p>

                                            </div>
                                        </div>
                                        <p class="description-title">Nature of Business: <span
                                                class="description-txt">{{ $product->company->nature_of_business }}</span>
                                        </p>
                                        <h4 class="description-titletxt">Company Description</h4>
                                        <p class="description-txt">{{ $product->company->description }}</p>
                                    </div>
                                </div>
                            </div>
                            <!-- More Products Info -->
                            <div class="tab-content more-product" id="more-product">
                                <div class="row">
                                    @php
                                        $categories2 = App\Models\Product::where(
                                            'company_id',
                                            '=',
                                            $product->company->id,
                                        )->get();
                                        // print_r($categories2);
                                    @endphp
                                    @forelse ($categories2 as $reletaedProductes)
                                        <div class="col-xl-4 col-lg-3 col-md-4 col-sm-6">
                                            <div class="card-view inner-card">
                                                <a href="/product/{{ $reletaedProductes->id }}"
                                                    class="card-link"></a>
                                                <div class="image-container">
                                                    <div class="thumbnail_container">
                                                        <div class="thumbnail">
                                                            <img src="{{ asset($reletaedProductes->image_url) }}"
                                                                alt="{{ $reletaedProductes->name }}"
                                                                class="product-image swiper-img"
                                                                onclick="openPopup(this)">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="logo-container" style="">
                                                    <img src="{{ asset($reletaedProductes->company->logo_url) }}"
                                                        class="logo-image" alt="{{ $reletaedProductes->name }}">
                                                </div>

                                                <div class="text-wrapper">
                                                    <h6 class="tranding-product-name">
                                                        <span class="title">Product:</span>
                                                        <span
                                                            class="trnding-pro-name">{{ $reletaedProductes->name }}</span>
                                                    </h6>

                                                </div>
                                                <div class="card-bottom">
                                                    <h6 class="tranding-product-name">
                                                        <span class="title">Company Name:</span>
                                                        <span
                                                            class="tranding-pro-name">{{ $reletaedProductes->company->name }}</span>
                                                    </h6>
                                                    <h6 class="tranding-product-name">
                                                        <span class="title">Category:</span>
                                                        <span
                                                            class="tranding-pro-name">{{ $reletaedProductes->category->name }}</span>
                                                    </h6>

                                                    <h6 class="tranding-material-name">
                                                        <span class="tranding-material-title">Material:</span>
                                                        <span
                                                            class="mt-name tranding-mt-name">{{ $reletaedProductes->material }}</span>
                                                    </h6>
                                                    <h6 class="tranding-product-size">
                                                        <span class="tranding-size-title">Size:</span>
                                                        <span
                                                            class="tranding-sz-name">{{ $reletaedProductes->size }}</span>
                                                    </h6>
                                                    <p class="card-description content-txt" id="description-92">

                                                        <span class="visible-text">
                                                            This Hammered Sauce...
                                                        </span>

                                                    </p>
                                                    <a href="javascript:void(0)" class="read-more"
                                                        onclick="toggleReadMore(92)"></a>

                                                    <div class="d-flex justify-content-start mx-2 bottom-btn">
                                                        <a href="http://127.0.0.1:8000/login" class="inqury-btn mt-2">
                                                            <span>Sign in to Inquire</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <li>No products found.</li>
                                    @endforelse
                                    {{-- <div class="col-xl-4 col-lg-3 col-md-4 col-sm-6">
                                        <div class="card-view inner-card">
                                            <a href="http://127.0.0.1:8000/product/92" class="card-link"></a>
                                            <div class="image-container">
                                                <div class="thumbnail_container">
                                                    <div class="thumbnail">
                                                        <img src="http://127.0.0.1:8000/images/1734066639_COOKWAREINDIVISUAl.webp" class="product-image swiper-img" alt="Hammered Sauce Pan" onclick="openPopup(this)">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="logo-container" style="">
                                                                                <img src="http://127.0.0.1:8000/logos\1733305223_shri_and_sam_logo_280_by_80.png" class="logo-image" alt="Shri and Sam">
                                                                        </div>

                                            <div class="text-wrapper">
                                                <h6 class="tranding-product-name">
                                                    <span class="title">Product:</span>
                                                    <span class="trnding-pro-name">Hammered Sauce Pan</span>
                                                </h6>

                                            </div>
                                            <div class="card-bottom">
                                                <h6 class="tranding-product-name">
                                                    <span class="title">Company Name:</span>
                                                    <span class="tranding-pro-name">Shri and Sam</span>
                                                </h6>
                                                <h6 class="tranding-product-name">
                                                    <span class="title">Category:</span>
                                                    <span class="tranding-pro-name">Kitchenware</span>
                                                </h6>

                                                <h6 class="tranding-material-name">
                                                    <span class="tranding-material-title">Material:</span>
                                                    <span class="mt-name tranding-mt-name">Stainless Steel</span>
                                                </h6>
                                                <h6 class="tranding-product-size">
                                                    <span class="tranding-size-title">Size:</span>
                                                    <span class="tranding-sz-name">12cm to 18 cm</span>
                                                </h6>
                                                 <p class="card-description content-txt" id="description-92">

                                                        <span class="visible-text">
                                                            This Hammered Sauce...
                                                        </span>

                                                    </p>
                                                    <a href="javascript:void(0)" class="read-more" onclick="toggleReadMore(92)"></a>

                                                <div class="d-flex justify-content-start mx-2 bottom-btn">
                                                                                            <a href="http://127.0.0.1:8000/login" class="inqury-btn mt-2">
                                                            <span>Sign in to Inquire</span>
                                                        </a>
                                                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-3 col-md-4 col-sm-6">
                                        <div class="card-view inner-card">
                                            <a href="http://127.0.0.1:8000/product/92" class="card-link"></a>
                                            <div class="image-container">
                                                <div class="thumbnail_container">
                                                    <div class="thumbnail">
                                                        <img src="http://127.0.0.1:8000/images/1734066639_COOKWAREINDIVISUAl.webp" class="product-image swiper-img" alt="Hammered Sauce Pan" onclick="openPopup(this)">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="logo-container" style="">
                                                                                <img src="http://127.0.0.1:8000/logos\1733305223_shri_and_sam_logo_280_by_80.png" class="logo-image" alt="Shri and Sam">
                                                                        </div>

                                            <div class="text-wrapper">
                                                <h6 class="tranding-product-name">
                                                    <span class="title">Product:</span>
                                                    <span class="trnding-pro-name">Hammered Sauce Pan</span>
                                                </h6>

                                            </div>
                                            <div class="card-bottom">
                                                <h6 class="tranding-product-name">
                                                    <span class="title">Company Name:</span>
                                                    <span class="tranding-pro-name">Shri and Sam</span>
                                                </h6>
                                                <h6 class="tranding-product-name">
                                                    <span class="title">Category:</span>
                                                    <span class="tranding-pro-name">Kitchenware</span>
                                                </h6>

                                                <h6 class="tranding-material-name">
                                                    <span class="tranding-material-title">Material:</span>
                                                    <span class="mt-name tranding-mt-name">Stainless Steel</span>
                                                </h6>
                                                <h6 class="tranding-product-size">
                                                    <span class="tranding-size-title">Size:</span>
                                                    <span class="tranding-sz-name">12cm to 18 cm</span>
                                                </h6>
                                                 <p class="card-description content-txt" id="description-92">

                                                        <span class="visible-text">
                                                            This Hammered Sauce...
                                                        </span>

                                                    </p>
                                                    <a href="javascript:void(0)" class="read-more" onclick="toggleReadMore(92)"></a>

                                                <div class="d-flex justify-content-start mx-2 bottom-btn">
                                                                                            <a href="http://127.0.0.1:8000/login" class="inqury-btn mt-2">
                                                            <span>Sign in to Inquire</span>
                                                        </a>
                                                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-3 col-md-4 col-sm-6">
                                        <div class="card-view inner-card">
                                            <a href="http://127.0.0.1:8000/product/92" class="card-link"></a>
                                            <div class="image-container">
                                                <div class="thumbnail_container">
                                                    <div class="thumbnail">
                                                        <img src="http://127.0.0.1:8000/images/1734066639_COOKWAREINDIVISUAl.webp" class="product-image swiper-img" alt="Hammered Sauce Pan" onclick="openPopup(this)">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="logo-container" style="">
                                                                                <img src="http://127.0.0.1:8000/logos\1733305223_shri_and_sam_logo_280_by_80.png" class="logo-image" alt="Shri and Sam">
                                                                        </div>

                                            <div class="text-wrapper">
                                                <h6 class="tranding-product-name">
                                                    <span class="title">Product:</span>
                                                    <span class="trnding-pro-name">Hammered Sauce Pan</span>
                                                </h6>

                                            </div>
                                            <div class="card-bottom">
                                                <h6 class="tranding-product-name">
                                                    <span class="title">Company Name:</span>
                                                    <span class="tranding-pro-name">Shri and Sam</span>
                                                </h6>
                                                <h6 class="tranding-product-name">
                                                    <span class="title">Category:</span>
                                                    <span class="tranding-pro-name">Kitchenware</span>
                                                </h6>

                                                <h6 class="tranding-material-name">
                                                    <span class="tranding-material-title">Material:</span>
                                                    <span class="mt-name tranding-mt-name">Stainless Steel</span>
                                                </h6>
                                                <h6 class="tranding-product-size">
                                                    <span class="tranding-size-title">Size:</span>
                                                    <span class="tranding-sz-name">12cm to 18 cm</span>
                                                </h6>
                                                 <p class="card-description content-txt" id="description-92">

                                                        <span class="visible-text">
                                                            This Hammered Sauce...
                                                        </span>

                                                    </p>
                                                    <a href="javascript:void(0)" class="read-more" onclick="toggleReadMore(92)"></a>

                                                <div class="d-flex justify-content-start mx-2 bottom-btn">
                                                                                            <a href="http://127.0.0.1:8000/login" class="inqury-btn mt-2">
                                                            <span>Sign in to Inquire</span>
                                                        </a>
                                                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-3 col-md-4 col-sm-6">
                                        <div class="card-view inner-card">
                                            <a href="http://127.0.0.1:8000/product/92" class="card-link"></a>
                                            <div class="image-container">
                                                <div class="thumbnail_container">
                                                    <div class="thumbnail">
                                                        <img src="http://127.0.0.1:8000/images/1734066639_COOKWAREINDIVISUAl.webp" class="product-image swiper-img" alt="Hammered Sauce Pan" onclick="openPopup(this)">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="logo-container" style="">
                                                                                <img src="http://127.0.0.1:8000/logos\1733305223_shri_and_sam_logo_280_by_80.png" class="logo-image" alt="Shri and Sam">
                                                                        </div>

                                            <div class="text-wrapper">
                                                <h6 class="tranding-product-name">
                                                    <span class="title">Product:</span>
                                                    <span class="trnding-pro-name">Hammered Sauce Pan</span>
                                                </h6>

                                            </div>
                                            <div class="card-bottom">
                                                <h6 class="tranding-product-name">
                                                    <span class="title">Company Name:</span>
                                                    <span class="tranding-pro-name">Shri and Sam</span>
                                                </h6>
                                                <h6 class="tranding-product-name">
                                                    <span class="title">Category:</span>
                                                    <span class="tranding-pro-name">Kitchenware</span>
                                                </h6>

                                                <h6 class="tranding-material-name">
                                                    <span class="tranding-material-title">Material:</span>
                                                    <span class="mt-name tranding-mt-name">Stainless Steel</span>
                                                </h6>
                                                <h6 class="tranding-product-size">
                                                    <span class="tranding-size-title">Size:</span>
                                                    <span class="tranding-sz-name">12cm to 18 cm</span>
                                                </h6>
                                                 <p class="card-description content-txt" id="description-92">

                                                        <span class="visible-text">
                                                            This Hammered Sauce...
                                                        </span>

                                                    </p>
                                                    <a href="javascript:void(0)" class="read-more" onclick="toggleReadMore(92)"></a>

                                                <div class="d-flex justify-content-start mx-2 bottom-btn">
                                                                                            <a href="http://127.0.0.1:8000/login" class="inqury-btn mt-2">
                                                            <span>Sign in to Inquire</span>
                                                        </a>
                                                                                    </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>

                            </div>
                        </div>

                    </div>


                    <!--company details section for bottom -->

                    <!-- <div class="product-container">
                        <h4 class="main-heading my-4" style="display: block;">About the Company</h4>
                    </div>
                    <div class="productdetail-container container">
                        <div class="company-details mx-2">
                            <div class="row">
                                <div class="col-lg-12 d-flex justify-content-between">
                                    <p class="description-title">GST Registration Date: <span class="description-txt">{{ $product->company->gst_registration_date }}</span></p>
                                    <p class="description-title">Legal Status: <span class="description-txt">{{ $product->company->legal_status }}</span></p>

                                </div>
                            </div>
                            <p class="description-title">Nature of Business: <span class="description-txt">{{ $product->company->nature_of_business }}</span></p>
                            <h4 class="description-titletxt">Description</h4>
                            {{-- <p>{{ $product->company->description }}</p> --}}


                        </div>
                    </div> -->
                </div>

                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12 d-lg-block d-sm-none d-md-block d-sm-none d-none">
                    <div class="company-personal-details sticky-top-new">
                        <div class="product-details mt-3">
                            <img src="{{ asset($product->company->logo_url) }}"
                                style="width: 100px;height:100%;margin-bottom: 10px;"
                                alt="{{ $product->companyname }}">
                        </div>
                        <h6 class="company-product-title detail-text">{{ $product->name }}</h6>
                        <h6 class="detail-text company-address">{{ $fullAddress }}</h6>
                        <div class="company-start-date"><span class="title">since:</span> <span class="title-ans">
                                {{-- {{ $product->company->gst_registration_date }}2011 --}}
                                <p>Registration Year: {{ $registrationYear }}</p>
                                <p>Years Since Registration: {{ $yearsSinceRegistration }} years</p>
                            </span></div>
                        <div class="company-business-category"><span class="title">Business Category :</span> <span
                                class="title-ans">{{ $product->company->nature_of_business ?? '' }}</span></div>
                        <div class="company-product-count"><span class="title">Number of Product :</span> <span
                                class="title-ans"> {{ $product->company->products->count() ?? '0' }}</span></div>
                        <div class="mobile-no-content">
                            <ul class="mobile-no-data">
                                <li class="company-no">
                                    <div class="action_button_filled">
                                        <span class="telephone-icon">
                                            <i class="fa-solid fa-phone" style="color: #ffffff;"></i>
                                        </span>
                                        <a href="tel:8511684938" class="no-link">
                                            8511684938
                                        </a>
                                    </div>
                                </li>
                                <li class="whatsup-content">
                                    <div class="action_whatsup_filled">
                                        <a target="_blank" rel="noopener noreferrer" role="button"
                                            title="Whats App Chat" aria-label="Whats app chat" class="no-link">
                                            <span class="whatus-icon"><i class="fa-brands fa-whatsapp"
                                                    style="color: #2aa81a;"></i></span>
                                            <span class="whatsup-link">WhatsApp</span>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        @if (Auth::check())

                @else
                <div class="btn-area my-4">
                    <a style="cursor: pointer" onclick="openInquiryModal()" class="inqury-btn d-block text-center">Inqury now</a>
                </div>
                @endif

                    </div>
                </div>
            </div>

        </div>

        </div>

        {{-- <div class="whatsapp-main-box">
            <a href="#" id="whatsapp-share-button" class="popmake-470 mx-auto">
                <img class="whatsapp-icon" src="{{ asset('images/icons8-whatsapp-48.png') }}" alt="WhatsApp Icon">
            </a>
        </div> --}}
        <script>
            // Function to encode text for URL
            function encodeText(text) {
                return encodeURIComponent(text);
            }

            // Function to construct the WhatsApp share URL
            function getWhatsAppShareURL(productName, productDescription, productPrice, productURL) {
                const phoneNumber = '918511684938'; // Replace with your business's WhatsApp number
                const message =
                    `I'm interested in the product: ${productName}\nDescription: ${productDescription}\nPrice: ${productPrice}\nYou can view it here: ${productURL}`;
                const encodedMessage = encodeText(message);
                return `https://wa.me/${phoneNumber}?text=${encodedMessage}`;
            }

            // Event listener for the Share on WhatsApp button
            document.getElementById('whatsapp-share-button').addEventListener('click', function(event) {
                event.preventDefault(); // Prevent default link behavior

                // Replace these variables with dynamic data from your product page
                const productName = '{{ $product->name }}';
                const productDescription = '{{ $product->description }}';
                const productPrice = '{{ $product->price }}';
                const productURL = window.location.href; // Current page URL

                const whatsappURL = getWhatsAppShareURL(productName, productDescription, productPrice, productURL);
                window.open(whatsappURL, '_blank');
            });
        </script>
    </section>



    <script>
        function openInquiryModal() {
            document.getElementById("inquiryModal").style.display = "flex";
        }

        document.getElementById("closeInquiryModal").addEventListener("click", function() {
            document.getElementById("inquiryModal").style.display = "none";
        });
    </script>
    <x-footer class="mb-0" />
    <x-script />
</body>

</html>
