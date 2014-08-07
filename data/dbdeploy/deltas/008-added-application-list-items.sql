INSERT INTO `lists` (`id`, `listShortName`, `listName`) VALUES
(11, 'applicationEntryStatus', 'Application Entry Status'),
(12, 'jobApplicationStatus', 'Job Application Status'),
(13, 'jobAlerts', 'Job Alerts'),
(14, 'jobApplicationSource', 'Job Application Source');


INSERT INTO `list_items` (`id`, `itemId`, `name`, `listId`, `displayOrder`, `defaultValue`) VALUES
(55, 1, 'New', 11, 100, 1),
(56, 2, 'Completed', 11, 100, 0),
(57, 3, 'Deleted', 11, 100, 0),
(58, 4, 'Blacklisted', 11, 100, 0),
(59, -1, 'Not Specified', 12, 100, 1),
(60, 1, 'Short List', 12, 100, 0),
(61, 2, 'Maybe', 12, 100, 0),
(62, 3, 'Rejected', 12, 100, 0),
(63, 4, 'Interviewing', 12, 100, 0),
(64, 5, 'Offer Made', 12, 100, 0),
(65, 6, 'Appointed', 12, 100, 0),
(66, -1, 'Not Specified', 13, 100, 1),
(67, 1, 'No', 13, 100, 0),
(68, 2, 'Yes', 13, 100, 0),
(69, -1, 'Not Specified', 14, 100, 0),
(70, 1, 'Direct', 14, 100, 0),
(71, 2, 'Gumtree', 14, 100, 0),
(72, 3, 'Best Jobs', 14, 100, 0),
(73, 4, 'LinkedIn', 14, 100, 0);

--//@UNDO

--//