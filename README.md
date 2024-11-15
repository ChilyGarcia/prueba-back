# Prueba UNBC

## Requisitos Previos

Asegúrate de tener instalados los siguientes programas:

- **PHP**: >= 8.1
- **Composer**: >= 2.0
- **MySQL** o cualquier otro gestor de base de datos soportado.
- **Node.js** y **npm**: (Para la administración de assets)
- **Servidor Web**: Apache o Nginx

## Instalación del Proyecto

1. **Clonar el repositorio**

   ```bash
   git clone <url-del-repositorio>
   cd nombre-del-proyecto
   ```

2. **Instalar las dependencias de PHP**

   ```bash
   composer install
   ```

3. **Configurar el archivo de entorno**

   Copia el archivo de ejemplo `.env.example` y renómbralo a `.env`:

   ```bash
   cp .env.example .env
   ```

   Luego, edita el archivo `.env` con la configuración adecuada para tu entorno (base de datos, etc.).

4. **Generar la clave de aplicación**

   ```bash
   php artisan key:generate
   ```

5. **Configurar la base de datos**

   Asegúrate de que los detalles de la base de datos estén correctos en el archivo `.env` y luego ejecuta las migraciones:

   ```bash
   php artisan migrate
   ```
6. **Correr las seeders**

   Luego de que corriste las migraciones, ejecuta el siguiente comando para ejecutar las seeders

   ```bash
   php artisan db:seed
   ```


## Configuración de JWT

1. **Generar clave JWT**

   ```bash
   php artisan jwt:secret
   ```

   Esto generará una clave secreta JWT y la agregará al archivo `.env` con la variable `JWT_SECRET`.

## Ejecutar el Servidor de Desarrollo

Inicia el servidor de desarrollo ejecutando:

```bash
php artisan serve
```

Por defecto, el proyecto estará disponible en `http://localhost:8000`.


