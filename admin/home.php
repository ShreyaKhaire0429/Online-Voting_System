SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(60) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `photo` varchar(150) NOT NULL,
  `created_on` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `admin` (`id`, `username`, `password`, `firstname`, `lastname`, `photo`, `created_on`) VALUES
(1, 'harie', 'Admin@123', 'Hariharan', 'Elancheliyan', 'facebook-profile-image.jpeg', '2018-04-02');

CREATE TABLE `candidates` (
  `id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `photo` varchar(150) NOT NULL,
  `year` int(5) NOT NULL,
  `platform` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `positions` (
  `id` int(11) NOT NULL,
  `description` varchar(50) NOT NULL,
  `max_vote` int(11) NOT NULL,
  `priority` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `voters` (
  `id` int(11) NOT NULL,
  `voters_id` varchar(15) NOT NULL,
  `password` varchar(60) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `photo` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `votes` (
  `id` int(11) NOT NULL,
  `voters_id` int(11) NOT NULL,
  `candidate_id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `ElectionDetails` (
  `election_year` int(11) NOT NULL,
  `election_date` date NOT NULL,
  `election_type` varchar(50) NOT NULL,
  `total_votes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `ElectionDetails` (`election_year`, `election_date`, `election_type`, `total_votes`) VALUES
(2023, '2023-11-07', 'Presidential', 10000000),
(2024, '2024-11-05', 'Presidential', 12000000);

CREATE VIEW MaxVotesPerYear AS
WITH ranked_candidates AS (
    SELECT
        candidate_id,
        YEAR(election_date) AS vote_year,
        COUNT(v.voters_id) AS total_votes,
        ROW_NUMBER() OVER (PARTITION BY YEAR(election_date) ORDER BY COUNT(v.voters_id) DESC) AS position
    FROM
        votes v
    JOIN ElectionDetails ed ON YEAR(v.election_date) = ed.election_year
    GROUP BY
        candidate_id,
        YEAR(election_date)
)
SELECT
    vote_year,
    candidate_id,
    total_votes,
    position
FROM
    ranked_candidates
WHERE
    position = 1;

COMMIT;
