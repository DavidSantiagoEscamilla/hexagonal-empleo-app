<?php declare(strict_types=1);
namespace App\Domain\Empleo\ValueObject;
use App\Domain\Empleo\Exception\InvalidEmpleoIdException;

final class EmpleoId {
    private string $value;
    public function __construct(string $value) {
        if (empty(trim($value))) throw new InvalidEmpleoIdException('El ID del empleo no puede estar vacío.');
        $this->value = $value;
    }
    public static function generate(): self { return new self(bin2hex(random_bytes(8))); }
    public function value(): string { return $this->value; }
    public function equals(self $other): bool { return $this->value === $other->value; }
}
