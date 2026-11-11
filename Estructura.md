# Estructura del proyecto

Este documento muestra cómo está organizado el proyecto en tres niveles: el árbol de carpetas, las clases con sus funciones y el recorrido MVC de cada funcionalidad.

---

## Nivel 1. Árbol de carpetas

```
GestionArchivos/
├── app/                                  Lógica de la aplicación
│   ├── Http/
│   │   └── Controllers/
│   │       ├── AuthController.php        Registro, login y logout
│   │       ├── ArchivoController.php     Subir, listar, abrir, descargar y eliminar
│   │       └── Controller.php            Clase base
│   ├── Models/
│   │   ├── User.php                      Modelo de usuarios (tb_usuarios)
│   │   └── Archivo.php                   Modelo de archivos (tb_archivos)
│   ├── Policies/
│   │   └── ArchivoPolicy.php             Reglas de quién puede tocar un archivo
│   └── Providers/
│       └── AppServiceProvider.php        Arranque de servicios
├── bootstrap/                            Arranque del framework
├── config/                               Configuración
│   ├── filesystems.php                   Disco privado "archivos"
│   ├── database.php                      Conexión a MySQL
│   ├── session.php                       Sesiones
│   ├── app.php                           (sin uso)
│   ├──auth.php                           (sin uso)
│   ├──cache.php                          (sin uso)
│   ├──logging.php                        (sin uso)
│   ├──mail.php                           (sin uso) 
│   ├──queue.php                          (sin uso)
│   ├──services.php                       (sin uso)
├── database/                             Base de datos como código
│   ├── migrations/                       Creación de tablas
│   ├── seeders/
│   │   └── DatabaseSeeder.php            Usuarios de prueba
│   └── factories/
├── public/                               Única carpeta accesible desde el navegador
│   ├── index.php                         Puerta de entrada
│   └── build/                            CSS y JS compilados por Vite
├── resources/                            Lo que ve el usuario
│   ├── css/app.css                       Estilos (Tailwind)
│   ├── js/
│   │   ├── app.js                        Interacciones (modal, arrastrar y soltar, ojo)
│   │   └── bootstrap.js
│   └── views/
│       ├── layouts/app.blade.php         Plantilla base
│       ├── auth/
│       │   ├── login.blade.php           Pantalla de login
│       │   └── registro.blade.php        Pantalla de registro
│       ├── components/
│       │   └── campo-password.blade.php  Campo de contraseña con ojo
│       ├── panel.blade.php               Panel principal de archivos
│       └── welcome.blade.php             (sin uso)
├── routes/
│   ├── web.php                           URL de la aplicación
│   └── console.php
├── storage/
│   └── app/archivos_usuarios/            Archivos subidos (fuera de public)
├── tests/                                Pruebas de ejemplo
├── vendor/                               Paquetes de PHP (Composer)
├── node_modules/                         Paquetes de front-end (npm)
├── .env / .env.example                   Configuración del entorno
├── composer.json                         Dependencias de PHP
├── package.json                          Dependencias de front-end
├── vite.config.js                        Configuración de Vite
├── README.md                             Instalación en otra máquina
├── Analisis.md                           Análisis, diagramas y modelo entidad-relación
└── Estructura.md                         Como esta estructurado el poryecto (Este Documento)
```

## Nivel 2. Clases y sus funciones

### `AuthController` (`app/Http/Controllers/AuthController.php`)

| Función | ¿Qué hace? |
|---|---|
| `mostrarRegistro()` | Muestra el formulario de registro. |
| `registrar(Request)` | Valida los datos, crea el usuario con la contraseña cifrada y muestra el aviso de cuenta creada. |
| `mostrarLogin()` | Muestra el formulario de inicio de sesión. |
| `login(Request)` | Valida correo y contraseña, inicia sesión con `Auth::attempt` y regenera la sesión. |
| `logout(Request)` | Cierra la sesión, la invalida y renueva el token CSRF. |

### `ArchivoController` (`app/Http/Controllers/ArchivoController.php`)

| Función | ¿Qué hace?  |
|---|---|
| `index(Request)` | Lista solo los archivos del usuario con sesión y muestra el panel. |
| `store(Request)` | Valida tipo y tamaño (máx. 10 MB), guarda el archivo con nombre aleatorio y crea el registro con su UUID. |
| `show(Archivo)` | Autoriza y abre el archivo en el navegador. |
| `download(Archivo)` | Autoriza y descarga el archivo con su nombre original. |
| `destroy(Archivo)` | Autoriza, borra el archivo físico y su registro. |

### `ArchivoPolicy` (`app/Policies/ArchivoPolicy.php`)

| Función | ¿Qué hace?  |
|---|---|
| `view(User, Archivo)` | Permite ver, abrir o descargar solo si el archivo es del usuario; si no, responde 404. |
| `delete(User, Archivo)` | Permite eliminar solo si el archivo es del usuario; si no, responde 404. |

### Modelos

| Clase | Función | ¿Qué hace? |
|---|---|---|
| `User` | `archivos()` | Relación: un usuario tiene muchos archivos. |
| `Archivo` | `usuario()` | Relación: un archivo pertenece a un usuario. |
| `Archivo` | `getRouteKeyName()` | Indica que la URL usa el `uuid` y no el `id`. |
| `Archivo` | `getPesoLegibleAttribute()` | Convierte los bytes a B, KB o MB para mostrarlos. |

### Rutas (`routes/web.php`)

| Método y URL | Va a | Acceso |
|---|---|---|
| `GET /registro` | `AuthController@mostrarRegistro` | Sin sesión |
| `POST /registro` | `AuthController@registrar` | Sin sesión |
| `GET /login` | `AuthController@mostrarLogin` | Sin sesión |
| `POST /login` | `AuthController@login` | Sin sesión |
| `GET /panel` | `ArchivoController@index` | Con sesión |
| `POST /archivos` | `ArchivoController@store` | Con sesión |
| `GET /archivos/{archivo}` | `ArchivoController@show` | Con sesión y dueño |
| `GET /archivos/{archivo}/descargar` | `ArchivoController@download` | Con sesión y dueño |
| `DELETE /archivos/{archivo}` | `ArchivoController@destroy` | Con sesión y dueño |
| `POST /logout` | `AuthController@logout` | Con sesión |

---

## Nivel 3. Recorrido MVC por funcionalidad

Formato: **Ruta → Modelo → Vista → Controlador**.

| Funcionalidad | Ruta | Modelo | Vista | Controlador |
|---|---|---|---|---|
| Ver registro | `GET /registro` | — | `auth/registro.blade.php` | `AuthController@mostrarRegistro` |
| Registrarse | `POST /registro` | `User` | `auth/registro.blade.php` (aviso de cuenta creada) | `AuthController@registrar` |
| Ver login | `GET /login` | — | `auth/login.blade.php` | `AuthController@mostrarLogin` |
| Iniciar sesión | `POST /login` | `User` | Redirige a `panel.blade.php` | `AuthController@login` |
| Listar archivos | `GET /panel` | `User::archivos()` `Archivo` | `panel.blade.php` | `ArchivoController@index` |
| Subir archivo | `POST /archivos` | `Archivo` (guarda en disco `archivos`) | `panel.blade.php` | `ArchivoController@store` |
| Abrir archivo | `GET /archivos/{uuid}` | `Archivo` + `ArchivoPolicy@view` | Archivo en el navegador | `ArchivoController@show` |
| Descargar archivo | `GET /archivos/{uuid}/descargar` | `Archivo` + `ArchivoPolicy@view` | Descarga | `ArchivoController@download` |
| Eliminar archivo | `DELETE /archivos/{uuid}` | `Archivo` + `ArchivoPolicy@delete` | `panel.blade.php` (modal de confirmación) | `ArchivoController@destroy` |
| Cerrar sesión | `POST /logout` | — | Redirige a `auth/login.blade.php` | `AuthController@logout` |

### Ejemplo completo: subir un archivo

```
POST /archivos
   → routes/web.php
   → ArchivoController@store
   → Archivo (modelo: crea la fila en tb_archivos)
   → storage/app/archivos_usuarios/{id_usuario}/  (archivo físico)
   → panel.blade.php (lista actualizada)
```

### Ejemplo completo: descargar un archivo ajeno (ataque)

```
GET /archivos/{uuid-de-otro-usuario}/descargar
   → routes/web.php (grupo auth: hay sesión, pasa)
   → ArchivoController@download
   → ArchivoPolicy@view (el id_usuario no coincide)
   → Respuesta 404 (A Proposito, NO INDICA SI O NO EXISTE EL ARCHIVO.)
```
