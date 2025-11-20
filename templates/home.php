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
                    <div class="option_category_input">Réception</div>
                    <div class="option_category_input">Télévision</div>
                    <div class="option_category_input">Concert</div>
                    <div class="option_category_input">Mariage</div>
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

    <article class="galerie_photos">
        <?php while ( have_posts() ) : the_post(); ?>
            <div class="photo_item">
                <img src="<?php the_field('singlephoto'); ?>" 
                    alt="<?php the_field('titre'); ?>">
                <p>RÉFÉRENCE : <?php the_field('reference'); ?></p>
                <p>CATÉGORIE : <?php the_field('categories'); ?></p>
            </div>

    <!-- besoin d'intégrer le format récuperer sous forme d'élément HTML pour l'utiliser dans les filtres, same pour date ? -->       
                <!-- <div class="photo_INFOS_PHANTOM" style="display:none;">
                    <?php //the_field('format'); ?>
                <p>FORMAT : <?php //the_field('format'); ?></p>
                <p>TYPE : <?php //the_field('type'); ?></p>
                <p>ANNÉE : <?php //the_field('date'); ?></p>
                </div>
                -->     
            
        <?php endwhile; // end of the loop. ?>
    </article>
</section>

<?php get_footer(); ?>