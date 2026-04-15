<?php declare(strict_types=1);
namespace App\Application\Empleo\DeleteEmpleo;

final class DeleteEmpleoCommand {
    public function __construct(public readonly string $id) {}
}
