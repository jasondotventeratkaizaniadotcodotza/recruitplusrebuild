INSERT INTO `lists` (`id`, `listShortName`, `listName`) VALUES
(19, 'attachmentStatus', 'Attachment Status'),
(20, 'attachmentType', 'Attachment Type');


INSERT INTO `list_items` (`id`, `itemId`, `name`, `listId`, `displayOrder`, `defaultValue`) VALUES
(86, 1, 'Pending', 19, 98, 0),
(87, 2, 'Uploaded', 19, 99, 1),
(88, 3, 'Deleted', 19, 100, 0),
(89, 1, 'CV', 20, 98, 1),
(90, 2, 'Certification', 20, 99, 0),
(91, 3, 'Other', 20, 100, 0);

--//@UNDO

--//