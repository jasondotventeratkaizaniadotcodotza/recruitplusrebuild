INSERT INTO `lists` (`id`, `listShortName`, `listName`) VALUES
(7, 'experienceLevel', 'Experience Level'),
(8, 'experienceYears', 'Experience Years');

INSERT INTO `list_items` (`id`, `itemId`, `name`, `listId`, `displayOrder`, `defaultValue`) VALUES
(32, -1, 'Not Specified', 7, 100, 1),
(33, 1, 'Executive', 7, 100, 0),
(34, 2, 'Director', 7, 100, 0),
(35, 3, 'Mid-Senior level', 7, 100, 0),
(36, 4, 'Associate', 7, 100, 0),
(37, 5, 'Entry level', 7, 100, 0),
(38, 6, 'Internship', 7, 100, 0),
(39, -1, 'Not Specified', 8, 100, 1),
(40, 1, 'No Experience Required', 8, 100, 0),
(41, 2, '1 year', 8, 100, 0),
(42, 3, '2 years', 8, 100, 0),
(43, 4, '3 years', 8, 100, 0),
(44, 5, '4 years', 8, 100, 0),
(45, 6, '5 years', 8, 100, 0),
(46, 7, '10 years', 8, 100, 0),
(47, 8, 'More than 10 years', 8, 100, 0);


--//@UNDO

--//