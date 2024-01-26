<?php

namespace App\Http\Controllers\intranet\languages;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Translation;
use App\Rules\CheckId;
use App\Services\LanguageService;
use App\Services\TranslateService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class LanguagesController extends Controller
{
    private $_languageService;

    public function __construct(LanguageService $languageService)
    {
        $this->_languageService = $languageService;
    }

    public function get() {
        $query = Language::select('languages.id', 'languages.language', 'languages.active', 'languages.name', 'languages.culture');

        // Search

        $query->orderBy('languages.name', 'asc');

        $items = $query->get();

        return view('intranet/languages/languages-form', ['items' => $items]);
    }

    public function set(Request $request)
    {
        $validateData = $request->validate([
            'language' =>'array'
        ]);

        $languages = Language::where('language', '!=', 'es')->get();

        $languageSended = $request->input('language');

        foreach ($languages as $language) {

            if ($languageSended != null && array_key_exists($language->id, $languageSended) && $languageSended[$language->id] == '1')
                $language->active = true;
             else
                $language->active = false;

            $language->save();
        }

        $this->_languageService->RefreshCache();

        return redirect()
            ->action([LanguagesController::class, 'get'])
            ->with('message.success', 'Se ha guardado correctamente la información');
    }

}
