<style>
    .toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1055;
    }

    .toast {
        opacity: 0;
        transform: translateX(100%);
        transition: all 0.4s ease;
    }

    .toast.show {
        opacity: 1;
        transform: translateX(0);
    }

    .toast.hiding {
        opacity: 0;
        transform: translateX(100%);
    }

    .toast-header {
        display: flex;
        align-items: center;
        padding: 0.5rem 1rem;
        color: #fff;
        background-color: #198754;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        border-top-left-radius: calc(0.375rem - 1px);
        border-top-right-radius: calc(0.375rem - 1px);
    }

    .toast-body {
        padding: 1rem;
        word-wrap: break-word;
    }
</style>

<?php if (isset($_SESSION['success_message'])) : ?>
    <div class="toast-container">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-success text-white">
                <i class="bi bi-check-circle-fill me-2"></i>
                <strong class="me-auto">Success</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                <?= htmlspecialchars($_SESSION['success_message']) ?>
            </div>
        </div>
    </div>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toastEl = document.getElementById('liveToast');
        if (!toastEl) return;

        const toast = new bootstrap.Toast(toastEl, {
            delay: 5000
        });

        toastEl.addEventListener('show.bs.toast', () => {
            toastEl.classList.remove('hiding');
        });

        toastEl.addEventListener('hide.bs.toast', () => {
            toastEl.classList.add('hiding');
        });

        toast.show();
    });
</script>