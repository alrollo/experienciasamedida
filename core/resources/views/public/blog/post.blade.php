@extends('templates.template-public', ['menu_selected' => 'blog'])
@section('page_class', 'page-blog')

@section('content')
    <div id="top"></div>
    <section id="subheader" class="text-light" data-bgimage="url({{ asset('assets/template/images-dj/background/subheader.jpg') }}) bottom">
        <div class="center-y relative text-center">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h1 class="wow fadeInLeft" data-wow-delay=".2s">Blog</h1>
                        <h2 class="wow fadeInLeft" data-wow-delay=".2s">{{ $post->title }}</h2>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </section>

    <div class="arrow_wrap">
        <div class="arrow__up"></div>
    </div>
    <section aria-label="section">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="blog-read">
                        <h2 class="wow fadeInUp" data-wow-delay=".2s">{{ $post->title }}</h2>
                        @image(["image" => $post->images->where('tag', 'portada')->first(), "model" => "article", "class" => "img-fluid mb-3"])
                        <div class="post-text">
                            <p>{{ $post->summary }}</p>
                            <div>{!! $post->description !!}</div>
                        </div>
                    </div>
                </div>

                <div id="sidebar" class="col-md-4">

                    <h4>Otros Artículos de igual o más interés turístico</h4>
                    <div class="small-border"></div>
                    <ul class="wow fadeInRight" data-wow-delay=".2s">
                        @foreach ($ultimosPost as $otroPost)
                            <li><strong>&raquo;</strong> <a href="{{ url(Tr::Get('links.blog.detail.href').$otroPost->title_slug) }}" aria-label="{{ Tr::Get('common.aria') }} {{ $otroPost->title }}" title="{{ Tr::Get('common.title') }} {{ $otroPost->title }}"><strong>{{ $otroPost->title }}</strong></a> </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>
@stop

@section('js')
@stop
