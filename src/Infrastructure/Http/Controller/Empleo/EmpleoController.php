<?php declare(strict_types=1);
namespace App\Infrastructure\Http\Controller\Empleo;

use App\Application\Empleo\CreateEmpleo\CreateEmpleoCommand;
use App\Application\Empleo\CreateEmpleo\CreateEmpleoHandler;
use App\Application\Empleo\UpdateEmpleo\UpdateEmpleoCommand;
use App\Application\Empleo\UpdateEmpleo\UpdateEmpleoHandler;
use App\Application\Empleo\DeleteEmpleo\DeleteEmpleoCommand;
use App\Application\Empleo\DeleteEmpleo\DeleteEmpleoHandler;
use App\Application\Empleo\GetEmpleo\GetEmpleoQuery;
use App\Application\Empleo\GetEmpleo\GetEmpleoHandler;
use App\Application\Empleo\ListEmpleos\ListEmpleosQuery;
use App\Application\Empleo\ListEmpleos\ListEmpleosHandler;
use App\Domain\Empleo\ValueObject\EmpleoCategoria;
use App\Domain\Empleo\ValueObject\EmpleoNivel;
use App\Infrastructure\Http\Controller\BaseController;
use DomainException;

final class EmpleoController extends BaseController {
    public function __construct(
        private readonly CreateEmpleoHandler $createHandler,
        private readonly UpdateEmpleoHandler $updateHandler,
        private readonly DeleteEmpleoHandler $deleteHandler,
        private readonly GetEmpleoHandler    $getHandler,
        private readonly ListEmpleosHandler  $listHandler,
    ) {}

    public function index(): void {
        $this->requireAuth();
        $page   = max(1, (int) $this->get('page', 1));
        $search = trim($this->get('search', ''));

        $result = $this->listHandler->handle(new ListEmpleosQuery($page, 10, $search));

        $this->render('empleo/index', [
            'title'      => 'Gestión de Empleos',
            'empleos'    => $result['items'],
            'total'      => $result['total'],
            'page'       => $result['page'],
            'totalPages' => $result['total_pages'],
            'search'     => $search,
        ]);
    }

    public function create(): void {
        $this->requireAuth();
        $this->render('empleo/form', [
            'title'      => 'Nuevo Empleo',
            'empleo'     => null,
            'categorias' => EmpleoCategoria::valid(),
            'niveles'    => EmpleoNivel::valid(),
            'action'     => '/empleos/guardar',
        ]);
    }

    public function store(): void {
        $this->requireAuth();
        try {
            $command = new CreateEmpleoCommand(
                nombre:      $this->post('nombre'),
                categoria:   $this->post('categoria'),
                areaTrabajo: $this->post('area_trabajo'),
                empresa:     $this->post('empresa'),
                nivel:       $this->post('nivel'),
                sueldo:      (float) $this->post('sueldo', 0),
                funciones:   $this->post('funciones'),
                cargoJefe:   $this->post('cargo_jefe'),
            );
            $this->createHandler->handle($command);
            $this->flashSuccess('Empleo creado exitosamente.');
            $this->redirect('/empleos');
        } catch (DomainException $e) {
            $this->flashError($e->getMessage());
            $this->redirect('/empleos/crear');
        }
    }

    public function edit(): void {
        $this->requireAuth();
        try {
            $empleo = $this->getHandler->handle(new GetEmpleoQuery($this->get('id')));
            $this->render('empleo/form', [
                'title'      => 'Editar Empleo',
                'empleo'     => $empleo,
                'categorias' => EmpleoCategoria::valid(),
                'niveles'    => EmpleoNivel::valid(),
                'action'     => '/empleos/actualizar',
            ]);
        } catch (DomainException $e) {
            $this->flashError($e->getMessage());
            $this->redirect('/empleos');
        }
    }

    public function update(): void {
        $this->requireAuth();
        try {
            $command = new UpdateEmpleoCommand(
                id:          $this->post('id'),
                nombre:      $this->post('nombre'),
                categoria:   $this->post('categoria'),
                areaTrabajo: $this->post('area_trabajo'),
                empresa:     $this->post('empresa'),
                nivel:       $this->post('nivel'),
                sueldo:      (float) $this->post('sueldo', 0),
                funciones:   $this->post('funciones'),
                cargoJefe:   $this->post('cargo_jefe'),
            );
            $this->updateHandler->handle($command);
            $this->flashSuccess('Empleo actualizado exitosamente.');
            $this->redirect('/empleos');
        } catch (DomainException $e) {
            $this->flashError($e->getMessage());
            $this->redirect('/empleos');
        }
    }

    public function show(): void {
        $this->requireAuth();
        try {
            $empleo = $this->getHandler->handle(new GetEmpleoQuery($this->get('id')));
            $this->render('empleo/show', ['title' => 'Detalle del Empleo', 'empleo' => $empleo]);
        } catch (DomainException $e) {
            $this->flashError($e->getMessage());
            $this->redirect('/empleos');
        }
    }

    public function delete(): void {
        $this->requireAuth();
        try {
            $this->deleteHandler->handle(new DeleteEmpleoCommand($this->post('id')));
            $this->flashSuccess('Empleo eliminado exitosamente.');
        } catch (DomainException $e) {
            $this->flashError($e->getMessage());
        }
        $this->redirect('/empleos');
    }
}
