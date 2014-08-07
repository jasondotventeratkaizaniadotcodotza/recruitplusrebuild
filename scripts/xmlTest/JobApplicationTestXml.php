<?php

$xml = 'test.xml';
//$filename = 'CV.txt';
$filename = 'DOC.jpg';

$contents = file_get_contents($filename);

$encodedData = base64_encode($contents);

$xmlString = <<<XML
<?xml version="1.0" encoding="UTF-8" ?>
<data>
    <firstName>Csabi</firstName>
    <lastName>NewLastName</lastName>
    <email>cs_csabi87@yahoo.com</email>
    <jobListingId>1</jobListingId>
    <allowCvSearch>true</allowCvSearch>
    <cv>$encodedData</cv>
    <cvFilename>DOC</cvFilename>
    <cvExtension>jpg</cvExtension>
    <xml>1</xml>
</data>
XML;

file_put_contents($xml, $xmlString);

$ch = curl_init();

$data = array(
    'xml' => '@/var/www/recruit.vagrant/scripts/xmlTest/' . $xml,
);

curl_setopt($ch, CURLOPT_URL, '33.33.33.11/job-listing/apply');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
curl_setopt($ch, CURLOPT_TIMEOUT, 60);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

curl_exec($ch);

?>