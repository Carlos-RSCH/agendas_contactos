<?php
require __DIR__ . '/init.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$contact = $contactRepo->getById($id);

if (!$contact) {
    set_flash('error', 'Contacto no encontrado.');
    header('Location: index.php');
    exit;
}

$pageTitle = 'Detalle de contacto';

require __DIR__ . '/includes/header.php';
?>

<h2>Detalle de contacto</h2>

<div class="contact-detail">
    <?php if (!empty($contact['foto_path'])): ?>
        <div class="detail-photo">
            <img src="<?= e($contact['foto_path']) ?>" alt="Foto de contacto">
        </div>
    <?php endif; ?>

    <dl>
        <dt>Nombre</dt>
        <dd><?= e($contact['nombre'] . ' ' . $contact['apellido']) ?></dd>

        <dt>Teléfono</dt>
        <dd><?= e($contact['telefono']) ?></dd>

        <dt>Email</dt>
        <dd><?= e($contact['email']) ?></dd>

        <dt>Dirección</dt>
        <dd><?= nl2br(e($contact['direccion'])) ?></dd>

        <dt>Notas</dt>
        <dd><?= nl2br(e($contact['notas'])) ?></dd>
    </dl>
</div>

<p class="detail-actions">
    <a href="edit.php?id=<?= $id ?>">Editar</a> |
    <a href="delete.php?id=<?= $id ?>">Eliminar</a> |
    <a href="index.php">Volver al listado</a>
</p>

<?php require __DIR__ . '/includes/footer.php';
