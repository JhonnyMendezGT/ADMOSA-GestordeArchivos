# Proyecto: gestión de archivos por usuario

## Instlacion Proyecto.
1. Copiar el proyecto y abrir una terminal en su carpeta.

2. Instalar dependencias de php
composer install

3. Instalar dependecnais de front-end y compilar los estilos
npm install
npm run build

4. Crear el archivo de configuraion y la llave de la aplicación:
copy .env.example .env
php artisan key:generate

5. Encender MySQL en XAMPP y crear la base de datos
CREATE DATABASE gestion_archivos CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

6. Configurar la conexión en .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gestion_archivos
DB_USERNAME=root
DB_PASSWORD=

7. Crear las tablas:
php artisan migrate

8. Inciar el servidor
php artisan serve

9. Abrir el enlace en el navegador.

## Usuarios de prueba.

| USUARIOS | | CORREO | | CONTRASEñAS |
| --- | --- | --- |
| USUARIO 1 | usuario1@prueba.com | Prueba1234 | 
| USUARIO 2 | usuario2@prueba.com | Prueba1234 | 

## Decisiones y supuestos.

### Almacenamiento:
Los archivos se guardan **en el disco del servidor**, no en la base de datos:
- Ruta física: `storage/app/archivos_usuarios/
Cada archivo se guarda con un **nombre aleatorio**; el nombre original solo se almacena en la base de datos para mostrarlo.
- El disco se define en `config/filesystems.php` con el nombre `archivos` y es **privado** (sin acceso directo por URL).
- La base de datos solo guarda los metadatos (ruta, nombre original, peso, tipo y dueño)

### Tipos de archivos:
Son formatos comunes de documentos, imágenes y datos. Se excluyen a propósito HTML, SVG, scripts y ejecutables por seguridad.

### Manejo de errores:
-**Archivo demasiado grande:**
El servidor valida max:10240 (10 MB) y devuelve “El archivo es demasiado grande. El tamaño máximo es 10 MB.”, y el navegador avisa antes de enviar.
- **Sesión vencida y archivo inexistente:**
El middleware auth redirige al login, y si el archivo no existe en la base (UUID inválido) o falta en disco, el sistema responde 404 con un mensaje claro.

### Otro Supuesto:
**Actualización de seguridad de PHP (octubre de 2026)**
El 21 de octubre de 2026 se publicaron correcciones para dos vulnerabilidades críticas del núcleo de PHP (CVE-2026-109618 y CVE-2026-109619), que pueden permitir ejecución remota de código.
