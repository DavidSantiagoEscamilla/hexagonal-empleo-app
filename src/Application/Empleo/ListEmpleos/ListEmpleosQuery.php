<?php declare(strict_types=1);
namespace App\Application\Empleo\ListEmpleos;

final class ListEmpleosQuery {
    public function __construct(
        public readonly int    $page    = 1,
        public readonly int    $perPage = 10,
        public readonly string $search  = ''
    ) {}
}
