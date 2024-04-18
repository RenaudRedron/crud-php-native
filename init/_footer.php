<!-- ---------------------------------- -->
</main>
<footer class="text-center bg-success text-white p-4 w-100 h-100">
    <?php
    if (isset($_SESSION['user'])) {
        if ($_SESSION['user']['role'] == 'admin') {
            ?>
            <a class="nav-link text-white link-warning m-2" href="dashboard.php">Panneau d'administration</a>
        <?php
        }
    }
    ?>
    <p>
        Copyright 2024
    </p>
</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>