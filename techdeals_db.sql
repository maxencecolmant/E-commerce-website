-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Client :  localhost
-- Généré le :  Mar 19 Décembre 2017 à 15:46
-- Version du serveur :  10.0.32-MariaDB
-- Version de PHP :  5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `techdeals_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id_category` int(11) NOT NULL,
  `name_category` varchar(25) DEFAULT NULL,
  `id_parent_cat` int(11) DEFAULT NULL,
  `published_at_category` datetime DEFAULT NULL,
  `last_modification_category` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `id_order` int(11) NOT NULL,
  `total_price` float DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `orders_info`
--

CREATE TABLE `orders_info` (
  `id_order` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `quantity_product_ordered` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE `products` (
  `id_product` int(11) NOT NULL,
  `name_product` varchar(50) DEFAULT NULL,
  `price_product` float DEFAULT NULL,
  `specs_product` varchar(500) DEFAULT NULL,
  `desc_product` varchar(500) DEFAULT NULL,
  `img_product` varchar(500) DEFAULT NULL,
  `rank_product` int(11) DEFAULT NULL,
  `category_product` int(11) DEFAULT NULL,
  `quantity_product` int(11) DEFAULT NULL,
  `published_at_product` datetime DEFAULT NULL,
  `last_modification_product` datetime DEFAULT NULL,
  `is_hidden` tinyint(1) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_category` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `last_name` varchar(25) DEFAULT NULL,
  `first_name` varchar(25) DEFAULT NULL,
  `pseudonym` varchar(50) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `password` varchar(250) DEFAULT NULL,
  `img_user_profile` varchar(250) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `last_connection` datetime DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'USER'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id_user`, `last_name`, `first_name`, `pseudonym`, `email`, `password`, `img_user_profile`, `created_at`, `last_connection`, `status`) VALUES
(2, 'test', 'Test', 'test123', 'test@b.fr', '$2y$10$G2ogXQPddAi9UE/Z1fBkF.t4Rwn8LimkCJUhAp9NJYMB.Uedgb4bK', NULL, '2017-12-05 23:53:53', '2017-12-19 15:41:02', 'USER'),
(3, 'Test', 'Test', 'tester', 'tester@test.test', '$2y$10$Egc/WtnNt8owlpZDL03SnOkpct8ldB76OYR/JXSpKyh4rw0d45zFO', NULL, '2017-12-06 08:18:12', '2017-12-19 15:41:02', 'USER'),
(4, 'ATest', 'ATest', 'Atester', 'atester@test.test', '$2y$10$XM0LLmy1vYqRz7XbaevVk.X2ymqSdzSNk6NCee0i6/GRpAGVxjFJi', NULL, '2017-12-06 08:21:43', '2017-12-19 15:41:02', 'USER'),
(5, 'Root', 'Admin', 'Root', 'admin@techdeals.com', '$2y$10$CzouLEfgrL/k7ySzJ8j/xOT6icnJUlGM0UNX4WNvDrwHQFmZ9IuOe', NULL, '2017-12-19 14:54:55', '2017-12-19 15:41:02', 'USER'),
(6, 'to', 'To', 'toto', 'toto@too.com', '$2y$10$K.A4KnTi4t9fNmzm22m6jujjmOPkHPv4flJYqkTeF4LnXzBOmR0Ty', NULL, '2017-12-19 15:41:02', '2017-12-19 15:41:02', 'USER');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id_category`);

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id_order`),
  ADD KEY `FK_orders_id_user` (`id_user`);

--
-- Index pour la table `orders_info`
--
ALTER TABLE `orders_info`
  ADD PRIMARY KEY (`id_order`,`id_product`),
  ADD KEY `FK_orders_info_id_product` (`id_product`);

--
-- Index pour la table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id_product`),
  ADD KEY `FK_products_id_user` (`id_user`),
  ADD KEY `FK_products_id_category` (`id_category`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `orders`
--
ALTER TABLE `orders`
  MODIFY `id_order` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `products`
--
ALTER TABLE `products`
  MODIFY `id_product` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
