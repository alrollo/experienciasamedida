@if ($doc)
    {{ asset('storage/'.strtolower($model).'/'.$doc->attachable_id.'/'.$doc->file_name) }}
@endif
