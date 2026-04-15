<?php

declare(strict_types=1);

namespace App\Domain\Empleo\Entity;

use App\Domain\Empleo\ValueObject\EmpleoId;
use App\Domain\Empleo\ValueObject\EmpleoNombre;
use App\Domain\Empleo\ValueObject\EmpleoCategoria;
use App\Domain\Empleo\ValueObject\EmpleoAreaTrabajo;
use App\Domain\Empleo\ValueObject\EmpleoEmpresa;
use App\Domain\Empleo\ValueObject\EmpleoNivel;
use App\Domain\Empleo\ValueObject\EmpleoSueldo;
use App\Domain\Empleo\ValueObject\EmpleoFunciones;
use App\Domain\Empleo\ValueObject\EmpleoCargoJefe;
use DateTimeImmutable;

final class Empleo
{
    private function __construct(
        private readonly EmpleoId        $id,
        private EmpleoNombre             $nombre,
        private EmpleoCategoria          $categoria,
        private EmpleoAreaTrabajo        $areaTrabajo,
        private EmpleoEmpresa            $empresa,
        private EmpleoNivel              $nivel,
        private EmpleoSueldo             $sueldo,
        private EmpleoFunciones          $funciones,
        private EmpleoCargoJefe          $cargoJefe,
        private readonly DateTimeImmutable $creadoEn,
        private DateTimeImmutable        $actualizadoEn
    ) {}

    public static function create(
        EmpleoId       $id,
        EmpleoNombre   $nombre,
        EmpleoCategoria $categoria,
        EmpleoAreaTrabajo $areaTrabajo,
        EmpleoEmpresa  $empresa,
        EmpleoNivel    $nivel,
        EmpleoSueldo   $sueldo,
        EmpleoFunciones $funciones,
        EmpleoCargoJefe $cargoJefe
    ): self {
        $now = new DateTimeImmutable();
        return new self($id, $nombre, $categoria, $areaTrabajo, $empresa, $nivel, $sueldo, $funciones, $cargoJefe, $now, $now);
    }

    public static function reconstitute(
        EmpleoId       $id,
        EmpleoNombre   $nombre,
        EmpleoCategoria $categoria,
        EmpleoAreaTrabajo $areaTrabajo,
        EmpleoEmpresa  $empresa,
        EmpleoNivel    $nivel,
        EmpleoSueldo   $sueldo,
        EmpleoFunciones $funciones,
        EmpleoCargoJefe $cargoJefe,
        DateTimeImmutable $creadoEn,
        DateTimeImmutable $actualizadoEn
    ): self {
        return new self($id, $nombre, $categoria, $areaTrabajo, $empresa, $nivel, $sueldo, $funciones, $cargoJefe, $creadoEn, $actualizadoEn);
    }

    public function update(
        EmpleoNombre   $nombre,
        EmpleoCategoria $categoria,
        EmpleoAreaTrabajo $areaTrabajo,
        EmpleoEmpresa  $empresa,
        EmpleoNivel    $nivel,
        EmpleoSueldo   $sueldo,
        EmpleoFunciones $funciones,
        EmpleoCargoJefe $cargoJefe
    ): void {
        $this->nombre       = $nombre;
        $this->categoria    = $categoria;
        $this->areaTrabajo  = $areaTrabajo;
        $this->empresa      = $empresa;
        $this->nivel        = $nivel;
        $this->sueldo       = $sueldo;
        $this->funciones    = $funciones;
        $this->cargoJefe    = $cargoJefe;
        $this->actualizadoEn = new DateTimeImmutable();
    }

    public function id(): EmpleoId            { return $this->id; }
    public function nombre(): EmpleoNombre    { return $this->nombre; }
    public function categoria(): EmpleoCategoria { return $this->categoria; }
    public function areaTrabajo(): EmpleoAreaTrabajo { return $this->areaTrabajo; }
    public function empresa(): EmpleoEmpresa  { return $this->empresa; }
    public function nivel(): EmpleoNivel      { return $this->nivel; }
    public function sueldo(): EmpleoSueldo    { return $this->sueldo; }
    public function funciones(): EmpleoFunciones { return $this->funciones; }
    public function cargoJefe(): EmpleoCargoJefe { return $this->cargoJefe; }
    public function creadoEn(): DateTimeImmutable { return $this->creadoEn; }
    public function actualizadoEn(): DateTimeImmutable { return $this->actualizadoEn; }

    public function toArray(): array
    {
        return [
            'id'           => $this->id->value(),
            'nombre'       => $this->nombre->value(),
            'categoria'    => $this->categoria->value(),
            'area_trabajo' => $this->areaTrabajo->value(),
            'empresa'      => $this->empresa->value(),
            'nivel'        => $this->nivel->value(),
            'sueldo'       => $this->sueldo->value(),
            'funciones'    => $this->funciones->value(),
            'cargo_jefe'   => $this->cargoJefe->value(),
            'creado_en'    => $this->creadoEn->format('Y-m-d H:i:s'),
            'actualizado_en' => $this->actualizadoEn->format('Y-m-d H:i:s'),
        ];
    }
}
