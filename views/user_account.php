<?php
// views/user_account.php
ob_start();
?>

<h2>👤 Mi Cuenta: <?= htmlspecialchars($_SESSION['nombre']) ?></h2>
<h3>✅Alojamientos que has Seleccionado (Puntos 3 y 4)</h3>

<?php if (isset($_SESSION['message'])): ?>
    <div style="background-color: #d4edda; color: #025e17ff; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
        <?= htmlspecialchars($_SESSION['message']); unset($_SESSION['message']); ?>
    </div>
<?php endif; ?>

<div class="alojamiento-grid">
    <?php if (empty($alojamientos)): ?>
        <p>❌Aún no has seleccionado ningún alojamiento. <a href="index.php?page=home">Explora los disponibles aquí</a>.</p>
    <?php else: ?>
        <?php foreach ($alojamientos as $alojamiento): ?>
            <div class="alojamiento-card">
                <h3><?= htmlspecialchars($alojamiento['titulo']) ?></h3>
                <p><?= htmlspecialchars($alojamiento['descripcion']) ?></p>
                <div class="price">$<?= number_format($alojamiento['precio'], 2) ?></div>
                
                <a href="index.php?page=user&action=delete_selected&alojamiento_id=<?= $alojamiento['id'] ?>" 
                   class="btn btn-danger" 
                   onclick="return confirm('¿Estás seguro de quitar este alojamiento de tu lista?');">
                    Eliminar de Mi Lista
                </a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
require_once '../views/layout.php';