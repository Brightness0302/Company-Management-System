-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2022 at 08:17 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webproto_protoarch`
--

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(30) NOT NULL,
  `category` varchar(30) NOT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `product` tinyint(1) NOT NULL DEFAULT 0,
  `slideshowimage` tinyint(1) NOT NULL DEFAULT 0,
  `finest` tinyint(1) NOT NULL DEFAULT 0,
  `name` varchar(30) NOT NULL,
  `ename` varchar(30) NOT NULL,
  `location` varchar(30) DEFAULT NULL,
  `elocation` varchar(30) DEFAULT NULL,
  `investor` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `collaborators` varchar(255) DEFAULT NULL,
  `year` year(4) DEFAULT NULL,
  `square` varchar(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `text` mediumtext DEFAULT NULL,
  `etext` mediumtext DEFAULT NULL,
  `imgorder` varchar(100) NOT NULL,
  `videourl` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `category`, `featured`, `product`, `slideshowimage`, `finest`, `name`, `ename`, `location`, `elocation`, `investor`, `author`, `collaborators`, `year`, `square`, `status`, `text`, `etext`, `imgorder`, `videourl`) VALUES
(1, 'Culture', 0, 0, 0, 0, 'Garaža OTP - DTS', 'Garage OTP - DTS', 'Gruž, Dubrovnik', 'Gruz, Dubrovnik', 'Sanitat Dubrovnik d.o.o.', 'Proto-arch d.o.o.', 'Marijan Katić (vizualizacije)', 2018, '11384 m2', 0, 'Planirana javna garaža smještena je longitudinalno uz Ulicu dr. Ante Starčevića. Kolni pristup građevini odvija se preko Vukovarske ulice dok je pješački pristup moguć i s Ulice dr. Ante Starčevića. Građevina se sastoji od prizemlja, pet nadzemnih katova, prohodnog krova i dva podzemna kata. Fasada će biti obložena u perforirane metalne panele. Perforacije panela služiti će kao vizualni identitet garaže ali i za odimljavanje prostora. Promet se unutar građevine odvija jednosmjerno po etažama odnosno dvosmjerno preko rampe. Krovna etaža iako većinom popunjena parkirnim mjestima po potrebni može služiti i za javne manifestacije. U garaži će biti 404 parkirna mjesta.', 'The planned public garage is located longitudinally along Dr. Ante Starčević Street. Road access to the building takes place via Vukovarska Street, while pedestrian access is also possible from Dr. Ante Starčević Street. The building consists of a ground floor, five above-ground floors, a walk-through roof and two underground floors. The facade will be clad in perforated metal panels. The perforations of the panels will serve as the visual identity of the garage, but also to smoke the space. Traffic inside the building is one-way on the floors or two-way across the ramp. The roof floor, although mostly filled with parking spaces, can be used for public events as needed. There will be 404 parking spaces in the garage.', '2,1,', ''),
(2, 'Public', 1, 0, 0, 0, 'Frequency Store', 'Frequency Store', 'Frequency, Dubrovnik', 'Frequency, Dubrovnik', 'Sanitat Dubrovnik d.o.o.', 'Proto-arch d.o.o.', 'Marijan Katić (vizualizacije)', 2018, '11384 m2', 1, 'Planirana javna garaža smještena je longitudinalno uz Ulicu dr. Ante Starčevića. Kolni pristup građevini odvija se preko Vukovarske ulice dok je pješački pristup moguć i s Ulice dr. Ante Starčevića. Građevina se sastoji od prizemlja, pet nadzemnih katova, prohodnog krova i dva podzemna kata. Fasada će biti obložena u perforirane metalne panele. Perforacije panela služiti će kao vizualni identitet garaže ali i za odimljavanje prostora. Promet se unutar građevine odvija jednosmjerno po etažama odnosno dvosmjerno preko rampe. Krovna etaža iako većinom popunjena parkirnim mjestima po potrebni može služiti i za javne manifestacije. U garaži će biti 404 parkirna mjesta.', 'The planned public garage is located longitudinally along Dr. Ante Starčević Street. Road access to the building takes place via Vukovarska Street, while pedestrian access is also possible from Dr. Ante Starčević Street. The building consists of a ground floor, five above-ground floors, a walk-through roof and two underground floors. The facade will be clad in perforated metal panels. The perforations of the panels will serve as the visual identity of the garage, but also to smoke the space. Traffic inside the building is one-way on the floors or two-way across the ramp. The roof floor, although mostly filled with parking spaces, can be used for public events as needed. There will be 404 parking spaces in the garage.', '1,5,2,3,6,4,8,7,', '321'),
(3, 'Business', 0, 0, 1, 0, 'Biskupija', 'Diocese', 'Biskupija, Dubrovnik', 'Diocese, Dubrovnik', 'Sanitat Dubrovnik d.o.o.', 'Proto-arch d.o.o.', 'Marijan Katić (vizualizacije)', 2018, '11384 m2', 0, 'Planirana javna garaža smještena je longitudinalno uz Ulicu dr. Ante Starčevića. Kolni pristup građevini odvija se preko Vukovarske ulice dok je pješački pristup moguć i s Ulice dr. Ante Starčevića. Građevina se sastoji od prizemlja, pet nadzemnih katova, prohodnog krova i dva podzemna kata. Fasada će biti obložena u perforirane metalne panele. Perforacije panela služiti će kao vizualni identitet garaže ali i za odimljavanje prostora. Promet se unutar građevine odvija jednosmjerno po etažama odnosno dvosmjerno preko rampe. Krovna etaža iako većinom popunjena parkirnim mjestima po potrebni može služiti i za javne manifestacije. U garaži će biti 404 parkirna mjesta.', 'The planned public garage is located longitudinally along Dr. Ante Starčević Street. Road access to the building takes place via Vukovarska Street, while pedestrian access is also possible from Dr. Ante Starčević Street. The building consists of a ground floor, five above-ground floors, a walk-through roof and two underground floors. The facade will be clad in perforated metal panels. The perforations of the panels will serve as the visual identity of the garage, but also to smoke the space. Traffic inside the building is one-way on the floors or two-way across the ramp. The roof floor, although mostly filled with parking spaces, can be used for public events as needed. There will be 404 parking spaces in the garage.', '1,2,3,4,5,', ''),
(4, 'Interior', 0, 1, 1, 1, 'Kuca_r', 'Kuca_r', 'Kuca, Dubrovnik', 'Kuca, Dubrovnik', 'Sanitat Dubrovnik d.o.o.', 'Proto-arch d.o.o.', 'Marijan Katić (vizualizacije)', 2018, '11384 m2', 1, 'Planirana javna garaža smještena je longitudinalno uz Ulicu dr. Ante Starčevića. Kolni pristup građevini odvija se preko Vukovarske ulice dok je pješački pristup moguć i s Ulice dr. Ante Starčevića. Građevina se sastoji od prizemlja, pet nadzemnih katova, prohodnog krova i dva podzemna kata. Fasada će biti obložena u perforirane metalne panele. Perforacije panela služiti će kao vizualni identitet garaže ali i za odimljavanje prostora. Promet se unutar građevine odvija jednosmjerno po etažama odnosno dvosmjerno preko rampe. Krovna etaža iako većinom popunjena parkirnim mjestima po potrebni može služiti i za javne manifestacije. U garaži će biti 404 parkirna mjesta.', 'The planned public garage is located longitudinally along Dr. Ante Starčević Street. Road access to the building takes place via Vukovarska Street, while pedestrian access is also possible from Dr. Ante Starčević Street. The building consists of a ground floor, five above-ground floors, a walk-through roof and two underground floors. The facade will be clad in perforated metal panels. The perforations of the panels will serve as the visual identity of the garage, but also to smoke the space. Traffic inside the building is one-way on the floors or two-way across the ramp. The roof floor, although mostly filled with parking spaces, can be used for public events as needed. There will be 404 parking spaces in the garage.', '4,5,3,1,2,', '123'),
(25, 'Public', 0, 0, 1, 0, 'Phillip.S', 'Phillip.S', 'United State', 'United State', 'Sanitat Dubrovnik d.o.o.', 'Proto-arch d.o.o.', 'Marijan Katić (vizualizacije)', 2002, '11384 m21', 0, 'This is philllips.', 'This is philllips.', '3,2,4,1,', '321');

-- --------------------------------------------------------

--
-- Table structure for table `projects_gallery`
--

CREATE TABLE `projects_gallery` (
  `id` int(30) NOT NULL,
  `project_id` int(30) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `type` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `projects_gallery`
--

INSERT INTO `projects_gallery` (`id`, `project_id`, `name`, `type`) VALUES
(1, 1, 'John Doe', 'CEO'),
(2, 2, 'Jessica Doe', 'Marketing'),
(3, 3, 'Rick Edward Doe', 'Developer'),
(4, 4, 'Melinda Wolosky', 'Design'),
(23, 25, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `studio_timeline`
--

CREATE TABLE `studio_timeline` (
  `id` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `etitle` varchar(30) NOT NULL,
  `year` year(4) NOT NULL,
  `description` varchar(100) NOT NULL,
  `edescription` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `studio_timeline`
--

INSERT INTO `studio_timeline` (`id`, `title`, `etitle`, `year`, `description`, `edescription`) VALUES
(1, 'TEMELJ', 'FOUNDATION', 2006, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce elementum, nulla vel consequat, ante.', 'The pain itself is love, the main storage system. Fusce elementum, nulla vel consequat, ante.'),
(2, 'NOVI PARTNERI', 'NEW PARTNERS', 2012, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce elementum, nulla vel pellentesque con', 'The pain itself is love, the main storage system. Fusce elementum, nulla vel consequat, ante.'),
(3, 'NOVI URED', 'NEW OFFICE', 2021, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce elementum, nulla vel pellentesque con', 'The pain itself is love, the main storage system. Fusce elementum, nulla vel consequat, ante.'),
(4, '123', '123', 2008, '123', '123'),
(7, 'Milutin', 'Milutin', 2002, 'New invitation', 'New invitation'),
(8, 'Phillips', 'Phillipx', 1998, 'This is phillips', 'This is phillipx');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `fullname` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `fullname`, `email`, `password`) VALUES
(1, 'oceandev', 'oceandev2002@gmail.com', '123123'),
(2, 'jackysmith', 'jackysmith@gmail.com', '123123'),
(3, 'superman', 'superman@gmail.com', '123123'),
(4, 'test', 'test@gmail.com', '123123'),
(5, 'milutin', 'milutin.0.milicevic@gmail.com', '123123'),
(6, 'phillips98', 'phillips981122@outlook.com', '123123'),
(7, 'phillips', 'phillips9204@outlook.com', '123123'),
(8, 'Miroslav', 'miroslav.stevanovic.000@gmail.', '123123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects_gallery`
--
ALTER TABLE `projects_gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `studio_timeline`
--
ALTER TABLE `studio_timeline`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `projects_gallery`
--
ALTER TABLE `projects_gallery`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `studio_timeline`
--
ALTER TABLE `studio_timeline`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
