<?php

/**
 * Template Name: Home Page
 */

get_header(); 

?>

<section id="primary">
    <hgroup id="content" class="hero_header" role="main">

        <?php while ( have_posts() ) : the_post(); ?>

            <h1 class="hero_title"><?php the_field('herotitle'); ?></h1>

            <img src="<?php the_field('heroimg'); ?>" />

        <?php endwhile; // end of the loop. ?>
</hgroup><!-- #content -->
</section><!-- #primary -->

<section class="galerie_section">
     <div class="galerie_filtre">
        <div class="filter_gauche">
            <div class="category_filter">
                <div class="selected_category">
                    <p>Catégories</p>
                </div>
                <div class="options_category hide">
                    <div data-category="A REMPLACER PAR UN DES CHOIX DE LA CATÉGORIE" class="option_category_input">A REMPLACER PAR LE NOM DU CHOIX</div>
                </div>
            </div>
            <div class="format_filter">
                <div class="selected_format">
                    <p>Formats</p>
                </div>
                <div class="options_format hide">
                    <div class="option_format_input">Portrait</div>
                    <div class="option_format_input">Paysage</div>
                    <div class="option_format_input">1/1</div>
                    <div class="option_format_input">4/4</div>
                </div>
            </div>
        </div>
        <div class="date_filter">
            <div class="selected_date">
                <p>Trier par</p>
            </div>
            <div class="options_date hide">
                <div class="option_date_input">À partir des plus récentes</div>
                <div class="option_date_input">À partir des plus anciennes</div>
            </div>
        </div>
    </div>

    <div class="galerie_photos" id="gallery">
        <!-- compléter avec script.js pour la galerie d'éléments photo de CPT UI-->
    </div>
</section>

<?php get_footer(); ?>