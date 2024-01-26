@extends('templates.template-public', ['menu_selected' => 'blog'])
@section('page_class', 'page-blog')

@section('content')
    <div id="top"></div>
    <section id="subheader" class="text-light" data-bgimage="url({{ asset('assets/template/images-dj/background/subheader.jpg') }}) bottom">
        <div class="center-y relative text-center">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h1 class="wow fadeInLeft" data-wow-delay=".2s">Clientes</h1>
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
                <div class="col-md-12">
                    <div class="blog-read">
                        <div class="post-text">
                            <p>Te dejamos algunas experiencias de clientes que ya han pasado por aquí para que veas cómo lo han pasado, su experiencia y qué opinan de nuestro servicio.</p>
                            <h2 class="wow fadeInUp" data-wow-delay=".2s">Igual te ayuda a tomar la mejor decisión...</h2>
                            <br><br>
                            <div class="container">
                                <div class="row g-custom-x">
                                    @foreach($opiniones as $opinion)
                                        <div class="row">
                                            <div class="col-md-4">
                                                @image(["image" => $opinion->images->where('tag', 'portada')->first(), "model" => "review", "class" => "img-fluid mb-3"])
                                            </div>
                                            <div class="col-md-8">
                                                <h3><span class="dorado">{{ $opinion->title }}</span></h3>
                                                <h4><span class="dorado">Tipo experiencia:</span> {{ $opinion->experiencia->title }}</a></h4>
                                                    <p>{{ $opinion->experiencia->summary }}</p>
                                                    <blockquote><em><h6>{{ $opinion->summary }}</h6></em></blockquote>
                                            </div>
                                        </div>
                                        <hr/>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('js')
@stop
