<?php

define('PARAM_JOBLISTING_ID', 'j');
define('PARAM_MESSAGE', 'm');
define('PARAM_EMAIL', 'e');
define('PARAM_HASH', 'h');
define('MESSAGE_SUCCESS', 'success');
define('MESSAGE_WARNING', 'warning');
define('MESSAGE_ERROR', 'error');
define('LINK_EXPIRATION_DAYS', 7);
defined('ATTACHMENTS_PATH')
    || define('ATTACHMENTS_PATH', realpath(dirname(__FILE__) . '/../../data/attachments/'));