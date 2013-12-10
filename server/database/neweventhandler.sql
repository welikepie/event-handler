CREATE DATABASE IF NOT EXISTS `eventhandler2013` /*!40100 DEFAULT CHARACTER SET latin1 */$$;
USE `eventhandler2013`;
CREATE TABLE IF NOT EXISTS`speakerform` (
  `date` datetime NOT NULL,
  `name` text NOT NULL,
  `contactinfo` text NOT NULL,
  `association` text,
  `why` text,
  `what` text,
  `style` text,
  `length` text,
  `links` text,
  `lanyrd` varchar(45) DEFAULT NULL,
  `subjects` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1$$

