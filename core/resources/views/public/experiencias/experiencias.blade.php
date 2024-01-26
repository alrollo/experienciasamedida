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
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </section>

    <div class="arrow_wrap">
        <div class="arrow__up"></div>
    </div>
    <section id="section-schedule section-artists" aria-label="section-services-tab" data-bgimage="">

        <div class="container">
            <div class="row g-custom-x align-items-center">
                @foreach ($familias as $familia)
                <div class="col-md-3 mb-sm-30">
                    <div class="de-image-text s2 wow flipInY">
                        <a href="{{ url(Tr::Get('links.experiencias.href').'/'.$familia->title_slug) }}" class="d-text">
                            <h3>{{ $familia->title }}</h3>
                        </a>
                        @image(["image" => $familia->images->where('tag', 'portada')->first(), "model" => "servicefamily", "class" => "img-fluid"])
                    </div>
                </div>
                @endforeach
            </div>

            <div class="row">
                <div class="col-md-12 text-center">
                    <br><br>
                    <h2 class="wow fadeInUp" data-wow-delay=".2s">¿Tienes claro con quien lo vas a disfrutar o a quien se lo vas a regalar?</h2>
                    <div class="small-border bg-color wow zoomIn" data-wow-delay=".4s"></div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('js')
@stop
