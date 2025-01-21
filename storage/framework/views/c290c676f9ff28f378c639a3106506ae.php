<style>
    .text-wrapper {
        font-family: Arial, sans-serif;
        font-size: 14px;
        line-height: 1.6;
        color: #333;
    }

    .card-description {
        margin-bottom: 8px;
    }

    .visible-text {
        display: inline;
    }

    .more-text {
        display: none;
    }

    .read-more {
        color: #007bff;
        text-decoration: none;
        cursor: pointer;
        font-weight: bold;
        margin-left: 5px;
    }

    .read-more:hover {
        text-decoration: underline;
    }
</style>

<section class="top-category section-margin" id="TopCategory">

    <div class="container">
        <div class="heading-section">
            <div class="main-heading">Top Categories</div>
            <a href="<?php echo e(route('innertopcategory')); ?>" class="btn-view primary-btn">View More</a>
        </div>
        <div class="row g-1">
            
                    <?php $__currentLoopData = $topCategoryProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 product-col">
                <div class="card-view">
                                    <a href="<?php echo e(route('product.show', $product->id)); ?>" class="card-link"></a>
                                    <div class="image-container">
                                        <div class="thumbnail_container">
                                            <div class="thumbnail">
                                                <img src="<?php echo e(asset($product->image_url)); ?>"
                                                    class="product-image swiper-img" alt="<?php echo e($product->name); ?>"
                                                    onclick="openPopup(this)">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="main-logo-container">

                                        <div class="logo-container">
                                            <?php if($product->company && $product->company->logo_url): ?>
                                                <img src="<?php echo e(asset($product->company->logo_url)); ?>" class="logo-image"
                                                    alt="<?php echo e($product->company->name); ?>">
                                            <?php else: ?>
                                                <span>No Logo</span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="image_overlay view-arrow-btn hide">
                                            <i class="fas fa-arrow-circle-down"></i>
                                        </div>
                                    </div>
                                    <div class="card-body product-card-body">
                                    <p class="card-description content-txt" id="description-<?php echo e($product->id); ?>">

                                        <span class="visible-text">
                                            <?php echo e(Str::limit($product->description, 20)); ?>

                                        </span>
                                        <span class="more-text">
                                            <?php echo e(substr($product->description, 50)); ?>

                                        </span>
                                    </p>
                                    <div class="product-description-div">
                                        <div class="text-wrapper">
                                            <h6 class="product-name">
                                                <span class="title">Product: </span>
                                                <span class="pro-name"><?php echo e($product->name); ?></span>
                                            </h6>
                                        </div>
                                        <h6 class="company-name">
                                            <span class="title">Company: </span>
                                            <span class="pro-company"><?php echo e($product->company->name ?? 'N/A'); ?></span>
                                        </h6>
                                        <h6 class="product-name">
                                            <span class="title">Category: </span>
                                            <span class="pro-name"><?php echo e($product->category->name ?? 'N/A'); ?></span>
                                        </h6>


                                        <h6 class="material-name">
                                            <span class="material-title">Material: </span>
                                            <span class="mt-name"><?php echo e($product->material); ?></span>
                                        </h6>
                                        <h6 class="product-size">
                                            <span class="size-title">Size: </span>
                                            <span class="sz-name"><?php echo e($product->size); ?></span>
                                        </h6>

                                        <a href="javascript:void(0)" class="read-more"
                                            onclick="toggleReadMore(<?php echo e($product->id); ?>)"></a>



                                    </div>
                                    <!-- CTA button within the card -->
                                    <div class="d-flex justify-content-start mx-2 bottom-btn">
                                        <?php if(auth()->guard()->check()): ?>
                                            <a href="<?php echo e(route('inquiryform', ['product_id' => $product->id, 'product_name' => $product->name])); ?>"
                                                class="inqury-btn">
                                                <span>Inquiry</span>
                                            </a>
                                        <?php else: ?>
                                            <a href="<?php echo e(route('login')); ?>" class="inqury-btn">
                                                <span>Sign in to Inquire</span>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>

                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

                // Only show the "Read More" link if additional text exists
                if (!moreText.textContent.trim()) {
                    readMoreBtn.style.display = "none";
                }
            });
        });

        var swiper = new Swiper(".mySwiper", {
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            loop: true,
            // autoplay: {
            //     delay: 2000,
            //     disableOnInteraction: false,
            // },
            slidesPerView: 1,
            spaceBetween: 10,
            breakpoints: {
                430: {
                    slidesPerView: 2,
                    spaceBetween: 10
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 5
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 15
                },
            },
        });
    </script>
</section>
<?php /**PATH C:\xampp\htdocs\vibrant_trade\resources\views/components/topcategoryy.blade.php ENDPATH**/ ?>