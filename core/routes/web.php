<?php

use App\Http\Controllers\common;
use App\Http\Controllers\publico;
use App\Http\Controllers\intranet;
use Illuminate\Support\Facades\Route;

// Misc
Route::middleware([])->group(function() {
    Route::post('common/upload-file-temp', [common\UploadFileController::class, "uploadFileToTemp"]);
    Route::post('common/upload-file', [common\UploadFileController::class, "uploadFile"])->middleware('permission:general.upload_files');
});

// Intranet
Route::prefix('intranet')->middleware(['auth'])->group(function () {

    Route::get('dashboard', [intranet\dashboard\DashboardController::class, "get"])->name('intranet.dashboard');

    // Users
    $_url = 'membership/users';
    $_permissions = 'users';
    Route::get("${_url}", [intranet\membership\UsersController::class, 'get'])->middleware("permission:{$_permissions}.view");
    Route::post("${_url}", [intranet\membership\UsersController::class, 'get'])->middleware("permission:{$_permissions}.view");
    Route::get("${_url}/create", [intranet\membership\UsersController::class, 'create'])->middleware("permission:{$_permissions}.create");
    Route::get("${_url}/{id}", [intranet\membership\UsersController::class, 'getById'])->middleware("permission:{$_permissions}.read")->whereNumber('id');;
    Route::post("${_url}/{id}", [intranet\membership\UsersController::class, 'set'])->middleware("permission:{$_permissions}.update")->whereNumber('id');
    Route::get("${_url}/{id}/delete", [intranet\membership\UsersController::class, 'delete'])->middleware("permission:{$_permissions}.delete")->whereNumber('id');
    Route::post("${_url}/impersonate", [intranet\membership\UsersController::class, 'impersonate'])->middleware("permission:{$_permissions}.impersonate")->name("intranet.users.impersonate");
    Route::get("${_url}/leave-impersonate", [intranet\membership\UsersController::class, 'leaveImpersonate'])->name("intranet.users.leave-impersonate");

    // Users
    $_url = 'membership/users/me';
    $_permissions = 'user';
    Route::get("${_url}", [intranet\membership\MeController::class, 'get'])->middleware("permission:{$_permissions}.update");
    Route::post("${_url}", [intranet\membership\MeController::class, 'set'])->middleware("permission:{$_permissions}.update");

    // Roles
    $_url = 'membership/roles';
    $_permissions = 'roles';
    Route::get("${_url}", [intranet\membership\RolesController::class, 'get'])->middleware("permission:{$_permissions}.view");
    Route::post("${_url}", [intranet\membership\RolesController::class, 'get'])->middleware("permission:{$_permissions}.view");
    Route::get("${_url}/create", [intranet\membership\RolesController::class, 'create'])->middleware("permission:{$_permissions}.create");
    Route::get("${_url}/{id}", [intranet\membership\RolesController::class, 'getById'])->middleware("permission:{$_permissions}.read")->whereNumber('id');;
    Route::post("${_url}/{id}", [intranet\membership\RolesController::class, 'set'])->middleware("permission:{$_permissions}.update");
    Route::get("${_url}/{id}/delete", [intranet\membership\RolesController::class, 'delete'])->middleware("permission:{$_permissions}.delete")->whereNumber('id');

    // Languages
    $_url = 'languages';
    $_permissions = 'languages';
    Route::get("${_url}", [intranet\languages\LanguagesController::class, 'get'])->middleware("permission:{$_permissions}.view");
    Route::post("${_url}", [intranet\languages\LanguagesController::class, 'set'])->middleware("permission:{$_permissions}.update");

    // Translations
    $_url = 'translations';
    $_permissions = 'translations';
    Route::get("${_url}", [intranet\translations\TranslationsController::class, 'get'])->middleware("permission:{$_permissions}.view");
    Route::post("${_url}", [intranet\translations\TranslationsController::class, 'get'])->middleware("permission:{$_permissions}.view");
    Route::get("${_url}/create", [intranet\translations\TranslationsController::class, 'create'])->middleware("permission:{$_permissions}.create");
    Route::get("${_url}/{id}", [intranet\translations\TranslationsController::class, 'getById'])->middleware("permission:{$_permissions}.read")->whereNumber('id');;
    Route::post("${_url}/{id}", [intranet\translations\TranslationsController::class, 'set'])->middleware("permission:{$_permissions}.update")->whereNumber('id');
    Route::get("${_url}/{id}/delete", [intranet\translations\TranslationsController::class, 'delete'])->middleware("permission:{$_permissions}.delete")->whereNumber('id');
    Route::get("${_url}/xhr/{id}", [intranet\translations\TranslationsController::class, 'getByIdXhr'])->middleware("permission:{$_permissions}.read")->whereNumber('id');
    Route::post("${_url}/xhr", [intranet\translations\TranslationsController::class, 'setXhr'])->middleware("permission:{$_permissions}.update");

    // Configuration
    $_url = 'configuration';
    $_permissions = 'configuration';
    Route::get("${_url}", [intranet\configuration\ConfigurationController::class, 'get'])->middleware("permission:{$_permissions}.view");
    Route::post("${_url}", [intranet\configuration\ConfigurationController::class, 'set'])->middleware("permission:{$_permissions}.update");

    // Utils
    $_url = 'utils';
    $_permissions = 'utils';
    Route::get("${_url}/clear-views-cache", [intranet\utils\UtilsController::class, 'clearViewsCache'])->middleware("permission:{$_permissions}.execute");
    Route::get("${_url}/clear-cache", [intranet\utils\UtilsController::class, 'clearCache'])->middleware("permission:{$_permissions}.execute");
    Route::get("${_url}/create-link-storage", [intranet\utils\UtilsController::class, 'createLinkStorage'])->middleware("permission:{$_permissions}.execute");
    Route::get("${_url}/empty-temp-folders", [intranet\utils\UtilsController::class, 'emptyTempFolders'])->middleware("permission:{$_permissions}.execute");

    // Seo
    $_url = 'seo';
    $_permissions = 'seo';
    Route::post("${_url}", [intranet\seo\SeoController::class, 'update'])->middleware("permission:{$_permissions}.update");
    Route::delete("${_url}", [intranet\seo\SeoController::class, 'delete'])->middleware("permission:{$_permissions}.update");

    // Pages
    $_url = 'pages';
    $_permissions = 'pages';
    Route::get("${_url}", [intranet\pages\PagesController::class, 'get'])->middleware("permission:{$_permissions}.view");
    Route::post("${_url}", [intranet\pages\PagesController::class, 'get'])->middleware("permission:{$_permissions}.view");
    Route::get("${_url}/create", [intranet\pages\PagesController::class, 'create'])->middleware("permission:{$_permissions}.create");
    Route::get("${_url}/{id}", [intranet\pages\PagesController::class, 'getById'])->middleware("permission:{$_permissions}.read")->whereNumber('id');;
    Route::post("${_url}/{id}", [intranet\pages\PagesController::class, 'set'])->middleware("permission:{$_permissions}.update");
    Route::get("${_url}/{id}/delete", [intranet\pages\PagesController::class, 'delete'])->middleware("permission:{$_permissions}.delete")->whereNumber('id');

    Route::post("${_url}/{page_id}/modules/sort", [intranet\pages\ModulesController::class, 'setOrderXhr'])->middleware("permission:{$_permissions}.edit_module")->whereNumber('page_id')->whereNumber('id');
    Route::get("${_url}/{page_id}/modules/create", [intranet\pages\ModulesController::class, 'create'])->middleware("permission:{$_permissions}.create")->whereNumber('page_id');
    Route::get("${_url}/{page_id}/modules/{id}", [intranet\pages\ModulesController::class, 'getById'])->middleware("permission:{$_permissions}.read")->whereNumber('id')->whereNumber('id');
    Route::post("${_url}/{page_id}/modules/{id}", [intranet\pages\ModulesController::class, 'set'])->middleware("permission:{$_permissions}.update")->whereNumber('page_id')->whereNumber('id');
    Route::get("${_url}/{page_id}/modules/{id}/delete", [intranet\pages\ModulesController::class, 'delete'])->middleware("permission:{$_permissions}.delete")->whereNumber('page_id')->whereNumber('id');

    // Masters
    $_url = 'masters';
    $_permissions = 'masters';
    Route::get("${_url}", [intranet\masters\MastersController::class, 'get'])->middleware("permission:{$_permissions}.view");
    Route::post("${_url}", [intranet\masters\MastersController::class, 'get'])->middleware("permission:{$_permissions}.view");
    Route::get("${_url}/create", [intranet\masters\MastersController::class, 'create'])->middleware("permission:{$_permissions}.create");
    Route::get("${_url}/{id}", [intranet\masters\MastersController::class, 'getById'])->middleware("permission:{$_permissions}.read")->whereNumber('id');;
    Route::post("${_url}/{id}", [intranet\masters\MastersController::class, 'set'])->middleware("permission:{$_permissions}.update");
    Route::get("${_url}/{id}/delete", [intranet\masters\MastersController::class, 'delete'])->middleware("permission:{$_permissions}.delete")->whereNumber('id');

    Route::get("${_url}/{master_id}/options", [intranet\masters\OptionsController::class, 'getById'])->middleware("permission:{$_permissions}.read")->whereNumber('master_id');
    Route::post("${_url}/{master_id}/options", [intranet\masters\OptionsController::class, 'set'])->middleware("permission:{$_permissions}.read")->whereNumber('master_id');
    Route::delete("${_url}/{master_id}/options/{id}", [intranet\masters\OptionsController::class, 'delete'])->middleware("permission:{$_permissions}.read")->whereNumber('master_id')->whereNumber('id');
    Route::post("${_url}/{master_id}/options/order", [intranet\masters\OptionsController::class, 'setOrder'])->middleware("permission:{$_permissions}.read")->whereNumber('master_id');

    // Files
    $_url = 'files';
    $_permissions = 'general';
    Route::get("${_url}/{id}", [intranet\files\FilesController::class, 'getById'])->middleware("permission:{$_permissions}.edit_files")->whereNumber('id');
    Route::post("${_url}", [intranet\files\FilesController::class, 'set'])->middleware("permission:{$_permissions}.edit_files");
    Route::delete("${_url}/{id}", [intranet\files\FilesController::class, 'delete'])->middleware("permission:{$_permissions}.delete_files")->whereNumber('id');
    Route::post("${_url}/{id}/order", [intranet\files\FilesController::class, 'setOrder'])->middleware("permission:{$_permissions}.read")->whereNumber('id');

    // FTP
    $_url = 'ftp';
    $_permissions = 'ftp';
    Route::post("${_url}", [intranet\ftp\FtpController::class, 'search'])->middleware("permission:{$_permissions}.read");
    Route::delete("${_url}", [intranet\ftp\FtpController::class, 'delete'])->middleware("permission:{$_permissions}.delete");

    // Articles
    $_url = 'articles';
    $_permissions = 'articles';
    Route::get("${_url}", [intranet\articles\ArticlesController::class, 'get'])->middleware("permission:{$_permissions}.view");
    Route::post("${_url}", [intranet\articles\ArticlesController::class, 'get'])->middleware("permission:{$_permissions}.view");
    Route::get("${_url}/create", [intranet\articles\ArticlesController::class, 'create'])->middleware("permission:{$_permissions}.create");
    Route::get("${_url}/{id}", [intranet\articles\ArticlesController::class, 'getById'])->middleware("permission:{$_permissions}.read")->whereNumber('id');;
    Route::post("${_url}/{id}", [intranet\articles\ArticlesController::class, 'set'])->middleware("permission:{$_permissions}.update");
    Route::get("${_url}/{id}/delete", [intranet\articles\ArticlesController::class, 'delete'])->middleware("permission:{$_permissions}.delete")->whereNumber('id');

    // News
    $_url = 'news';
    $_permissions = 'news';
    Route::get("${_url}", [intranet\news\NewsController::class, 'get'])->middleware("permission:{$_permissions}.view");
    Route::post("${_url}", [intranet\news\NewsController::class, 'get'])->middleware("permission:{$_permissions}.view");
    Route::get("${_url}/create", [intranet\news\NewsController::class, 'create'])->middleware("permission:{$_permissions}.create");
    Route::get("${_url}/{id}", [intranet\news\NewsController::class, 'getById'])->middleware("permission:{$_permissions}.read")->whereNumber('id');;
    Route::post("${_url}/{id}", [intranet\news\NewsController::class, 'set'])->middleware("permission:{$_permissions}.update");
    Route::get("${_url}/{id}/delete", [intranet\news\NewsController::class, 'delete'])->middleware("permission:{$_permissions}.delete")->whereNumber('id');

    // Services
    $_url = 'services';
    $_permissions = 'services';
    Route::get("${_url}", [intranet\services\ServicesController::class, 'get'])->middleware("permission:{$_permissions}.view");
    Route::post("${_url}", [intranet\services\ServicesController::class, 'get'])->middleware("permission:{$_permissions}.view");
    Route::get("${_url}/create", [intranet\services\ServicesController::class, 'create'])->middleware("permission:{$_permissions}.create");
    Route::get("${_url}/{id}", [intranet\services\ServicesController::class, 'getById'])->middleware("permission:{$_permissions}.read")->whereNumber('id');;
    Route::post("${_url}/{id}", [intranet\services\ServicesController::class, 'set'])->middleware("permission:{$_permissions}.update");
    Route::get("${_url}/{id}/delete", [intranet\services\ServicesController::class, 'delete'])->middleware("permission:{$_permissions}.delete")->whereNumber('id');

    $_url = 'services-families';
    $_permissions = 'services';
    Route::get("${_url}/create", [intranet\services\ServiceFamiliesController::class, 'create'])->middleware("permission:{$_permissions}.create");
    Route::get("${_url}/{id}", [intranet\services\ServiceFamiliesController::class, 'getById'])->middleware("permission:{$_permissions}.read")->whereNumber('id');;
    Route::post("${_url}/{id}", [intranet\services\ServiceFamiliesController::class, 'set'])->middleware("permission:{$_permissions}.update");
    Route::get("${_url}/{id}/delete", [intranet\services\ServiceFamiliesController::class, 'delete'])->middleware("permission:{$_permissions}.delete")->whereNumber('id');

    // Reviews
    $_url = 'reviews';
    $_permissions = 'reviews';
    Route::get("${_url}", [intranet\reviews\ReviewsController::class, 'get'])->middleware("permission:{$_permissions}.view");
    Route::post("${_url}", [intranet\reviews\ReviewsController::class, 'get'])->middleware("permission:{$_permissions}.view");
    Route::get("${_url}/create", [intranet\reviews\ReviewsController::class, 'create'])->middleware("permission:{$_permissions}.create");
    Route::get("${_url}/{id}", [intranet\reviews\ReviewsController::class, 'getById'])->middleware("permission:{$_permissions}.read")->whereNumber('id');;
    Route::post("${_url}/{id}", [intranet\reviews\ReviewsController::class, 'set'])->middleware("permission:{$_permissions}.update");
    Route::get("${_url}/{id}/delete", [intranet\reviews\ReviewsController::class, 'delete'])->middleware("permission:{$_permissions}.delete")->whereNumber('id');

    // Products
    $_url = 'products';
    $_permissions = 'products';
    Route::get("${_url}", [intranet\products\ProductsController::class, 'get'])->middleware("permission:{$_permissions}.view");
    Route::post("${_url}", [intranet\products\ProductsController::class, 'get'])->middleware("permission:{$_permissions}.view");
    Route::get("${_url}/create", [intranet\products\ProductsController::class, 'create'])->middleware("permission:{$_permissions}.create");
    Route::get("${_url}/{id}", [intranet\products\ProductsController::class, 'getById'])->middleware("permission:{$_permissions}.read")->whereNumber('id');;
    Route::post("${_url}/{id}", [intranet\products\ProductsController::class, 'set'])->middleware("permission:{$_permissions}.update");
    Route::get("${_url}/{id}/delete", [intranet\products\ProductsController::class, 'delete'])->middleware("permission:{$_permissions}.delete")->whereNumber('id');

    $_url = 'products-families';
    $_permissions = 'products';
    Route::get("${_url}/create", [intranet\products\ProductFamiliesController::class, 'create'])->middleware("permission:{$_permissions}.create");
    Route::get("${_url}/{id}", [intranet\products\ProductFamiliesController::class, 'getById'])->middleware("permission:{$_permissions}.read")->whereNumber('id');;
    Route::post("${_url}/{id}", [intranet\products\ProductFamiliesController::class, 'set'])->middleware("permission:{$_permissions}.update");
    Route::get("${_url}/{id}/delete", [intranet\products\ProductFamiliesController::class, 'delete'])->middleware("permission:{$_permissions}.delete")->whereNumber('id');

    // Promotions
    $_url = 'promotions';
    $_permissions = 'promotions';
    Route::get("${_url}", [intranet\promotions\PromotionsController::class, 'get'])->middleware("permission:{$_permissions}.view");
    Route::post("${_url}", [intranet\promotions\PromotionsController::class, 'get'])->middleware("permission:{$_permissions}.view");
    Route::get("${_url}/create", [intranet\promotions\PromotionsController::class, 'create'])->middleware("permission:{$_permissions}.create");
    Route::get("${_url}/{id}", [intranet\promotions\PromotionsController::class, 'getById'])->middleware("permission:{$_permissions}.read")->whereNumber('id');;
    Route::post("${_url}/{id}", [intranet\promotions\PromotionsController::class, 'set'])->middleware("permission:{$_permissions}.update");
    Route::get("${_url}/{id}/delete", [intranet\promotions\PromotionsController::class, 'delete'])->middleware("permission:{$_permissions}.delete")->whereNumber('id');

    // Faqs
    $_url = 'faqs';
    $_permissions = 'faqs';
    Route::get("${_url}", [intranet\faqs\FaqsController::class, 'get'])->middleware("permission:{$_permissions}.view");
    Route::post("${_url}", [intranet\faqs\FaqsController::class, 'get'])->middleware("permission:{$_permissions}.view");
    Route::get("${_url}/create", [intranet\faqs\FaqsController::class, 'create'])->middleware("permission:{$_permissions}.create");
    Route::get("${_url}/{id}", [intranet\faqs\FaqsController::class, 'getById'])->middleware("permission:{$_permissions}.read")->whereNumber('id');;
    Route::post("${_url}/{id}", [intranet\faqs\FaqsController::class, 'set'])->middleware("permission:{$_permissions}.update");
    Route::get("${_url}/{id}/delete", [intranet\faqs\FaqsController::class, 'delete'])->middleware("permission:{$_permissions}.delete")->whereNumber('id');

    // Works
    $_url = 'works';
    $_permissions = 'works';
    Route::get("${_url}", [intranet\works\WorksController::class, 'get'])->middleware("permission:{$_permissions}.view");
    Route::post("${_url}", [intranet\works\WorksController::class, 'get'])->middleware("permission:{$_permissions}.view");
    Route::get("${_url}/create", [intranet\works\WorksController::class, 'create'])->middleware("permission:{$_permissions}.create");
    Route::get("${_url}/{id}", [intranet\works\WorksController::class, 'getById'])->middleware("permission:{$_permissions}.read")->whereNumber('id');;
    Route::post("${_url}/{id}", [intranet\works\WorksController::class, 'set'])->middleware("permission:{$_permissions}.update");
    Route::get("${_url}/{id}/delete", [intranet\works\WorksController::class, 'delete'])->middleware("permission:{$_permissions}.delete")->whereNumber('id');

});

// Public
Route::middleware(['setLanguage'])->group(function() {

    Route::get('/', [publico\home\HomeController::class, "get"]);
    foreach(Language::GetArray() as $lang)
        Route::get($lang, [publico\home\HomeController::class, "get"]);

    Route::get('es/experiencias', [publico\experiencias\ExperienciasController::class, "get"]);
    Route::get('es/experiencias/{slug}', [publico\experiencias\ExperienciasController::class, "getFamily"]);
    Route::get('es/experiencia/{slug}', [publico\experiencias\ExperienciasController::class, "getByTitle"]);

    Route::get('es/blog', [publico\blog\BlogController::class, "get"]);
    Route::get('es/blog/{type}', [publico\blog\BlogController::class, "get"]);
    Route::get('es/post/{slug}', [publico\blog\BlogController::class, "getByTitle"]);

    Route::get('es/clientes', [publico\clientes\ClientesController::class, "get"]);

    Route::get('login', [publico\auth\LoginController::class, "login"])->name('auth.login');
    Route::post('login', [publico\auth\LoginController::class, "makeLogin"]);
    Route::get('logout', [publico\auth\LoginController::class, "logout"])->name('auth.logout');

    Route::get('auth/forgot-password', [publico\auth\ForgotPasswordController::class, "showForm"]);
    Route::post('auth/forgot-password', [publico\auth\ForgotPasswordController::class, "sendEmailReset"]);
    Route::get('auth/forgot-password/{token}/{email}',[publico\auth\ForgotPasswordController::class, "resetLink"]);

    Route::get('{any}', [publico\pages\PagesController::class, "get"])->where('any', '.*');
});

