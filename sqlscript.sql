CREATE TABLE users(
    id AUTOINCREMENT INT PRIMARY KEY,
    ime CHAR(20),
    prezime CHAR(20),
    email CHAR(50),
    password CHAR(255),
    datum_rodjenja DATE,
    username CHAR(50)
)

CREATE TABLE lokacija(
    id AUTOINCREMENT INT PRIMARY KEY,
    br_mjesta INT,
    ime CHAR(150),
    adresa CHAR(150)
)

CREATE TABLE konferencija(
    id AUTOINCREMENT INT PRIMARY KEY,
    ime CHAR(150),
    kreator INT,
    br_mjesta INT,
    lokacija INT,
    pocetak DATE,
    status ENUM('ceka', 'odobreno', 'odbijeno') DEFAULT 'ceka'
    link CHAR(255),
    org_file(255),
    CONSTRAINT fk_K_U FOREIGN KEY (kreator) REFERENCES users(id),
    CONSTRAINT fk_K_L FOREIGN KEY (lokacija) REFERENCES lokacija(id)
)

CREATE TABLE Administracija(
    id AUTOINCREMENT INT PRIMARY KEY,
    user_id INT,
    datum_rodjenja DATE,
    CONSTRAINT fk_A_U FOREIGN KEY (user_id) REFERENCES users(id)
)

CREATE TABLE predavaci(
    id AUTOINCREMENT INT PRIMARY KEY,
    user_id INT,
    konferencija_id INT,
    CONSTRAINT fk_P_U FOREIGN KEY (user_id) REFERENCES users(id),
    CONSTRAINT fk_P_K FOREIGN KEY (konferencija_id) REFERENCES konferencija(id)
)

CREATE TABLE prijava(
    id AUTOINCREMENT INT PRIMARY KEY,
    user_id INT,
    konferencija_id INT,
    CONSTRAINT fk_P_U FOREIGN KEY (user_id) REFERENCES users(id),
    CONSTRAINT fk_P_K FOREIGN KEY (konferencija_id) REFERENCES konferencija(id)
)