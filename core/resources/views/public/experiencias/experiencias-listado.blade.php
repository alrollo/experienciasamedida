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
                        <h2 class="wow fadeInLeft" data-wow-delay=".2s">{{ $familia->title }}</h2>
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
                        <h4><a href="{{ url(Tr::Get('links.experiencias.href').'/'.$familiaListado->title_slug) }}" class="@if($familiaListado->id == $familia->id) dorado @endif">{{ $familiaListado->title }}</a></h4>
                        <hr>
                    @endforeach
                </div>
                <div class="col-md-9">
                    <div class="blog-read">
                        <div class="post-text">
                            <p>Resumen de la familia de experiencias...Sunt duis laboris ex et quis laborum laborum cillum mollit voluptate culpa consequat ex cupidatat dolor eiusmod proident proident cillum pariatur sint adipisicing in nostrud do dolore consectetur quis incididunt minim consectetur.</p>
                            <h2 class="wow fadeInUp" data-wow-delay=".2s">Míra lo que tenemos para ti...</h2>
                            <br><br>

                            @foreach($familia->services as $service)
                            <div class="row">
                                <div class="col-md-4">
                                    @image(["image" => $service->images->where('tag', 'portada')->first(), "model" => "service", "class" => "img-fluid mb-3"])
                                </div>
                                <div class="col-md-8">
                                    <h3><a href="{{ url(Tr::Get('links.experiencias.detalle.href').$service->title_slug) }}"><span class="dorado">{{ $service->title }}</span></a></h3>
                                    <p>{{ $service->summary }}</p>
                                </div>
                            </div>
                            <hr/>
                            @endforeach

                            <h2 class="wow fadeInUp" data-wow-delay=".2s">Y también podemos prepararte algo a medida... <span class="dorado">¡Contacta y cuéntanos!</span></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('js')
@stop
