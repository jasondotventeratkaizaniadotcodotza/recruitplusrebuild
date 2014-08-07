INSERT INTO `lists` (`id`, `listShortName`, `listName`) VALUES
(9, 'userStatus', 'User Status'),
(10, 'systemNotifications', 'System Notifications');


INSERT INTO `list_items` (`id`, `itemId`, `name`, `listId`, `displayOrder`, `defaultValue`) VALUES
(48, 1, 'Pending', 9, 100, 1),
(49, 2, 'Enabled', 9, 100, 0),
(50, 3, 'Disabled', 9, 100, 0),
(51, 4, 'Blacklisted', 9, 100, 0),
(52, -1, 'Not Specified', 10, 100, 1),
(53, 1, 'On', 10, 100, 0),
(54, 2, 'Off', 10, 100, 0);

--//@UNDO

--//