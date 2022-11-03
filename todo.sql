CREATE DATABASE `todo`;

USE `todo`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `login` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `sign_date` datetime NOT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `email_address` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `things` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `thing_title` varchar(31) NOT NULL,
  `thing_description` varchar(255) NOT NULL,
  `from_when` datetime NOT NULL,
  `to_when` datetime NOT NULL,
  `is_done` tinyint(1) NOT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `post_dane` datetime NOT NULL,
  `message` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `things`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`);

ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`);


ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `things`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `things`
  ADD CONSTRAINT `things_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`id`);

ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`id`);
