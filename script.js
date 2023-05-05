var navbarToggle = document.querySelector(".navbar-toggler");

$(document).ready(function() {
    $('.navbar-toggler').click(function() {
        $('.collapse').toggle();
    });
});