<?php

/**
 * Description of AbstractRepository
 *
 * @author Csabi
 */

namespace RM\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class AbstractRepository extends EntityRepository
{

    const DB_IP = '33.33.33.11';
    const MEMCACHE_PORT = 11211;

    public $memcache;
    public $host;
    public $port;
    public $cacheDriver;

    public function getRmCacheDriver()
    {
        $this->memcache = new \Memcache();
        $this->memcache->connect(self::DB_IP, self::MEMCACHE_PORT);
        $this->cacheDriver = new \Doctrine\Common\Cache\MemcacheCache();
        $this->cacheDriver->setMemcache($this->memcache);
        return $this->cacheDriver;
    }

}
