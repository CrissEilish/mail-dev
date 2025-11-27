# Guía de Despliegue: DevBossMail

Este documento explica cómo desplegar la aplicación en **EasyPanel** (Recomendado) y **Hostinger**.

---

## Opción 1: EasyPanel (VPS)
EasyPanel es ideal porque usa Docker, que es como diseñamos esta aplicación.

### Pasos:
1.  **Subir código a GitHub/GitLab**:
    - Sube todo el código de este proyecto a un repositorio privado o público.

2.  **Crear Proyecto en EasyPanel**:
    - Entra a tu EasyPanel.
    - Crea un nuevo proyecto "DevBossMail".

3.  **Añadir Servicio (App)**:
    - Elige **"App"** como tipo de servicio.
    - **Source**: Conecta tu repositorio de GitHub.
    - **Build Method**: Dockerfile (EasyPanel detectará el `Dockerfile` en la raíz).
    - **Environment Variables**: Copia el contenido de tu `.env` aquí.
        - Asegúrate de cambiar `DB_HOST` a la IP interna o nombre del servicio de base de datos si usas uno gestionado por EasyPanel.

4.  **Añadir Base de Datos (MySQL)**:
    - En EasyPanel, añade un servicio **MySQL**.
    - EasyPanel te dará las credenciales (Host, User, Password, Database).
    - Vuelve a tu App > Environment y actualiza `DB_HOST`, `DB_USERNAME`, etc.

5.  **Añadir Redis (Opcional pero recomendado)**:
    - Añade un servicio **Redis** en EasyPanel.
    - Actualiza `REDIS_HOST` en las variables de entorno de tu App.

6.  **Desplegar**:
    - Dale a "Deploy". EasyPanel construirá la imagen y lanzará el contenedor.

7.  **Comandos Post-Despliegue**:
    - Una vez levantado, entra a la consola de la App en EasyPanel y ejecuta:
      ```bash
      php artisan migrate --force
      php artisan key:generate --show  # (Copia esto a tus env vars si no tienes una)
      ```

---

## Opción 2: Hostinger (VPS - CyberPanel/Docker)
Si tienes un VPS en Hostinger, es básicamente un servidor Linux.

1.  **Entra por SSH** a tu VPS.
2.  **Instala Docker** (si no viene instalado):
    ```bash
    curl -fsSL https://get.docker.com -o get-docker.sh
    sh get-docker.sh
    ```
3.  **Clona tu repositorio**:
    ```bash
    git clone https://github.com/tu-usuario/devbossmail.git
    cd devbossmail
    ```
4.  **Sigue las instrucciones del README.md**:
    - `cp .env.example .env` (Configura tus datos).
    - `docker compose up -d --build`.

---

## Opción 3: Hostinger (Shared Hosting / cPanel)
**Nota**: No recomendado para aplicaciones Dockerizadas, pero posible si tienes acceso SSH y PHP >= 8.2.

1.  **Preparar Archivos**:
    - En tu PC local, ejecuta `composer install --optimize-autoloader --no-dev`.
    - Comprime todo el proyecto en un `.zip` (incluyendo `vendor`, excluyendo `.git` y `node_modules`).

2.  **Subir Archivos**:
    - Sube el zip al `public_html` (o una subcarpeta) en Hostinger.
    - Descomprime.

3.  **Configurar Dominio**:
    - Apunta tu dominio a la carpeta `public` del proyecto.
    - En Hostinger, ve a "Dominios" > "Apuntar directorio" y selecciona la carpeta `public`.

4.  **Base de Datos**:
    - Crea una base de datos MySQL en el panel de Hostinger.
    - Edita el archivo `.env` con las credenciales.

5.  **Migraciones**:
    - Si tienes acceso SSH: ejecuta `php artisan migrate`.
    - Si NO tienes SSH: Importa un dump SQL localmente o usa una ruta temporal en `routes/web.php` para ejecutar `Artisan::call('migrate')` (borrar inmediatamente después).

6.  **Permisos**:
    - Asegúrate de que las carpetas `storage` y `bootstrap/cache` tengan permisos de escritura (775 o 777).
