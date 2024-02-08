<div class="test-profil-container">
    <div class="test-profil" onclick="openProfil();">    
        <a>Connexion</a>
        <img class="test-profil-icon" src="img/profil.png" alt="">
    </div>
    <div class="test-profil2">
        <div class="close">
            <img src="img/close.svg" alt="" onclick="closeProfil();">
        </div>
        <div class="test-profil">    
            <a>Connexion</a>
            <img class="test-profil-icon" src="img/profil.png" alt="">
        </div>
    </div>
</div>
<script>

    function closeProfil(){
        let profil2 = document.querySelector('.test-profil2');
        profil2.removeChild(document.querySelector('#login-form'));

        let close = document.querySelector('.close');
        profil2.removeChild(close);
        
        profil2.style.animation = "closefadeIn 0.4s ease-in-out";

        setTimeout(function(){
            let profil = document.querySelector('.test-profil');
            profil.style.display = "flex";
            profil2.style.display = "none";
            profil2.style.animation = "fadeIn 0.4s ease-in-out";
            profil2.appendChild(close);
        }, 300);
    }

    function openProfil(){
        let profil = document.querySelector('.test-profil');
        profil.style.display = "none";

        let profil2 = document.querySelector('.test-profil2');
        profil2.style.display = "flex";

        $.ajax({
            url: "/login",
            type: "POST",
            async: false,
            data: {
                "action": "ajaxGetLoginForm"
            },
            success: function(reponse){
                let obj = JSON.parse(reponse);
                let form = document.querySelector('.test-profil2');
                setTimeout(function() {
                    form.innerHTML = form.innerHTML + obj;
                    loadScript("js/login.js");
                }, 400);
            }
        });
    }

    function loadScript(src){
        let script = document.createElement('script');
        script.src = src;
        document.head.append(script);
    }

</script>
<style>

@keyframes form {
    0% {
        opacity: 0;
        transform: translateY(-10px);
    }
    100% {
        opacity: 1;
    }
}

#login-form{
    animation: form 0.6s ease-in-out;
    margin-top: 10%;
}

@keyframes closefadeIn {
    0% {
        height: 300px;
        width: 300px;
    }
    100% {
        height: 0px;
        width: 200px;
    }
}

@keyframes fadeIn {
    0% {
        height: 0px;
        width: 200px;
    }
    100% {
        height: 300px;
        width: 300px;
    }
}

.test-profil{
    background-color: var(--couleur1);
    border-radius: 7px;
    width: 200px;
    height: 40px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: absolute;
    right: 0;
    top: 0;
    z-index: 3;
}

#login-form{
    z-index: 3;
}

.test-profil2{
    background-color: var(--couleur1);
    border-radius: 7px;
    width: 300px;
    height: 300px;
    display: flex;
    position: absolute;
    right: 0;
    top: 0;
    display: none;
    animation: fadeIn 0.4s ease-in-out;
    flex-wrap: wrap;
    flex-direction: column;
}


.close{
    display: flex;
    justify-content: center;
    align-items: center;
    height: 40px;
    width: 40px;
}

.test-profil-container{
    position: relative;
    right: -500px;
    top: 100px;
    width: 200px;
    height: 40px;
}

.test-profil, .test-profil, a, img :hover{
    cursor: pointer;
}

.test-profil a, .test-profil2 a{
    color: white;
    text-decoration: none;
    font-size: 20px;
    margin-left: 10%;
}

.test-profil-icon{
    height: 40px;
    width: 40px;
    border-radius: 7px;
    background-color: var(--couleur3);
}
</style>