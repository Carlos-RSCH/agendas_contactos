<?php
require __DIR__ . '/init.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$contact = $contactRepo->getById($id);

if (!$contact) {
    set_flash('error', 'Contacto no encontrado.');
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
        try {
            $contactRepo->delete($id);
            set_flash('success', 'Contacto eliminado correctamente.');
        } catch (PDOException $e) {
            set_flash('error', 'Error al eliminar el contacto.');
        }
    } else {
        set_flash('info', 'Eliminación cancelada.');
    }
    header('Location: index.php');
    exit;
}

$pageTitle = 'Eliminar contacto';

require __DIR__ . '/includes/header.php';
?>

<h2>Eliminar contacto</h2>

<p>¿Estás seguro de que deseas eliminar al contacto <strong><?= e($contact['nombre'] . ' ' . $contact['apellido']) ?></strong>?</p>

<form method="post" class="delete-form">
    <button type="submit" name="confirm" value="yes">Sí, eliminar</button>
    <button type="submit" name="confirm" value="no" class="btn-secondary">No, cancelar</button>
</form>

<?php require __DIR__ . '/includes/footer.php';
