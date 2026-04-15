<?php declare(strict_types=1);
namespace App\Infrastructure\Persistence\MySQL;

use App\Domain\Empleo\Entity\Empleo;
use App\Domain\Empleo\Repository\EmpleoRepository;
use App\Domain\Empleo\ValueObject\{
    EmpleoId, EmpleoNombre, EmpleoCategoria, EmpleoAreaTrabajo,
    EmpleoEmpresa, EmpleoNivel, EmpleoSueldo, EmpleoFunciones, EmpleoCargoJefe
};
use DateTimeImmutable;
use PDO;

final class MySQLEmpleoRepository implements EmpleoRepository {
    private PDO $db;

    public function __construct() {
        $this->db = DatabaseConnection::getInstance();
    }

    public function save(Empleo $empleo): void {
        $data = $empleo->toArray();

        $exists = $this->db
            ->prepare('SELECT COUNT(*) FROM empleos WHERE id = :id')
            ->execute([':id' => $data['id']]);

        $stmt = $this->db->prepare('SELECT COUNT(*) as cnt FROM empleos WHERE id = :id');
        $stmt->execute([':id' => $data['id']]);
        $row = $stmt->fetch();

        if ((int)$row['cnt'] > 0) {
            $sql = 'UPDATE empleos SET
                        nombre        = :nombre,
                        categoria     = :categoria,
                        area_trabajo  = :area_trabajo,
                        empresa       = :empresa,
                        nivel         = :nivel,
                        sueldo        = :sueldo,
                        funciones     = :funciones,
                        cargo_jefe    = :cargo_jefe,
                        actualizado_en = :actualizado_en
                    WHERE id = :id';
        } else {
            $sql = 'INSERT INTO empleos
                        (id, nombre, categoria, area_trabajo, empresa, nivel, sueldo, funciones, cargo_jefe, creado_en, actualizado_en)
                    VALUES
                        (:id, :nombre, :categoria, :area_trabajo, :empresa, :nivel, :sueldo, :funciones, :cargo_jefe, :creado_en, :actualizado_en)';
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id'            => $data['id'],
            ':nombre'        => $data['nombre'],
            ':categoria'     => $data['categoria'],
            ':area_trabajo'  => $data['area_trabajo'],
            ':empresa'       => $data['empresa'],
            ':nivel'         => $data['nivel'],
            ':sueldo'        => $data['sueldo'],
            ':funciones'     => $data['funciones'],
            ':cargo_jefe'    => $data['cargo_jefe'],
            ':creado_en'     => $data['creado_en'],
            ':actualizado_en'=> $data['actualizado_en'],
        ]);
    }

    public function findById(EmpleoId $id): ?Empleo {
        $stmt = $this->db->prepare('SELECT * FROM empleos WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => $id->value()]);
        $row = $stmt->fetch();

        return $row ? $this->hydrate($row) : null;
    }

    public function findAll(int $page, int $perPage, string $search): array {
        $offset = ($page - 1) * $perPage;
        $like   = '%' . $search . '%';

        $sql  = 'SELECT * FROM empleos WHERE
                    nombre LIKE :s1 OR empresa LIKE :s2 OR categoria LIKE :s3 OR area_trabajo LIKE :s4
                 ORDER BY actualizado_en DESC
                 LIMIT :limit OFFSET :offset';

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':s1', $like);
        $stmt->bindValue(':s2', $like);
        $stmt->bindValue(':s3', $like);
        $stmt->bindValue(':s4', $like);
        $stmt->bindValue(':limit',  $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset,  PDO::PARAM_INT);
        $stmt->execute();

        return array_map([$this, 'hydrate'], $stmt->fetchAll());
    }

    public function countAll(string $search): int {
        $like = '%' . $search . '%';
        $sql  = 'SELECT COUNT(*) as cnt FROM empleos WHERE
                    nombre LIKE :s1 OR empresa LIKE :s2 OR categoria LIKE :s3 OR area_trabajo LIKE :s4';

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':s1' => $like, ':s2' => $like, ':s3' => $like, ':s4' => $like]);
        return (int) $stmt->fetch()['cnt'];
    }

    public function delete(EmpleoId $id): void {
        $stmt = $this->db->prepare('DELETE FROM empleos WHERE id = :id');
        $stmt->execute([':id' => $id->value()]);
    }

    public function nextId(): EmpleoId {
        return EmpleoId::generate();
    }

    private function hydrate(array $row): Empleo {
        return Empleo::reconstitute(
            new EmpleoId($row['id']),
            new EmpleoNombre($row['nombre']),
            new EmpleoCategoria($row['categoria']),
            new EmpleoAreaTrabajo($row['area_trabajo']),
            new EmpleoEmpresa($row['empresa']),
            new EmpleoNivel($row['nivel']),
            new EmpleoSueldo((float)$row['sueldo']),
            new EmpleoFunciones($row['funciones']),
            new EmpleoCargoJefe($row['cargo_jefe']),
            new DateTimeImmutable($row['creado_en']),
            new DateTimeImmutable($row['actualizado_en'])
        );
    }
}
