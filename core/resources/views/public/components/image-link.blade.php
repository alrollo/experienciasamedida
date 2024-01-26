@if ($image)
    {{ asset('storage/'.strtolower($model).'/'.$image->attachable_id.'/'.$image->file_name) }}
@endif
