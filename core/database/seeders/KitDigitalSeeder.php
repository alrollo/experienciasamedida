<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\Page;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use mysql_xdevapi\Exception;

class KitDigitalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get root user
        $root = User::where('email', 'info@gyastudio.com')->first();
        if ($root == null)
            throw new Exception('User `info@gyastudio.com` is null or empty');

        // Create pages
        $myPages[] = new MyPage('Aviso Legal', ['es/aviso-legal']);
        $myPages[] = new MyPage('Cookies', ['es/cookies']);
        $myPages[] = new MyPage('Política de Privacidad', ['es/politica-de-privacidad']);
        $myPages[] = new MyPage('Mapa Web', ['es/mapa-web']);
        $myPages[] = new MyPage('Declaración de Accesibilidad', ['es/declaracion-de-accesibilidad']);

        $now = Carbon::now();
        foreach ($myPages as $myPage) {
            $page = Page::create(['active' => true, 'name' => $myPage->name, 'url' => $myPage->url, 'created_by' => $root->id, 'updated_by' => $root->id]);
            $breadcrumbs = Module::create(['page_id' => $page->id, 'active' => true, 'blocked' => true, 'name' => 'Breadcrumbs', 'order' => 1, 'created_by' => $root->id, 'updated_by' => $root->id]);
            $content = Module::create(['page_id' => $page->id, 'active' => true, 'blocked' => true, 'name' => 'Contenido', 'order' => 2, 'created_by' => $root->id, 'updated_by' => $root->id]);
        }
    }
}

class MyPage {
    public string $name;
    public array $url;

    public function __construct(string $name, array $url) {
        $this->name = $name;
        $this->url = $url;
    }
}
