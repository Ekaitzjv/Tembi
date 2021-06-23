CREATE DATABASE IF NOT EXISTS tembieoekaitzj;
USE tembieoekaitzj;

CREATE TABLE IF NOT EXISTS users(
id              int(255) auto_increment not null,
role            varchar(20),
name            varchar(100),
surname         varchar(200),
username        varchar(100),
email           varchar(255),
password        varchar(255),
description     text,
created_at      datetime,
updated_at      datetime,
remember_token  varchar(255),
CONSTRAINT pk_users PRIMARY KEY(id)
)ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS posts(
id              int(255) auto_increment not null,
user_id         int(255),
image_path      varchar(255),
description     text,
created_at      datetime,
updated_at      datetime,
CONSTRAINT pk_posts PRIMARY KEY(id),
CONSTRAINT fk_posts_users FOREIGN KEY(user_id) REFERENCES users(id)
)ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS comments(    
id              int(255) auto_increment not null,
user_id         int(255),
post_id         int(255),
content         text,
created_at      datetime,
updated_at      datetime,
CONSTRAINT pk_comments PRIMARY KEY(id),
CONSTRAINT fk_comments_users FOREIGN KEY(user_id) REFERENCES users(id),
CONSTRAINT fk_comments_posts FOREIGN KEY(post_id) REFERENCES posts(id)
)ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS likes(
id              int(255) auto_increment not null,
user_id         int(255),
post_id         int(255),
created_at      datetime,
updated_at      datetime,
CONSTRAINT pk_likes PRIMARY KEY(id),
CONSTRAINT fk_likes_user FOREIGN KEY(user_id) REFERENCES users(id),
CONSTRAINT fk_likes_posts FOREIGN KEY(post_id) REFERENCES posts(id)
)ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS reports(
id              int(255) auto_increment not null,
user_id         int(255),
post_id         int(255),
created_at      datetime,
updated_at      datetime,
CONSTRAINT pk_reports PRIMARY KEY(id),
CONSTRAINT fk_reports_users FOREIGN KEY(user_id) REFERENCES users(id),
CONSTRAINT fk_reports_posts FOREIGN KEY(post_id) REFERENCES posts(id)
)ENGINE=InnoDb;

