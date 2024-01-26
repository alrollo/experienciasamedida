@extends('templates.template-public', ['menu_selected' => 'servicios'])
@section('page_class', 'page-servicios')

@section('content')
    <div id="top"></div>
    <section id="subheader" class="text-light" data-bgimage="url({{ asset('assets/template/images-dj/background/subheader.jpg') }}) bottom">
        <div class="center-y relative text-center">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h1 class="wow fadeInLeft" data-wow-delay=".2s">Experiencias</h1>
                        <h2 class="wow fadeInLeft" data-wow-delay=".2s">{{ $servicio->title }}</h2>
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
                <div id="sidebar" class="col-md-3">
                    @foreach ($familias as $familiaListado)
                        <h4><span class="@if($familiaListado->id == $servicio->family_id) dorado @endif">{{ $familiaListado->title }}</span></h4>
                        <hr>
                    @endforeach
                </div>
                <div class="col-md-9">
                    <div class="blog-read">
                        <div class="post-text">
                            <p>{{ $servicio->family->summary }}</p>
                            <h2 class="wow fadeInUp" data-wow-delay=".2s">{{ $servicio->title }}</h2>
                            <br><br>
                            @image(["image" => $servicio->images->where('tag', 'portada')->first(), "model" => "service", "class" => "img-fluid mb-3"])
                            <br><br>
                            <p>{{ $servicio->summary }}</p>
                            <div>{!! $servicio->description !!}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="section-schedule" aria-label="section-services-tab" data-bgimage="url({{ asset('assets/template/images-dj/background/1.jpg') }})">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <div class="wm wow slideInUp"><span class="black">DISFRUTA</span></div>
                        <h2 class="wow fadeInUp" data-wow-delay=".2s"><span class="black">Otras experiencas similares</span></h2>
                        <div class="small-border bg-color wow zoomIn" data-wow-delay=".4s"></div>
                        <br>
                    </div>
                </div>
                <div class="spacer-single"></div>
            </div>
        </div>
    </section>
    <section aria-label="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @foreach($servicio->family->services as $otroServicio)
                        <div class="row">
                            <div class="col-md-4"> @image(["image" => $otroServicio->images->where('tag', 'portada')->first(), "model" => "service", "class" => "img-fluid mb-3"])</div>
                            <div class="col-md-8">
                                <h3><a href="{{ url(Tr::Get('links.experiencias.detalle.href').$otroServicio->title_slug) }}"><span class="dorado">{{ $otroServicio->title }}</span></a></h3>
                                <p>{{ $otroServicio->summary }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <hr/>
            </div>
        </div>
    </section>
@stop

@section('js')
@stop
