<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Empleo App') ?> — EmpleoApp</title>
    <link rel="stylesheet" href="/assets/css/app.css">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>💼</text></svg>">
</head>
<body>

<nav class="navbar">
    <a href="/empleos" class="navbar__brand">💼 Empleo<span>App</span></a>
    <div class="navbar__links">
        <a href="/empleos" class="<?= str_starts_with($_SERVER['REQUEST_URI'], '/empleos') ? 'active' : '' ?>">Empleos</a>
        <?php if (!empty($_SESSION['user_id'])): ?>
            <span style="font-size:.82rem;color:var(--muted)">
                <?= htmlspecialchars($_SESSION['user_name'] ?? '') ?>
            </span>
            <a href="/logout">Salir</a>
        <?php else: ?>
            <a href="/login">Iniciar sesión</a>
        <?php endif; ?>
    </div>
</nav>

<main>
<div class="container">

<?php
// Flash message display
if (!empty($_SESSION['flash'])):
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
?>
<div class="flash flash--<?= $flash['type'] === 'success' ? 'success' : 'error' ?>">
    <?= $flash['type'] === 'success' ? '✓' : '✕' ?>
    <?= htmlspecialchars($flash['message']) ?>
</div>
<?php endif; ?>
