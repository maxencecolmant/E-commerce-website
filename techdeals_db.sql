-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Client :  localhost
-- Généré le :  Sam 13 Janvier 2018 à 17:10
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
-- Structure de la table `category_`
--

CREATE TABLE `category_` (
  `id_category` int(11) NOT NULL,
  `name_category` varchar(25) DEFAULT NULL,
  `id_parent_cat` int(11) DEFAULT NULL,
  `published_at_category` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_modification_category` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `category_`
--

INSERT INTO `category_` (`id_category`, `name_category`, `id_parent_cat`, `published_at_category`, `last_modification_category`) VALUES
(1, 'Test', NULL, '2017-12-22 16:28:38', '2018-01-13 16:46:38');

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
  `category_product` varchar(250) DEFAULT NULL,
  `quantity_product` int(11) DEFAULT NULL,
  `published_at_product` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_modification_product` datetime DEFAULT NULL,
  `is_hidden` tinyint(1) NOT NULL DEFAULT '0',
  `id_user` int(11) DEFAULT NULL,
  `id_category` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `products`
--

INSERT INTO `products` (`id_product`, `name_product`, `price_product`, `specs_product`, `desc_product`, `img_product`, `rank_product`, `category_product`, `quantity_product`, `published_at_product`, `last_modification_product`, `is_hidden`, `id_user`, `id_category`) VALUES
(1, 'Example', 10, 'Specs', 'Ma description', NULL, NULL, 'Test', 124, '2018-01-04 12:29:43', '2018-01-13 17:04:31', 0, 12, 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `last_name` varchar(25) DEFAULT NULL,
  `first_name` varchar(25) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `password` varchar(250) DEFAULT NULL,
  `img_user_profile` varchar(250) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_connection` datetime DEFAULT NULL,
  `last_modification_user` datetime DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'USER'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id_user`, `last_name`, `first_name`, `username`, `email`, `password`, `img_user_profile`, `created_at`, `last_connection`, `last_modification_user`, `status`) VALUES
(15, 'Another', 'Example', 'AnotherExample', 'another@example.fr', '$2y$10$aexGdYMSzR/Zh8JTexmT.uD6fdcgsT.4iez/sLdWFK5S8jIQMySui', NULL, '2018-01-08 11:19:13', '2018-01-08 11:19:13', NULL, 'USER'),
(5, 'Root', 'Admin', 'Root', 'admin@techdeals.com', '$2y$10$CzouLEfgrL/k7ySzJ8j/xOT6icnJUlGM0UNX4WNvDrwHQFmZ9IuOe', NULL, '2017-12-19 14:54:55', '2018-01-13 13:52:33', NULL, 'SUPER_ADMIN'),
(18, 'Space', 'Name', 'namespace', 'namespace@test.test', '$2y$10$gPGlfplrWxK0t5ynrDH6jeL7qT4/jW0GQz87JZdsUnOIe666PBfii', NULL, '2018-01-08 18:33:40', '2018-01-08 18:35:50', '2018-01-13 16:49:29', 'USER'),
(12, 'An', 'Example', 'Lorem', 'example@test.com', '$2y$10$cdWi9FY4CYUSo/88NUpXxeg0H1AJQ/COTjlT/gucOarhYxxiP.Zh6', NULL, '2018-01-05 21:24:36', '2018-01-05 21:24:36', NULL, 'USER');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `category_`
--
ALTER TABLE `category_`
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
-- AUTO_INCREMENT pour la table `category_`
--
ALTER TABLE `category_`
  MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `orders`
--
ALTER TABLE `orders`
  MODIFY `id_order` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `products`
--
ALTER TABLE `products`
  MODIFY `id_product` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
