<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="js/login.js" defer></script>
<link rel="stylesheet" href="styles/login.css">
<section class="login">
    <section class="top">
        <div class="close">
            <img src="img/close.svg" alt="">
        </div>
        <div class="profil">
            <?php

            use utils\Utils;

            if(Utils::isConnected()){
                echo "<a>".Utils::getConnexion()->getPseudoU()."</a>";
            }else{
                echo "<a>Connexion</a>";
            }

            ?>
            <img class="profil-icon" src="img/profil.png" alt="">
        </div>
    </section>
    <section class="bottom">
        <?php 
            echo $form;
        ?>
    </section>
</section>

