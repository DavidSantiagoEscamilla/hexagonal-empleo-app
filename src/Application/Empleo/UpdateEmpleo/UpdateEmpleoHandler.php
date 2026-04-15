<?php declare(strict_types=1);
namespace App\Application\Empleo\UpdateEmpleo;

use App\Domain\Empleo\Exception\EmpleoNotFoundException;
use App\Domain\Empleo\Repository\EmpleoRepository;
use App\Domain\Empleo\ValueObject\{EmpleoId, EmpleoNombre, EmpleoCategoria, EmpleoAreaTrabajo, EmpleoEmpresa, EmpleoNivel, EmpleoSueldo, EmpleoFunciones, EmpleoCargoJefe};

final class UpdateEmpleoHandler {
    public function __construct(private readonly EmpleoRepository $repository) {}

    public function handle(UpdateEmpleoCommand $command): void {
        $id     = new EmpleoId($command->id);
        $empleo = $this->repository->findById($id);

        if ($empleo === null) throw EmpleoNotFoundException::withId($command->id);

        $empleo->update(
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
    }
}
