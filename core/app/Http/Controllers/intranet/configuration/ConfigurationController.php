<?php

namespace App\Http\Controllers\intranet\configuration;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ConfigurationController extends Controller
{
    public function get()
    {
        $items = Setting::get()->pluck('value', 'name');

        return view('intranet/configuration/configuration-form', ['items' => $items]);
    }

    public function set(Request $request)
    {
        $banned_preferences = ['imagenes.logo_aplicacion', 'imagenes.imagen_emails'];
        $preferencias = Setting::get();
        $values = $request->input('value');

        foreach ($preferencias as $preferencia) {
            if (in_array($preferencia->name, $banned_preferences))
                continue;

            if (array_key_exists($preferencia->name, $values)) {
                if ($values[$preferencia->name] != $preferencia->value) {
                    $preferencia->value = $values[$preferencia->name];
                    $preferencia->save();
                }
            } else {
                $preferencia->value = null;
                $preferencia->save();
            }

            unset($values[$preferencia->name]);
        }

        $inserts = [];
        foreach ($values as $key => $value) {
            $inserts[] = ['name' => $key, 'value' => $value];
        }
        Setting::insert($inserts);

        // Clear cache
        Artisan::call('cache:clear');

        return redirect()
            ->action([ConfigurationController::class, 'get'])
            ->with('message.success', 'Se ha guardado correctamente la información');
    }
}
