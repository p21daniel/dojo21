CREATE DATABASE okr;

use okr;

CREATE TABLE user
(
    id         int(10) unsigned not null auto_increment,
    name       varchar(45)      not null,
    email      varchar(80)      not null,
    password   varchar(80)      not null,
    created_at DATETIME         NOT NULL default NOW(),
    updated_at DATETIME         NOT NULL default NOW(),
    deleted_at DATETIME,
    PRIMARY KEY (id)
);

create index fk_user_id_idx on objective (user_id);


CREATE TABLE objective
(
    id          int(10) unsigned not null auto_increment,
    user_id     int(10) unsigned not null,
    title       varchar(80)      not null,
    description longtext         not null,
    status      tinyint(1)                DEFAULT 0,
    created_at  DATETIME         NOT NULL default NOW(),
    updated_at  DATETIME         NOT NULL default NOW(),
    deleted_at  DATETIME,
    primary key (id),
    constraint fk_objective_user FOREIGN KEY (user_id) REFERENCES user (id) on delete restrict on update restrict
);

create index fk_user_id_idx on objective (user_id);

CREATE TABLE key_result
(
    id           int(10) unsigned not null auto_increment,
    objective_id int(10) unsigned not null,
    title        varchar(80)      not null,
    description  varchar(255)     not null,
    type         enum ('1', '2')  not null comment "1: Milestone 2: Porcentagem",
    created_at   DATETIME         NOT NULL default NOW(),
    updated_at   DATETIME         NOT NULL default NOW(),
    deleted_at   DATETIME,
    primary key (id),
    constraint fk_key_result_objective FOREIGN KEY (objective_id) REFERENCES objective (id) on delete restrict on update restrict
);

create index fk_objective_id_idx on key_result (objective_id);