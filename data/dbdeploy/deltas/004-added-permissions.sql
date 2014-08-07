-- Insert Guest Permissions
INSERT INTO `recruitplus`.`permissions` (
`id` ,
`permission` ,
`roleId` ,
`resourceId`
)
VALUES (
NULL , 'allow', '1', '1'
), (
NULL , 'allow', '1', '2'
), (
NULL , 'allow', '1', '3'
), (
NULL , 'allow', '1', '4'
), (
NULL , 'allow', '1', '5'
), (
NULL , 'allow', '1', '6'
), (
NULL , 'allow', '1', '7'
), (
NULL , 'deny', '1', '8'
), (
NULL , 'allow', '1', '9'
), (
NULL , 'allow', '1', '10'
), (
NULL , 'allow', '1', '11'
), (
NULL , 'deny', '1', '12'
), (
NULL , 'deny', '1', '13'
), (
NULL , 'allow', '1', '14'
), (
NULL , 'allow', '1', '15'
), (
NULL , 'allow', '1', '16'
), (
NULL , 'allow', '1', '17'
), (
NULL , 'deny', '1', '18'
), (
NULL , 'deny', '1', '19'
), (
NULL , 'deny', '1', '20'
);

-- Insert Seeker Permissions

INSERT INTO `recruitplus`.`permissions` (
`id` ,
`permission` ,
`roleId` ,
`resourceId`
)
VALUES (
NULL , 'allow', '4', '1'
), (
NULL , 'allow', '4', '2'
), (
NULL , 'allow', '4', '3'
), (
NULL , 'allow', '4', '4'
), (
NULL , 'allow', '4', '5'
), (
NULL , 'allow', '4', '6'
), (
NULL , 'deny', '4', '7'
), (
NULL , 'allow', '4', '8'
), (
NULL , 'allow', '4', '9'
), (
NULL , 'allow', '4', '10'
), (
NULL , 'allow', '4', '11'
), (
NULL , 'deny', '4', '12'
), (
NULL , 'deny', '4', '13'
), (
NULL , 'allow', '4', '14'
), (
NULL , 'allow', '4', '15'
), (
NULL , 'allow', '4', '16'
), (
NULL , 'allow', '4', '17'
), (
NULL , 'allow', '4', '18'
), (
NULL , 'allow', '4', '19'
), (
NULL , 'allow', '4', '20'
);

-- Insert Recruiter Permissions

INSERT INTO `recruitplus`.`permissions` (
`id` ,
`permission` ,
`roleId` ,
`resourceId`
)
VALUES (
NULL , 'allow', '5', '1'
), (
NULL , 'allow', '5', '2'
), (
NULL , 'allow', '5', '3'
), (
NULL , 'allow', '5', '4'
), (
NULL , 'allow', '5', '5'
), (
NULL , 'allow', '5', '6'
), (
NULL , 'deny', '5', '7'
), (
NULL , 'allow', '5', '8'
), (
NULL , 'allow', '5', '9'
), (
NULL , 'allow', '5', '10'
), (
NULL , 'allow', '5', '11'
), (
NULL , 'allow', '5', '12'
), (
NULL , 'allow', '5', '13'
), (
NULL , 'allow', '5', '14'
), (
NULL , 'allow', '5', '15'
), (
NULL , 'allow', '5', '16'
), (
NULL , 'allow', '5', '17'
), (
NULL , 'allow', '5', '18'
), (
NULL , 'allow', '5', '19'
), (
NULL , 'allow', '5', '20'
);

--//@UNDO

TRUNCATE TABLE `permissions`;

--//