-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : mer. 28 avr. 2021 à 14:19
-- Version du serveur :  5.7.32
-- Version de PHP : 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `vintage_vibe`
--

-- --------------------------------------------------------

--
-- Structure de la table `blog`
--

CREATE TABLE `blog` (
  `id` int(11) NOT NULL,
  `title` varchar(80) NOT NULL,
  `description` text NOT NULL,
  `picture` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `blog`
--

INSERT INTO `blog` (`id`, `title`, `description`, `picture`) VALUES
(1, 'BREAK THE SOUND', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent vel molestie justo. Mauris nec eros sit amet diam condimentum tincidunt. Vestibulum a massa ligula. Aliquam feugiat congue velit, a blandit enim sagittis sit amet. Phasellus luctus mauris eu purus dapibus, non bibendum purus eleifend. Suspendisse eu orci dolor. Maecenas nec purus hendrerit, auctor lorem et, pretium ex. Nulla suscipit, orci quis blandit hendrerit, dolor purus fermentum magna, elementum porttitor neque lorem fermentum ipsum. Donec eget egestas nisl. Sed sagittis, felis elementum semper.', 'https://images.unsplash.com/photo-1585838017777-5003198884b5?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=2766&q=80'),
(2, 'VINTAGE REVIVAL', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent vel molestie justo. Mauris nec eros sit amet diam condimentum tincidunt. Vestibulum a massa ligula. Aliquam feugiat congue velit, a blandit enim sagittis sit amet. Phasellus luctus mauris eu purus dapibus, non bibendum purus eleifend. Suspendisse eu orci dolor. Maecenas nec purus hendrerit, auctor lorem et, pretium ex. Nulla suscipit, orci quis blandit hendrerit, dolor purus fermentum magna, elementum porttitor neque lorem fermentum ipsum. Donec eget egestas nisl. Sed sagittis, felis elementum semper.', 'https://images.unsplash.com/photo-1494232410401-ad00d5433cfa?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1050&q=80'),
(3, 'WHO ARE WE? WHO, WHO?', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent vel molestie justo. Mauris nec eros sit amet diam condimentum tincidunt. Vestibulum a massa ligula. Aliquam feugiat congue velit, a blandit enim sagittis sit amet. Phasellus luctus mauris eu purus dapibus, non bibendum purus eleifend. Suspendisse eu orci dolor. Maecenas nec purus hendrerit, auctor lorem et, pretium ex. Nulla suscipit, orci quis blandit hendrerit, dolor purus fermentum magna, elementum porttitor neque lorem fermentum ipsum. Donec eget egestas nisl. Sed sagittis, felis elementum semper. Maecenas nec purus hendrerit, auctor lorem et, pretium ex. Nulla suscipit, orci quis blandit hendrerit, dolor purus fermentum magna, elementum porttitor neque lorem fermentum ipsum. Donec eget egestas nisl. Sed sagittis, felis elementum semper.', 'https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1050&q=80');

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Vinyl'),
(2, 'Bazar');

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `email` varchar(80) NOT NULL,
  `firstname` varchar(80) NOT NULL,
  `lastname` varchar(80) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `contact`
--

INSERT INTO `contact` (`id`, `email`, `firstname`, `lastname`, `message`) VALUES
(1, 'jpp_localhost@caramail.fr', 'Jean-Pol', 'Plus', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent vel molestie justo. Mauris nec eros sit amet diam condimentum tincidunt. Vestibulum a massa ligula. Aliquam feugiat congue velit, a blandit enim sagittis sit amet. Phasellus luctus mauris eu purus dapibus, non bibendum purus eleifend. Suspendisse eu orci dolor. Maecenas nec purus hendrerit, auctor lorem et, pretium ex. Nulla suscipit, orci quis blandit hendrerit, dolor purus fermentum magna, elementum porttitor neque lorem fermentum ipsum. Donec eget egestas nisl. Sed sagittis, felis elementum semper. Maecenas nec purus hendrerit, auctor lorem et, pretium ex. Nulla suscipit, orci quis blandit hendrerit, dolor purus fermentum magna, elementum porttitor neque lorem fermentum ipsum. Donec eget egestas nisl. Sed sagittis, felis elementum semper.'),
(2, 'jm_mafemme@yahoo.com', 'Jean-Michel', 'MaFemme', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent vel molestie justo. Mauris nec eros sit amet diam condimentum tincidunt. Vestibulum a massa ligula. Aliquam feugiat congue velit, a blandit enim sagittis sit amet. Phasellus luctus mauris eu purus dapibus, non bibendum purus eleifend. Suspendisse eu orci dolor. Maecenas nec purus hendrerit, auctor lorem et, pretium ex. Nulla suscipit, orci quis blandit hendrerit, dolor purus fermentum magna, elementum porttitor neque lorem fermentum ipsum. Donec eget egestas nisl. Sed sagittis, felis elementum semper. Maecenas nec purus hendrerit, auctor lorem et, pretium ex. Nulla suscipit, orci quis blandit hendrerit, dolor purus fermentum magna, elementum porttitor neque lorem fermentum ipsum. Donec eget egestas nisl. Sed sagittis, felis elementum semper.'),
(3, 'poil_poil@caramail.', 'Poil', 'Poil', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent vel molestie justo. Mauris nec eros sit amet diam condimentum tincidunt. Vestibulum a massa ligula. Aliquam feugiat congue velit, a blandit enim sagittis sit amet. Phasellus luctus mauris eu purus dapibus, non bibendum purus eleifend. Suspendisse eu orci dolor. Maecenas nec purus hendrerit, auctor lorem et, pretium ex. Nulla suscipit, orci quis blandit hendrerit, dolor purus fermentum magna, elementum porttitor neque lorem fermentum ipsum. Donec eget egestas nisl. Sed sagittis, felis elementum semper. Maecenas nec purus hendrerit, auctor lorem et, pretium ex. Nulla suscipit, orci quis blandit hendrerit, dolor purus fermentum magna, elementum porttitor neque lorem fermentum ipsum. Donec eget egestas nisl. Sed sagittis, felis elementum semper.');

-- --------------------------------------------------------

--
-- Structure de la table `newsletter`
--

CREATE TABLE `newsletter` (
  `id` int(11) NOT NULL,
  `email` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `newsletter`
--

INSERT INTO `newsletter` (`id`, `email`) VALUES
(1, 'jpp_localhost@caramail.fr'),
(2, 'jm_mafemme@yahoo.com'),
(3, 'aminator_contact@gmail.com'),
(4, 'antoinotor_navbar@aol.fr'),
(5, 'ppaulinator_design@hotmail.fr'),
(6, 'annator_blog@yahoo.fr'),
(7, 'justinator_article@localhost.com'),
(8, 'eddy_crud@8888.fr');

-- --------------------------------------------------------

--
-- Structure de la table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` date NOT NULL,
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `order_product`
--

CREATE TABLE `order_product` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `order_product`
--

INSERT INTO `order_product` (`id`, `order_id`, `product_id`, `quantity`) VALUES
(1, 1, 7, 1);

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `title` varchar(80) NOT NULL,
  `artist` varchar(150) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `size_id` int(11) DEFAULT NULL,
  `description` text NOT NULL,
  `picture` varchar(250) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id`, `title`, `artist`, `category_id`, `size_id`, `description`, `picture`, `price`, `quantity`) VALUES
(1, 'COMING HOME', 'LEON BRIDGES', 1, 1, 'RETRO SOUL REVIVALIST DEBUT ALBUM. You know when old timers look at someone that seems out of place and they\'re like \'you got an old soul\'? Pretty sure this phrase was created for Leon Bridges and we just had to wait for him to get old enough for it to make sense. The young Fort Worth based soul singer takes you on a walk down memory lane with his smooth vintage soul tunes often compared to Sam Cooke. Recommended.\r\n\r\nmusic label: Columbia 2015', 'https://cdn.shopify.com/s/files/1/0105/4542/products/leonbridges-cominghome_1800x.jpg?v=1571264392', 25, 6),
(2, 'RUMOURS', 'FLEETWOOD MAC', 1, 1, 'OFFICIAL REISSUE OF FLEETWOOD MAC\'S RUMOURS. Not the rarest record by any means (it is after all the second biggest-selling record of all time), but still heavily sweated amongst DJs, collectors, and music lovers alike for good reason. This is the one with all hits. Classic and essential.\r\n\r\nmusic label: Warner Brothers 2020', 'https://cdn.shopify.com/s/files/1/0105/4542/products/fleetwoodmac-rumours-blackvinyl-1_1800x.jpg?v=1606776358', 20, 4),
(3, 'NO DISTRACTION', 'BECK', 1, 2, 'SIDE A “No Distraction (Khraungbin Remix)”\r\nSIDE B “Uneventful Days (St Vincent Remix)”\r\n\r\nmusic label: Capitol 2020', 'https://images-ext-1.discordapp.net/external/vmf6fImqCSfjTyuHlov88E0GBg_-NZLNk0VwqkmNmwI/%3Fv%3D1604085018/https/cdn.shopify.com/s/files/1/0105/4542/products/MacintoshPlusFloralShoppe_BubblegumPinkVinyl_VinylLP_1800x.jpg?width=1760&height=1760', 15, 2),
(4, 'DON\'T STOP BELIEVIN\'', 'JOURNEY', 1, 2, 'Don\'t Stop Believin\' is a song by the American rock band Journey, originally released as a single from their 1981 album Escape; it became an immediate hit, reaching number nine on the Billboard Hot 100. In the United Kingdom, the song did not enter the top 40 upon its release; however, it reached number six on a 2009 re-release, its popularity having increased due to its recurring use in the musical series Glee.\r\n\r\nmusic label: Warner Brothers 1981', 'https://cdn.shopify.com/s/files/1/0105/4542/products/hozanyamamoto-bambooflute_1800x.jpg?v=1572021754', 13, 2),
(5, 'GIMME FICTION', 'SPOON\r\n', 1, 1, 'Spoon\'s classic Gimme Fiction pressed onto limited red and white vinyl. Featuring the hit single \'I Turn My Camera On,\' as well as other tracks included on the recent greatest hits Everything Hits At Once: The Best of Spoon, the new edition is included in an ongoing campaign highlighting Spoon\'s expansive catalog.', 'https://cdn.shopify.com/s/files/1/0105/4542/products/spoon-gimmefiction-coloredvinyl-1_1800x.jpg?v=1618773756', 25, 1),
(6, 'WELFARE VINYL LP', 'VIAGRA BOYS', 1, 2, 'Since their founding in 2015, Swedish post-punk band Viagra Boys have made a name for themselves burning up stages around the world. There\'s a little Iggy Pop spit and seethe, a David Yow drunken stumble, and a bite of Nick Cave\'s haunted bark. Add a dash of motorik groove, a pinch of post-punk grime, and a dose of no wave howl. Welfare Jazz doesn\'t bargain with the anxiety in that defeated feeling, but rather a boiling certainty that nothing and no one is absolute. There\'s plenty of blame to go around, and things are just a lot more interesting when you admit that you\'re not always going to be nice, you\'re not always going to pick the right words in a fist-fight. So why not keep moving forward, swaying and strutting into the night.', 'https://cdn.shopify.com/s/files/1/0105/4542/products/viagraboys-welfarejazz-blackvinyl-1_1800x.jpg?v=1614816028', 45, 2),
(7, 'PLATINE PORTATIVE', '', 2, 3, 'Portable turntable: A concept that overcomes the inherent inconveniences of the vinyl record format\r\n\r\nVinyl turntables are not only of interest to DJs and other music professionals. They also attract audiophiles who want to listen to music the old-fashioned way, through vinyl. Many of them want to buy a portable record player instead of a fixed format. This is partly due to a need for convenience in the daily use of a record player.', 'https://images-ext-2.discordapp.net/external/SQ66i6_jwomUe4Z7vc5DLVIn-7QWElbGLb2xGG13tpg/%3Fixlib%3Drb-1.2.1%26q%3D80%26fm%3Djpg%26crop%3Dentropy%26cs%3Dtinysrgb%26w%3D1080%26fit%3Dmax/https/images.unsplash.com/photo-1558584609-1301000a9db5', 150, 10),
(8, 'PLATINE MK2', NULL, 2, 3, 'It is widely regarded as the most durable and strongest turntable ever produced, so much so that most units made in the 1970s are still widely used today. The material has not been produced since 2010. Production resumed in 2014 after many people came forward to Technics, which reportedly received over 20,000 letters of request to resume production. Only 20 handcrafted examples with great care leave the Technics factory located in Japan every day. ', 'https://images-ext-1.discordapp.net/external/zhxK9o1nfdCqDbdq40R2ufJzW5WLCyAldAWDofvHdq8/%3Fixlib%3Drb-1.2.1%26q%3D80%26fm%3Djpg%26crop%3Dentropy%26cs%3Dtinysrgb%26w%3D1080%26fit%3Dmax/https/images.unsplash.com/photo-1505672984986-b7c468c7a134', 235, 5),
(9, 'STRANGE NIGHTS - AFFICHE', '', 2, 3, 'Affiliated with the psychedelic rock scene, the group distinguished itself by a protean and rather peculiar music, borrowing at the same time from blues (Cars Hiss by My Window), from pop (Touch Me), from funk (Peace Frog), from jazz5 (Shaman\'s Blues) but also from flamenco (Spanish Caravan), and from opera (Alabama Song), and deeply influenced by art and poetry in particular6. All these characteristics have made the Doors a \"cult\" band that has inspired many artists.', 'https://i.pinimg.com/originals/a7/1e/3b/a71e3b667bffc9683e97a281fc555f0b.jpg', 20, 6);

-- --------------------------------------------------------

--
-- Structure de la table `size`
--

CREATE TABLE `size` (
  `id` int(11) NOT NULL,
  `name` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `size`
--

INSERT INTO `size` (`id`, `name`) VALUES
(1, 'Vinyl 33'),
(2, 'Vinyl 45'),
(3, '--');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstname` varchar(80) NOT NULL,
  `lastname` varchar(80) NOT NULL,
  `email` varchar(80) NOT NULL,
  `address` text NOT NULL,
  `password` varchar(250) NOT NULL,
  `is_admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `email`, `address`, `password`, `is_admin`) VALUES
(1, 'MICHEL', 'Jean', 'jean.michel@gmail.com', '1 rue de la Poisse 75002 PARIS', '9d99c9082b6b8f4633a7a85fa1e59976', 1),
(2, 'PAUL', 'Jean', 'jean.paul@caramail.fr', '125 rue de la Poisse 93310 Le Pré-Saint-Gervais', '44da0066463bf2a2ef13536e8d6c73c4', 1),
(3, 'BERTHIER', 'Jean-Michel', 'jean-michel.berthier@yahoo.com', '6 rue de la Poisse 94041 Ivry-sur-Seine', 'dcbd4890a668be07d924c296bf1f5777', 0),
(4, 'RANU', 'Jean-Christian', 'jc.ranu@gmail.com', '89 rue de la Poisse 75033 Paris', '7715df2a5e7aa152c97e9797c68175ce', 0),
(5, 'Couçi', 'COUÇA', 'coco@gmail.com', '25 rue de l\'Ailleurs 93100 LOIN', '4c9d1e52d4707c822f0e6c6978764d71', 0),
(6, 'JEAN', 'Jean', 'jean.jean@outlook.com', '8 rue du Général Pas-de-Bol 96000 ABON', '52bd5c10122eb5bda98e7a774b207893', 0),
(7, 'DISCO', 'Dance', 'disco.dance@lycoos.com', '2 rue du Potiron 80500 RONRON', '19b1898c952bc4ec9ee2b335431fb0cc', 1),
(8, 'PLOP', 'Plop', 'plop@plop.com', '3 rue plop 35012 PLOPCITY-sur-PLOP', '4239d722d57a970d99664fcb3ba726b2', 0);

-- --------------------------------------------------------

--
-- Structure de la table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Index pour la table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_order_user` (`user_id`);

--
-- Index pour la table `order_product`
--
ALTER TABLE `order_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_order_product_order` (`order_id`),
  ADD KEY `FK_order_product_product` (`product_id`);

--
-- Index pour la table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_product_category` (`category_id`),
  ADD KEY `FK_product_size` (`size_id`);

--
-- Index pour la table `size`
--
ALTER TABLE `size`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_user_wishlist` (`user_id`),
  ADD KEY `FK_product_wishlist` (`product_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `order_product`
--
ALTER TABLE `order_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `size`
--
ALTER TABLE `size`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `FK_order_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `order_product`
--
ALTER TABLE `order_product`
  ADD CONSTRAINT `FK_order_product_order` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`),
  ADD CONSTRAINT `FK_order_product_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Contraintes pour la table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `FK_product_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `FK_product_size` FOREIGN KEY (`size_id`) REFERENCES `size` (`id`);

--
-- Contraintes pour la table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);


