// CouponHub - app.js
// Most interaction logic lives in stores/show.blade.php push('scripts')
// This file handles global utilities.

document.addEventListener('DOMContentLoaded', function () {
    // Dismiss alerts automatically after 4 seconds
    document.querySelectorAll('.alert-dismissible').forEach(function (alert) {
        setTimeout(() => {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
            bsAlert.close();
        }, 4000);
    });
});
