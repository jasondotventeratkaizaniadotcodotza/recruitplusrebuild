INSERT INTO `recruitplus`.`resources` (`id`, `resource`) VALUES
(1, '*/*'),
(2, 'index/*'),
(3, 'index/index'),
(4, 'error/*'),
(5, 'error/error'),
(6, 'login/*'),
(7, 'login/index'),
(8, 'login/logout'),
(9, 'job-listing/*'),
(10, 'job-listing/index'),
(11, 'job-listing/add'),
(12, 'job-listing/edit'),
(13, 'job-listing/delete'),
(14, 'job-listing/view'),
(15, 'feed/*'),
(16, 'feed/index'),
(17, 'feed/rss'),
(18, 'user/*'),
(19, 'user/index'),
(20, 'user/information');

--//@UNDO

TRUNCATE TABLE `resources`;

--//