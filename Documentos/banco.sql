CREATE DATABASE cardchoice;
USE cardchoice;

CREATE TABLE conta(
    id_conta int AUTO_INCREMENT PRIMARY KEY,
    nome varchar(50) NOT null,
    email varchar(50) UNIQUE NOT null,
    senha varchar(250) NOT null,  
    tipo varchar(50) NOT null DEFAULT 'Usuario',
  	data_criacao date DEFAULT CURRENT_DATE
);

CREATE TABLE carta(
    id_carta int AUTO_INCREMENT PRIMARY KEY,
    nome varchar(50) NOT null,
    descricao varchar(300) NOT null,
    raridade varchar(50),
    imagem varchar(250) not null
);

CREATE TABLE conta_cartas(
    id_conta int NOT null,
    id_carta int NOT null,
    data_adquiriu date DEFAULT CURRENT_DATE,
    PRIMARY KEY (id_conta,id_carta),
    CONSTRAINT fk_id_conta FOREIGN KEY(id_conta) REFERENCES conta(id_conta),
    CONSTRAINT fk_id_carta FOREIGN KEY(id_carta) REFERENCES carta(id_carta)
);