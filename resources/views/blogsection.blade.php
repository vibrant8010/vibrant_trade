<!DOCTYPE html>
<html lang="en">
<head>
    <x-head />
</head>
<body>
    <x-header />

    <section class="blog-inner-section section-margin">
        <div class="container-fluid">
            <div class="blog-main-part">
                <!-- Left Part: Main Blog Content -->
                <div class="left-part">
                    <!-- Blog Image -->
                    <div class="img-container">
                        <div class="thumbnail_container">
                            <div class="thumbnail">
                                @if($blog->image_url)
                                    <img src="{{ asset($blog->image_url) }}" alt="{{ $blog->heading }}" style="width: 100%; height: auto;">
                                @else
                                    <span>No Image</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Blog Heading -->
                    <h2 class="title p-0">{{ $blog->heading }}</h2>

                    <!-- Blog Date -->
                    <div class="blog-date d-flex text-center justify-content-center py-3">
                        <span><i class="fa-solid fa-clock" style="color:#005353;"></i></span> 
                        <p class="inner-blog-date mx-2">{{ $blog->created_at->format('d.F.Y') }}</p>
                    </div>

                    <!-- Blog Detail Subcontent -->
                    <div class="sub-content">
                        {!! $blog->detail_subcontent !!}
                    </div>

                    <!-- Blog Sections (Subtitles and Text Content) -->
                    @foreach ($blog->sections as $section)
                        <div class="additional-content mb-4">
                            <div class="d-flex">
                                <span class="me-2"><i class="fa-solid fa-hand-point-right fa-2x"></i></span>
                                <h4 class="subtitle mb-2">{{ $section->subtitle }}</h4>
                            </div>
                            <div class="text-content">
                                {!! $section->textcontent !!}
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Right Part: List of Blogs (Excluding the Current Blog) -->
                <div class="right-part">
                    <h3 class="mb-4">Other Blogs</h3> <!-- Heading for the right part -->
                    @if(isset($allBlogs) && $allBlogs->count() > 0) <!-- Check if $allBlogs is defined and not empty -->
                        @foreach ($allBlogs as $singleBlog)
                            <div class="item mb-4">
                                <div class="row">
                                    <!-- Blog Image -->
                                    <div class="col-lg-5">
                                        @if($singleBlog->image_url)
                                            <div class="main-container bg_fix">
                                                <img src="{{ asset($singleBlog->image_url) }}" alt="blog img" style="width: 100%; height: auto;">
                                            </div>
                                        @else
                                            <span>No Image</span>
                                        @endif
                                    </div>

                                    <!-- Blog Info -->
                                    <div class="col-lg-7">
                                        <div class="card-body">
                                            <div class="blog-info">
                                                <!-- Blog Date -->
                                                <div class="blog-container-date-inner">
                                                    <p class="blog-inner-date blog-date">{{ $singleBlog->created_at->format('d - F - Y') }}</p>
                                                </div>

                                                <!-- Blog Heading -->
                                                <h3 class="blog-inner-title">{{ $singleBlog->heading }}</h3>

                                                <!-- Read More Link -->
                                                <a href="{{ route('blogsection', $singleBlog->id) }}" class="read-more">Read More</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>No other blogs found.</p>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <x-footer />
</body>
</html>