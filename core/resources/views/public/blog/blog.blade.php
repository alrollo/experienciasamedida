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
        <h2 class="text-center wow fadeInLeft" data-wow-delay=".2s"> Cuenca tiene mucho que ofrecerte</h2>
        <h4 class="text-center wow fadeInRight" data-wow-delay=".4s">No tiene por qué ser lo mismo que siempre se vende y oferta...</h4>
        <br><br>
        <div class="container">
            <div class="row g-custom-x">
                @foreach($posts as $post)
                    <div class="col-lg-4 col-md-6 mb20">
                        <div class="de-event-item">
                            <div class="d-content">
                                <div class="d-image">
                                    <span class="d-image-wrap">@image(["image" => $post->images->where('tag', 'portada')->first(), "model" => "article", "class" => "lazy"])</span>
                                    <span class="d-date">
                                        <span class="d-mm">{{ \Carbon\Carbon::parse($post->dateTime)->isoFormat('MMM') }}</span>
                                        <span class="d-dd">{{ \Carbon\Carbon::parse($post->dateTime)->isoFormat('DD') }}</span>
                                    </span>
                                </div>
                                <div class="d-text">
                                    <a href="{{ url(Tr::Get('links.post.detalle.href').$post->title_slug) }}" aria-label="{{ Tr::Get('common.aria') }} {{ $post->title }}" title="{{ Tr::Get('common.title') }} {{ $post->title }}"><h4>{{ $post->title }}</h4></a>
                                    <p>{{ $post->summary }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($loop->iteration % 3 == 1)
                        <div class="spacer-single"></div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>
@stop

@section('js')
@stop
