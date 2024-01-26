@if ($image)
    <img src="{{ asset('storage/'.strtolower($model).'/'.$image->attachable_id.'/'.$image->file_name) }}"
         @if(isset($alt))
             alt="{{ $alt }}"
         @else
            alt="{{ $image->translate('name', app()->getLocale(), false) }}"
         @endif
         @if(isset($ariaLabel))
             aria-label="{{ $ariaLabel }}"
         @else
            aria-label="{{ $image->translate('name', app()->getLocale(), false) }}"
         @endif
         @if(isset($class)) class="{{ $class }}" @endif
         @if(isset($style)) style="{{ $style }}" @endif>
@endif
