<?php declare(strict_types=1);
namespace App\Application\Empleo\CreateEmpleo;

use App\Domain\Empleo\Entity\Empleo;
use App\Domain\Empleo\Repository\EmpleoRepository;
use App\Domain\Empleo\ValueObject\{EmpleoNombre, EmpleoCategoria, EmpleoAreaTrabajo, EmpleoEmpresa, EmpleoNivel, EmpleoSueldo, EmpleoFunciones, EmpleoCargoJefe};

final class CreateEmpleoHandler {
    public function __construct(private readonly EmpleoRepository $repository) {}

    public function handle(CreateEmpleoCommand $command): string {
        $id = $this->repository->nextId();

        $empleo = Empleo::create(
            $id,
            new EmpleoNombre($command->nombre),
            new EmpleoCategoria($command->categoria),
            new EmpleoAreaTrabajo($command->areaTrabajo),
            new EmpleoEmpresa($command->empresa),
            new EmpleoNivel($command->nivel),
            new EmpleoSueldo($command->sueldo),
            new EmpleoFunciones($command->funciones),
            new EmpleoCargoJefe($command->cargoJefe)
        );

        $this->repository->save($empleo);

        return $id->value();
    }
}
