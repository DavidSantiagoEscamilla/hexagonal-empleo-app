<?php declare(strict_types=1);
namespace App\Domain\Empleo\ValueObject;
use App\Domain\Empleo\Exception\InvalidEmpleoDataException;
final class EmpleoEmpresa {
    private string $value;
    public function __construct(string $value) {
        $value = trim($value);
        if (empty($value)) throw new InvalidEmpleoDataException('La empresa no puede estar vacía.');
        if (strlen($value) > 150) throw new InvalidEmpleoDataException('La empresa no puede superar los 150 caracteres.');
        $this->value = $value;
    }
    public function value(): string { return $this->value; }
}
