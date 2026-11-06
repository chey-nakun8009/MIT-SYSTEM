<footer class="admin-footer">
    <div class="container-fluid">
        <div class="d-flex justify-content-end align-items-center gap-3">
            <p class="mb-0 text-muted fw-bold">
                © {{ date('Y') }} {{ setting('system_name', 'MTI SYSTEM') }}
            </p>

            <p class="mb-0 text-muted fw-bold" id="cambodia-datetime">
                <i class="bi bi-clock me-1"></i> Loading...
            </p>
        </div>
    </div>
</footer>

<script>
    function updateCambodiaDateTime() {
        const formatted = new Intl.DateTimeFormat('en-GB', {
            timeZone: 'Asia/Phnom_Penh',
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: true
        }).format(new Date());

        document.getElementById('cambodia-datetime').innerHTML =
            '<i class="bi bi-clock me-1"></i>' + formatted;
    }

    updateCambodiaDateTime();
    setInterval(updateCambodiaDateTime, 1000);
</script>
