<?php
/**
 * Template Name: Modale Contact
 */

get_header(); 
?>

 <section class="modale_contact" id="modale_contact">
    <div class="modale-content">
        <div class="titre">CONTACT</div>
        <form>
            <article>
                <label for="name">Nom :</label>
                <input type="text" id="name" name="name" required />
            </article>
            <article>
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required />
            </article>
            <article>
                <label for="reference">Ref. Photo :</label>
                <input type="text" id="reference" name="reference" required />
            </article>
            <article>
                <label for="message">Message :</label>
                <input type="text" id="message" name="message" class="messageLong"/>
            </article>
            <button type="submit" class="submit-button">Envoyer</button>
        </form>
    </div>
</section>