<?php declare(strict_types=1);
namespace App\Domain\Empleo\ValueObject;
use App\Domain\Empleo\Exception\InvalidEmpleoDataException;
final class EmpleoSueldo {
    private float $value;
    public function __construct(float $value) {
        if ($value < 0) throw new InvalidEmpleoDataException('El sueldo no puede ser negativo.');
        if ($value > 999999999) throw new InvalidEmpleoDataException('El sueldo ingresado excede el máximo permitido.');
        $this->value = $value;
    }
    public function value(): float { return $this->value; }
    public function formatted(): string { return number_format($this->value, 2, ',', '.'); }
}
