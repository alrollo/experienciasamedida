# GYAsys 3.0 (2023)

Versión 3.0 de GYAsys para la administración y gestión de sitios web, basado en **Laravel 8.0**, integrando 
gestión de envío de emails. Mejoras en todos los módulos antiguos y en el rendimiento
genérico de la aplicación

## Requisitos

- PHP >= 7.3
- BCMath PHP Extension
- Ctype PHP Extension
- Fileinfo PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension

## Instalación

- Descargar el repositorio y descomprimirlo en el directorio de la aplicación.
- Modificar el fichero **.env.example** de **/core** renombrarlo a **.env** y adaptarlo al sitio web.
- Actualizar el repositorio de dependencias

    ```shell script
    c:\[...]\core>composer update
    ```
  
- Creamos las claves únicas para la aplicación

    ```shell script
    c:\[...]\core>php artisan key:generate
    c:\[...]\core>php artisan jwt:secret
    ```

- Realizamos la migración del modelo de datos

    ```shell script
    c:\[...]\core>php artisan migrate
    ```
   
- Realizamos una instalación del modelo de datos

    ```shell script
    c:\[...]\core>php artisan db:seed
    ```
  
- Generamos el enlace simbólico:

    ```shell script
    Linux - http://{url}/simlink
    Windows - c:\mklink /d c:\www\[...]\storage c:\www\[...]\core\storage\app\public
    ```

## Versiones
- **3.5** - 13/08/2023
    - Se corrige bug en el SEO con los idiomas
  

- **3.4** - 12/08/2023
    - Se corrige bug en los idiomas

  
- **3.3** - 11/08/2023
    - Se corrige bug al guardar las URLs 


- **3.2** - 10/08/2023
    - Se corrige bug con algunos links a imágenes
    - Se añade componente `document` y `documentLink`


- **3.1** - 24/05/2023
    - Se añade módulo `works`
    - Se añade módulo `customers`


- **3.0** - 10/05/2023
    - Lanzamiento inicial

## Autores

- **Gya Studio** [Alfonso]
