<?php declare(strict_types=1);
namespace App\Application\Empleo\DeleteEmpleo;

use App\Domain\Empleo\Exception\EmpleoNotFoundException;
use App\Domain\Empleo\Repository\EmpleoRepository;
use App\Domain\Empleo\ValueObject\EmpleoId;

final class DeleteEmpleoHandler {
    public function __construct(private readonly EmpleoRepository $repository) {}

    public function handle(DeleteEmpleoCommand $command): void {
        $id     = new EmpleoId($command->id);
        $empleo = $this->repository->findById($id);

        if ($empleo === null) throw EmpleoNotFoundException::withId($command->id);

        $this->repository->delete($id);
    }
}
