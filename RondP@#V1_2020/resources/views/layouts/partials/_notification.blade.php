<script>
    "use strict";

    toastr.options.closeButton = true;

    @if(session('success'))
    notify('success', "{{ session('success') }}")
    @endif

    @if(session('info'))
    notify("info", "{{ session('info') }}")
    @endif

    @if(session('error'))
    notify("error", "{{ session('error') }}")
    @endif

    // success, error, info
    function notify(sign, message) {
        const sessionId = "{{ uniqid() }}";
        if (sessionStorage) {
            if (!sessionStorage.getItem('shown-' + sessionId)) {
                if (sign ===  "success") {
                    success(message)
                }
                if (sign === "error") {
                    error(message)
                }
                if (sign === "info") {
                    info(message)
                }
            }
            sessionStorage.setItem('shown-' + sessionId, '1');
        }
    }

    function success(message) {
        toastr.success(message);
    }

    function error(message) {
        toastr.error(message);
    }

    function info(message) {
        toastr.info(message);
    }

    // Toast
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

    function alert_sweet_success(message) {
        Toast.fire({
            icon: 'success',
            type: 'success',
            title: message
        });
    }

    function alert_sweet_error(message) {
        Toast.fire({
            icon: 'error',
            type: 'error',
            title: message
        });
    }
</script>
