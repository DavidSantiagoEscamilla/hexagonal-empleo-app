<?php declare(strict_types=1);
namespace App\Domain\Empleo\ValueObject;
use App\Domain\Empleo\Exception\InvalidEmpleoDataException;
final class EmpleoAreaTrabajo {
    private string $value;
    public function __construct(string $value) {
        $value = trim($value);
        if (empty($value)) throw new InvalidEmpleoDataException('El área de trabajo no puede estar vacía.');
        if (strlen($value) > 100) throw new InvalidEmpleoDataException('El área de trabajo no puede superar los 100 caracteres.');
        $this->value = $value;
    }
    public function value(): string { return $this->value; }
}
