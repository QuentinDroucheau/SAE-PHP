<link rel="stylesheet" href="styles/album.css">
<div class="header-album" onclick="">
    <div class="img-album">
        <img src=<?= $album->getImage() ?> alt="">
        <p class="note"><?= $note ?>/10</p>
    </div>
    <div class="info">
        <p>Album</p>
        <h1><?= $album->getTitre() ?></h1>
        <p>par <?= $album->getAuteur()->getNom() ?></p>
        <div class="container-description">
            <p>
                <?= $album->getDescription() ?>
            </p>
        </div>
        <p>Sortie le <?= $album->getAnneeAlbum()->format("d/m/Y")?>, <?= count($album->getMusiques())?> titre(s), -m-s. <?= $album->getEcoute()?> Ecoute(s) </p>
        <div class="buttons">
            <div class="button-play"></div>
            <div class="button-add"></div>
            <?php 
                if($critique){
                    echo '<a class="button-critique" onclick="openFormCritique(10919);">Laisser une critique</a>';
                }
            ?>
        </div>
    </div>
    <ul class="navbar-album">
        <li><a onclick="openMusique();">Musiques</a></li>
        <li><a onclick="openCritique();">Critique</a></li>
    </ul>
</div>
<div class="container-musique">
    <table>
        <thead>
            <tr>
                <th></th>
                <th>TITRES</th>
                <th>ECOUTES</th>
                <th><img class="icon" src="img/horloge.jpg" alt=""></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($musiques as $musique) : ?>
                <tr>
                    <td><?= $musique->getId() ?></td>

                    <td class="musique-title">
                        <div class="left">
                            <img src=<?= $musique->getLien() ?> alt="" style="height: 70px; width:70px;">
                        </div>
                        <div class="right">
                            <p class="title"><?= $musique->getNom() ?></p>
                        </div>
                    </td>
                    <td><?= $musique->getEcoute() ?></td>
                    <td>-:-</td>
                    <td>
                        <a href="">
                            <img class="plus-button" src="img/plus.png" alt="">
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="container-critique">
    <table>
        <thead>
            <tr>
                <th>AUDITEUR</th>
                <th>CRITIQUE</th>
                <th>NOTE</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($notes as $note) : ?>
                <tr>
                    <td class="critique-auditeur">
                        <div class="left">
                            <img src="img/default_album.png" alt="">
                        </div>
                        <div class="right">
                            <p class="title"><?= $note->getUtilisateur()->getPseudoU() ?></p>
                            <p>Il y a <?= time() - $note->getDate()?> s</p>
                        </div>
                    </td>
                    <td>
                        <div class="critique">
                            <p><?= $note->getCritique() ?></p>
                        </div>
                    </td>
                    <td>
                        <p><?= $note->getNote() ?>/10</p>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
    function openMusique() {
        document.querySelector('.container-musique').style.display = 'block';
        document.querySelector('.container-critique').style.display = 'none';
    }

    function openCritique() {
        document.querySelector('.container-musique').style.display = 'none';
        document.querySelector('.container-critique').style.display = 'block';
    }

    function addCritique(id){
        let note = document.querySelector("#note");
        let critique = document.querySelector("#critique");

        $.ajax({
            url: "/album",
            type: "POST",
            async: false,
            data: {
                "id": id,
                "note": note.value,
                "critique": critique.value,
                action: "ajaxAddCritique",
            },
            success: function (reponse) {
                let obj = JSON.parse(reponse);
                console.log(obj);
                if(obj.success == true){
                    window.location.reload();
                }
            },
        });
    }

    function openFormCritique(id){
        $.ajax({
            url: "/album",
            type: "POST",
            async: false,
            data: {
                action: "ajaxGetCritiqueForm",
            },
            success: function (reponse) {
                let obj = JSON.parse(reponse);
                let body = document.querySelector("body");
                let div = document.createElement("div");

                div.style.backgroundColor = "var(--couleur1)";
                div.style.height = "40%";
                div.style.width = "40%";
                div.style.position = "absolute";
                div.style.top = "35%";
                div.style.left = "30%";
                div.style.borderRadius = "7px";

                let close = document.createElement("div");
                close.style.height = "40px";
                close.style.width = "40px";
                close.classList.add("close");
                close.innerHTML = "<img src='img/close.svg' alt=''>";
                
                div.innerHTML = obj;

                div.appendChild(close);

                body.appendChild(div);

                close.addEventListener("click", function(e){
                    console.log("click");
                });

                let form = document.querySelector("#critique-form");
                form.addEventListener("submit", function (e){
                    addCritique(id);
                });
            }
        });
    }
</script>