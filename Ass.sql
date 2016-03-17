CREATE DATABASE `family-tree`;
USE `family-tree`;

CREATE TABLE `person` (
   'id' int UNIQUE NOT NULL AUTO_INCREMENT,
   'email' varchar(40) UNIQUE NOT NULL,
   'pass' varchar(50) NOT NULL,
   'name' varchar(50) NOT NULL,
   PRIMARY KEY(id)
);

CREATE TABLE `admin` (
   'id' int UNIQUE NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY (id) REFERENCES person(id),
);

CREATE TABLE `user` (
   `id` int UNIQUE NOT NULL,
   `admin-id` int NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY (id) REFERENCES person(id),
   FOREIGN KEY (admin-id) REFERENCES admin(id)
);

