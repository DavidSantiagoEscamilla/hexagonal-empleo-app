<?php declare(strict_types=1);

use App\Application\Empleo\CreateEmpleo\CreateEmpleoHandler;
use App\Application\Empleo\UpdateEmpleo\UpdateEmpleoHandler;
use App\Application\Empleo\DeleteEmpleo\DeleteEmpleoHandler;
use App\Application\Empleo\GetEmpleo\GetEmpleoHandler;
use App\Application\Empleo\ListEmpleos\ListEmpleosHandler;
use App\Infrastructure\Http\Controller\Empleo\EmpleoController;
use App\Infrastructure\Persistence\MySQL\MySQLEmpleoRepository;

// ─── Repositories (adapters) ──────────────────────────────────────────────────
$empleoRepository = new MySQLEmpleoRepository();

// ─── Use-case handlers ────────────────────────────────────────────────────────
$createEmpleoHandler = new CreateEmpleoHandler($empleoRepository);
$updateEmpleoHandler = new UpdateEmpleoHandler($empleoRepository);
$deleteEmpleoHandler = new DeleteEmpleoHandler($empleoRepository);
$getEmpleoHandler    = new GetEmpleoHandler($empleoRepository);
$listEmpleosHandler  = new ListEmpleosHandler($empleoRepository);

// ─── Controllers ──────────────────────────────────────────────────────────────
$empleoController = new EmpleoController(
    $createEmpleoHandler,
    $updateEmpleoHandler,
    $deleteEmpleoHandler,
    $getEmpleoHandler,
    $listEmpleosHandler
);

return compact('empleoController');
