<div id="alert-toast" class="position-fixed bottom-0 start-0 w-100 d-none text-end" style="z-index: 9999;">
    <div id="ajax-alert" class="alert rounded-0 border-0 mb-0 shadow-lg py-2 px-3 text-white text-end" role="alert">
        <div class="container-fluid d-flex align-items-center py-0">
            <button type="button" class="btn-close btn-close-white ms-auto btn-sm" aria-label="Close"
                style="font-size: 0.65rem;"></button>
            <div class="d-flex gap-2 align-items-center text-end">
                <span id="alert-message" class="small text-end"></span>
            </div>

        </div>
    </div>
</div>

@if (session('success') || session('error') || session('warning'))
    <script>
        function triggerSessionToast() {
            if (typeof Toast === 'undefined') {
                setTimeout(triggerSessionToast, 50);
                return;
            }

            @if (session('success'))
                Toast.success("{{ session('success') }}");
            @endif

            @if (session('error'))
                Toast.error("{{ session('error') }}");
            @endif

            @if (session('warning'))
                Toast.warning("{{ session('warning') }}");
            @endif
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', triggerSessionToast);
        } else {
            triggerSessionToast();
        }
    </script>
@endif
<style>
    .toast-success {
        background-color: #198754 !important;
        /* Bootstrap Success Green */
    }

    .toast-danger {
        background-color: #dc3545 !important;
        /* Bootstrap Danger Red */
    }

    .toast-warning {
        background-color: #ffc107 !important;
        /* Bootstrap Warning Yellow */
        color: #000 !important;
    }
</style>
