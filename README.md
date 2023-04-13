# Prueba NitsNets

## Configuración del proyecto:

    - Clonar el repo con git clone https://github.com/dapaor/pruebaNitsNets.
    - Ejecutar "composer i" en la carpeta raíz del proyecto
    - Ejecutar "composer require "darkaonline/l5-swagger"
    - Crear un .env copiando los valores del .env.example y modificar según necesidades la conexión a base de datos.
    - Ejecutar "php artisan migrate"
    - Ejecutar "php artisan db:seed"
    - Ejecutar "php artisan serve" para lanzar la aplicación
    
## Probar el proyecto:

El proyecto contiene una documentación en Swagger que permite el testeo de la api. Para probarla se ha de acceder desde un navegador a la url:

    http://localhost:8000/api/documentation#/

## Funcionamiento de la API:

Para poder probar la api deberás loggear un usuario, por lo que se debe coger uno de los usuarios creados automáticamente y copiar su email. Por defecto, todos los usuarios creados automáticamente tienen como contraseña "12341234", pero el email sí que se debe coger de la base de datos, puesto que se genera aleatoriamente.

Acto seguido se ha de acceder al panel de rutas etiquetado como "Autenticación" y probar la ruta de login con el email que hemos copiado previamente.

Copiamos esta vez el accessToken que devuelve ese endpoint y lo pegamos en la opción de autorización de la API, arriba del todo donde pone "Authorize" y aparece un candado.

Una vez loggeado ya se pueden usar todas las rutas de la api.
