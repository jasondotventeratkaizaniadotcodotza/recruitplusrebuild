INSERT INTO `recruitplus`.`resources` (`id`, `resource`) VALUES
(22, 'job-listing/apply'),
(23, 'job-application/index'),
(24, 'job-application/change-status'),
(25, 'job-application/rate-application'),
(26, 'job-application/comment-application');

INSERT INTO `recruitplus`.`permissions` (
`id` ,
`permission` ,
`roleId` ,
`resourceId`
)
VALUES (
NULL , 'allow', '1', '22'
), (
NULL , 'allow', '4', '22'
), (
NULL , 'deny', '5', '22'
),
NULL , 'deny', '1', '23'
), (
NULL , 'deny', '4', '23'
), (
NULL , 'allow', '5', '23'
),
NULL , 'deny', '1', '24'
), (
NULL , 'deny', '4', '24'
), (
NULL , 'allow', '5', '24'
),
NULL , 'deny', '1', '25'
), (
NULL , 'deny', '4', '25'
), (
NULL , 'allow', '5', '25'
),
NULL , 'deny', '1', '26'
), (
NULL , 'deny', '4', '26'
), (
NULL , 'allow', '5', '26'
);

--//@UNDO

--//