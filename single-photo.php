<?php

/**
 * Template Name: Single Photo Page
 */

get_header(); 

?>

<section class="single_photo_section">
    <div class="photo_container">
        <?php while ( have_posts() ) : the_post(); ?>
            <div class="photo_informations">
                <h2><?php the_field('titre'); ?></h2>
                <p>RÉFÉRENCE : <?php the_field('reference'); ?></p>
                <p>CATÉGORIE : <?php the_field('categories'); ?></p>
                <p>FORMAT : <?php the_field('format'); ?></p>
                <p>TYPE : <?php the_field('type'); ?></p>
                <p>ANNÉE : <?php the_field('date'); ?></p>
            </div>
            <div class="photo_showcase">
            <img src="<?php the_field('singlephoto'); ?>" 
                    alt="<?php the_field('titre'); ?>">
            </div>
        <?php endwhile; // end of the loop. ?>
    </div>
    <div class="more">
        <div class="cta_button">
            <p>Cette photo vous intéresse ? </p>
            <span class="contact_cta"
                data-reference="<?php the_field('reference'); ?>"
                >
                Contact 
            </span>
        </div>
        <div class="preview_next">
            <img src="<?php  the_field('singlephoto')?>" alt="Aperçu de la photo suivante" class="preview_image">
            <div class="arrows_navigation">
                <a href="<?php //fleche preview ?>" class="preview_arrow">               
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/left_arrow.svg" alt="Précédente">                         
                </a>
                <a href="<?php //fleche next ?>" class="next_arrow">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/right_arrow.svg" alt="Suivante">      

                </a>
            </div> 
        </div>
    </div>
    <p><?php the_content(); ?></p>
</section>

<section class="other_photos_section">
    <h3>Vous aimerez aussi </h2>
    <div class="other_photos_container">
        <a href="<?php //lien vers la photo 1 ?>" class="other_photo_item">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/nathalie-1.jpeg" alt="Photo 1">
        </a>
        <a href="<?php //lien vers la photo 2 ?>" class="other_photo_item">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/nathalie-2.jpeg" alt="Photo 2">
        </a>
    </div>
</section>
<?php get_footer(); ?>