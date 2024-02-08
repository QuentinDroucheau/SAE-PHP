let form = document.querySelector("#login-form");

form.addEventListener("submit", function(e){
    let pseudo = document.querySelector("#login-pseudo");
    let password = document.querySelector("#login-password");

    if(pseudo.value == "" || password.value == ""){
        alert("Veuillez remplir tous les champs");
        return false;
    }

    $.ajax({
        url: "/login",
        type: "POST",
        async: false,
        data: {
            "login-pseudo": pseudo.value,
            "login-password": password.value,
            "action": "ajaxValideForm"
        },
        success: function(reponse){
            let obj = JSON.parse(reponse);
            console.log(obj);
        }
    });
});