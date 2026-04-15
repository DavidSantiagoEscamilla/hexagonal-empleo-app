<?php declare(strict_types=1);
namespace App\Domain\Empleo\ValueObject;
use App\Domain\Empleo\Exception\InvalidEmpleoDataException;
final class EmpleoFunciones {
    private string $value;
    public function __construct(string $value) {
        $value = trim($value);
        if (empty($value)) throw new InvalidEmpleoDataException('Las funciones no pueden estar vacías.');
        $this->value = $value;
    }
    public function value(): string { return $this->value; }
}
