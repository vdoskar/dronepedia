create table users_drones
(
    id                int auto_increment,
    owner             varchar(255) null,
    drone_name        varchar(255) null,
    drone_description varchar(255) null,
    drone_params      json         null comment 'json of raw params',
    drone_img         varchar(255) null comment 'url to the image',
    constraint users_drones_pk
        primary key (id),
    constraint users_drones_author_fk
        foreign key (owner) references users (uuid)
            on update cascade on delete cascade
);