
</div><!-- /.container -->
</main>

<!-- Delete confirmation modal -->
<div class="modal-overlay" id="deleteModal">
    <div class="modal">
        <h3>⚠️ Confirmar eliminación</h3>
        <p>¿Estás seguro de que deseas eliminar este empleo? Esta acción no se puede deshacer.</p>
        <div class="modal__actions">
            <button class="btn btn-secondary" onclick="closeModal()">Cancelar</button>
            <form method="POST" action="/empleos/eliminar" id="deleteForm">
                <input type="hidden" name="id" id="deleteId">
                <button type="submit" class="btn btn-danger">Eliminar</button>
            </form>
        </div>
    </div>
</div>

<footer>
    <p>EmpleoApp &copy; <?= date('Y') ?> &mdash; DDD + Arquitectura Hexagonal en PHP</p>
</footer>

<script>
function confirmDelete(id, nombre) {
    document.getElementById('deleteId').value = id;
    document.getElementById('deleteModal').classList.add('open');
}
function closeModal() {
    document.getElementById('deleteModal').classList.remove('open');
}
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeModal();
});
</script>
</body>
</html>
