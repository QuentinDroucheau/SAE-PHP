:
ASSOCIER, ON UTILISATEUR, 11 PLAYLIST
PLAYLIST: idP, nomP,imgPlaylist, descriptionP, anneeP, dateMajP
COMPOSER, ON PLAYLIST, 0N MUSIQUE:dateAjout
:
:

:
UTILISATEUR: idU, pseudoU, mdpU, roleU, mailU
ECOUTER, ON UTILISATEUR, ON MUSIQUE:date
MUSIQUE: idM, nomM, lienM
CONTIENT, 1N MUSIQUE, 0N GENRE
GENRE: idG, nomG

ABONNEMENT, 0N UTILISATEUR, 0N ARTISTE
NOTER, 0N UTILISATEUR, 0N ALBUM:note, critique, date
ALBUM: idAlbum, anneeAlbum, titreAlbum, imgAlbum, descriptionA
POSSEDER, 0N ALBUM, 11 MUSIQUE
:
:

:
ARTISTE: idA, nomA, imgArtiste
PUBLIER, 0N ARTISTE, 11 ALBUM
:
:
:
