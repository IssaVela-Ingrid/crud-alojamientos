<?php
// views/admin_panel.php
ob_start();
?>

<h2>⚙️ Panel de Administración (Punto 5)</h2>
<p>Bienvenido, **<?= htmlspecialchars($_SESSION['nombre']) ?>**. Tu rol te permite **agregar** nuevos alojamientos al sistema.</p>

<div class="form-card">
    <h3>Agregar Nuevo Alojamiento</h3>
    
    <?php if (isset($error) && $error): ?>
        <p style="color: var(--danger-color); font-weight: bold;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <?php if (isset($success) && $success): ?>
        <p style="color: green; font-weight: bold;"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

    <form method="POST" action="index.php?page=admin&action=create">
        <div class="form-group">
            <label for="titulo">Título del Alojamiento</label>
            <input type="text" id="titulo" name="titulo" required>
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" required></textarea>
        </div>
        <div class="form-group">
            <label for="precio">Precio por Noche ($)</label>
            <input type="number" id="precio" name="precio" step="0.01" min="0.01" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar Alojamiento</button>
    </form>
</div>

<?php
$content = ob_get_clean();
require_once '../views/layout.php';