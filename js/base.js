// retourne le code html d'un composant

async function fetchHtmlAsText(url) {
    return await (await fetch(url)).text();
}