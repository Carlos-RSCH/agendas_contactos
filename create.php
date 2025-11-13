<?php
require __DIR__ . '/init.php';

$pageTitle = 'Nuevo contacto';

$errors = [];
$data = [
    'nombre' => '',
    'apellido' => '',
    'telefono' => '',
    'email' => '',
    'direccion' => '',
    'notas' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'nombre' => trim($_POST['nombre'] ?? ''),
        'apellido' => trim($_POST['apellido'] ?? ''),
        'telefono' => trim($_POST['telefono'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'direccion' => trim($_POST['direccion'] ?? ''),
        'notas' => trim($_POST['notas'] ?? ''),
    ];

    $errors = validate_contact($data, $_FILES);

    if (!$errors) {
        $fotoPath = null;
        if (isset($_FILES['foto'])) {
            $fotoPath = handle_upload($_FILES['foto']);
        }
        $data['foto_path'] = $fotoPath;

        try {
            $id = $contactRepo->create($data);
            set_flash('success', 'Contacto creado correctamente.');
            header('Location: view.php?id=' . $id);
            exit;
        } catch (PDOException $e) {
            set_flash('error', 'Error al crear el contacto.');
        }
    } else {
        set_flash('error', 'Por favor corrige los errores del formulario.');
    }
}

require __DIR__ . '/includes/header.php';
?>

<h2>Nuevo contacto</h2>

<form method="post" enctype="multipart/form-data" class="contact-form">
    <?php include __DIR__ . '/includes/form_fields.php'; ?>
    <button type="submit">Guardar</button>
    <a href="index.php" class="btn-secondary">Cancelar</a>
</form>

<?php require __DIR__ . '/includes/footer.php';
