INSERT INTO `recruitplus`.`roles` (`id`, `role`, `parentId`) VALUES
(1, 'guest', 0),
(2, 'administrator', 1),
(3, 'superadministrator', 2),
(4, 'seeker', 1),
(5, 'recruiter', 1),
(6, 'premium recruiter', 5);

--//@UNDO

TRUNCATE TABLE `roles`;

--//