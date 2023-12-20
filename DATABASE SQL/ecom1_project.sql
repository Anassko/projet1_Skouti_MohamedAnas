-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 20 déc. 2023 à 07:06
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ecom1_project`
--

-- --------------------------------------------------------

--
-- Structure de la table `address`
--

CREATE TABLE `address` (
  `id` bigint(20) NOT NULL,
  `street_name` varchar(255) NOT NULL,
  `street_nb` int(11) NOT NULL,
  `city` varchar(40) NOT NULL,
  `province` varchar(40) NOT NULL,
  `zip_code` varchar(6) NOT NULL,
  `country` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `address`
--

INSERT INTO `address` (`id`, `street_name`, `street_nb`, `city`, `province`, `zip_code`, `country`) VALUES
(1, 'langelier', 20, 'montreal', 'quebec', 'hasdjn', 'canada'),
(33, 'jfhdh', 98, 'lj', 'lj', '9893', 'klj'),
(34, 'klkfjd', 98, 'lkj', 'lj', '9083', 'ljkl'),
(35, 'kljfslj', 98, 'ljl', 'ljlj', '9808', 'ljlj'),
(36, 'kljd', 98, 'ljk', 'olo', 'ili', 'ljk'),
(37, 'kljfsd', 980, 'lkj', 'ljlkj', '98', 'ljlj'),
(38, 'kljlj', 90808, 'ljlj', 'lkjlj', '0', 'kljlkj'),
(39, 'kfjsj', 984, 'lkj', 'lj', 'lkj4', 'kljd');

-- --------------------------------------------------------

--
-- Structure de la table `order_has_product`
--

CREATE TABLE `order_has_product` (
  `order_id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `order_has_product`
--

INSERT INTO `order_has_product` (`order_id`, `product_id`, `quantity`, `price`) VALUES
(49, 36, 2, 19.99),
(52, 36, 1, 19.99),
(54, 36, 8, 19.99),
(55, 36, 5, 19.99),
(56, 36, 3, 19.99),
(57, 36, 3, 19.99),
(58, 36, 5, 19.99),
(59, 36, 5, 19.99),
(60, 36, 4, 19.99),
(62, 36, 5, 19.99),
(63, 36, 1, 19.99),
(64, 36, 7, 19.99),
(49, 37, 2, 17.99),
(50, 40, 1, 15.99);

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE `product` (
  `id` bigint(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(5,2) NOT NULL,
  `img_url` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `img_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id`, `name`, `quantity`, `price`, `img_url`, `description`, `img_path`) VALUES
(36, 'product2', 90, 19.99, './images/product2.png', 'description product2', './images/product2.png'),
(37, 'product3', 78, 17.99, './images/product3.png', 'description product3', './images/product3.png'),
(38, 'product4', 29, 23.99, './images/product4.png', 'description product4', './images/product4.png'),
(39, 'product5', 100, 19.99, './images/product5.png', 'description product5', './images/product5.png'),
(40, 'product7', 65, 15.99, './images/product7.png', 'description product7', './images/product7.png'),
(46, 'product3', 34, 99.12, './images/product3.png', 'description product3', './images/product3.png'),
(47, 'product6', 23, 32.99, './images/product4.png', 'description product6', './images/product4.png');

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `id` bigint(20) NOT NULL,
  `name` varchar(10) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id`, `name`, `description`) VALUES
(1, 'superadmin', 'Super Administrator'),
(2, 'admin', 'admin'),
(3, 'client', 'Client');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` bigint(20) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `billing_address_id` bigint(20) NOT NULL,
  `shipping_address_id` bigint(20) NOT NULL,
  `token` varchar(255) NOT NULL,
  `role_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `user_name`, `email`, `pwd`, `fname`, `lname`, `billing_address_id`, `shipping_address_id`, `token`, `role_id`) VALUES
(1, 'superadmin', 'superadmin@admin.ca', '$2y$10$XbVZVwOxlwfv4iiSvMhZdOXiuWWlWhqWJIgZQ5aM5UiUyDhhcHKMa', 'Super', 'Admin', 1, 1, '', 1),
(40, 'tereza', 'tereza@gmail.com', '$2y$10$Ln4PRpevP0wvKqfQB.QjyO3c2ZA282CDdaTNosf5udS4DqtnN6NS6', 'tereza', 'lopez', 33, 33, '', 2),
(41, 'luna', 'luna@gmail.com', '$2y$10$FQoi02Uk13G3cV9Rtn2z0.oWiBMPUWd58QqlONuOapwejJQBKSe86', 'luna', 'aska', 34, 34, '', 2),
(42, 'messi', 'messi@gmail.com', '$2y$10$/muPNsiL1dc1n/MZYXFqFeueurY6E3NZFbQI8.sevAc4AXKvqPH3a', 'lionel', 'messi', 35, 35, '', 3),
(43, 'toto', 'totooui@gmail.com', '$2y$10$bu7om0zM85NizolkjDQDSuQKutF5eulPMVp1ZhPTk2mTGKCPv7THu', 'toto', 'rino', 36, 36, '', 3),
(44, 'ines', 'ines@gmail.com', '$2y$10$mFCQ2krAR6ab10AoaftcXeNYaZTXJlDaaI/osEyW0jjA2mXaEJq/S', 'ines', 'omen', 37, 37, '', 3),
(45, 'selena', 'selena@gmail.com', '$2y$10$GDD7J4Wx3PFjmWV40IRmOuxrMBGsRUYgzXvhGKwrlRj.88FIzsXCq', 'selena', 'gomez', 38, 38, '', 3),
(46, 'lend', 'lend@gmail.com', '$2y$10$irOj7DQaFIPtFnE0mgQ3nu9Dn7tEnBQP8KRZ7qTWrqgSui3RsX0kW', 'lendo', 'bendo', 39, 39, '', 3);

-- --------------------------------------------------------

--
-- Structure de la table `user_order`
--

CREATE TABLE `user_order` (
  `id` bigint(20) NOT NULL,
  `ref` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `user_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user_order`
--

INSERT INTO `user_order` (`id`, `ref`, `date`, `total`, `user_id`) VALUES
(39, 'ORDER-65812d92ef29e', '2023-12-19', 99.95, 1),
(49, 'ORDER-658266dff4090', '2023-12-20', 75.96, 1),
(50, 'ORDER-658268e28add6', '2023-12-20', 15.99, 1),
(51, 'ORDER-658268f2bf4f6', '2023-12-20', 0.00, 1),
(52, 'ORDER-65826a9eba05d', '2023-12-20', 19.99, 1),
(53, 'ORDER-65826aadd4fab', '2023-12-20', 0.00, 1),
(54, 'ORDER-65826de5e545a', '2023-12-20', 159.92, 1),
(55, 'ORDER-65826e806fc7a', '2023-12-20', 99.95, 1),
(56, 'ORDER-65826f4b0cb18', '2023-12-20', 59.97, 1),
(57, 'ORDER-65826fbd04c16', '2023-12-20', 59.97, 1),
(58, 'ORDER-658270124691a', '2023-12-20', 99.95, 1),
(59, 'ORDER-658270be01bcd', '2023-12-20', 99.95, 1),
(60, 'ORDER-65827166660b4', '2023-12-20', 79.96, 1),
(61, 'ORDER-65827168d60f7', '2023-12-20', 0.00, 1),
(62, 'ORDER-6582718bee919', '2023-12-20', 99.95, 1),
(63, 'ORDER-6582784ddd7dc', '2023-12-20', 19.99, 1),
(64, 'ORDER-65827e4da9273', '2023-12-20', 139.93, 46);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `order_has_product`
--
ALTER TABLE `order_has_product`
  ADD PRIMARY KEY (`product_id`,`order_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Index pour la table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_name` (`user_name`),
  ADD KEY `role_id` (`role_id`);

--
-- Index pour la table `user_order`
--
ALTER TABLE `user_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `address`
--
ALTER TABLE `address`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT pour la table `product`
--
ALTER TABLE `product`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT pour la table `user_order`
--
ALTER TABLE `user_order`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `order_has_product`
--
ALTER TABLE `order_has_product`
  ADD CONSTRAINT `fk_order_id` FOREIGN KEY (`order_id`) REFERENCES `user_order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_role_id` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `user_order`
--
ALTER TABLE `user_order`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
