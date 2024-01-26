@if ($doc)
    <a href="{{ asset('storage/'.strtolower($model).'/'.$doc->attachable_id.'/'.$doc->file_name) }}"
        @if(isset($alt))
            alt="{{ $alt }}"
        @else
            alt="{{ $doc->translate('name', app()->getLocale(), false) }}"
        @endif
        @if(isset($ariaLabel))
            aria-label="{{ $ariaLabel }}"
        @else
            aria-label="{{ $doc->translate('name', app()->getLocale(), false) }}"
        @endif
        @if(isset($class)) class="{{ $class }}" @endif
        @if(isset($style)) style="{{ $style }}" @endif target="_blank">{{$doc->name}}</a>
@endif
