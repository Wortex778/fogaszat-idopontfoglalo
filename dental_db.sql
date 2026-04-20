-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2026. Ápr 20. 02:12
-- Kiszolgáló verziója: 10.4.28-MariaDB
-- PHP verzió: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `dental_db`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `status` varchar(20) DEFAULT 'függő',
  `doctor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `appointments`
--

INSERT INTO `appointments` (`id`, `user_id`, `service_id`, `date`, `time`, `status`, `doctor_id`) VALUES
(1, 5, 1, '2026-04-01', '17:00:00', 'elfogadva', NULL),
(2, 7, 2, '2026-04-20', '09:00:00', 'függő', NULL),
(4, 7, 2, '2026-04-19', '10:00:00', 'függő', NULL),
(5, 7, 1, '2026-04-19', '09:00:00', 'függő', NULL),
(6, 7, 1, '2026-04-19', '08:00:00', 'függő', NULL),
(7, 7, 1, '2026-04-20', '08:00:00', 'függő', 3),
(8, 7, 1, '2026-04-24', '11:00:00', 'függő', 1),
(9, 7, 1, '2026-04-22', '08:00:00', 'függő', 1),
(10, 8, 1, '2026-04-20', '15:00:00', 'függő', 1),
(11, 8, 16, '2026-04-20', '10:00:00', 'függő', 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `specialization` varchar(100) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `doctors`
--

INSERT INTO `doctors` (`id`, `name`, `specialization`, `service_id`) VALUES
(1, 'Dr. Kovács Anna', 'Általános fogászat', 1),
(2, 'Dr. Szabó Péter', 'Általános fogászat', 5),
(3, 'Dr. Nagy Gábor', 'Fogszabályozás', NULL),
(4, 'Dr. Tóth Eszter', 'Implantológia', NULL);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `doctor_services`
--

CREATE TABLE `doctor_services` (
  `doctor_id` int(11) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `doctor_services`
--

INSERT INTO `doctor_services` (`doctor_id`, `service_id`) VALUES
(1, 1),
(2, 1),
(1, 2),
(2, 2),
(1, 3),
(2, 3),
(1, 4),
(2, 4),
(1, 7),
(2, 7),
(1, 8),
(2, 8),
(1, 9),
(2, 9),
(1, 10),
(2, 10),
(1, 11),
(2, 11),
(1, 12),
(2, 12),
(1, 13),
(2, 13),
(1, 14),
(2, 14),
(1, 15),
(2, 15),
(1, 16),
(2, 16),
(3, 5),
(1, 5),
(2, 5),
(4, 6),
(1, 6),
(2, 6),
(3, 8),
(4, 9);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `details` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `services`
--

INSERT INTO `services` (`id`, `name`, `description`, `price`, `duration`, `details`) VALUES
(1, 'Fogtömés', 'Fog javítása', 10000, 60, 'A fogtömés célja a sérült fog helyreállítása. Akkor szükséges, ha szuvasodás vagy kisebb törés jelentkezik. A kezelés gyors és fájdalommentes.'),
(2, 'Fogkő eltávolítás', 'Tisztítás', 8000, 30, 'A fogkő eltávolítás segít megelőzni az ínybetegségeket. Ajánlott évente legalább egyszer elvégezni. Gyors és kíméletes eljárás.'),
(3, 'Gyökérkezelés', 'Fájdalmas fog kezelése', 20000, 90, 'A gyökérkezelés a fertőzött fog megmentésére szolgál. Akkor szükséges, ha a fog belseje begyullad. Több alkalmas kezelés lehet.'),
(7, 'Fogfehérítés', 'Esztétikai fogfehérítés modern technológiával', 30000, 60, 'A fogfehérítés esztétikai kezelés, amely világosabbá teszi a fogakat. Dohányzás vagy kávé okozta elszíneződésnél ajánlott.'),
(8, 'Fogszabályozás', 'Fogak helyreigazítása készülékkel', 150000, 120, 'A fogszabályozás segít a fogak helyes pozíciójának kialakításában. Hosszabb kezelési folyamat, de tartós eredményt ad.'),
(9, 'Implantátum beültetés', 'Hiányzó fog pótlása implantátummal', 120000, 120, 'Az implantátum a hiányzó fog pótlására szolgál. Tartós és esztétikus megoldás. Sebészeti beavatkozást igényel.'),
(10, 'Korona készítés', 'Fogkorona felhelyezése sérült fogra', 50000, 120, 'A korona a sérült fog védelmét szolgálja. Erősíti és esztétikailag is javítja a fog megjelenését.'),
(11, 'Híd készítés', 'Több fog pótlása híddal', 90000, 120, 'A híd több hiányzó fog pótlására alkalmas. Stabil és tartós megoldás. Több fog bevonásával készül.'),
(12, 'Szájhigiéniai kezelés', 'Teljes száj tisztítás és polírozás', 10000, 45, 'A szájhigiéniai kezelés segít a fogak és az íny egészségének megőrzésében. Rendszeres tisztítást és polírozást tartalmaz.'),
(13, 'Röntgen vizsgálat', 'Digitális fogászati röntgen', 5000, 30, 'A röntgen vizsgálat segít a rejtett problémák feltárásában. Gyors és fájdalommentes diagnosztikai módszer.'),
(14, 'Konzultáció', 'Állapotfelmérés és tanácsadás', 3000, 30, 'A konzultáció során felmérjük a fogak állapotát és kezelési tervet készítünk. Ajánlott minden új páciensnek.'),
(15, 'Foghúzás', 'Egyszerű fogeltávolítás', 15000, 90, 'A foghúzás akkor szükséges, ha a fog nem menthető. Gyors beavatkozás, helyi érzéstelenítéssel történik.'),
(16, 'Sebészeti foghúzás', 'Bonyolult fog eltávolítása', 30000, 120, 'A sebészeti foghúzás bonyolultabb esetekben szükséges. Gyakran bölcsességfogaknál alkalmazzuk.'),
(17, 'Barázdazárás', 'Gyermekeknél alkalmazott fogvédő kezelés', 12000, 45, 'A barázdazárás segít megelőzni a szuvasodást gyermekeknél. A fogak barázdáit zárjuk le védőanyaggal. Gyors és fájdalommentes kezelés.'),
(18, 'Fogékszer felhelyezés', 'Esztétikai díszítés a fogon', 8000, 30, 'A fogékszer felhelyezés esztétikai célú beavatkozás. Kis díszt helyezünk a fog felszínére. Nem károsítja a fogat.'),
(19, 'Ínykezelés', 'Gyulladt íny kezelése és tisztítása', 18000, 60, 'Az ínykezelés a gyulladt íny kezelésére szolgál. Segít megelőzni a komolyabb ínybetegségeket. Rendszeres tisztítással történik.'),
(20, 'Ideiglenes tömés', 'Átmeneti fogkezelés fájdalom csökkentésére', 7000, 60, 'Az ideiglenes tömés átmeneti megoldás a fog védelmére. Akkor alkalmazzuk, ha a végleges kezelés később történik. Csökkenti a fájdalmat.'),
(21, 'Harapásemelés', 'Állkapocs problémák kezelése', 25000, 60, 'A harapásemelés az állkapocs problémák kezelésére szolgál. Segít a helyes harapás kialakításában. Hosszabb távú kezelés lehet.');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Teszt Elek', 'teszt@gmail.com', '1234', NULL, '2026-03-31 18:29:29'),
(2, 'Teszt Elek', 'teszt@gmail.com', '1234', 'user', '2026-03-31 18:47:00'),
(3, 'qw', 'qw@fd', 'qw', 'user', '2026-03-31 18:47:09'),
(4, '', '', '', 'user', '2026-03-31 18:47:10'),
(5, 'Admin', 'admin@test.com', '1234', 'user', '2026-03-31 19:02:03'),
(6, 'boti', 'boti@gmail.com', '123', 'user', '2026-03-31 20:03:02'),
(7, 'boti', 'kovacsbotond035@gmail.com', '$2y$10$Hc/eTTA44WzDha9kGxX9X.ew6uO8eD3XFS1ebsp6OPYJT6Ydsyagu', 'admin', '2026-04-19 18:27:02'),
(8, 'korte', 'korte@gmail.com', '$2y$10$j4HT7BKozY/SkTyewRoGM.crXK96vF.SwjxFTdj3hW1zpxrsfSNs.', 'user', '2026-04-20 00:07:09');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT a táblához `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT a táblához `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
