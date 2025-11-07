

<?php 
// Fichier: modale_contact.php 
// Ce fichier NE doit contenir que le HTML de la modale
?>
<div id="modale-contact-form" class="modale-ajax modale-visible">
    <div class="modale-content">
        <button class="close-button">&times;</button>
        <h2>Contactez-nous</h2>
        <?php
        // Affichage du formulaire Contact Form 7
        echo do_shortcode( '[contact-form-7 id="123" title="Formulaire de contact 1"]' );
        ?>
    </div>
</div>