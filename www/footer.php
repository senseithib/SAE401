<?php
/**
 * Footer template for the BikeStores website.
 *
 * Displays the legal notice link and copyright.
 * Includes Bootstrap JS and a script to close the navbar on navigation link or icon click.
 *
 * @package www
 * @version 1.0
 */
?>
<footer class="bg-black text-white py-4">

        <div class="text-center mt-3">
            <p class="mb-0">&copy; 2025 Bike.<a href="index.php?action=mention">Legal notice</a></p>

          
        </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script>
        document.querySelectorAll('.navbar-nav .nav-link, .icon').forEach(function(element) {
            element.addEventListener('click', function() {
                var navbar = document.getElementById('navbarNav');
                if (navbar.classList.contains('show')) {
                    var bsCollapse = bootstrap.Collapse.getOrCreateInstance(navbar);
                    bsCollapse.hide();
                }
            });
        });
    </script>
</body>

</html>
