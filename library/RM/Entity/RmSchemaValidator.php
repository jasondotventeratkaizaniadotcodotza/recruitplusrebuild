<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SchemaValidator
 *
 * @author User
 */

namespace RM\Entity;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaValidator;

class RmSchemaValidator
{

    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function validateSchema()
    {
        $validator = new SchemaValidator($this->em);
        $errors = $validator->validateMapping();
        return $errors;
    }

}