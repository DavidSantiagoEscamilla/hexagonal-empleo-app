<?php declare(strict_types=1);
namespace App\Domain\Empleo\ValueObject;
use App\Domain\Empleo\Exception\InvalidEmpleoDataException;
final class EmpleoCargoJefe {
    private string $value;
    public function __construct(string $value) {
        $value = trim($value);
        if (empty($value)) throw new InvalidEmpleoDataException('El cargo del jefe no puede estar vacío.');
        if (strlen($value) > 150) throw new InvalidEmpleoDataException('El cargo del jefe no puede superar los 150 caracteres.');
        $this->value = $value;
    }
    public function value(): string { return $this->value; }
}
