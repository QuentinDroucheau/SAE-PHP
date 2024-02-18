let sidebar = document.querySelector(".menu");
let sidebarClose = document.querySelector(".menu-close");

let buttonOpen = document.querySelector(".button-open");
let buttonClose = document.querySelector(".button-close");

buttonOpen.addEventListener("click", () => {
    sidebar.className = "menu-open";
});

buttonClose.addEventListener("click", () => {
    // affiche le menu par défaut qui est fermé si la page est trop petite
    sidebar.className = "menu";
});