<?php declare(strict_types=1);

namespace Tests\Unit\Application;

use App\Application\Empleo\CreateEmpleo\{CreateEmpleoCommand, CreateEmpleoHandler};
use App\Application\Empleo\DeleteEmpleo\{DeleteEmpleoCommand, DeleteEmpleoHandler};
use App\Application\Empleo\GetEmpleo\{GetEmpleoQuery, GetEmpleoHandler};
use App\Application\Empleo\ListEmpleos\{ListEmpleosQuery, ListEmpleosHandler};
use App\Application\Empleo\UpdateEmpleo\{UpdateEmpleoCommand, UpdateEmpleoHandler};
use App\Domain\Empleo\Entity\Empleo;
use App\Domain\Empleo\Exception\EmpleoNotFoundException;
use App\Domain\Empleo\Repository\EmpleoRepository;
use App\Domain\Empleo\ValueObject\{
    EmpleoId, EmpleoNombre, EmpleoCategoria, EmpleoAreaTrabajo,
    EmpleoEmpresa, EmpleoNivel, EmpleoSueldo, EmpleoFunciones, EmpleoCargoJefe
};
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class EmpleoHandlersTest extends TestCase
{
    private EmpleoRepository&MockObject $repo;

    protected function setUp(): void
    {
        $this->repo = $this->createMock(EmpleoRepository::class);
    }

    // ── Helpers ───────────────────────────────────────────────────

    private function fakeId(): EmpleoId { return new EmpleoId('aabbccddeeff1122'); }

    private function fakeEmpleo(): Empleo
    {
        return Empleo::create(
            $this->fakeId(),
            new EmpleoNombre('Dev Senior'),
            new EmpleoCategoria('Tecnología'),
            new EmpleoAreaTrabajo('Backend'),
            new EmpleoEmpresa('Corp'),
            new EmpleoNivel('Senior'),
            new EmpleoSueldo(7000000),
            new EmpleoFunciones('Desarrollar.'),
            new EmpleoCargoJefe('CTO')
        );
    }

    private function createCmd(string $nombre = 'Dev Senior'): CreateEmpleoCommand
    {
        return new CreateEmpleoCommand($nombre, 'Tecnología', 'Backend', 'Corp', 'Senior', 7000000, 'Desarrollar.', 'CTO');
    }

    // ── Create ────────────────────────────────────────────────────

    public function test_create_llama_save_y_retorna_id(): void
    {
        $this->repo->expects($this->once())->method('nextId')->willReturn($this->fakeId());
        $this->repo->expects($this->once())->method('save');

        $handler = new CreateEmpleoHandler($this->repo);
        $id = $handler->handle($this->createCmd());

        $this->assertSame('aabbccddeeff1122', $id);
    }

    // ── Update ────────────────────────────────────────────────────

    public function test_update_modifica_empleo_existente(): void
    {
        $empleo = $this->fakeEmpleo();
        $this->repo->method('findById')->willReturn($empleo);
        $this->repo->expects($this->once())->method('save')->with($empleo);

        $cmd = new UpdateEmpleoCommand('aabbccddeeff1122', 'Tech Lead', 'Tecnología', 'Arquitectura', 'Corp', 'Lead', 9000000, 'Liderar.', 'CEO');
        (new UpdateEmpleoHandler($this->repo))->handle($cmd);

        $this->assertSame('Tech Lead', $empleo->nombre()->value());
    }

    public function test_update_lanza_excepcion_si_no_existe(): void
    {
        $this->repo->method('findById')->willReturn(null);
        $this->expectException(EmpleoNotFoundException::class);

        $cmd = new UpdateEmpleoCommand('00000000', 'X', 'Tecnología', 'Y', 'Z', 'Junior', 0, 'N/A', 'Jefe');
        (new UpdateEmpleoHandler($this->repo))->handle($cmd);
    }

    // ── Delete ────────────────────────────────────────────────────

    public function test_delete_llama_delete_en_repo(): void
    {
        $this->repo->method('findById')->willReturn($this->fakeEmpleo());
        $this->repo->expects($this->once())->method('delete');

        (new DeleteEmpleoHandler($this->repo))->handle(new DeleteEmpleoCommand('aabbccddeeff1122'));
    }

    public function test_delete_lanza_excepcion_si_no_existe(): void
    {
        $this->repo->method('findById')->willReturn(null);
        $this->expectException(EmpleoNotFoundException::class);

        (new DeleteEmpleoHandler($this->repo))->handle(new DeleteEmpleoCommand('99999999'));
    }

    // ── Get ───────────────────────────────────────────────────────

    public function test_get_retorna_array_del_empleo(): void
    {
        $this->repo->method('findById')->willReturn($this->fakeEmpleo());

        $result = (new GetEmpleoHandler($this->repo))->handle(new GetEmpleoQuery('aabbccddeeff1122'));

        $this->assertSame('Dev Senior', $result['nombre']);
        $this->assertSame(7000000.0, $result['sueldo']);
    }

    public function test_get_lanza_excepcion_si_no_existe(): void
    {
        $this->repo->method('findById')->willReturn(null);
        $this->expectException(EmpleoNotFoundException::class);

        (new GetEmpleoHandler($this->repo))->handle(new GetEmpleoQuery('noexiste'));
    }

    // ── List ──────────────────────────────────────────────────────

    public function test_list_retorna_paginacion_correcta(): void
    {
        $this->repo->method('countAll')->willReturn(25);
        $this->repo->method('findAll')->willReturn([$this->fakeEmpleo()]);

        $result = (new ListEmpleosHandler($this->repo))->handle(new ListEmpleosQuery(1, 10, ''));

        $this->assertSame(25, $result['total']);
        $this->assertSame(3, $result['total_pages']);
        $this->assertCount(1, $result['items']);
    }

    public function test_list_con_resultado_vacio(): void
    {
        $this->repo->method('countAll')->willReturn(0);
        $this->repo->method('findAll')->willReturn([]);

        $result = (new ListEmpleosHandler($this->repo))->handle(new ListEmpleosQuery(1, 10, 'xyz'));

        $this->assertSame(0, $result['total']);
        $this->assertSame(1, $result['total_pages']); // mínimo 1 página
        $this->assertEmpty($result['items']);
    }
}
