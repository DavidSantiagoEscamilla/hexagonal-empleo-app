<?php declare(strict_types=1);
namespace App\Domain\Empleo\Repository;
use App\Domain\Empleo\Entity\Empleo;
use App\Domain\Empleo\ValueObject\EmpleoId;

interface EmpleoRepository {
    public function save(Empleo $empleo): void;
    public function findById(EmpleoId $id): ?Empleo;
    public function findAll(int $page, int $perPage, string $search): array;
    public function countAll(string $search): int;
    public function delete(EmpleoId $id): void;
    public function nextId(): EmpleoId;
}
