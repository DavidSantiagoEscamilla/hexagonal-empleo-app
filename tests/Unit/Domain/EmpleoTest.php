<?php declare(strict_types=1);

namespace Tests\Unit\Domain;

use App\Domain\Empleo\Entity\Empleo;
use App\Domain\Empleo\Exception\InvalidEmpleoDataException;
use App\Domain\Empleo\ValueObject\{
    EmpleoId, EmpleoNombre, EmpleoCategoria, EmpleoAreaTrabajo,
    EmpleoEmpresa, EmpleoNivel, EmpleoSueldo, EmpleoFunciones, EmpleoCargoJefe
};
use PHPUnit\Framework\TestCase;

final class EmpleoTest extends TestCase
{
    private function makeEmpleo(): Empleo
    {
        return Empleo::create(
            EmpleoId::generate(),
            new EmpleoNombre('Desarrollador Backend'),
            new EmpleoCategoria('Tecnología'),
            new EmpleoAreaTrabajo('Ingeniería'),
            new EmpleoEmpresa('TechCorp'),
            new EmpleoNivel('Senior'),
            new EmpleoSueldo(6500000),
            new EmpleoFunciones('Desarrollar APIs REST y microservicios.'),
            new EmpleoCargoJefe('CTO')
        );
    }

    // ── Entity ────────────────────────────────────────────────────

    public function test_empleo_se_crea_con_datos_validos(): void
    {
        $empleo = $this->makeEmpleo();

        $this->assertSame('Desarrollador Backend', $empleo->nombre()->value());
        $this->assertSame('Tecnología', $empleo->categoria()->value());
        $this->assertSame(6500000.0, $empleo->sueldo()->value());
    }

    public function test_empleo_puede_actualizarse(): void
    {
        $empleo = $this->makeEmpleo();
        $empleo->update(
            new EmpleoNombre('Tech Lead'),
            new EmpleoCategoria('Tecnología'),
            new EmpleoAreaTrabajo('Arquitectura'),
            new EmpleoEmpresa('NewCorp'),
            new EmpleoNivel('Lead'),
            new EmpleoSueldo(9000000),
            new EmpleoFunciones('Liderar el equipo técnico.'),
            new EmpleoCargoJefe('CTO')
        );

        $this->assertSame('Tech Lead', $empleo->nombre()->value());
        $this->assertSame('Lead', $empleo->nivel()->value());
        $this->assertSame(9000000.0, $empleo->sueldo()->value());
    }

    public function test_empleo_to_array_contiene_todas_las_claves(): void
    {
        $arr = $this->makeEmpleo()->toArray();

        foreach (['id','nombre','categoria','area_trabajo','empresa','nivel','sueldo','funciones','cargo_jefe','creado_en','actualizado_en'] as $key) {
            $this->assertArrayHasKey($key, $arr);
        }
    }

    // ── Value Objects ─────────────────────────────────────────────

    public function test_nombre_vacio_lanza_excepcion(): void
    {
        $this->expectException(InvalidEmpleoDataException::class);
        new EmpleoNombre('   ');
    }

    public function test_nombre_demasiado_largo_lanza_excepcion(): void
    {
        $this->expectException(InvalidEmpleoDataException::class);
        new EmpleoNombre(str_repeat('a', 151));
    }

    public function test_categoria_invalida_lanza_excepcion(): void
    {
        $this->expectException(InvalidEmpleoDataException::class);
        new EmpleoCategoria('Fantasía');
    }

    public function test_nivel_invalido_lanza_excepcion(): void
    {
        $this->expectException(InvalidEmpleoDataException::class);
        new EmpleoNivel('Dios');
    }

    public function test_sueldo_negativo_lanza_excepcion(): void
    {
        $this->expectException(InvalidEmpleoDataException::class);
        new EmpleoSueldo(-1.0);
    }

    public function test_sueldo_cero_es_valido(): void
    {
        $vo = new EmpleoSueldo(0.0);
        $this->assertSame(0.0, $vo->value());
    }

    public function test_id_generado_no_esta_vacio(): void
    {
        $id = EmpleoId::generate();
        $this->assertNotEmpty($id->value());
    }

    public function test_dos_ids_generados_son_distintos(): void
    {
        $this->assertNotSame(EmpleoId::generate()->value(), EmpleoId::generate()->value());
    }

    public function test_sueldo_formateado(): void
    {
        $vo = new EmpleoSueldo(6500000.5);
        $this->assertSame('6.500.000,50', $vo->formatted());
    }
}
