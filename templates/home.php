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
                <label for="format">Formats</label>
                <select id="format" name="format">
                    <option value="reception">Portrait</option>
                    <option value="television">Paysage</option>
                    <option value="concert">1/1</option>
                    <option value="mariage">4/4</option>
                </select>
            </div>
        </div>
        <div class="trier_filter">
            <label for="tri">Trier par </label>
            <select id="tri" name="tri">
                <option value="recentes">À partir des plus récentes</option>
                <option value="anciennes">À partir des plus anciennes</option>
            </select>
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