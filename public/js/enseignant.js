// Toggle Sidebar
document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function(e) {
            e.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

    // Vérifier l'état du sidebar dans le localStorage
    if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        document.body.classList.add('sb-sidenav-toggled');
    }
});

// Initialiser les tooltips
$(function () {
    $('[data-bs-toggle="tooltip"]').tooltip();
});

// Gestion des messages flash
setTimeout(function() {
    $('.alert').fadeOut('slow');
}, 5000);