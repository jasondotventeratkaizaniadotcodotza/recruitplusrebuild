INSERT INTO `recruitplus`.`resources` (`id`, `resource`) VALUES
(21, 'login/check');

INSERT INTO `recruitplus`.`permissions` (
`id` ,
`permission` ,
`roleId` ,
`resourceId`
)
VALUES (
NULL , 'allow', '1', '21'
), (
NULL , 'allow', '4', '21'
), (
NULL , 'allow', '5', '21'
);

--//@UNDO

--//