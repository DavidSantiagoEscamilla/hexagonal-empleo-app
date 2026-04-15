<?php declare(strict_types=1);
namespace App\Application\Empleo\ListEmpleos;

use App\Domain\Empleo\Repository\EmpleoRepository;

final class ListEmpleosHandler {
    public function __construct(private readonly EmpleoRepository $repository) {}

    public function handle(ListEmpleosQuery $query): array {
        $total  = $this->repository->countAll($query->search);
        $items  = $this->repository->findAll($query->page, $query->perPage, $query->search);
        $pages  = (int) ceil($total / $query->perPage);

        return [
            'items'      => array_map(fn($e) => $e->toArray(), $items),
            'total'      => $total,
            'page'       => $query->page,
            'per_page'   => $query->perPage,
            'total_pages'=> max(1, $pages),
        ];
    }
}
