<?php
require __DIR__ . '/init.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$contact = $contactRepo->getById($id);

if (!$contact) {
    set_flash('error', 'Contacto no encontrado.');
    header('Location: index.php');
    exit;
}

$pageTitle = 'Editar contacto';

$errors = [];
$data = $contact;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'nombre' => trim($_POST['nombre'] ?? ''),
        'apellido' => trim($_POST['apellido'] ?? ''),
        'telefono' => trim($_POST['telefono'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'direccion' => trim($_POST['direccion'] ?? ''),
        'notas' => trim($_POST['notas'] ?? ''),
        'foto_path' => $contact['foto_path'],
    ];

    $errors = validate_contact($data, $_FILES, true);

    if (!$errors) {
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] !== UPLOAD_ERR_NO_FILE) {
            $newPath = handle_upload($_FILES['foto']);
            if ($newPath) {
                $data['foto_path'] = $newPath;
            }
        }
        try {
            $contactRepo->update($id, $data);
            set_flash('success', 'Contacto actualizado correctamente.');
            header('Location: view.php?id=' . $id);
            exit;
        } catch (PDOException $e) {
            set_flash('error', 'Error al actualizar el contacto.');
        }
    } else {
        set_flash('error', 'Por favor corrige los errores del formulario.');
    }
}

require __DIR__ . '/includes/header.php';
?>

<h2>Editar contacto</h2>

<form method="post" enctype="multipart/form-data" class="contact-form">
    <?php include __DIR__ . '/includes/form_fields.php'; ?>
    <button type="submit">Guardar cambios</button>
    <a href="view.php?id=<?= $id ?>" class="btn-secondary">Cancelar</a>
</form>

<?php require __DIR__ . '/includes/footer.php';
