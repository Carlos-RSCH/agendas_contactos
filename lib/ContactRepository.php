<?php
declare(strict_types=1);

class ContactRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function countAll(?string $search = null): int
    {
        if ($search) {
            $sql = "SELECT COUNT(*) FROM contacts
                    WHERE nombre LIKE :q OR apellido LIKE :q OR telefono LIKE :q";
            $stmt = $this->pdo->prepare($sql);
            $like = '%' . $search . '%';
            $stmt->bindParam(':q', $like, PDO::PARAM_STR);
        } else {
            $sql = "SELECT COUNT(*) FROM contacts";
            $stmt = $this->pdo->prepare($sql);
        }
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }

    public function getAll(int $limit, int $offset, ?string $search = null): array
    {
        if ($search) {
            $sql = "SELECT * FROM contacts
                    WHERE nombre LIKE :q OR apellido LIKE :q OR telefono LIKE :q
                    ORDER BY apellido, nombre
                    LIMIT :limit OFFSET :offset";
            $stmt = $this->pdo->prepare($sql);
            $like = '%' . $search . '%';
            $stmt->bindParam(':q', $like, PDO::PARAM_STR);
        } else {
            $sql = "SELECT * FROM contacts
                    ORDER BY apellido, nombre
                    LIMIT :limit OFFSET :offset";
            $stmt = $this->pdo->prepare($sql);
        }

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM contacts WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $contact = $stmt->fetch();
        return $contact ?: null;
    }

    public function create(array $data): int
    {
        $sql = "INSERT INTO contacts (nombre, apellido, telefono, email, direccion, notas, foto_path)
                VALUES (:nombre, :apellido, :telefono, :email, :direccion, :notas, :foto_path)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':nombre' => $data['nombre'],
            ':apellido' => $data['apellido'] ?? null,
            ':telefono' => $data['telefono'],
            ':email' => $data['email'] ?? null,
            ':direccion' => $data['direccion'] ?? null,
            ':notas' => $data['notas'] ?? null,
            ':foto_path' => $data['foto_path'] ?? null,
        ]);
        return (int) $this->pdo->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE contacts
                SET nombre = :nombre,
                    apellido = :apellido,
                    telefono = :telefono,
                    email = :email,
                    direccion = :direccion,
                    notas = :notas,
                    foto_path = :foto_path
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':nombre' => $data['nombre'],
            ':apellido' => $data['apellido'] ?? null,
            ':telefono' => $data['telefono'],
            ':email' => $data['email'] ?? null,
            ':direccion' => $data['direccion'] ?? null,
            ':notas' => $data['notas'] ?? null,
            ':foto_path' => $data['foto_path'] ?? null,
            ':id' => $id,
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM contacts WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
