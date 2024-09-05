

<script>
    document.getElementById('toggleButton').addEventListener('click', function() {
        if (element.classList.contains('collapse')) {
            element.classList.remove('collapse');
            element.classList.add('collapse.show');
            // Para garantir que a transição funcione corretamente, altere a altura antes de ocultar
            setTimeout(function() {
                element.style.height = '0';
            }, 500); // 500ms deve corresponder à duração da transição
        } else {
            element.classList.remove('collapse.show');
            element.classList.add('collapse');
            element.style.height = 'auto';
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const flashMessage = document.getElementById('flashMessageEdit');
        if (flashMessageEdit) {
            setTimeout(function() {
                flashMessage.style.display = 'none';
            }, 200000);
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('toggleSidebar').addEventListener('click', function() {
        document.getElementById('sidebar').classList.toggle('collapsed');
        document.getElementById('content').classList.toggle('collapsed');
    });
</script>

</body>

</html>