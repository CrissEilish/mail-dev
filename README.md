# DevBossMail

Sistema de gestión de correos para clientes de DevBossPanel.

## Requisitos Previos

Asegúrate de tener instalados los siguientes programas en tu entorno:
- [Docker Desktop](https://www.docker.com/products/docker-desktop/)
- [Git](https://git-scm.com/)

## Instalación y Despliegue

Sigue estos pasos para levantar el proyecto:

1.  **Clonar/Descargar el código**:
    Asegúrate de estar en la carpeta del proyecto.

2.  **Configurar Variables de Entorno**:
    Copia el archivo de ejemplo y configúralo (si no existe, crea uno nuevo):
    ```bash
    cp .env.example .env
    ```
    *Nota: Como no hemos creado un .env.example explícito, puedes usar el que genera Laravel por defecto o crear uno con:*
    ```ini
    APP_NAME=DevBossMail
    APP_ENV=local
    APP_KEY=base64:TuKeyGeneradaAqui
    APP_DEBUG=true
    APP_URL=http://localhost:8000

    DB_CONNECTION=mysql
    DB_HOST=db
    DB_PORT=3306
    DB_DATABASE=devbossmail
    DB_USERNAME=root
    DB_PASSWORD=root

    REDIS_HOST=redis
    REDIS_PASSWORD=null
    REDIS_PORT=6379

    MAIL_MAILER=smtp
    MAIL_HOST=mailpit
    MAIL_PORT=1025
    MAIL_USERNAME=null
    MAIL_PASSWORD=null
    MAIL_ENCRYPTION=null
    MAIL_FROM_ADDRESS="hello@example.com"
    MAIL_FROM_NAME="${APP_NAME}"
    ```

3.  **Levantar Contenedores Docker**:
    Ejecuta el siguiente comando para construir y levantar los servicios:
    ```bash
    docker-compose up -d --build
    ```

4.  **Instalar Dependencias de PHP**:
    Ejecuta este comando para instalar las librerías de Laravel dentro del contenedor:
    ```bash
    docker-compose exec app composer install
    ```

5.  **Generar Key de Aplicación**:
    ```bash
    docker-compose exec app php artisan key:generate
    ```

6.  **Ejecutar Migraciones (Base de Datos)**:
    Crea las tablas en la base de datos:
    ```bash
    docker-compose exec app php artisan migrate
    ```

7.  **Acceder a la Aplicación**:
    - Web: [http://localhost:8000](http://localhost:8000)
    - Mailpit (Simulador de Correo): [http://localhost:8025](http://localhost:8025)

## Uso

1.  **Crear Admin**:
    Puedes crear un admin manualmente en la base de datos o usar `tinker`:
    ```bash
    docker-compose exec app php artisan tinker
    ```
    Luego en la consola interactiva:
    ```php
    \App\Models\Admin::create(['username' => 'admin', 'email' => 'admin@devboss.com', 'password' => bcrypt('password')]);
    ```

2.  **Login**:
    Ve a `/admin/login` y usa las credenciales creadas.

## Configuración de Correo (Producción)

Para usar un proveedor real (Opción B), edita tu `.env` con las credenciales de Mailgun/Sendgrid/etc., o configura los valores en el panel de administración si implementaste la lectura dinámica desde la DB.
