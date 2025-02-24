-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost
-- Üretim Zamanı: 25 Şub 2025, 01:51:16
-- Sunucu sürümü: 10.6.19-MariaDB
-- PHP Sürümü: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `arif_quicksurvey`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `form_types`
--

CREATE TABLE `form_types` (
  `id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `description` varchar(55) NOT NULL,
  `path_name` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `form_types`
--

INSERT INTO `form_types` (`id`, `name`, `description`, `path_name`) VALUES
(3, 'Emoji Rating', '', '/user/home.php'),
(4, 'Multiple Choice', '', '/user/multiplechoice.php'),
(5, 'Range Number', '', '/user/inputnum.php'),
(6, 'Yes/No', '', '/user/polarquestions.php'),
(7, 'Short Text', '', '/user/stext.php'),
(8, 'Long Text', '', '/user/ltext.php'),
(9, 'Number', '', '/user/freeint.php'),
(10, 'Rate 1-5', '', '/user/rate1_5.php'),
(11, 'Rate 0-10', '', '/user/rate0_10.php');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `profiles`
--

CREATE TABLE `profiles` (
  `id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `surname` varchar(55) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `responses`
--

CREATE TABLE `responses` (
  `id` int(11) NOT NULL,
  `survey_fields_id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `survey`
--

CREATE TABLE `survey` (
  `id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) NOT NULL,
  `title` varchar(55) NOT NULL,
  `description` varchar(255) NOT NULL,
  `hash_id` varchar(55) NOT NULL,
  `exp_date` timestamp NULL DEFAULT NULL,
  `isPrivacyMode` tinyint(1) NOT NULL DEFAULT 0,
  `isDeleted` int(11) NOT NULL DEFAULT 0,
  `backgroundColor` varchar(55) NOT NULL DEFAULT '#9588E8',
  `fontColor` varchar(55) NOT NULL DEFAULT '#ffffff',
  `publish_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `survey_fields`
--

CREATE TABLE `survey_fields` (
  `id` int(11) NOT NULL,
  `survey_id` int(11) NOT NULL,
  `type_id` int(11) DEFAULT 3,
  `min` int(11) DEFAULT NULL,
  `max` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT 'Your Question Here!',
  `description` varchar(55) DEFAULT NULL,
  `isOptional` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `company_name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `isEmailVerified` tinyint(1) NOT NULL DEFAULT 0,
  `verificationHashId` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `form_types`
--
ALTER TABLE `form_types`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `responses`
--
ALTER TABLE `responses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `survey_fields_id` (`survey_fields_id`),
  ADD KEY `profile_id` (`profile_id`);

--
-- Tablo için indeksler `survey`
--
ALTER TABLE `survey`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Tablo için indeksler `survey_fields`
--
ALTER TABLE `survey_fields`
  ADD PRIMARY KEY (`id`),
  ADD KEY `survey_id` (`survey_id`,`type_id`),
  ADD KEY `type_id` (`type_id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `company_name` (`company_name`,`email`),
  ADD UNIQUE KEY `company_name_2` (`company_name`,`email`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `form_types`
--
ALTER TABLE `form_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Tablo için AUTO_INCREMENT değeri `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Tablo için AUTO_INCREMENT değeri `responses`
--
ALTER TABLE `responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `survey`
--
ALTER TABLE `survey`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- Tablo için AUTO_INCREMENT değeri `survey_fields`
--
ALTER TABLE `survey_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=368;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `responses`
--
ALTER TABLE `responses`
  ADD CONSTRAINT `responses_ibfk_1` FOREIGN KEY (`survey_fields_id`) REFERENCES `survey_fields` (`id`),
  ADD CONSTRAINT `responses_ibfk_2` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`id`);

--
-- Tablo kısıtlamaları `survey`
--
ALTER TABLE `survey`
  ADD CONSTRAINT `survey_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Tablo kısıtlamaları `survey_fields`
--
ALTER TABLE `survey_fields`
  ADD CONSTRAINT `survey_fields_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `form_types` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `survey_fields_ibfk_2` FOREIGN KEY (`survey_id`) REFERENCES `survey` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
