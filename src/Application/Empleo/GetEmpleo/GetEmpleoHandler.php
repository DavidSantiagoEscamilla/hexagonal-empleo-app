<?php declare(strict_types=1);
namespace App\Application\Empleo\GetEmpleo;

use App\Domain\Empleo\Exception\EmpleoNotFoundException;
use App\Domain\Empleo\Repository\EmpleoRepository;
use App\Domain\Empleo\ValueObject\EmpleoId;

final class GetEmpleoHandler {
    public function __construct(private readonly EmpleoRepository $repository) {}

    public function handle(GetEmpleoQuery $query): array {
        $empleo = $this->repository->findById(new EmpleoId($query->id));

        if ($empleo === null) throw EmpleoNotFoundException::withId($query->id);

        return $empleo->toArray();
    }
}
