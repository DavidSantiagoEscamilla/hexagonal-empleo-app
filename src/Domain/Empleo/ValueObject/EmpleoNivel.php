<?php declare(strict_types=1);
namespace App\Domain\Empleo\ValueObject;
use App\Domain\Empleo\Exception\InvalidEmpleoDataException;
final class EmpleoNivel {
    private const VALID = ['Junior','Semi-Senior','Senior','Lead','Manager','Director'];
    private string $value;
    public function __construct(string $value) {
        $value = trim($value);
        if (!in_array($value, self::VALID, true)) throw new InvalidEmpleoDataException("Nivel '$value' no válido.");
        $this->value = $value;
    }
    public function value(): string { return $this->value; }
    public static function valid(): array { return self::VALID; }
}
