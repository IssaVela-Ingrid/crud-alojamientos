<?php
// views/login.php
ob_start();
?>

<div class="form-card">
    <h2>Iniciar Sesión (Punto 2)</h2>
    
    <?php if ($error): ?>
        <p style="color: var(--danger-color); font-weight: bold;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" action="index.php?page=auth&action=login">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="contrasena">Contraseña</label>
            <input type="password" id="contrasena" name="contrasena" required>
        </div>
        <button type="submit" class="btn btn-primary">Acceder</button>
    </form>
    
    <p style="margin-top: 20px; text-align: center;">¿No tienes cuenta? <a href="index.php?page=auth&action=register">Regístrate aquí</a></p>
</div>

<?php
$content = ob_get_clean();
require_once '../views/layout.php';