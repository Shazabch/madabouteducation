<style>
    .bd-blog-thumb {
        width: 100%;
        max-height: 350px;
        /* control max height of container */
        overflow: hidden;
        /* hides the extra part of long images */
        border-radius: 6px;
        /* optional */
    }

    .bd-blog-thumb img {
        width: 100%;
        height: auto;
        /* keep aspect ratio */
        display: block;
        object-fit: cover;
        /* ensures it fills the box neatly */
    }
</style>

<div class="bd-blog mb-40 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".3s">
    <a href="{{ route('article_details', $article->slug) }}">
        <div class="bd-blog-thumb">
            <img src="{{ asset($article->image) }}" alt="blog image">
        </div>
    </a>
    <div class="bd-blog-content">
        <div class="bd-blog-date">
            <span>{{ $article->published_on }}</span>
        </div>
        <div class="bd-blog-meta">
            <span><i class="fas fa-user"></i> by <a href="news.html">Admin</a></span>
            {{-- <span><i class="fa-solid fa-comment-dots"></i><a href="{{ route('article_details',$article->slug) }}">0
                    Comments</a></span> --}}
        </div>
        <h4 class="bd-blog-title"><a href="{{ route('article_details', $article->slug) }}">{{ $article->title }}</a>
        </h4>
    </div>
</div>
