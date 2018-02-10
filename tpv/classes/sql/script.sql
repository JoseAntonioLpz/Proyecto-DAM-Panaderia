/*------------- CÓDIGO REVISADO POR CARMELO -------------*/

/* 1º Crear base de datos */
create database bakery
default character set utf8
collate utf8_unicode_ci;

/* 2º Crear el usuario administrador de esa base de datos */
create user baker@localhost
identified by 'cbaker';

grant all
on bakery.* to
baker@localhost;

flush privileges;

/* 3º Crear las tablas */ 
create table if not exists member(
id bigint not null auto_increment,
login varchar(40) not null,
clave varchar(250) not null,
primary key (id),
unique (login)
)engine = innodb default character set = utf8 collate utf8_unicode_ci;

create table if not exists client(
id bigint not null auto_increment,
name varchar(40) not null,
surname varchar(60) not null,
tin varchar(20) not null,
address varchar(100),
location varchar(100),
postalcode varchar(5),
province varchar(30),
email varchar(100),
primary key (id),
unique(name, surname, tin)
)engine = innodb default character set = utf8 collate utf8_unicode_ci;

create table if not exists ticket(
id bigint not null auto_increment,
date datetime not null,
idmember bigint not null,
idclient bigint not null,
primary key (id),
foreign key (idmember) references member(id) on delete restrict,
foreign key (idclient) references client(id) on delete restrict
)engine = innodb default character set = utf8 collate utf8_unicode_ci;

create table if not exists ticketdetail(
id bigint not null auto_increment,
idticket bigint not null,
idproduct bigint not null,
quantity tinyint(4) not null,
price decimal(10,2) not null,
primary key (id),
unique(idticket, idproduct),
foreign key (idticket) references ticket(id) on delete restrict,
foreign key (idproduct) references product(id) on delete restrict
)engine = innodb default character set = utf8 collate utf8_unicode_ci;

create table if not exists product(
id bigint not null auto_increment,
idfamily bigint not null,
product varchar(100) not null,
price decimal(10,2) not null,
description text,
primary key (id),
unique(idfamily, product),
foreign key (idfamily) references family(id) on delete restrict
)engine = innodb default character set = utf8 collate utf8_unicode_ci;

create table if not exists family(
id bigint not null auto_increment,
family varchar(100) not null,
primary key (id),
unique(family)
)engine = innodb default character set = utf8 collate utf8_unicode_ci;


-- ticket date se guarda automaticamente
-- ticket idcliente anonimo => null

-- Ticket y TicketDetail => Ajax

-- Tabla family opcional
-- family family unique