INSERT INTO `lists` (`id`, `listShortName`, `listName`) VALUES
(15, 'recruiterPaymentPeriod', 'Recruiter Payment Period'),
(16, 'recruiterApplicationNotifications', 'Recruiter Application Notifications'),
(17, 'recruiterUserType', 'Recruiter User Type'),
(18, 'recruiterStatus', 'Recruiter Status');


INSERT INTO `list_items` (`id`, `itemId`, `name`, `listId`, `displayOrder`, `defaultValue`) VALUES
(74, 1, 'Adhoc', 15, 100, 1),
(75, 2, 'Monthly', 15, 100, 0),
(76, 3, 'Yearly', 15, 100, 0),
(77, 1, 'No Notifications', 16, 100, 1),
(78, 2, 'Daily Digest', 16, 100, 0),
(79, 3, 'Real Time', 16, 100, 0),
(80, 1, 'Super User', 17, 100, 1),
(81, 2, 'Standard User', 17, 100, 0),
(82, 1, 'Pending', 18, 100, 1),
(83, 2, 'Enabled', 18, 100, 0),
(84, 3, 'Disabled', 18, 100, 0),
(85, 4, 'Blacklisted', 18, 100, 0);

--//@UNDO

--//