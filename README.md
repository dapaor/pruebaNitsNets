# Prueba previa juninor backend developer (php)

## Base de datos:

Para la configuración de la base de datos es necesario acceder al ficher .env y añadir el nombre de la base de datos que se va a usar durante la prueba del proyecto (líneas 12-16).


### Crear tablas de la base de de datos:

Se han creado migraciones para la creación de las tablas de la base de datos. Para ponerlas en marcha se debe ejecutar el siguiente comando en la carpeta raíz del proyecto:
        
        php artisan migrate

### Población de la base de datos

Con el propósito de llenar la base de datos con datos ficticios se han creado Seeders. Para poblar la base de datos se debe ejecutar el siguiente comando en la carpeta raíz del proyecto:

        php artisan db:seed
***
**Bonus: Se ha creado un fichhero de configuración (config/databaseConsts.php) en el que se indican los valores utilizados para la generación de datos. Si se desean cambiar los parámetros puede realizarse desde ese fichero.

Habría que tener cuidado ya que se utiliza la librería faker y si el número de datos a introducir es muy elevado para la tabla 'Pistas', puede darse que se intente introducir un código de pista que ya exista y la población genere un error.
***
