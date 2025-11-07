<?php

/**
 * Template Name: Single Photo Page
 */

get_header(); 

?>

<section class="single_photo_section">
    <div class="photo_container">
        <div class="photo_showcase">
        <img src="<?php //récupérer l'url de la photo à afficher selon le lien de la photo (VIA TABLEAU PHP AVEC PHOTO1 comme pour TheArtbox ?) ?>" 
                alt="<?php //récupérer le titre ou la description de la photo ?>">
        </div>
        <div class="photo_description">
            <h2><?php //récupérer le titre de la photo ?></h2>
            <p><?php //récupérer la description de la photo ?></p>
        </div>
    </div>
    <div class="cta_button">
        <p>Cette photo vous intéresse ? </p>
        <a href="<?php //lien vers la page de contact ?>" class="contact_cta">Contact</a>
    </div>
</section>

<?php get_footer(); ?>