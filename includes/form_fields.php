<?php
// Espera $data y $errors definidos en el ámbito que incluye este archivo.
?>
<div class="form-group">
    <label for="nombre">Nombre *</label>
    <input type="text" id="nombre" name="nombre" required
           value="<?= e($data['nombre'] ?? '') ?>">
    <?php if (!empty($errors['nombre'])): ?>
        <div class="error"><?= e($errors['nombre']) ?></div>
    <?php endif; ?>
</div>

<div class="form-group">
    <label for="apellido">Apellido</label>
    <input type="text" id="apellido" name="apellido"
           value="<?= e($data['apellido'] ?? '') ?>">
</div>

<div class="form-group">
    <label for="telefono">Teléfono *</label>
    <input type="tel" id="telefono" name="telefono" required
           pattern="[0-9+()\-\s]{5,20}"
           value="<?= e($data['telefono'] ?? '') ?>">
    <?php if (!empty($errors['telefono'])): ?>
        <div class="error"><?= e($errors['telefono']) ?></div>
    <?php endif; ?>
</div>

<div class="form-group">
    <label for="email">Email</label>
    <input type="email" id="email" name="email"
           value="<?= e($data['email'] ?? '') ?>">
    <?php if (!empty($errors['email'])): ?>
        <div class="error"><?= e($errors['email']) ?></div>
    <?php endif; ?>
</div>

<div class="form-group">
    <label for="direccion">Dirección</label>
    <textarea id="direccion" name="direccion" rows="2"><?= e($data['direccion'] ?? '') ?></textarea>
</div>

<div class="form-group">
    <label for="notas">Notas</label>
    <textarea id="notas" name="notas" rows="3"><?= e($data['notas'] ?? '') ?></textarea>
</div>

<div class="form-group">
    <label for="foto">Foto (opcional)</label>
    <input type="file" id="foto" name="foto" accept="image/*">
    <?php if (!empty($errors['foto'])): ?>
        <div class="error"><?= e($errors['foto']) ?></div>
    <?php endif; ?>

    <?php if (!empty($data['foto_path'])): ?>
        <div class="current-photo">
            <p>Foto actual:</p>
            <img src="<?= e($data['foto_path']) ?>" alt="Foto de contacto">
        </div>
    <?php endif; ?>
</div>
