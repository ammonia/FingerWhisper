-- phpMyAdmin SQL Dump
-- version 2.11.2.1
-- http://www.phpmyadmin.net
--
-- localhost
-- 2014/03/06 09:14
-- server 5.0.45
-- PHP 5.2.5

-- Database: `fingerwhisper`

-- Table `circle`
-- A linked list 

CREATE TABLE `circle` (
  `id` int(11) NOT NULL auto_increment,
  `roomid` int(11) NOT NULL,
  `peopleid` int(11) NOT NULL,
  `pre` int(11) NOT NULL,
  `next` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `roomid` (`roomid`,`peopleid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- Table `people`
--

CREATE TABLE `people` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(20) NOT NULL default 'Anonymous',
  `password` varchar(100) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- Table `room`
-- There's a circle in each room

CREATE TABLE `room` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(20) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- Table `talk`
-- Words people said when state = 0
-- state=1: One join the circle; state=-1: One left.

CREATE TABLE `talk` (
  `id` int(11) NOT NULL auto_increment,
  `roomid` int(11) NOT NULL,
  `peopleid` int(11) NOT NULL,
  `words` varchar(210) NOT NULL,
  `state` tinyint(4) NOT NULL default '0',
  `phptime` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
