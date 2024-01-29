CREATE TABLE IF NOT EXISTS album (
  idAlbum INTEGER NOT NULL,
  anneeAlbum INTEGER,
  titreAlbum TEXT,
  imgAlbum TEXT,
  idA INTEGER NOT NULL,
  PRIMARY KEY (idAlbum),
  FOREIGN KEY (idA) REFERENCES artiste (idA)
);

CREATE TABLE IF NOT EXISTS artiste (
  idA INTEGER NOT NULL,
  nomA TEXT,
  PRIMARY KEY (idA)
);

CREATE TABLE IF NOT EXISTS composer (
  idP INTEGER NOT NULL,
  idM INTEGER NOT NULL,
  dateAjout INTEGER NOT NULL,
  PRIMARY KEY (idP, idM),
  FOREIGN KEY (idM) REFERENCES musique (idM),
  FOREIGN KEY (idP) REFERENCES playlist (idP)
);

CREATE TABLE IF NOT EXISTS contient (
  idM INTEGER NOT NULL,
  idG INTEGER NOT NULL,
  PRIMARY KEY (idM, idG),
  FOREIGN KEY (idG) REFERENCES genre (idG),
  FOREIGN KEY (idM) REFERENCES musique (idM)
);

CREATE TABLE IF NOT EXISTS ecouter (
  idU INTEGER NOT NULL,
  idM INTEGER NOT NULL,
  date INTEGER,
  PRIMARY KEY (idU, idM),
  FOREIGN KEY (idM) REFERENCES musique (idM),
  FOREIGN KEY (idU) REFERENCES utilisateur (idU)
);

CREATE TABLE IF NOT EXISTS genre (
  idG INTEGER NOT NULL,
  nomG TEXT,
  PRIMARY KEY (idG)
);

CREATE TABLE IF NOT EXISTS musique (
  idM INTEGER NOT NULL,
  nomM TEXT,
  lienM TEXT,
  idAlbum INTEGER NOT NULL,
  PRIMARY KEY (idM),
  FOREIGN KEY (idAlbum) REFERENCES album (idAlbum)
);

CREATE TABLE IF NOT EXISTS noter (
  idU INTEGER NOT NULL,
  idAlbum INTEGER NOT NULL,
  note FLOAT,
  PRIMARY KEY (idU, idAlbum),
  FOREIGN KEY (idAlbum) REFERENCES album (idAlbum),
  FOREIGN KEY (idU) REFERENCES utilisateur (idU)
);

CREATE TABLE IF NOT EXISTS playlist (
  idP INTEGER NOT NULL,
  nomP TEXT,
  imgPlaylist TEXT,
  descriptionP TEXT,
  idU INTEGER NOT NULL,
  PRIMARY KEY (idP),
  FOREIGN KEY (idU) REFERENCES utilisateur (idU)
);

CREATE TABLE IF NOT EXISTS utilisateur (
  idU INTEGER NOT NULL,
  pseudoU TEXT,
  mdpU TEXT,
  roleU TEXT,
  PRIMARY KEY (idU)
);

-- pour avoir la fonctionnalité du nombre d'abonnées qu'a un artiste
-- pour avoir une liste des musiques des artistes que l'utilisateur écoute (est abonnée)
CREATE TABLE IF NOT EXISTS abonnement (
  idU INTEGER NOT NULL,
  idA INTEGER NOT NULL,
  PRIMARY KEY (idU, idA),
  FOREIGN KEY (idA) REFERENCES artiste (idA),
  FOREIGN KEY (idU) REFERENCES utilisateur (idU)
);
