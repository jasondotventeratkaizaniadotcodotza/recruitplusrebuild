<?php

namespace RM\Entity;

use Doctrine\ORM\EntityManager;
use RM\Entity\Geolocation;
use RM\Entity\Repository\GeolocationRepository;

class GeolocationService extends AbstractService
{

    const ID_KEY = 12;
    const NO_LOCATION_POSTAL_CODE = '0000';
    const NO_LOCATION_SPECIFIED = 'No Location Specified';
    const NO_LOCATION_ID = 1;
    const NO_LOCATION_ACCURACY = '';
    const NO_LOCATION_LATITUDE = '';
    const NO_LOCATION_LONGITUDE = '';

    public $entity;

    public function __construct(EntityManager $em)
    {
        parent::__construct($em);
    }

    public function createEntityFromFileRow($entity, $data)
    {
        foreach ($data as $key => $value) {
            if ($key != self::ID_KEY)
                $data[$key] = trim($value);
        }
        $entity->setCountryCode($data[0]);
        $entity->setPostalCode($data[1]);
        $entity->setPlaceName($data[2]);
        $entity->setAdminName1($data[3]);
        $entity->setAdminCode1($data[4]);
        $entity->setAdminName2($data[5]);
        $entity->setAdminCode2($data[6]);
        $entity->setAdminName3($data[7]);
        $entity->setAdminCode3($data[8]);
        $entity->setLatitude($data[9]);
        $entity->setLongitude($data[10]);
        $entity->setAccuracy($data[11]);
        $entity->setId($data[12]);
        return $entity;
    }

    public function getNewGeolocationEntity()
    {
        return new \RM\Entity\Geolocation();
    }

    public function initNoLocationRow($entity, $data)
    {
        $entity = $this->createEntityFromFileRow($entity, $data);
        $entity->setPostalCode(self::NO_LOCATION_POSTAL_CODE);
        $entity->setPlaceName(self::NO_LOCATION_SPECIFIED);
        $entity->setAccuracy(self::NO_LOCATION_ACCURACY);
        $entity->setLatitude(self::NO_LOCATION_LATITUDE);
        $entity->setLongitude(self::NO_LOCATION_LONGITUDE);
        $entity->setId(self::NO_LOCATION_ID);
        return $entity;
    }

    public function getGeolocationFromString($string)
    {
        if ($string != '') {
            $postalCodeInformation = explode(', ', $string);
            $geolocationEntity = $this->em->getRepository('RM\Entity\Geolocation')
                    ->findOneBy(array(
                'postalCode' => $postalCodeInformation[0],
                'placeName' => $postalCodeInformation[1]
                    ));
            if ($geolocationEntity == null)
                $geolocationEntity = $this->setUndefinedLocation();
        }
        return $geolocationEntity;
    }

    public function setUndefinedLocation()
    {
        return $this->em->getRepository('RM\Entity\Geolocation')
                        ->findOneBy(array(
                            'postalCode' => self::NO_LOCATION_POSTAL_CODE,
                            'placeName' => self::NO_LOCATION_SPECIFIED
                        ));
    }

}
