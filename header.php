<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Site de Nathalie Mota</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header>
        <div class="nav__logo">
                <a href=" ">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/Logo.png" alt="Logo Mota Photo">
                </a>
        </div>
        <nav class="nav__menu">
            <ul>
                <li><a href="#home">ACCUEIL</a></li>
                <li><a href="#about">À PROPOS</a></li>
                <li><a href="#contact">CONTACT</a></li>
            </ul>
        </nav>
    </header>