<link rel="stylesheet" href="styles/header.css">
<header class="header">
    <div class="left">
        <div class="container">
            <img class="logo" src="img/logo.png" alt="">
            <div class="search-bar">
                <div class="icon_search">
                    <img src="img/search.png" alt="">
                </div>
                <input type="text" placeholder="Cherchez des albums/artistes...">
            </div>
        </div>
        <div class="publier">
            <img class="icon_publier" src="img/icon_publier.png" alt="">
            <a href="">PUBLIER</a>
        </div>
    </div>
    <div class="right">
        <div class="notif">
            <img class="notif-icon" src="img/notif.png" alt="">
            <div class="nb-notif">
                <p>3</p>
            </div>
        </div>
        <div class="profil">
            <div class="testt">
            <?php

                use utils\Utils;

                if(Utils::isConnected()){
                    echo "<a onclick='openLogin();'>".Utils::getConnexion()->getPseudoU()."</a>";
                }else{
                    echo "<a onclick='openLogin();'>Connexion</a>";
                }
            ?>
            </div>
            
            
            <img class="profil-icon" src="img/profil.png" alt="">
        </div>
    </div>
</header>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    function openLogin(){
        let right = document.querySelector('.testt');
        $.ajax({
            url: "/login",
            type: "POST",
            async: false,
            data: {
                "action": "ajaxGetLoginForm"
            },
            success: function(reponse){
                let obj = JSON.parse(reponse);
                right.innerHTML = obj + right.innerHTML;
            }
        });
    }
</script>