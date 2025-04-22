<?php

namespace Repository;

use Doctrine\ORM\EntityRepository;
use Entity\Stores;
class StoreRepository extends EntityRepository
{
    public function getAllStore() {
        $qb=$this->getEntityManager()->createQuery("SELECT s FROM Entity\Stores s");
        return $qb->getResult();
    }
    public function getStoreById($id) {
        $qb=$this->getEntityManager()->createQuery("SELECT s FROM Entity\Stores s WHERE s.store_id = :id");
        $qb->setParameter('id',$id);
        return $qb->getResult();
    }
    public function insertStore($name, $email, $phone,$street,$zip_code,$city,$state) {
        $store = new Stores();
        $store->setStoreName($name);
        $store->setEmail($email);
        $store->setStreet($street);
        $store->setZipCode($zip_code);
        $store->setCity($city);	
        $store->setState($state);
        $store->setPhone($phone);
        $this->getEntityManager()->persist($store);
        $this->getEntityManager()->flush();
        return "ok";
    }
    public function updateStore($id, $name, $email, $phone,$street,$zip_code,$city,$state) {
        $store = $this->getEntityManager()->getRepository('Entity\Stores')->find($id);
        if (!$store) {
            throw new \Exception("Store not found");
        }
        $store->setStoreName($name);
        $store->setEmail($email);
        $store->setStreet($street);
        $store->setZipCode($zip_code);
        $store->setCity($city);	
        $store->setState($state);
        $store->setPhone($phone);
        $this->getEntityManager()->persist($store);
        $this->getEntityManager()->flush();
        return "ok";
    }
    public function deleteStore($id)
    {
        $brand = $this->getEntityManager()->getRepository('Entity\Stores')->getStoreById($id);
        if (!$brand) {
            throw new \Exception("Brand not found");
        }
        $qb = $this->getEntityManager()->createQuery("DELETE FROM Entity\Stores s WHERE s.store_id = :id");
        $qb->setParameter("id", $id);
        return $qb->execute();
    }
}
