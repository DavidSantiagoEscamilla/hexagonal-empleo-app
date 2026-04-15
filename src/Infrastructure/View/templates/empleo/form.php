<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="page-header">
    <h1><?= $empleo ? 'Editar <span>Empleo</span>' : 'Nuevo <span>Empleo</span>' ?></h1>
    <a href="/empleos" class="btn btn-ghost">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
        Volver al listado
    </a>
</div>

<div class="card">
    <form method="POST" action="<?= htmlspecialchars($action) ?>">
        <?php if ($empleo): ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars($empleo['id']) ?>">
        <?php endif; ?>

        <div class="form-grid">

            <!-- Nombre -->
            <div class="form-group">
                <label for="nombre">Nombre del cargo *</label>
                <input
                    type="text"
                    id="nombre"
                    name="nombre"
                    value="<?= htmlspecialchars($empleo['nombre'] ?? '') ?>"
                    placeholder="Ej: Desarrollador Backend"
                    required
                    maxlength="150"
                >
            </div>

            <!-- Empresa -->
            <div class="form-group">
                <label for="empresa">Empresa *</label>
                <input
                    type="text"
                    id="empresa"
                    name="empresa"
                    value="<?= htmlspecialchars($empleo['empresa'] ?? '') ?>"
                    placeholder="Ej: TechCorp S.A."
                    required
                    maxlength="150"
                >
            </div>

            <!-- Categoría -->
            <div class="form-group">
                <label for="categoria">Categoría *</label>
                <select id="categoria" name="categoria" required>
                    <option value="">— Seleccionar —</option>
                    <?php foreach ($categorias as $cat): ?>
                        <option value="<?= $cat ?>" <?= ($empleo['categoria'] ?? '') === $cat ? 'selected' : '' ?>>
                            <?= $cat ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Área de trabajo -->
            <div class="form-group">
                <label for="area_trabajo">Área de trabajo *</label>
                <input
                    type="text"
                    id="area_trabajo"
                    name="area_trabajo"
                    value="<?= htmlspecialchars($empleo['area_trabajo'] ?? '') ?>"
                    placeholder="Ej: Desarrollo de Software"
                    required
                    maxlength="100"
                >
            </div>

            <!-- Nivel -->
            <div class="form-group">
                <label for="nivel">Nivel *</label>
                <select id="nivel" name="nivel" required>
                    <option value="">— Seleccionar —</option>
                    <?php foreach ($niveles as $niv): ?>
                        <option value="<?= $niv ?>" <?= ($empleo['nivel'] ?? '') === $niv ? 'selected' : '' ?>>
                            <?= $niv ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Sueldo -->
            <div class="form-group">
                <label for="sueldo">Sueldo (COP) *</label>
                <input
                    type="number"
                    id="sueldo"
                    name="sueldo"
                    value="<?= htmlspecialchars((string)($empleo['sueldo'] ?? '')) ?>"
                    placeholder="Ej: 3500000"
                    required
                    min="0"
                    step="any"
                >
            </div>

            <!-- Cargo Jefe -->
            <div class="form-group">
                <label for="cargo_jefe">Cargo del jefe directo *</label>
                <input
                    type="text"
                    id="cargo_jefe"
                    name="cargo_jefe"
                    value="<?= htmlspecialchars($empleo['cargo_jefe'] ?? '') ?>"
                    placeholder="Ej: CTO / Gerente de Tecnología"
                    required
                    maxlength="150"
                >
            </div>

            <!-- Funciones (full width) -->
            <div class="form-group full">
                <label for="funciones">Funciones y responsabilidades *</label>
                <textarea
                    id="funciones"
                    name="funciones"
                    rows="5"
                    placeholder="Describe las principales funciones del cargo…"
                    required
                ><?= htmlspecialchars($empleo['funciones'] ?? '') ?></textarea>
            </div>

        </div><!-- /.form-grid -->

        <div class="form-actions">
            <a href="/empleos" class="btn btn-ghost">Cancelar</a>
            <button type="submit" class="btn btn-primary">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v14a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                <?= $empleo ? 'Guardar cambios' : 'Crear empleo' ?>
            </button>
        </div>
    </form>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
