<?php
session_start(); // debut de session
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">
        <img src="images/logo_JO.jpg" alt="Logo" style="height: 40px;">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="billetterie.php">Billet</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Hospitalité</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Transport</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Boutique</a>
            </li>
        </ul>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="../src/php/logout.php" class="btn btn-outline-danger my-2 my-sm-0" type="button">Déconnexion</a>
            <a href="espace_utilisateur.php" class="btn btn-outline-success my-2 my-sm-0" type="button">Espace Utilisateur</a>
        <?php else: ?>
            <a href="espace_utilisateur.php" class="btn btn-outline-success my-2 my-sm-0" type="button">Se connecter</a>
        <?php endif; ?>
    </div>
</nav>

