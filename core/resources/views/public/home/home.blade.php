@extends('templates.template-public', ['menu_selected' => 'inicio'])
@section('page_class', 'page-home')

@section('content')
    <section id="de-carousel" class="no-top no-bottom carousel slide carousel-fade shadow-2-strong" data-mdb-ride="carousel">

        <ol class="carousel-indicators">
            <li data-mdb-target="#de-carousel" data-mdb-slide-to="0" class="active"></li>
            <li data-mdb-target="#de-carousel" data-mdb-slide-to="1"></li>
            <li data-mdb-target="#de-carousel" data-mdb-slide-to="2"></li>
        </ol>

        <div class="carousel-inner">

            <div class="carousel-item active" data-bgimage="url({{ asset('assets/template/images-dj/slider/1.jpg') }})">
                <div class="mask">
                    <div class="d-flex justify-content-center align-items-center h-100">
                        <div class="container text-white text-center">
                            <div class="row">
                                <div class="col-md-12">
                                    <h1 class="ultra-big mb-3 wow fadeInUp">Experiencias<br><span class="id-color">a medida</span><br><span style="font-size:0.7em">en cuenca</span></h1>
                                    <div class="col-md-6 offset-md-3">
                                        <p class="lead wow fadeInUp" data-wow-delay=".3s">Vivirás toda una experienca en Cuenca totalmente adaptada a tus gustos, a tu bolsillo, a tus aficiones...</p>
                                    </div>
                                    <div class="spacer-10"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <a class="carousel-control-prev" href="#de-carousel" role="button" data-mdb-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#de-carousel" role="button" data-mdb-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </section>


    <div class="arrow_wrap">
        <div class="arrow__up"></div>
    </div>
    <section id="section-date" class="bg-color pt40 pb30">
        <div class="container">
            <div class="row g-custom-x align-items-center">
                <div class="col-lg-12">
                    <div class="text-center" style="padding-top:10px">
                        <h2 class="s2 text-black wow fadeInUp" data-wow-delay="0s"><span class="dorado">¡Conoce Cuenca de una forma diferente!</span></h2>
                        <h3 class="text-black wow fadeInUp" data-wow-delay=".2s">Es toda una experiencia que estás a punto de descubrir, y que vas a querer repetir</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="section-artists">
        <div class="container">
            <div class="row g-custom-x align-items-center">
                <div class="col-lg-12">
                    <div class="text-center">
                        <div class="wm wow slideInUp">¡VÍVELO!</div>
                        <h2 class="wow fadeInUp" data-wow-delay=".2s"><span class="id-color">01</span> Elige el tipo de experiencia</h2>
                        <div class="small-border bg-color-2"></div>
                        <br><br><h5>¿Como quieres disfrutar de tu experiencia a medida en Cuenca?</h5>
                        <div class="spacer-single"></div>
                    </div>
                </div>
                <div class="col-md-3 mb-sm-30">
                    <div class="de-image-text s2 wow flipInY">
                        <a href="#" class="d-text">
                            <div class="arrow_wrap">
                                <div class="arrow__up"></div>
                            </div>
                            <h3>Individual</h3>
                        </a>
                        <img src="{{ asset('assets/template/images-dj/misc/featured-1.jpg') }}" class="img-fluid" alt="">
                    </div>
                </div>
                <div class="col-md-3 mb-sm-30">
                    <div class="de-image-text s2 wow flipInY">
                        <a href="#" class="d-text">
                            <div class="arrow_wrap">
                                <div class="arrow__up"></div>
                            </div>
                            <h3>En pareja</h3>
                        </a>
                        <img src="{{ asset('assets/template/images-dj/misc/featured-2.jpg') }}" class="img-fluid" alt="">
                    </div>
                </div>
                <div class="col-md-3 mb-sm-30">
                    <div class="de-image-text s2 wow flipInY">
                        <a href="#" class="d-text">
                            <div class="arrow_wrap">
                                <div class="arrow__up"></div>
                            </div>
                            <h3>En familia</h3>
                        </a>
                        <img src="{{ asset('assets/template/images-dj/misc/featured-3.jpg') }}" class="img-fluid" alt="">
                    </div>
                </div>
                <div class="col-md-3 mb-sm-30">
                    <div class="de-image-text s2 wow flipInY">
                        <a href="#" class="d-text">
                            <div class="arrow_wrap">
                                <div class="arrow__up"></div>
                            </div>
                            <h3>En grupo</h3>
                        </a>
                        <img src="{{ asset('assets/template/images-dj/misc/featured-4.jpg') }}" class="img-fluid" alt="">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <br><br>
                        <div class="small-border bg-color wow zoomIn" data-wow-delay=".4s"></div>
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
                        <h2 class="wow fadeInUp" data-wow-delay=".2s"><span class="id-color">02</span> <span class="black">Indícanos gustos, aficiones...</span></h2>
                        <div class="small-border bg-color wow zoomIn" data-wow-delay=".4s"></div>
                        <br>
                        <h5><span class="black">Una experiencia a medida es eso, una experiencia totalmente planificada y orientata a tus intereses, gustos y aficiones. </span></h5>
                        <h3><span class="black">Queremos que sea inolvidable, y por eso necesitamos saber un poco más.</span></h3>
                    </div>
                </div>
                <div class="spacer-single"></div>
                <div class="col-md-12 d-none d-md-block">
                    <div class="de_tab tab_style_4 text-center">
                        <ul class="de_nav de_nav_dark">
                            <li data-link="#section-services-tab">
                                <h3>Busco Cultura <span>01</span></h3>
                                <h4>Museos, Teatro...</h4>
                            </li>
                            <li data-link="#section-services-tab">
                                <h3>Busco Naturaleza <span>02</span></h3>
                                <h4>Rincones mágicos, vistas...</h4>
                            </li>
                            <li data-link="#section-services-tab">
                                <h3>Busco Adrenalina <span>03</span></h3>
                                <h4>Deporte, multiaventura...</h4>
                            </li>
                            <li data-link="#section-services-tab">
                                <h3>Busco Gastronomía <span>04</span></h3>
                                <h4>Restaurantes, tapeo...</h4>
                            </li>
                        </ul>
                        <div class="de_tab_content text-left">
                            <div id="tab1" class="tab_single_content">
                                <div class="content" style=" background-image:url({{ asset('assets/template/images-dj/bg-negroclaro.png') }}); margin:0px 50px 0px 50px; padding-top:25px">
                                    <div class="row">
                                        <div class="col-md-12 text-center mb-4">
                                            <p class="white" style="padding:0px 25px 0px 25px">Vive toda una experiencia cultural en Cuenca. La capital y algunos puntos de especial interés cultural te dan la oportunidad de viajar en el tiempo, conocer y descubrir un patrimonio que es digno de admirar y visitar.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="tab2" class="tab_single_content">
                                <div class="content" style=" background-image:url({{ asset('assets/template/images-dj/bg-negroclaro.png') }}); margin:0px 50px 0px 50px; padding-top:25px">
                                    <div class="row">
                                        <div class="col-md-12 text-center mb-4">
                                            <p class="white" style="padding:0px 25px 0px 25px">Si de algo podemos presumir en Cuenca es del increíble entorno natural que tenemos. Ya habrás buscado información y habrás leido sobre la Ciudad Encantada, El nacimiento del Río Cuervo, etc. Pero hay mucho mucho màs. Rincones mágicos, entornos irrepetibles... Si te gusta la naturaleza y buscas una experiencia nueva en Cuenca, ahora puedes hacerlo...</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="tab3" class="tab_single_content">
                                <div class="content" style=" background-image:url({{ asset('assets/template/images-dj/bg-negroclaro.png') }}); margin:0px 50px 0px 50px; padding-top:25px">
                                    <div class="row">
                                        <div class="col-md-12 text-center mb-4">
                                            <p class="white" style="padding:0px 25px 0px 25px">Ya te hemos hablado de nuestro increible entorno natural, lo cual hace que las actividades multiaventura sean una de las principales actividades para realizar en Cuenca, disfrutando a la vez del entorno y de la adrenalina de practicar cualquiera de ellas. Barranquismo, tirolinas, escalada, piragüismo, espeleología, senderismo, tutas a caballo, en quad...</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="tab4" class="tab_single_content">
                                <div class="content" style=" background-image:url({{ asset('assets/template/images-dj/bg-negroclaro.png') }}); margin:0px 50px 0px 50px; padding-top:25px">
                                    <div class="row">
                                        <div class="col-md-12 text-center mb-4">
                                            <p class="white" style="padding:0px 25px 0px 25px">Cuenca, declarada Capital Gastronómica tiene mucho que ofrecerte. Una gastronomía que no deja a nadie indiferente. Te recomendaremos los mejores, apuestas seguras para disfrutar de increíbles jornadas sentados en la mesa, y siempre acorde a vuestras indicaciones.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h2 class="wow fadeInUp" data-wow-delay=".2s"><span class="black">Cuéntanos más sobre ti</span></h2>
                            <h2 class="wow fadeInUp" data-wow-delay=".2s"><span class="dorado">Siempre recordarás tu paso por Cuenca con nosotros</span></h2>
                            <div class="small-border bg-color wow zoomIn" data-wow-delay=".4s"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section id="section-gallery" data-bgimage="url({{ asset('assets/template/images-dj/background/2.jpg') }})">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="wm wow slideInUp">CUÁNDO</div>
                    <h2 class="wow fadeInUp" data-wow-delay=".2s"><span class="black">03</span><span class="white"> Elige la fecha</span></h2>
                    <div class="small-border bg-color wow zoomIn" data-wow-delay=".4s"></div>
                </div>
                <div class="spacer-single"></div>
            </div>
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <br><p class="text-center"> Dejar las cosas para última hora es perder oportunidades de vivir experiencias únicas. Cuenca ofrece un inumerable abanico de oportunidades, muchas de ellas en épocas especiales.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2 class="wow fadeInUp" data-wow-delay=".2s"><span class="white">¿Buscamos fecha con tiempo?</span></h2>
                    <div class="small-border bg-color wow zoomIn" data-wow-delay=".4s"></div>
                </div>
                <div class="spacer-single"></div>
            </div>
        </div>
    </section>


    <section id="section-gallery" data-bgimage="url({{ asset('assets/template/images-dj/background/3.jpg') }})">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="wm wow slideInUp">EJEMPLOS</div>
                    <h2 class="wow fadeInUp" data-wow-delay=".2s"><span class="black">04</span><span class="dorado"> Mira algunas experiencias</span></h2>
                    <br>

                    <div class="small-border bg-color wow zoomIn" data-wow-delay=".4s"></div>
                </div>
                <div class="spacer-single"></div>
            </div>
            <div class="row">
                <div class="col-md-10 offset-md-1 black">
                    <div class="row">
                        <div class="col-md-4 text-center"><a href=""><img src="{{ asset('assets/template/images-dj/gallery/1.jpg') }}" class="img-fluid mb-3"></a><br><h3><span class="dorado">Titulo</span></h3><strong>"</strong> <em>Resumen...</em> <strong>"</strong></div>
                        <div class="col-md-4 text-center"><a href=""><img src="{{ asset('assets/template/images-dj/gallery/1.jpg') }}" class="img-fluid mb-3"></a><br><h3><span class="dorado">Titulo</span></h3><strong>"</strong> <em>Resumen...</em> <strong>"</strong></div>
                        <div class="col-md-4 text-center"><a href=""><img src="{{ asset('assets/template/images-dj/gallery/1.jpg') }}" class="img-fluid mb-3"></a><br><h3><span class="dorado">Titulo</span></h3><strong>"</strong> <em>Resumen...</em> <strong>"</strong></div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="wm wow slideInUp">CUENCA</div>
                    <h2 class="wow fadeInUp" data-wow-delay=".2s"><span class="id-color">05</span> Con la colaboración de:</h2>
                    <div class="small-border bg-color wow zoomIn" data-wow-delay=".4s"></div>
                </div>
                <div class="spacer-single"></div>
            </div>
            <br>
            <div class="row g-custom-x">
                <div class="col-lg-2 col-md-4 col-6 mb-sm-30">
                    <img src="{{ asset('assets/template/images/colaborador.png') }}" class="img-fluid" alt="">
                </div>
                <div class="col-lg-2 col-md-4 col-6 mb-sm-30">
                    <img src="{{ asset('assets/template/images/colaborador.png') }}" class="img-fluid" alt="">
                </div>
                <div class="col-lg-2 col-md-4 col-6 mb-sm-30">
                    <img src="{{ asset('assets/template/images/colaborador.png') }}" class="img-fluid" alt="">
                </div>
                <div class="col-lg-2 col-md-4 col-6 mb-sm-30">
                    <img src="{{ asset('assets/template/images/colaborador.png') }}" class="img-fluid" alt="">
                </div>
                <div class="col-lg-2 col-md-4 col-6 mb-sm-30">
                    <img src="{{ asset('assets/template/images/colaborador.png') }}" class="img-fluid" alt="">
                </div>
                <div class="col-lg-2 col-md-4 col-6 mb-sm-30">
                    <img src="{{ asset('assets/template/images/colaborador.png') }}" class="img-fluid" alt="">
                </div>
            </div>
        </div>
    </section>
@stop

@section('js')
@stop
