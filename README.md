# Proyecto: gestión de archivos por usuario

Aplicación web hecha con **Laravel 12** y **MySQL** para que cada usuario se registre, inicie sesión y administre sus propios archivos (subir, listar, abrir, descargar y eliminar).

## Análisis del proyecto
Antes de comenzar el desarrollo de la aplicación desde cero, se realizó un análisis previo del proyecto, definiendo la lógica y el funcionamiento del sistema mediante diagramas de flujo y el diseño del Modelo Entidad-Relación (MER) de la base de datos.

[Consultar análisis del proyecto](Analisis.md)

## Requisitos previos

| Programa | Para qué | Cómo verificar |
|---|---|---|
| **Git** | Descargar el proyecto | `git --version` |
| **PHP 8.2 o superior** | Ejecutar Laravel | `php -v` |
| **Composer** | Instalar dependencias de PHP | `composer -V` |
| **Node.js y npm** | Compilar los estilos (Tailwind/Vite) | `node -v` y `npm -v` |
| **MySQL o MariaDB** | Base de datos (se puede usar XAMPP) | Debe poder encenderse |

Notas:

- Se recomienda una versión de PHP con los parches de seguridad de octubre de 2026 (8.2.35, 8.3.36, 8.4.27 u 8.5.12 o superior).
- Con XAMPP solo hace falta encender **MySQL**. Apache solo se necesita para abrir phpMyAdmin.
- En PHP deben estar activas las extensiones habituales de Laravel (`pdo_mysql`, `mbstring`, `openssl`, `fileinfo`, `zip`). En XAMPP vienen activadas.

## Instlacion Proyecto.

1. Descargar el proyecto

```bash
git clone URL-DEL-REPOSITORIO
cd NOMBRE-DE-LA-CARPETA
```

### 2. Instalar las dependencias de PHP

```bash
composer install
```

### 3. Instalar las dependencias de front-end y compilar los estilos

```bash
npm install
npm run build
```
### 4. Crear el archivo de configuración desde la terminal.

```bash
copy .env.example .env
```
Luego generar la llave de la aplicación:

```bash
php artisan key:generate
```

### 5. Crear la base de datos

Encender MySQL en XAMPP

```sql
CREATE DATABASE gestion_archivos CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 6. Configurar la conexión a la base de datos

Abrir el archivo `.env` 
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gestion_archivos
DB_USERNAME=root
DB_PASSWORD=
```

En XAMPP el usuario es `root` y la contraseña viene vacía. Si alguna de estas líneas aparece con `#` al inicio, quitar el `#`.

### 7. Crear las tablas y los usuarios de prueba

```bash
php artisan migrate --seed
```

Este comando crea automáticamente las tablas `tb_usuarios`, `tb_archivos` y `sessions` (más las tablas internas de Laravel) a partir de la carpeta `database/migrations/`, e inserta los dos usuarios de prueba.

Si pregunta si desea crear la base de datos, el paso 5 no se hizo bien.

### 8. Iniciar la aplicación

```bash
php artisan serve
```

## Usuarios de prueba.

| USUARIOS  | CORREO |  CONTRASEñAS |
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
- **Archivo demasiado grande:**
El servidor valida max:10240 (10 MB) y devuelve “El archivo es demasiado grande. El tamaño máximo es 10 MB.”, y el navegador avisa antes de enviar.
- **Sesión vencida y archivo inexistente:**
El middleware auth redirige al login, y si el archivo no existe en la base (UUID inválido) o falta en disco, el sistema responde 404 con un mensaje claro.

### Otro Supuesto:
**Actualización de seguridad de PHP (octubre de 2026)**
El 21 de octubre de 2026 se publicaron correcciones para dos vulnerabilidades críticas del núcleo de PHP (CVE-2026-109618 y CVE-2026-109619), que pueden permitir ejecución remota de código.

**Mejoras para el proyecto**
- **Busqueda de archivo:**
Implementar un buscador en el panel principal que permita localizar archivos por nombre. Esta funcionalidad facilitaría el acceso a la información y mejoraría la experiencia del usuario, especialmente cuando se maneja una gran cantidad de archivos.

- **Correo de bienvenida y Seguridad:**
Implementar un sistema de envío de correos electrónicos de bienvenida para los usuarios nuevos que se registren en la plataforma. Además, verificar la dirección de correo electrónico mediante un enlace de confirmación o un código de verificación. Esto permitiría comprobar que el correo pertenece al usuario y reducir el registro de cuentas con direcciones inexistentes o incorrectas.

- **Recuperar contraseña:**
Incorporar una opción para recuperar la contraseña en caso de que el usuario la olvide. El sistema podría enviar un código de verificación al correo electrónico registrado para validar su identidad y permitirle establecer una nueva contraseña de forma segura.


