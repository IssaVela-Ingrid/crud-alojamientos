<?php
// views/register.php
// Esta vista utiliza $error y $success establecidos en AuthController.php

ob_start();
?>

<div class="form-container">
    <div class="form-card">
        <h2>Crear una Cuenta (Punto 2)</h2>
        
        <?php if (isset($error) && $error): ?>
            <p class="message-error" style="color: var(--danger-color); font-weight: bold;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <?php if (isset($success) && $success): ?>
            <p class="message-success" style="color: green; font-weight: bold;"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>

        <form method="POST" action="index.php?page=auth&action=register">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="contrasena">Contraseña</label>
                <input type="password" id="contrasena" name="contrasena" required>
            </div>
            <div class="form-group">
                <!-- CORRECCIÓN: Se cambió el 'name' a 'contrasena_confirm' para que coincida con AuthController -->
                <label for="contrasena_confirm">Confirmar Contraseña</label>
                <input type="password" id="contrasena_confirm" name="contrasena_confirm" required>
            </div>
            <button type="submit" class="btn btn-primary">Registrarse</button>
        </form>
        
        <p class="mt-4" style="margin-top: 20px; text-align: center;">¿Ya tienes una cuenta? <a href="index.php?page=auth&action=login">Inicia Sesión aquí</a></p>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once '../views/layout.php';
?>
