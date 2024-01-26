<?php

namespace Database\Seeders;

use App\Models\Language;
use App\Models\Master;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create permissions
        Permission::create(['name' => 'general.acceso_intranet', 'name_friendly' => 'Acceso a la Intranet', 'group' => 'General', 'description' => 'Acceder a la Intranet']);
        Permission::create(['name' => 'general.download_files', 'name_friendly' => 'Files Download', 'group' => 'General', 'description' => 'Descargar archivos']);
        Permission::create(['name' => 'general.upload_files', 'name_friendly' => 'Files Upload', 'group' => 'General', 'description' => 'Subir archivos']);
        Permission::create(['name' => 'general.edit_files', 'name_friendly' => 'Files Edit', 'group' => 'General', 'description' => 'Editar archivos']);
        Permission::create(['name' => 'general.delete_files', 'name_friendly' => 'Files Delete', 'group' => 'General', 'description' => 'Borrar archivos']);

        // Utils permissions
        Permission::create(['name' => 'utils.execute', 'name_friendly' => 'Utils Execute', 'group' => 'Utils', 'description' => 'Ejecutar utilidades']);

        // User management
        Permission::create(['name' => 'users.view', 'name_friendly' => 'Users View', 'group' => 'Users', 'description' => 'Acceder a Usuarios']);
        Permission::create(['name' => 'users.read', 'name_friendly' => 'Users Read', 'group' => 'Users', 'description' => 'Ver los Usuarios']);
        Permission::create(['name' => 'users.create', 'name_friendly' => 'Users Create', 'group' => 'Users', 'description' => 'Crear Usuarios']);
        Permission::create(['name' => 'users.delete', 'name_friendly' => 'Users Delete', 'group' => 'Users', 'description' => 'Borrar Usuarios']);
        Permission::create(['name' => 'users.update', 'name_friendly' => 'Users Update', 'group' => 'Users', 'description' => 'Actualizar Usuarios']);
        Permission::create(['name' => 'users.assign_roles', 'name_friendly' => 'Users Assing Roles', 'group' => 'Users', 'description' => 'Asignar Roles a Usuarios']);
        Permission::create(['name' => 'users.impersonate', 'name_friendly' => 'Users Impersonate', 'group' => 'Users', 'description' => 'Suplantar a otros Usuarios']);

        Permission::create(['name' => 'user.update', 'name_friendly' => 'User Update', 'group' => 'User', 'description' => 'Actualizar el Perfíl de Usuario']);

        // Roles management
        Permission::create(['name' => 'roles.view', 'name_friendly' => 'Roles View', 'group' => 'Roles', 'description' => 'Acceder a Roles']);
        Permission::create(['name' => 'roles.read', 'name_friendly' => 'Roles Read', 'group' => 'Roles', 'description' => 'Ver los Roles']);
        Permission::create(['name' => 'roles.create', 'name_friendly' => 'Roles Create', 'group' => 'Roles', 'description' => 'Crear Roles']);
        Permission::create(['name' => 'roles.delete', 'name_friendly' => 'Roles Delete', 'group' => 'Roles', 'description' => 'Borrar Roles']);
        Permission::create(['name' => 'roles.update', 'name_friendly' => 'Roles Update', 'group' => 'Roles', 'description' => 'Actualizar Roles']);
        Permission::create(['name' => 'roles.assign_permission', 'name_friendly' => 'Role Assing Permissions', 'group' => 'Roles', 'description' => 'Asignar Permisos a Roles']);

        // Configuration management
        Permission::create(['name' => 'configuration.view', 'name_friendly' => 'Configuration View', 'group' => 'Configuration', 'description' => 'Acceder a Configuración.']);
        Permission::create(['name' => 'configuration.read', 'name_friendly' => 'Configuration Read', 'group' => 'Configuration', 'description' => 'Ver la Configuración.']);
        Permission::create(['name' => 'configuration.update', 'name_friendly' => 'Configuration Update', 'group' => 'Configuration', 'description' => 'Actualizar la Configuración.']);

        // Language management
        Permission::create(['name' => 'languages.view', 'name_friendly' => 'Languages View', 'group' => 'Languages', 'description' => 'Acceder a Lenguajes']);
        Permission::create(['name' => 'languages.update', 'name_friendly' => 'Languages Update', 'group' => 'Languages', 'description' => 'Actualizar Lenguajes']);

        // Translations management
        Permission::create(['name' => 'translations.view', 'name_friendly' => 'Translations View', 'group' => 'Translations', 'description' => 'Acceder a Traducciones']);
        Permission::create(['name' => 'translations.read', 'name_friendly' => 'Translations Read', 'group' => 'Translations', 'description' => 'Ver Traducciones']);
        Permission::create(['name' => 'translations.create', 'name_friendly' => 'Translations Create', 'group' => 'Translations', 'description' => 'Crear Traducciones']);
        Permission::create(['name' => 'translations.delete', 'name_friendly' => 'Translations Delete', 'group' => 'Translations', 'description' => 'Borrar Traducciones']);
        Permission::create(['name' => 'translations.update', 'name_friendly' => 'Translations Update', 'group' => 'Translations', 'description' => 'Actualizar Traducciones']);

        // Seo management
        Permission::create(['name' => 'seo.update', 'name_friendly' => 'SEO Update', 'group' => 'SEO', 'description' => 'Actualizar el SEO']);

        // Pages management
        Permission::create(['name' => 'pages.view', 'name_friendly' => 'Pages View', 'group' => 'Pages', 'description' => 'Acceder a Pages']);
        Permission::create(['name' => 'pages.read', 'name_friendly' => 'Pages Read', 'group' => 'Pages', 'description' => 'Ver Pages']);
        Permission::create(['name' => 'pages.create', 'name_friendly' => 'Pages Create', 'group' => 'Pages', 'description' => 'Crear Pages']);
        Permission::create(['name' => 'pages.delete', 'name_friendly' => 'Pages Delete', 'group' => 'Pages', 'description' => 'Borrar Pages']);
        Permission::create(['name' => 'pages.update', 'name_friendly' => 'Pages Update', 'group' => 'Pages', 'description' => 'Actualizar Pages']);
        Permission::create(['name' => 'pages.edit_urls', 'name_friendly' => 'Pages Edit URLs', 'group' => 'Pages', 'description' => 'Editar URLs Pages']);
        Permission::create(['name' => 'pages.read_module', 'name_friendly' => 'Modules Read', 'group' => 'Pages', 'description' => 'Ver Modules']);
        Permission::create(['name' => 'pages.create_module', 'name_friendly' => 'Modules Create', 'group' => 'Pages', 'description' => 'Crear Modules']);
        Permission::create(['name' => 'pages.delete_module', 'name_friendly' => 'Modules Delete', 'group' => 'Pages', 'description' => 'Borrar Modules']);
        Permission::create(['name' => 'pages.update_module', 'name_friendly' => 'Modules Update', 'group' => 'Pages', 'description' => 'Actualizar Modules']);

        // Master Tables management
        Permission::create(['name' => 'masters.view', 'name_friendly' => 'Masters View', 'group' => 'Masters', 'description' => 'Acceder a Tablas Maestras']);
        Permission::create(['name' => 'masters.read', 'name_friendly' => 'Masters Read', 'group' => 'Masters', 'description' => 'Ver Tablas Maestras']);
        Permission::create(['name' => 'masters.create', 'name_friendly' => 'Masters Create', 'group' => 'Masters', 'description' => 'Crear Tablas Maestras']);
        Permission::create(['name' => 'masters.delete', 'name_friendly' => 'Masters Delete', 'group' => 'Masters', 'description' => 'Borrar Tablas Maestras']);
        Permission::create(['name' => 'masters.update', 'name_friendly' => 'Masters Update', 'group' => 'Masters', 'description' => 'Actualizar Tablas maestras']);
        Permission::create(['name' => 'masters.add_option', 'name_friendly' => 'Masters Add Option', 'group' => 'Masters', 'description' => 'Añadir Opciones a Tablas Maestras']);

        // FTP management
        Permission::create(['name' => 'ftp.view', 'name_friendly' => 'FTP View', 'group' => 'Ftp', 'description' => 'Acceder a Ftp']);
        Permission::create(['name' => 'ftp.read', 'name_friendly' => 'FTP Read', 'group' => 'Ftp', 'description' => 'Ver Ftp']);
        Permission::create(['name' => 'ftp.upload', 'name_friendly' => 'FTP Create', 'group' => 'Ftp', 'description' => 'Subir archivo FTP']);
        Permission::create(['name' => 'ftp.delete', 'name_friendly' => 'FTP Delete', 'group' => 'Ftp', 'description' => 'Borrar archivo FTP']);

        // Articles management
        Permission::create(['name' => 'articles.view', 'name_friendly' => 'Articles View', 'group' => 'Articles', 'description' => 'Acceder a Artículos']);
        Permission::create(['name' => 'articles.read', 'name_friendly' => 'Articles Read', 'group' => 'Articles', 'description' => 'Ver Artículos']);
        Permission::create(['name' => 'articles.create', 'name_friendly' => 'Articles Create', 'group' => 'Articles', 'description' => 'Crear Artículos']);
        Permission::create(['name' => 'articles.delete', 'name_friendly' => 'Articles Delete', 'group' => 'Articles', 'description' => 'Borrar Artículos']);
        Permission::create(['name' => 'articles.update', 'name_friendly' => 'Articles Update', 'group' => 'Articles', 'description' => 'Actualizar Artículos']);

        // Articles management
        Permission::create(['name' => 'news.view', 'name_friendly' => 'News View', 'group' => 'News', 'description' => 'Acceder a Noticias']);
        Permission::create(['name' => 'news.read', 'name_friendly' => 'News Read', 'group' => 'News', 'description' => 'Ver Noticias']);
        Permission::create(['name' => 'news.create', 'name_friendly' => 'News Create', 'group' => 'News', 'description' => 'Crear Noticias']);
        Permission::create(['name' => 'news.delete', 'name_friendly' => 'News Delete', 'group' => 'News', 'description' => 'Borrar Noticias']);
        Permission::create(['name' => 'news.update', 'name_friendly' => 'News Update', 'group' => 'News', 'description' => 'Actualizar Noticias']);

        // Services management
        Permission::create(['name' => 'services.view', 'name_friendly' => 'Services View', 'group' => 'Services', 'description' => 'Acceder a Servicios']);
        Permission::create(['name' => 'services.read', 'name_friendly' => 'Services Read', 'group' => 'Services', 'description' => 'Ver Servicios']);
        Permission::create(['name' => 'services.create', 'name_friendly' => 'Services Create', 'group' => 'Services', 'description' => 'Crear Servicios']);
        Permission::create(['name' => 'services.delete', 'name_friendly' => 'Services Delete', 'group' => 'Services', 'description' => 'Borrar Servicios']);
        Permission::create(['name' => 'services.update', 'name_friendly' => 'Services Update', 'group' => 'Services', 'description' => 'Actualizar Servicios']);

        // Reviews management
        Permission::create(['name' => 'reviews.view', 'name_friendly' => 'Reviews View', 'group' => 'Reviews', 'description' => 'Acceder a Reseñas']);
        Permission::create(['name' => 'reviews.read', 'name_friendly' => 'Reviews Read', 'group' => 'Reviews', 'description' => 'Ver Reseñas']);
        Permission::create(['name' => 'reviews.create', 'name_friendly' => 'Reviews Create', 'group' => 'Reviews', 'description' => 'Crear Reseñas']);
        Permission::create(['name' => 'reviews.delete', 'name_friendly' => 'Reviews Delete', 'group' => 'Reviews', 'description' => 'Borrar Reseñas']);
        Permission::create(['name' => 'reviews.update', 'name_friendly' => 'Reviews Update', 'group' => 'Reviews', 'description' => 'Actualizar Reseñas']);

        // Products management
        Permission::create(['name' => 'products.view', 'name_friendly' => 'Products View', 'group' => 'Products', 'description' => 'Acceder a Products']);
        Permission::create(['name' => 'products.read', 'name_friendly' => 'Products Read', 'group' => 'Products', 'description' => 'Ver Products']);
        Permission::create(['name' => 'products.create', 'name_friendly' => 'Products Create', 'group' => 'Products', 'description' => 'Crear Products']);
        Permission::create(['name' => 'products.delete', 'name_friendly' => 'Products Delete', 'group' => 'Products', 'description' => 'Borrar Products']);
        Permission::create(['name' => 'products.update', 'name_friendly' => 'Products Update', 'group' => 'Products', 'description' => 'Actualizar Products']);

        // Promotions management
        Permission::create(['name' => 'promotions.view', 'name_friendly' => 'Promotions View', 'group' => 'Promotions', 'description' => 'Acceder a Promotions']);
        Permission::create(['name' => 'promotions.read', 'name_friendly' => 'Promotions Read', 'group' => 'Promotions', 'description' => 'Ver Promotions']);
        Permission::create(['name' => 'promotions.create', 'name_friendly' => 'Promotions Create', 'group' => 'Promotions', 'description' => 'Crear Promotions']);
        Permission::create(['name' => 'promotions.delete', 'name_friendly' => 'Promotions Delete', 'group' => 'Promotions', 'description' => 'Borrar Promotions']);
        Permission::create(['name' => 'promotions.update', 'name_friendly' => 'Promotions Update', 'group' => 'Promotions', 'description' => 'Actualizar Promotions']);

        // Faqs management
        Permission::create(['name' => 'faqs.view', 'name_friendly' => 'Faqs View', 'group' => 'Faqs', 'description' => 'Acceder a Faqs']);
        Permission::create(['name' => 'faqs.read', 'name_friendly' => 'Faqs Read', 'group' => 'Faqs', 'description' => 'Ver Faqs']);
        Permission::create(['name' => 'faqs.create', 'name_friendly' => 'Faqs Create', 'group' => 'Faqs', 'description' => 'Crear Faqs']);
        Permission::create(['name' => 'faqs.delete', 'name_friendly' => 'Faqs Delete', 'group' => 'Faqs', 'description' => 'Borrar Faqs']);
        Permission::create(['name' => 'faqs.update', 'name_friendly' => 'Faqs Update', 'group' => 'Faqs', 'description' => 'Actualizar Faqs']);

        // Customers management
        Permission::create(['name' => 'customers.view', 'name_friendly' => 'Customers View', 'group' => 'Clientes', 'description' => 'Acceder a Clientes']);
        Permission::create(['name' => 'customers.read', 'name_friendly' => 'Customers Read', 'group' => 'Clientes', 'description' => 'Ver Clientes']);
        Permission::create(['name' => 'customers.create', 'name_friendly' => 'Customers Create', 'group' => 'Clientes', 'description' => 'Crear Clientes']);
        Permission::create(['name' => 'customers.delete', 'name_friendly' => 'Customers Delete', 'group' => 'Clientes', 'description' => 'Borrar Clientes']);
        Permission::create(['name' => 'customers.update', 'name_friendly' => 'Customers Update', 'group' => 'Clientes', 'description' => 'Actualizar Clientes']);

        // Workds management
        Permission::create(['name' => 'works.view', 'name_friendly' => 'Works View', 'group' => 'Works', 'description' => 'Acceder a Works']);
        Permission::create(['name' => 'works.read', 'name_friendly' => 'Works Read', 'group' => 'Works', 'description' => 'Ver Works']);
        Permission::create(['name' => 'works.create', 'name_friendly' => 'Works Create', 'group' => 'Works', 'description' => 'Crear Works']);
        Permission::create(['name' => 'works.delete', 'name_friendly' => 'Works Delete', 'group' => 'Works', 'description' => 'Borrar Works']);
        Permission::create(['name' => 'works.update', 'name_friendly' => 'Works Update', 'group' => 'Works', 'description' => 'Actualizar Works']);

        // Languages management
        Language::create(['name' => 'Español', 'language' => 'es', 'culture' => 'es_ES', 'active' => true]);
        Language::create(['name' => 'Inglés', 'language' => 'en', 'culture' => 'en_EN', 'active' => false]);
        Language::create(['name' => 'Francés', 'language' => 'fr', 'culture' => 'fr_FR', 'active' => false]);
        Language::create(['name' => 'Italiano', 'language' => 'it', 'culture' => 'it_IT', 'active' => false]);

        // Create roles
        // MASTER
        $master = Role::create(['name' => 'master', 'name_friendly' => 'Master']);

        // GESTIÓN
        $gestion = Role::create(['name' => 'gestion', 'name_friendly' => 'Gestión']);
        $gestion->givePermissionTo('general.acceso_intranet');
        $gestion->givePermissionTo('general.download_files');
        $gestion->givePermissionTo('general.upload_files');
        $gestion->givePermissionTo('general.edit_files');
        $gestion->givePermissionTo('general.delete_files');

        $gestion->givePermissionTo('user.update');

        $gestion->givePermissionTo('seo.update');

        $gestion->givePermissionTo('pages.view');
        $gestion->givePermissionTo('pages.read');
        $gestion->givePermissionTo('pages.create');
        $gestion->givePermissionTo('pages.delete');
        $gestion->givePermissionTo('pages.update');
        $gestion->givePermissionTo('pages.read_module');
        $gestion->givePermissionTo('pages.create_module');
        $gestion->givePermissionTo('pages.delete_module');
        $gestion->givePermissionTo('pages.update_module');

        $gestion->givePermissionTo('masters.view');
        $gestion->givePermissionTo('masters.read');
        $gestion->givePermissionTo('masters.add_option');

        $gestion->givePermissionTo('articles.view');
        $gestion->givePermissionTo('articles.read');
        $gestion->givePermissionTo('articles.create');
        $gestion->givePermissionTo('articles.delete');
        $gestion->givePermissionTo('articles.update');

        $gestion->givePermissionTo('news.view');
        $gestion->givePermissionTo('news.read');
        $gestion->givePermissionTo('news.create');
        $gestion->givePermissionTo('news.delete');
        $gestion->givePermissionTo('news.update');

        $gestion->givePermissionTo('services.view');
        $gestion->givePermissionTo('services.read');
        $gestion->givePermissionTo('services.create');
        $gestion->givePermissionTo('services.delete');
        $gestion->givePermissionTo('services.update');

        $gestion->givePermissionTo('reviews.view');
        $gestion->givePermissionTo('reviews.read');
        $gestion->givePermissionTo('reviews.create');
        $gestion->givePermissionTo('reviews.delete');
        $gestion->givePermissionTo('reviews.update');

        $gestion->givePermissionTo('promotions.view');
        $gestion->givePermissionTo('promotions.read');
        $gestion->givePermissionTo('promotions.create');
        $gestion->givePermissionTo('promotions.delete');
        $gestion->givePermissionTo('promotions.update');

        $gestion->givePermissionTo('faqs.view');
        $gestion->givePermissionTo('faqs.read');
        $gestion->givePermissionTo('faqs.create');
        $gestion->givePermissionTo('faqs.delete');
        $gestion->givePermissionTo('faqs.update');

        $gestion->givePermissionTo('works.view');
        $gestion->givePermissionTo('works.read');
        $gestion->givePermissionTo('works.create');
        $gestion->givePermissionTo('works.delete');
        $gestion->givePermissionTo('works.update');

        // Root user
        $root = User::create(['active' => true, 'name' => 'Gya Admin', 'email' => 'info@gyastudio.com', 'password' => bcrypt('123123123')]);
        $root->assignRole('master');

        // create master tables
        Master::create(['name' => 'Tipos Articulos', 'name_slug' => Str::slug('Tipos Articulos', '_'), 'description' => 'Tipos de Artículos']);
        Master::create(['name' => 'Tags Noticias', 'name_slug' => Str::slug('Tags Noticias', '_'), 'description' => 'Tags de noticias']);
        Master::create(['name' => 'Tipos Promociones', 'name_slug' => Str::slug('Tipos Promociones', '_'), 'description' => 'Tipos de Promociones']);
        Master::create(['name' => 'Tipos Faqs', 'name_slug' => Str::slug('Tipos Faqs', '_'), 'description' => 'Tipos de Preguntas frecuentes']);
        Master::create(['name' => 'Tags Clientes', 'name_slug' => Str::slug('Tags Clientes', '_'), 'description' => 'Tags de Clientes']);
        Master::create(['name' => 'Tags Trabajos', 'name_slug' => Str::slug('Tags Trabajos', '_'), 'description' => 'Tags de Trabajos']);

        // set site settings
        Setting::create(['name' => 'general.web', 'value' => 'https://www.gyastudio.com']);
        Setting::create(['name' => 'intranet.name', 'value' => 'GYAsys<b>3.0</b>']);

        Setting::create(['name' => 'archivos.encriptados', 'value' => 'false']);
    }
}
