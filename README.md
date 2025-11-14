# Agenda de Contactos en PHP

Este repositorio contiene una aplicación web desarrollada en PHP que permite gestionar una agenda telefónica mediante operaciones CRUD (Crear, Leer, Actualizar, Eliminar). La app utiliza MySQL/MariaDB como base de datos y está diseñada con buenas prácticas de seguridad, modularidad y claridad didáctica.

## ¿Qué hace esta aplicación?

- Permite registrar nuevos contactos con nombre, apellido, teléfono, email, dirección, notas y foto.
- Muestra un listado paginado de todos los contactos registrados.
- Permite editar los datos de un contacto existente.
- Muestra el detalle completo de cada contacto.
- Permite eliminar contactos con confirmación previa.
- Incluye un buscador.
- Muestra mensajes de éxito o error tras cada acción para mejorar la experiencia del usuario.

## Seguridad implementada

- Conexión segura con PDO y sentencias preparadas
- Validación en HTML5 y en servidor PHP
- Sanitización de salidas con `htmlspecialchars()`
- Eliminación por método POST con confirmación
- Uso de variables de entorno para ocultar credenciales
