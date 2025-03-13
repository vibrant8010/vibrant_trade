<section class="blog-section section-margin mt-4" id="BlogCarousel">
    <div class="container">
        <div class="heading-section mb-4">
            <div class="main-heading">
                Blog Section
            </div>
        </div>

        <div id="blogsection" class="owl-carousel owl-theme p-0 m-0">
            @if (!$blogs->isempty())
            @foreach ($blogs as $blog)
            <div class="item">
                     @if($blog->image_url)
                     <div class="main-container bg_fix">
                                <img src="{{ asset($blog->image_url) }}" alt="blog img">
                      </div>
                        @else
                        <span>No Image</span>
                    @endif
                    <div class="card-body">

                        <div class="blog-info">
                            <div class="blog-container-date">
                                <p class="blog-date">{{ $blog->created_at->format('d - F - Y') }}</p>
                           </div>
                            <h3 class="blog-title">{{ $blog->heading }}</h3>
                            <a href="{{ route('blogsection', $blog->id) }}" class="read-more">Read More</a>
                        </div>
                    </div>
            </div>
        @endforeach
            @endif

        </div>
    </div>
</section>
