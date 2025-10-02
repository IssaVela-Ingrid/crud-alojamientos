<?php
// views/landing.php
ob_start();
?>

<h1>🛍️Alojamientos en Oferta</h1>
<p>Explora la selección de nuestros mejores alojamientos. ¡Inicia sesión para guardar tus favoritos!</p>

<?php if (isset($_SESSION['message'])): ?>
    <div style="background-color: #d4edda; color: #048522ff; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
        <?= htmlspecialchars($_SESSION['message']); unset($_SESSION['message']); ?>
    </div>
<?php endif; ?>

<div class="alojamiento-grid">
    <?php if (empty($alojamientos)): ?>
        <p>No hay alojamientos disponibles en este momento.</p>
    <?php else: ?>
        <?php foreach ($alojamientos as $alojamiento): ?>
            <div class="alojamiento-card">
                <h3><?= htmlspecialchars($alojamiento['titulo']) ?></h3>
                <p><?= htmlspecialchars($alojamiento['descripcion']) ?></p>
                <div class="price">$<?= number_format($alojamiento['precio'], 2) ?></div>
                
                <?php if (isset($_SESSION['user_id']) && $_SESSION['rol'] === 'usuario'): ?>
                    <a href="index.php?page=user&action=select&alojamiento_id=<?= $alojamiento['id'] ?>" class="btn btn-primary">
                        Guardar en mi Cuenta
                    </a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
require_once '../views/layout.php';