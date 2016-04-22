SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO"; -- change?
SET time_zone = "+00:00"; -- change?

--
-- Database: `botcards`
--


--
-- collections table
--

DROP TABLE IF EXISTS collections;
CREATE TABLE IF NOT EXISTS collections (
  token char(6) NOT NULL,
  piece char(5) NOT NULL,
  broker varchar(255),
  player varchar(25) NOT NULL, 
  datetime datetime NOT NULL,
  PRIMARY KEY (token)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO collections (token, piece, player, datetime) VALUES
('1BB155', '11b-2', 'George', '2016.02.01-09:01:00'),
('1E654C', '11b-2', 'Mickey', '2016.02.01-09:01:02'),
('1DE9BB', '11b-2', 'Donald', '2016.02.01-09:01:04'),
('1BE8FA', '11c-0', 'George', '2016.02.01-09:01:06'),
('135745', '11a-0', 'Donald', '2016.02.01-09:01:08'),
('1A2EE5', '11c-0', 'Donald', '2016.02.01-09:01:10'),
('11F084', '11a-1', 'Donald', '2016.02.01-09:01:12'),
('1ADF71', '11a-1', 'George', '2016.02.01-09:01:14'),
('1C292C', '11b-0', 'George', '2016.02.01-09:01:16'),
('1E095A', '11c-2', 'Donald', '2016.02.01-09:01:18'),
('132956', '11c-0', 'George', '2016.02.01-09:01:20'),
('1359B6', '11a-0', 'Mickey', '2016.02.01-09:01:22'),
('139244', '11c-0', 'George', '2016.02.01-09:01:24'),
('12072C', '11c-0', 'Henry', '2016.02.01-09:01:26'),
('1C58FB', '11c-2', 'Donald', '2016.02.01-09:01:28'),
('11F0C5', '11b-1', 'George', '2016.02.01-09:01:30'),
('1AB11B', '11a-2', 'Henry', '2016.02.01-09:01:32'),
('1BB8CC', '11b-2', 'Henry', '2016.02.01-09:01:34'),
('14338A', '11c-0', 'George', '2016.02.01-09:01:36'),
('1D17DE', '11a-0', 'George', '2016.02.01-09:01:38'),
('17DC94', '11b-1', 'George', '2016.02.01-09:01:40'),
('1E5222', '11c-2', 'Donald', '2016.02.01-09:01:42'),
('19573B', '11a-2', 'Donald', '2016.02.01-09:01:44'),
('150417', '11b-2', 'Mickey', '2016.02.01-09:01:46'),
('1CA087', '11c-1', 'Mickey', '2016.02.01-09:01:48'),
('154281', '11c-0', 'Donald', '2016.02.01-09:01:50'),
('10DA3E', '11a-1', 'Mickey', '2016.02.01-09:01:52'),
('141117', '11c-2', 'Henry', '2016.02.01-09:01:54'),
('12268C', '11b-0', 'Mickey', '2016.02.01-09:01:56');

-- --------------------------------------------------------

-- players table

DROP TABLE IF EXISTS players;
CREATE TABLE IF NOT EXISTS players (
  player varchar(25) NOT NULL,
  peanuts integer NOT NULL,
  adminrole boolean NOT NULL,
  pwhash CHAR(128) NOT NULL,
  imgpath varchar(40) NOT NULL,
  PRIMARY KEY (player)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO players (player, peanuts, adminrole, pwhash, imgpath) VALUES
('Mickey', '200', FALSE, '$2y$10$ahhxkbfhlQx9lfZViF6SU.IKEeme1DDQuVVp8mLAI/WvMRqoMDt/m', '/data/uploads/mickey.jpg'), -- passwords for all these hashes are just 'password'
('Donald', '35', TRUE, '$2y$10$ahhxkbfhlQx9lfZViF6SU.IKEeme1DDQuVVp8mLAI/WvMRqoMDt/m', '/data/uploads/donald.jpg'),
('George', '500', FALSE, '$2y$10$ahhxkbfhlQx9lfZViF6SU.IKEeme1DDQuVVp8mLAI/WvMRqoMDt/m', '/data/uploads/george.jpg'),
('Henry', '100', FALSE, '$2y$10$ahhxkbfhlQx9lfZViF6SU.IKEeme1DDQuVVp8mLAI/WvMRqoMDt/m', '/data/uploads/henry.jpg');

-- --------------------------------------------------------

--
-- series table
--

DROP TABLE IF EXISTS series;
CREATE TABLE IF NOT EXISTS series (
  series integer NOT NULL,
  description varchar(25),
  frequency smallint NOT NULL,
  value smallint NOT NULL,
  PRIMARY KEY (series)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO series (series, description, frequency, value) VALUES
('11', 'Basic house bots', '100', '20'),
('13', 'House butlers', '50', '50'),
('26', 'Home companions', '20', '200');

-- --------------------------------------------------------

--
-- transactions table
--

DROP TABLE IF EXISTS transactions;
CREATE TABLE IF NOT EXISTS transactions (
  transaction_id integer NOT NULL AUTO_INCREMENT,
  datetime datetime NOT NULL,
  broker varchar(255),
  player varchar(25) NOT NULL,
  series smallint DEFAULT NULL,
  trans varchar(5) NOT NULL,
  PRIMARY KEY (transaction_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO transactions (datetime, player, series, trans) VALUES
('2016.02.01-09:01:00', 'Henry', '11', 'sell'),
('2016.02.01-09:01:05', 'George', NULL, 'buy'),
('2016.02.01-09:01:10', 'Mickey', NULL, 'buy'),
('2016.02.01-09:01:15', 'George', '13', 'sell'),
('2016.02.01-09:01:20', 'Henry', NULL, 'buy'),
('2016.02.01-09:01:25', 'Mickey', NULL, 'buy'),
('2016.02.01-09:01:30', 'Mickey', NULL, 'buy'),
('2016.02.01-09:01:35', 'Henry', NULL, 'buy'),
('2016.02.01-09:01:40', 'Henry', NULL, 'buy'),
('2016.02.01-09:01:45', 'Henry', '22', 'sell'),
('2016.02.01-09:01:50', 'Mickey', '11', 'sell'),
('2016.02.01-09:01:55', 'George', NULL, 'buy'),
('2016.02.01-09:01:60', 'George', NULL, 'buy');

-- --------------------------------------------------------

--
-- rounds table
--

DROP TABLE IF EXISTS rounds;
CREATE TABLE IF NOT EXISTS rounds (
  round integer NOT NULL,
  token varchar(255), -- to be honest I have no idea what the token will look like, so make this hueg to be safe
  PRIMARY KEY (round)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO rounds (round, token) VALUES
(0, '88ACD6FE280');

-- --------------------------------------------------------

--
-- registration data table
--

DROP TABLE IF EXISTS agent;
CREATE TABLE IF NOT EXISTS agent (
  team char(3) NOT NULL,
  name varchar(255),
  password varchar(30),
  PRIMARY KEY (team)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO agent (team, name, password) VALUES
('A04', 'cyberbot_autodb', 'tuesday');
