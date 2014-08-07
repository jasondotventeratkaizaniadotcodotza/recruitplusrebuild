INSERT INTO `lists` (`id`, `listShortName`, `listName`) VALUES
(1, 'jobListingStatus', 'Job Listing Status'),
(2, 'advertisedBy', 'Advertised By'),
(3, 'jobListingType', 'Job Listing Type'),
(4, 'employmentEquity', 'Employment Equity'),
(5, 'industry', 'Industry'),
(6, 'category', 'Category');

INSERT INTO `list_items` (`id`, `itemId`, `name`, `listId`, `displayOrder`, `defaultValue`) VALUES
(1, 1, 'Loaded', 1, 0, 1),
(2, 2, 'Pending', 1, 0, 0),
(3, 3, 'Active', 1, 0, 0),
(4, 4, 'Deleted', 1, 0, 0),
(5, 1, 'Agency', 2, 1, 0),
(6, 2, 'Private', 2, 2, 0),
(7, 3, 'Not Specified', 2, 3, 1),
(8, -1, 'Not Selected', 3, 1, 1),
(9, 1, 'Casual', 3, 2, 0),
(10, 2, 'Temporary', 3, 2, 0),
(11, 3, 'Contract', 3, 2, 0),
(12, 4, 'Part-Time', 3, 2, 0),
(13, 5, 'Full-Time', 3, 2, 0),
(14, 6, 'Graduate', 3, 2, 0),
(15, 7, 'Internship', 3, 2, 0),
(16, 8, 'Volunteer', 3, 2, 0),
(17, 9, 'Other', 3, 100, 0),
(18, 1, 'EE / AA', 4, 0, 0),
(19, 2, 'Non EE / AA', 4, 0, 0),
(20, 3, 'Not Specified', 4, 0, 1),
(21, -1, 'Not Selected', 5, 1, 1),
(22, 1, 'Accounting', 5, 100, 0),
(23, 2, 'Airlines / Aviation', 5, 100, 0),
(24, 3, 'Alternative Dispute Resolution', 5, 100, 0),
(25, 4, 'Alternative Medicine', 5, 100, 0),
(26, 5, 'Animation', 5, 100, 0),
(27, -1, 'Not Selected', 6, 1, 1),
(28, 1, 'Administrative', 6, 100, 0),
(29, 2, 'Advertising', 6, 100, 0),
(30, 3, 'Analyst', 6, 100, 0),
(31, 4, 'Art/Creative', 6, 100, 0);

--//@UNDO

TRUNCATE TABLE `list_items`;
TRUNCATE TABLE `lists`;

--//