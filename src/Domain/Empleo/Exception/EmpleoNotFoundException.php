<?php declare(strict_types=1);
namespace App\Domain\Empleo\Exception;
use DomainException;
final class EmpleoNotFoundException extends DomainException {
    public static function withId(string $id): self {
        return new self("Empleo con ID '$id' no encontrado.");
    }
}
