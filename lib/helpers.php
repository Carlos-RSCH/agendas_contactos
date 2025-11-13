<?php
declare(strict_types=1);

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function set_flash(string $type, string $message): void
{
    $_SESSION['flash'][] = ['type' => $type, 'message' => $message];
}

function get_flashes(): array
{
    $flashes = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);
    return $flashes;
}

function validate_contact(array $data, array $files = [], bool $is_edit = false): array
{
    $errors = [];

    $nombre = trim($data['nombre'] ?? '');
    $telefono = trim($data['telefono'] ?? '');
    $email = trim($data['email'] ?? '');

    if ($nombre === '') {
        $errors['nombre'] = 'El nombre es obligatorio.';
    }

    if ($telefono === '') {
        $errors['telefono'] = 'El teléfono es obligatorio.';
    } elseif (!preg_match('/^[0-9+()\-\s]{5,20}$/', $telefono)) {
        $errors['telefono'] = 'El teléfono no tiene un formato válido.';
    }

    if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'El email no es válido.';
    }

    // Validación de imagen (opcional)
    if (isset($files['foto']) && $files['foto']['error'] !== UPLOAD_ERR_NO_FILE) {
        if ($files['foto']['error'] !== UPLOAD_ERR_OK) {
            $errors['foto'] = 'Error al subir la imagen.';
        } else {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array(mime_content_type($files['foto']['tmp_name']), $allowedTypes, true)) {
                $errors['foto'] = 'La imagen debe ser JPG, PNG o GIF.';
            }
            if ($files['foto']['size'] > 2 * 1024 * 1024) {
                $errors['foto'] = 'La imagen no debe superar los 2MB.';
            }
        }
    }

    return $errors;
}

/**
 * Maneja la subida de imagen (si existe). Devuelve la ruta relativa o null.
 */
function handle_upload(array $file): ?string
{
    if ($file['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    $uploadsDir = __DIR__ . '/../public/uploads';
    if (!is_dir($uploadsDir)) {
        mkdir($uploadsDir, 0777, true);
    }

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $ext = strtolower($ext);
    $basename = bin2hex(random_bytes(8));
    $filename = $basename . ($ext ? "." . $ext : '');
    $targetPath = $uploadsDir . '/' . $filename;

    if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
        return null;
    }

    return 'public/uploads/' . $filename;
}
