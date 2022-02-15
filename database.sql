CREATE DATABASE `framework` DEFAULT CHARACTER SET utf8mb4;

CREATE TABLE `admins` (
                          `id` int(4) NOT NULL,
                          KEY `ind_id_admin` (`id`),
                          CONSTRAINT `ind_id_admin` FOREIGN KEY (`id`) REFERENCES `users` (`id`)
);
CREATE TABLE `page_html` (
                             `name_control` varchar(10) NOT NULL,
                             `title` varchar(20) DEFAULT NULL,
                             `id_template` int(10) NOT NULL,
                             `content` longtext DEFAULT NULL,
                             KEY `ind_page_html` (`name_control`),
                             KEY `ind_template_html` (`id_template`),
                             CONSTRAINT `ind_page_html` FOREIGN KEY (`name_control`) REFERENCES `routing` (`name_control`),
                             CONSTRAINT `ind_template_html` FOREIGN KEY (`id_template`) REFERENCES `templates` (`id`)
);
CREATE TABLE `php_dynamic` (
                               `name_control` varchar(10) NOT NULL,
                               `content` mediumtext DEFAULT NULL,
                               UNIQUE KEY `dynamic_name_control` (`name_control`),
                               CONSTRAINT `dynamic_name_control` FOREIGN KEY (`name_control`) REFERENCES `routing` (`name_control`)
);
CREATE TABLE `php_static` (
                              `name_control` varchar(10) NOT NULL,
                              `content` mediumtext DEFAULT NULL,
                              UNIQUE KEY `php_name_control` (`name_control`),
                              CONSTRAINT `php_name_control` FOREIGN KEY (`name_control`) REFERENCES `routing` (`name_control`)
);
CREATE TABLE `pictures` (
                            `name_control` varchar(10) NOT NULL,
                            `type` enum('png','jpg','gif','') NOT NULL,
                            `height` int(4) NOT NULL,
                            `width` int(4) NOT NULL,
                            `content` longblob DEFAULT NULL,
                            KEY `ind_pictures` (`name_control`),
                            CONSTRAINT `ind_pictures` FOREIGN KEY (`name_control`) REFERENCES `routing` (`name_control`)
);
CREATE TABLE `routing` (
                           `name_control` varchar(10) NOT NULL,
                           `type_route` int(1) NOT NULL,
                           `or_log` tinyint(1) NOT NULL,
                           `nota` mediumtext DEFAULT NULL,
                           UNIQUE KEY `ind_name_control` (`name_control`)
);
CREATE TABLE `templates` (
                             `id` int(11) NOT NULL AUTO_INCREMENT,
                             `head` longtext DEFAULT NULL,
                             `foot` longtext DEFAULT NULL,
                             PRIMARY KEY (`id`)
);
CREATE TABLE `users` (
                         `id` int(4) NOT NULL AUTO_INCREMENT,
                         `e_mail` varchar(10) NOT NULL,
                         `users_name` varchar(100) DEFAULT NULL,
                         `password` varchar(200) DEFAULT NULL,
                         `token_facebook` varchar(200) NOT NULL,
                         `token_google` varchar(200) NOT NULL,
                         PRIMARY KEY (`id`),
                         UNIQUE KEY `ind_mail` (`e_mail`)
);