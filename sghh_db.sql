CREATE DATABASE sghh;

USE sghh;

-- TABLES
ALTER DATABASE sghh CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- OK
create table receptionists(
	id int not null auto_increment,
    name varchar(100) not null unique,
    email varchar(60) not null unique,
    password varchar(255) not null,
    primary key(id)
)ENGINE = InnoDB;

-- OK
create table guests(
	id int not null auto_increment,
    name varchar(100) not null unique,
    email varchar(60) not null unique,
    cpf char(11) not null unique,
    cpf_responsible char(11),
    telephone char(11) not null unique,
    date_birth date not null,
    primary key(id)
)ENGINE = InnoDB;

-- OK
create table types_rooms(
	id int not null auto_increment,
    type_room varchar(30) not null unique,
    primary key(id)
)ENGINE = InnoDB;

-- OK
create table availability_rooms(
	id int not null auto_increment,
    availability_room varchar(30) not null unique,
    primary key(id)
)ENGINE = InnoDB;

-- OK
create table rooms(
	id int not null auto_increment,
    id_type_room int not null,
    id_availability_room int not null,
    number int not null unique,
    floor int not null,
    capacity int not null,
    daily_price decimal(10,2) not null,
    foreign key(id_type_room) references types_rooms(id),
    foreign key(id_availability_room) references availability_rooms(id),
	primary key(id)
)ENGINE = InnoDB;

-- OK
create table status_accommodations(
	id int not null auto_increment,
    status_accommodation varchar(30) not null unique,
    primary key(id)
)ENGINE = InnoDB;

-- OK
create table status_payments(
	id int not null auto_increment,
    status_payment varchar(30) not null unique,
    primary key(id)
)ENGINE = InnoDB;

-- OK
create table guest_accommodation(
	id int not null auto_increment,
	cpf_guest char(11) not null,
    id_accommodation int not null,
	foreign key(cpf_guest) references guests(cpf),
    foreign key(id_accommodation) references accommodations(id),
	primary key(id)
);

-- OK
create table accommodations(
	id int not null auto_increment,
	number_room int not null,
	id_status_accommodation int not null,
    id_status_payment int not null, 
    date_checkin DATE not null,
    date_checkout DATE not null,
    total_value decimal(10,2) default 0,
    foreign key(number_room) references rooms(number),
	foreign key(id_status_accommodation) references status_accommodations(id),
	foreign key(id_status_payment) references status_payments(id),
    primary key(id)
)ENGINE = InnoDB;


-- TRIGGERS
-- OK
DELIMITER $$
CREATE TRIGGER after_insert_accommodations
AFTER INSERT ON accommodations
FOR EACH ROW
BEGIN
	UPDATE 
		rooms
	SET 
		id_availability_room = 2
	WHERE 
		number = NEW.number_room;
END $$
DELIMITER ;


-- PROCEDURES
-- OK
DELIMITER $$
CREATE PROCEDURE cancel_accommodation(IN accommodationId INT)
BEGIN
    DECLARE roomNumber INT;

	DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
    END;

    START TRANSACTION;

    SELECT number_room INTO roomNumber
    FROM accommodations
    WHERE id = accommodationId;

    UPDATE accommodations 
	SET 
		id_status_accommodation = 3,
        id_status_payment = 3
    WHERE id = accommodationId;

    UPDATE rooms 
    SET id_availability_room = 1
    WHERE number = roomNumber;

    COMMIT;
END$$
DELIMITER ;

-- OK
DELIMITER $$
CREATE PROCEDURE end_accommodation (IN accommodationId INT)
BEGIN
    DECLARE roomNumber INT;
   
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
    END;

    START TRANSACTION;
    
    SELECT number_room INTO roomNumber
    FROM accommodations
    WHERE id = accommodationId;

    UPDATE accommodations 
    SET 
		id_status_accommodation = 2,
        id_status_payment = 1
    WHERE id = accommodationId;

    UPDATE rooms 
    SET id_availability_room = 1
    WHERE number = roomNumber;
    
    COMMIT;
END$$
DELIMITER ;


-- INSERTS
INSERT INTO availability_rooms (availability_room) VALUES ('disponível');
INSERT INTO availability_rooms (availability_room) VALUES ('ocupado');
INSERT INTO availability_rooms (availability_room) VALUES ('indisponível');

INSERT INTO types_rooms (type_room) VALUES ('simples');
INSERT INTO types_rooms (type_room) VALUES ('suíte');
INSERT INTO types_rooms (type_room) VALUES ('luxuoso');

INSERT INTO status_accommodations (status_accommodation) VALUES ('ativa');
INSERT INTO status_accommodations (status_accommodation) VALUES ('finalizada');
INSERT INTO status_accommodations (status_accommodation) VALUES ('cancelada');

INSERT INTO status_payments (status_payment) VALUES ('pago');
INSERT INTO status_payments (status_payment) VALUES ('pendente');
INSERT INTO status_payments (status_payment) VALUES ('cancelado');