<?php require __DIR__ . '/../layout/header.php'; ?>

<?php
$nivelColor = [
    'Junior'      => 'badge-blue',
    'Semi-Senior' => 'badge-green',
    'Senior'      => 'badge-amber',
    'Lead'        => 'badge-purple',
    'Manager'     => 'badge-red',
    'Director'    => 'badge-red',
];
?>

<div class="page-header">
    <h1>Detalle del <span>Empleo</span></h1>
    <div style="display:flex;gap:.75rem;">
        <a href="/empleos/editar?id=<?= urlencode($empleo['id']) ?>" class="btn btn-secondary">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            Editar
        </a>
        <a href="/empleos" class="btn btn-ghost">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
            Volver
        </a>
    </div>
</div>

<div class="card">

    <!-- Header del cargo -->
    <div style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:2rem;padding-bottom:1.5rem;border-bottom:1px solid var(--border)">
        <div>
            <h2 style="font-family:'Syne',sans-serif;font-size:1.5rem;font-weight:700;margin-bottom:.35rem">
                <?= htmlspecialchars($empleo['nombre']) ?>
            </h2>
            <p style="color:var(--muted);font-size:.95rem">
                <?= htmlspecialchars($empleo['empresa']) ?>
                &nbsp;·&nbsp;
                <?= htmlspecialchars($empleo['area_trabajo']) ?>
            </p>
        </div>
        <div style="display:flex;gap:.6rem;align-items:center;flex-wrap:wrap;">
            <span class="badge badge-default"><?= htmlspecialchars($empleo['categoria']) ?></span>
            <span class="badge <?= $nivelColor[$empleo['nivel']] ?? 'badge-default' ?>">
                <?= htmlspecialchars($empleo['nivel']) ?>
            </span>
        </div>
    </div>

    <!-- Sueldo destacado -->
    <div style="margin-bottom:2rem;">
        <div class="detail-item__label">Sueldo mensual</div>
        <div class="sueldo-display">$ <?= number_format((float)$empleo['sueldo'], 0, ',', '.') ?> COP</div>
    </div>

    <!-- Grid de detalles -->
    <div class="detail-grid">

        <div class="detail-item">
            <div class="detail-item__label">Categoría</div>
            <div class="detail-item__value"><?= htmlspecialchars($empleo['categoria']) ?></div>
        </div>

        <div class="detail-item">
            <div class="detail-item__label">Área de trabajo</div>
            <div class="detail-item__value"><?= htmlspecialchars($empleo['area_trabajo']) ?></div>
        </div>

        <div class="detail-item">
            <div class="detail-item__label">Empresa</div>
            <div class="detail-item__value"><?= htmlspecialchars($empleo['empresa']) ?></div>
        </div>

        <div class="detail-item">
            <div class="detail-item__label">Nivel</div>
            <div class="detail-item__value"><?= htmlspecialchars($empleo['nivel']) ?></div>
        </div>

        <div class="detail-item">
            <div class="detail-item__label">Cargo del jefe directo</div>
            <div class="detail-item__value"><?= htmlspecialchars($empleo['cargo_jefe']) ?></div>
        </div>

        <div class="detail-item">
            <div class="detail-item__label">Registrado el</div>
            <div class="detail-item__value" style="font-size:.88rem;color:var(--muted)">
                <?= (new DateTime($empleo['creado_en']))->format('d/m/Y H:i') ?>
            </div>
        </div>

        <div class="detail-item detail-item--full">
            <div class="detail-item__label">Funciones y responsabilidades</div>
            <div class="detail-item__value" style="line-height:1.75;color:var(--muted);white-space:pre-wrap;font-size:.9rem;margin-top:.5rem">
                <?= htmlspecialchars($empleo['funciones']) ?>
            </div>
        </div>

    </div><!-- /.detail-grid -->

    <!-- Danger zone -->
    <div style="margin-top:2.5rem;padding-top:1.5rem;border-top:1px solid var(--border);display:flex;justify-content:flex-end;">
        <button
            class="btn btn-danger btn-sm"
            onclick="confirmDelete('<?= htmlspecialchars($empleo['id']) ?>','<?= htmlspecialchars(addslashes($empleo['nombre'])) ?>')"
        >
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
            Eliminar este empleo
        </button>
    </div>

</div><!-- /.card -->

<?php require __DIR__ . '/../layout/footer.php'; ?>
