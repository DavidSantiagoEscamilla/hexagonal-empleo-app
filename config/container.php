<?php declare(strict_types=1);

use App\Application\Empleo\CreateEmpleo\CreateEmpleoHandler;
use App\Application\Empleo\UpdateEmpleo\UpdateEmpleoHandler;
use App\Application\Empleo\DeleteEmpleo\DeleteEmpleoHandler;
use App\Application\Empleo\GetEmpleo\GetEmpleoHandler;
use App\Application\Empleo\ListEmpleos\ListEmpleosHandler;
use App\Infrastructure\Http\Controller\Auth\AuthController;
use App\Infrastructure\Http\Controller\Empleo\EmpleoController;
use App\Infrastructure\Persistence\MySQL\MySQLEmpleoRepository;

$empleoRepository    = new MySQLEmpleoRepository();
$createEmpleoHandler = new CreateEmpleoHandler($empleoRepository);
$updateEmpleoHandler = new UpdateEmpleoHandler($empleoRepository);
$deleteEmpleoHandler = new DeleteEmpleoHandler($empleoRepository);
$getEmpleoHandler    = new GetEmpleoHandler($empleoRepository);
$listEmpleosHandler  = new ListEmpleosHandler($empleoRepository);

$empleoController = new EmpleoController(
    $createEmpleoHandler,
    $updateEmpleoHandler,
    $deleteEmpleoHandler,
    $getEmpleoHandler,
    $listEmpleosHandler
);

$authController = new AuthController();

return compact('empleoController', 'authController');
