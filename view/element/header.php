<link rel="stylesheet" href="styles/header.css">
<header class="header">
    <div class="left">
        <div class="container">
            <a href="/"><img class="logo" src="img/logo.png" alt=""></a>
            <div class="search-bar">
                <div class="icon_search">
                    <img src="img/search.png" alt="">
                </div>
                <input type="text" placeholder="Cherchez des albums/artistes...">
            </div>
        </div>
        <div class="publier">
            <img class="icon_publier" src="img/icon_publier.png" alt="">
            <a href="/publier">PUBLIER</a>
        </div>
    </div>
    <div class="right">
        <div class="notif">
            <img class="notif-icon" src="img/notif.png" alt="">
            <div class="nb-notif">
                <p>3</p>
            </div>
        </div>
        <div class="profil-container">
            <div class="profil" onclick='openLogin();'>
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
        </div>
    </div>
</header>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    function openLogin(){
        let right = document.querySelector('.profil-container');
        $.ajax({
            url: "/login",
            type: "POST",
            async: false,
            data: {
                "action": "ajaxGetLoginForm"
            },
            success: function(reponse){
                let obj = JSON.parse(reponse);
                let test = document.createElement('div');
                test.innerHTML = obj;
                right.append(test);
                // right.innerHTML = obj + right.innerHTML;
            }
        });
    }
</script>