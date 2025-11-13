<?php
require __DIR__ . '/init.php';

$pageTitle = 'Listado de contactos';

$search = trim($_GET['q'] ?? '');
$page = max(1, (int)($_GET['page'] ?? 1));
$perPage = 10;
$offset = ($page - 1) * $perPage;

$total = $contactRepo->countAll($search ?: null);
$contacts = $contactRepo->getAll($perPage, $offset, $search ?: null);
$totalPages = (int)ceil($total / $perPage);

require __DIR__ . '/includes/header.php';
?>

<h2>Contactos</h2>

<form method="get" class="search-form">
    <input type="text" name="q" placeholder="Buscar por nombre, apellido o teléfono" value="<?= e($search) ?>">
    <button type="submit">Buscar</button>
    <?php if ($search): ?>
        <a href="index.php" class="btn-secondary">Limpiar</a>
    <?php endif; ?>
</form>

<table class="contacts-table">
    <thead>
    <tr>
        <th>Nombre</th>
        <th>Teléfono</th>
        <th>Email</th>
        <th>Acciones</th>
    </tr>
    </thead>
    <tbody>
    <?php if (!$contacts): ?>
        <tr><td colspan="4">No hay contactos.</td></tr>
    <?php else: ?>
        <?php foreach ($contacts as $c): ?>
            <tr>
                <td>
                    <a href="view.php?id=<?= (int)$c['id'] ?>">
                        <?= e($c['nombre'] . ' ' . $c['apellido']) ?>
                    </a>
                </td>
                <td><?= e($c['telefono']) ?></td>
                <td><?= e($c['email']) ?></td>
                <td>
                    <a href="view.php?id=<?= (int)$c['id'] ?>">Ver</a> |
                    <a href="edit.php?id=<?= (int)$c['id'] ?>">Editar</a> |
                    <a href="delete.php?id=<?= (int)$c['id'] ?>">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>

<?php if ($totalPages > 1): ?>
    <nav class="pagination">
        <?php for ($p = 1; $p <= $totalPages; $p++): ?>
            <?php if ($p === $page): ?>
                <span class="current"><?= $p ?></span>
            <?php else: ?>
                <a href="?page=<?= $p ?>&amp;q=<?= urlencode($search) ?>"><?= $p ?></a>
            <?php endif; ?>
        <?php endfor; ?>
    </nav>
<?php endif; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>
