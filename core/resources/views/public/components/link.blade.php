<a href="{{ url(Tr::Get('links.'.$selector.'.href')) }}"
   title="{{ Tr::Get('links.'.$selector.'.title' , '') }}"
   alt="{{ Tr::Get('links.'.$selector.'.title' , '') }}"
   aria-label="{{ Tr::Get('links.'.$selector.'.aria') }}"
   @if(isset($hotkey))
        data-hotkey="{{ $hotkey }}"
   @endif
   class="@if(isset($class)) {{ $class }} @endif @if(isset($selected) && $selected) link-active @endif">{{ Tr::Get('links.'.$selector.'.label') }}</a>
