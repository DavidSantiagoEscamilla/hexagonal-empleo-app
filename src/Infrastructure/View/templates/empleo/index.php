<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="page-header">
    <h1>Gestión de <span>Empleos</span></h1>
    <a href="/empleos/crear" class="btn btn-primary">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
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
    <button type="submit" class="btn btn-secondary">Buscar</button>
    <?php if ($search): ?>
        <a href="/empleos" class="btn btn-ghost">✕ Limpiar</a>
    <?php endif; ?>
</form>

<!-- Stats row -->
<p style="font-size:.85rem;color:var(--muted);margin-bottom:1rem;">
    <?= $total ?> empleo<?= $total !== 1 ? 's' : '' ?> encontrado<?= $total !== 1 ? 's' : '' ?>
    <?= $search ? ' para "<strong style="color:var(--white)">' . htmlspecialchars($search) . '</strong>"' : '' ?>
</p>

<?php if (empty($empleos)): ?>
<div class="empty-state">
    <div class="empty-state__icon">📭</div>
    <div class="empty-state__title">No hay empleos registrados</div>
    <p style="margin-bottom:1.5rem">Comienza creando el primer registro.</p>
    <a href="/empleos/crear" class="btn btn-primary">Crear Empleo</a>
</div>
<?php else: ?>

<div class="table-wrap">
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Nombre / Empresa</th>
            <th>Categoría</th>
            <th>Área</th>
            <th>Nivel</th>
            <th>Sueldo</th>
            <th>Cargo Jefe</th>
            <th>Acciones</th>
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
        <td style="color:var(--muted);font-size:.8rem;"><?= $num++ ?></td>
        <td>
            <div style="font-weight:500;color:var(--white)"><?= htmlspecialchars($e['nombre']) ?></div>
            <div style="font-size:.78rem;color:var(--muted)"><?= htmlspecialchars($e['empresa']) ?></div>
        </td>
        <td><span class="badge badge-default"><?= htmlspecialchars($e['categoria']) ?></span></td>
        <td style="font-size:.85rem"><?= htmlspecialchars($e['area_trabajo']) ?></td>
        <td>
            <span class="badge <?= $nivelColor[$e['nivel']] ?? 'badge-default' ?>">
                <?= htmlspecialchars($e['nivel']) ?>
            </span>
        </td>
        <td style="font-family:'Syne',sans-serif;color:var(--amber);font-weight:600;white-space:nowrap">
            $ <?= number_format((float)$e['sueldo'], 0, ',', '.') ?>
        </td>
        <td style="font-size:.85rem;color:var(--muted)"><?= htmlspecialchars($e['cargo_jefe']) ?></td>
        <td>
            <div class="actions">
                <a href="/empleos/ver?id=<?= urlencode($e['id']) ?>" class="btn btn-ghost btn-sm" title="Ver detalle">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                </a>
                <a href="/empleos/editar?id=<?= urlencode($e['id']) ?>" class="btn btn-secondary btn-sm" title="Editar">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                </a>
                <button
                    class="btn btn-danger btn-sm"
                    title="Eliminar"
                    onclick="confirmDelete('<?= htmlspecialchars($e['id']) ?>','<?= htmlspecialchars(addslashes($e['nombre'])) ?>')"
                >
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
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
        <a href="?page=<?= $page-1 ?>&search=<?= urlencode($search) ?>" title="Anterior">‹</a>
    <?php else: ?>
        <span class="disabled">‹</span>
    <?php endif; ?>

    <?php for ($i = max(1, $page-2); $i <= min($totalPages, $page+2); $i++): ?>
        <?php if ($i === $page): ?>
            <span class="active"><?= $i ?></span>
        <?php else: ?>
            <a href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
        <?php endif; ?>
    <?php endfor; ?>

    <?php if ($page < $totalPages): ?>
        <a href="?page=<?= $page+1 ?>&search=<?= urlencode($search) ?>" title="Siguiente">›</a>
    <?php else: ?>
        <span class="disabled">›</span>
    <?php endif; ?>
</div>
<?php endif; ?>

<?php endif; ?>

<?php require __DIR__ . '/../layout/footer.php'; ?>
