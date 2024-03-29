function addLoginFormEvent() {
  let form = document.querySelector("#login-form");
  if (form == null) {
    console.log("login form est null");
    return false;
  }
  form.addEventListener("submit", function (e) {
    let pseudo = document.querySelector("#login-pseudo");
    let password = document.querySelector("#login-password");

    if (pseudo.value == "" || password.value == "") {
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
        action: "ajaxValideLoginForm",
      },
      success: function (reponse) {
        let obj = JSON.parse(reponse);
        if (obj.success == true) {
          window.location.reload();
        }
      },
    });
  });
}

function addInscriptionFormEvent() {
  let form = document.querySelector("#inscription-form");
  if (form == null) {
    console.log("inscription form est null");
    return false;
  }
  form.addEventListener("submit", function (e) {
    let pseudo = document.querySelector("#inscription-pseudo");
    let password = document.querySelector("#inscription-password");
    let passwordc = document.querySelector("#inscription-confirmation");
    let mail = document.querySelector("#inscription-mail");

    $.ajax({
      url: "/login",
      type: "POST",
      async: false,
      data: {
        "inscription-pseudo": pseudo.value,
        "inscription-password": password.value,
        "inscription-confirmation": passwordc.value,
        "inscription-mail": mail.value,
        action: "ajaxValideInscriptionForm",
      },
      success: function (reponse) {
        let obj = JSON.parse(reponse);
        if (obj.success == true) {
          window.location.reload();
        }
      },
    });
  });
}

function addPasswordFormEvent() {
  let form = document.querySelector("#password-form");
  if (form == null) {
    console.log("password form est null");
    return false;
  }
  form.addEventListener("submit", function (e) {
    let old = document.querySelector("#password-old");
    let newP = document.querySelector("#password-new");
    let confirmation = document.querySelector("#password-confirmation");

    if (old.value == "" || newP.value == "" || confirmation.value == "") {
      alert("Veuillez remplir tous les champs");
      return false;
    }

    $.ajax({
      url: "/login",
      type: "POST",
      async: false,
      data: {
        "password-old": old.value,
        "password-new": newP.value,
        "password-confirmation": confirmation.value,
        action: "ajaxValidePasswordForm",
      },
      success: function (reponse) {
        let obj = JSON.parse(reponse);
        console.log(obj);
        if (obj.success == true) {
          window.location.reload();
        }
      },
    });
  });
}

function closeConnexion() {
  let connexion = document.querySelector(".connexion");
  connexion.removeChild(document.querySelector("#login-form"));

  let close = document.querySelector(".connexion .close");
  connexion.removeChild(close);

  connexion.style.animation = "close 0.4s ease-in-out";

  setTimeout(function () {
    let profil = document.querySelector(".profil");
    profil.style.display = "flex";
    connexion.style.display = "none";
    connexion.style.animation = "open 0.4s ease-in-out";
    connexion.appendChild(close);
  }, 300);
}

function closePassword() {
  let password = document.querySelector(".password");
  password.removeChild(document.querySelector("#password-form"));

  let close = document.querySelector(".password .close");
  password.removeChild(close);

  password.style.animation = "close 0.4s ease-in-out";

  setTimeout(function () {
    let profil = document.querySelector(".profil");
    profil.style.display = "flex";
    password.style.display = "none";
    password.style.animation = "open 0.4s ease-in-out";
    password.appendChild(close);
  }, 300);
}

function openPassword() {
  let elem = document.querySelector(".inscription-connexion");
  elem.style.display = "none";

  let update = document.querySelector(".profil-update");
  update.style.animation = "close 0.4s ease-in-out";

  setTimeout(function () {
    update.style.display = "none";
  }, 300);

  setTimeout(function () {
    let connexion = document.querySelector(".password");
    connexion.style.display = "flex";

    $.ajax({
      url: "/login",
      type: "POST",
      async: false,
      data: {
        action: "ajaxGetPasswordForm",
      },
      success: function (reponse) {
        let obj = JSON.parse(reponse);
        let form = document.querySelector(".password");
        setTimeout(function () {
          form.innerHTML = form.innerHTML + obj;
          addPasswordFormEvent();
        }, 400);
      },
    });
  }, 400);
}

function openConnexionInscription(){
  let elem = document.querySelector(".inscription-connexion");
  elem.style.display = "flex";

  let profil = document.querySelector(".profil");
  profil.style.display = "none";
}

function closeInscription() {
  let inscription = document.querySelector(".inscription");
  inscription.removeChild(document.querySelector("#inscription-form"));

  let close = document.querySelector(".inscription .close");
  inscription.removeChild(close);

  inscription.style.animation = "close 0.4s ease-in-out";

  setTimeout(function () {
    let profil = document.querySelector(".profil");
    profil.style.display = "flex";
    inscription.style.display = "none";
    inscription.style.animation = "open 0.4s ease-in-out";
    inscription.appendChild(close);
  }, 300);
}

function closeInscriptionConnexion() {
  let inscriptionConnexion = document.querySelector(".inscription-connexion");

  let close = document.querySelector(".inscription-connexion .close");
  inscriptionConnexion.removeChild(close);

  inscriptionConnexion.style.animation = "close 0.4s ease-in-out";

  setTimeout(function () {
    let profil = document.querySelector(".profil");
    profil.style.display = "flex";
    inscriptionConnexion.style.display = "none";
    inscriptionConnexion.style.animation = "open 0.4s ease-in-out";
    inscriptionConnexion.appendChild(close);
  }, 300);
}

function openInscription(){
  let elem = document.querySelector(".inscription-connexion");
  elem.style.display = "none";

  let profil = document.querySelector(".profil");
  profil.style.display = "none";

  let inscription = document.querySelector(".inscription");
  inscription.style.display = "flex";

  $.ajax({
    url: "/login",
    type: "POST",
    async: false,
    data: {
      action: "ajaxGetInscriptionForm",
    },
    success: function (reponse) {
      let obj = JSON.parse(reponse);
      let form = document.querySelector(".inscription");
      setTimeout(function () {
        form.innerHTML = form.innerHTML + obj;
        addInscriptionFormEvent();
      }, 400);
    },
  });
}

function openConnexion(){
  let elem = document.querySelector(".inscription-connexion");
  elem.style.display = "none";

  let profil = document.querySelector(".profil");
  profil.style.display = "none";

  let connexion = document.querySelector(".connexion");
  connexion.style.display = "flex";

  $.ajax({
    url: "/login",
    type: "POST",
    async: false,
    data: {
      action: "ajaxGetLoginForm",
    },
    success: function (reponse) {
      let obj = JSON.parse(reponse);
      let form = document.querySelector(".connexion");
      setTimeout(function () {
        form.innerHTML = form.innerHTML + obj;
        addLoginFormEvent();
      }, 400);
    },
  });
}

function openUpdate() {
  let profil = document.querySelector(".profil");
  profil.style.display = "none";

  let elem = document.querySelector(".inscription-connexion");
  elem.style.display = "none";

  let connexion = document.querySelector(".profil-update");
  connexion.style.display = "flex";
}

function closeUpdate() {
  let profil = document.querySelector(".profil");
  profil.style.display = "flex";

  let connexion = document.querySelector(".profil-update");
  connexion.style.display = "none";
}

function loadScript(src) {
  let script = document.createElement("script");
  script.src = src;
  // permet de le supprimer ensuite
  script.id = "login-js";
  document.head.append(script);
}

document.addEventListener("DOMContentLoaded", function () {
  const closeButton = document.getElementById("close-popup");
  const plusButton = document.querySelector(".plus-button");
  if (plusButton) {
    plusButton.addEventListener("click", function (event) {
      event.preventDefault();
      document.getElementById("popup").style.display = "block";
      document.getElementById("overlay").style.display = "block";
      console.log("popup");
    });
  }
  if (closeButton) {
    document
      .getElementById("close-popup")
      .addEventListener("click", function (event) {
        event.preventDefault();
        document.getElementById("popup").style.display = "none";
        document.getElementById("overlay").style.display = "none";
      });
  }
});
