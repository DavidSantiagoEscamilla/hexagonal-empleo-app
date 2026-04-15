<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="page-header">
    <h1>Gestión de <span>Empleos</span></h1>
    <a href="/empleos/crear" class="btn btn-primary">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
        Nuevo Empleo
    </a>
</div>

<!-- Search -->
<form method="GET" action="/empleos" class="search-bar">
    <input
        type="text"
        name="search"
        value="<?= htmlspecialchars($search) ?>"
        placeholder="Buscar por nombre, empresa, categoría o área…"
        autocomplete="off"
    >
    <button type="submit" class="btn btn-secondary">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
        Buscar
    </button>
    <?php if ($search): ?>
        <a href="/empleos" class="btn btn-ghost">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M18 6 6 18M6 6l12 12"/></svg>
            Limpiar
        </a>
    <?php endif; ?>
</form>

<!-- Stats -->
<p class="stats-row">
    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 3H8L2 7h20l-6-4z"/></svg>
    <strong><?= $total ?></strong> empleo<?= $total !== 1 ? 's' : '' ?> encontrado<?= $total !== 1 ? 's' : '' ?>
    <?php if ($search): ?>
        &nbsp;para "<strong><?= htmlspecialchars($search) ?></strong>"
    <?php endif; ?>
</p>

<?php if (empty($empleos)): ?>

<div class="empty-state">
    <span class="empty-state__icon">📭</span>
    <div class="empty-state__title">No hay empleos registrados</div>
    <p>Comienza agregando el primer empleo para gestionar tus oportunidades laborales.</p>
    <a href="/empleos/crear" class="btn btn-primary">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
        Crear primer empleo
    </a>
</div>

<?php else: ?>

<div class="table-wrap">
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Cargo / Empresa</th>
            <th>Categoría</th>
            <th>Área</th>
            <th>Nivel</th>
            <th>Sueldo</th>
            <th>Jefe directo</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    <?php
    $nivelColor = [
        'Junior'      => 'badge-blue',
        'Semi-Senior' => 'badge-green',
        'Senior'      => 'badge-amber',
        'Lead'        => 'badge-purple',
        'Manager'     => 'badge-red',
        'Director'    => 'badge-red',
    ];
    $num = ($page - 1) * 10 + 1;
    foreach ($empleos as $e):
    ?>
    <tr>
        <td class="cell-num"><?= $num++ ?></td>
        <td>
            <div class="cell-nombre"><?= htmlspecialchars($e['nombre']) ?></div>
            <div class="cell-empresa"><?= htmlspecialchars($e['empresa']) ?></div>
        </td>
        <td><span class="badge badge-default"><?= htmlspecialchars($e['categoria']) ?></span></td>
        <td class="cell-area"><?= htmlspecialchars($e['area_trabajo']) ?></td>
        <td>
            <span class="badge <?= $nivelColor[$e['nivel']] ?? 'badge-default' ?>">
                <?= htmlspecialchars($e['nivel']) ?>
            </span>
        </td>
        <td class="cell-sueldo">$ <?= number_format((float)$e['sueldo'], 0, ',', '.') ?></td>
        <td class="cell-area"><?= htmlspecialchars($e['cargo_jefe']) ?></td>
        <td>
            <div class="actions">
                <a href="/empleos/ver?id=<?= urlencode($e['id']) ?>" class="btn btn-ghost btn-sm" title="Ver detalle">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                </a>
                <a href="/empleos/editar?id=<?= urlencode($e['id']) ?>" class="btn btn-secondary btn-sm" title="Editar">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                </a>
                <button
                    class="btn btn-danger btn-sm"
                    title="Eliminar"
                    onclick="confirmDelete('<?= htmlspecialchars($e['id']) ?>','<?= htmlspecialchars(addslashes($e['nombre'])) ?>')"
                >
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                </button>
            </div>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>

<!-- Pagination -->
<?php if ($totalPages > 1): ?>
<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="?page=<?= $page-1 ?>&search=<?= urlencode($search) ?>" title="Anterior">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"/></svg>
        </a>
    <?php else: ?>
        <span class="disabled"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"/></svg></span>
    <?php endif; ?>

    <?php for ($i = max(1, $page-2); $i <= min($totalPages, $page+2); $i++): ?>
        <?php if ($i === $page): ?>
            <span class="active"><?= $i ?></span>
        <?php else: ?>
            <a href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
        <?php endif; ?>
    <?php endfor; ?>

    <?php if ($page < $totalPages): ?>
        <a href="?page=<?= $page+1 ?>&search=<?= urlencode($search) ?>" title="Siguiente">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
        </a>
    <?php else: ?>
        <span class="disabled"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg></span>
    <?php endif; ?>
</div>
<?php endif; ?>

<?php endif; ?>

<?php require __DIR__ . '/../layout/footer.php'; ?>
