@extends('templates.template-public', ['menu_selected' => $page->name])
@section('page_class', 'page-pagina')

@section('content')
    <section id="_gyaPage_{{$page->id}}" style="padding: 0px;">
    @foreach($page->modules as $module)
        <div id="_gyaModule_{{$module->id}}">
            {!! $module->content !!}
        </div>
    @endforeach
    </section>
@stop
