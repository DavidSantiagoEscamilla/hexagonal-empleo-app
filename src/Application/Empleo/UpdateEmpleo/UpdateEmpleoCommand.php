<?php declare(strict_types=1);
namespace App\Application\Empleo\UpdateEmpleo;

final class UpdateEmpleoCommand {
    public function __construct(
        public readonly string $id,
        public readonly string $nombre,
        public readonly string $categoria,
        public readonly string $areaTrabajo,
        public readonly string $empresa,
        public readonly string $nivel,
        public readonly float  $sueldo,
        public readonly string $funciones,
        public readonly string $cargoJefe
    ) {}
}
