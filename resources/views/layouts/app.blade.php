<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo') - Gestión de Archivos</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f3f4f6; margin: 0; padding: 20px; }
        .caja { max-width: 420px; margin: 40px auto; background: #fff; padding: 28px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,.1); }
        h1 { margin-top: 0; font-size: 22px; }
        label { display: block; margin-top: 14px; font-weight: bold; font-size: 14px; }
        input { width: 100%; padding: 9px; margin-top: 4px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; margin-top: 20px; padding: 10px; background: #2563eb; color: #fff; border: 0; border-radius: 4px; font-size: 15px; cursor: pointer; }
        button:hover { background: #1d4ed8; }
        .error { background: #fee2e2; color: #991b1b; padding: 10px; border-radius: 4px; margin-bottom: 10px; font-size: 14px; }
        .exito { background: #dcfce7; color: #166534; padding: 10px; border-radius: 4px; margin-bottom: 10px; font-size: 14px; }
        .req { color: #dc2626; }
        .boton { display: block; text-align: center; margin-top: 20px; padding: 10px; background: #2563eb; color: #fff; border-radius: 4px; font-size: 15px; text-decoration: none; }
        .boton:hover { background: #1d4ed8; }
        .enlace { text-align: center; margin-top: 16px; font-size: 14px; }
        .enlace a { color: #2563eb; }
        .exito-grande { text-align: center; }
        .exito-grande h1 { color: #166534; }
    </style>
</head>
<body>
    @yield('contenido')
</body>
</html>