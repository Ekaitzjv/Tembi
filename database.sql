CREATE DATABASE IF NOT EXISTS red_social;
USE red_social;

CREATE TABLE IF NOT EXISTS users(
id              int(255) auto_increment not null,
role            varchar(20),
name            varchar(100),
surname         varchar(200),
nick            varchar(100),
email           varchar(255),
password        varchar(255),
image           varchar(255),
created_at      datetime,
updated_at      datetime,
remember_token  varchar(255),
CONSTRAINT pk_users PRIMARY KEY(id)
)ENGINE=InnoDb;

INSERT INTO users VALUES(NULL, 'user', 'Ekaitz', 'Jiménez', 'ekaitzj', 'ekaitzj@gmail.com', '123456', NULL, CURTIME(), CURTIME(), NULL);
INSERT INTO users VALUES(NULL, 'user', 'manolo', 'Jiménez', 'manoloj', 'manolo@gmail.com', '12346', NULL, CURTIME(), CURTIME(), NULL);
INSERT INTO users VALUES(NULL, 'user', 'pablo', 'Jiménez', 'papa', 'papaj@gmail.com', '1256', NULL, CURTIME(), CURTIME(), NULL);

CREATE TABLE IF NOT EXISTS images(
id              int(255) auto_increment not null,
user_id         int(255),
image_path      varchar(255),
description     text,
created_at      datetime,
updated_at      datetime,
CONSTRAINT pk_images PRIMARY KEY(id),
CONSTRAINT fk_images_users FOREIGN KEY(user_id) REFERENCES users(id)
)ENGINE=InnoDb;

INSERT INTO images VALUES(NULL, '4', 'test.jpg', 'descripción prueba1', CURTIME(), CURTIME());
INSERT INTO images VALUES(NULL, '4', 'arena.jpg', 'descripción prueba2', CURTIME(), CURTIME());
INSERT INTO images VALUES(NULL, '4', 'playa.jpg', 'descripción prueba3', CURTIME(), CURTIME());
INSERT INTO images VALUES(NULL, '3', 'movil.jpg', 'descripción prueba4', CURTIME(), CURTIME());

CREATE TABLE IF NOT EXISTS comments(
id              int(255) auto_increment not null,
user_id         int(255),
image_id        int(255),
content         text,
created_at      datetime,
updated_at      datetime,
CONSTRAINT pk_comments PRIMARY KEY(id),
CONSTRAINT fk_comments_users FOREIGN KEY(user_id) REFERENCES users(id),
CONSTRAINT fk_comments_images FOREIGN KEY(image_id) REFERENCES images(id)
)ENGINE=InnoDb;

INSERT INTO comments VALUES(NULL, '3', '6', 'buena foto!!', CURTIME(), CURTIME());
INSERT INTO comments VALUES(NULL, '5', '8', 'buena foto!!', CURTIME(), CURTIME());
INSERT INTO comments VALUES(NULL, '4', '9', 'buena foto con la abuela', CURTIME(), CURTIME());

CREATE TABLE IF NOT EXISTS likes(
id              int(255) auto_increment not null,
user_id         int(255),
image_id        int(255),
created_at      datetime,
updated_at      datetime,
CONSTRAINT pk_likes PRIMARY KEY(id),
CONSTRAINT fk_likes_user FOREIGN KEY(user_id) REFERENCES users(id),
CONSTRAINT fk_likes_images FOREIGN KEY(image_id) REFERENCES images(id)
)ENGINE=InnoDb;

INSERT INTO likes VALUES(NULL, '4', '9', CURTIME(), CURTIME());
INSERT INTO likes VALUES(NULL, '5', '9', CURTIME(), CURTIME());
INSERT INTO likes VALUES(NULL, '6', '9', CURTIME(), CURTIME());

