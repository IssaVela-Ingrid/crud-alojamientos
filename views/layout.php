<?php
// views/layout.php
// Usaremos $title y $content para inyectar contenido

// Define los enlaces del menú
$isLoggedIn = isset($_SESSION['user_id']);
$user_name = $_SESSION['nombre'] ?? 'Invitado';
$user_rol = $_SESSION['rol'] ?? 'usuario';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'CRUD Alojamientos' ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="container">
                <a href="index.php?page=home">🏡 Alojamientos</a>
                <div class="right-links">
                    <?php if ($isLoggedIn): ?>
                        <?php if ($user_rol === 'administrador'): ?>
                            <a href="index.php?page=admin">⚙️ Admin Panel</a> <?php else: ?>
                            <a href="index.php?page=user">👤 Mi Cuenta</a> <?php endif; ?>
                        
                        <span>Hola, <?= htmlspecialchars($user_name) ?></span>
                        <a href="index.php?page=auth&action=logout" class="btn btn-danger">Salir</a>
                    <?php else: ?>
                        <a href="index.php?page=auth&action=login">Iniciar Sesión</a>
                        <a href="index.php?page=auth&action=register" class="btn btn-primary">Crear Cuenta</a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>
    
    <main class="container">
        <?= $content ?>
    </main>
</body>
</html>