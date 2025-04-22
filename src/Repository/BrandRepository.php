<?php

namespace Repository;
use Doctrine\ORM\EntityRepository;
use Entity\Brands;
class BrandRepository extends EntityRepository
{
    public function getAllBrands()
    {
        $qb = $this->getEntityManager()->createQuery("SELECT b FROM Entity\Brands b");
        return $qb->getResult();
    }
    public function getBrandById($id)
    {
        $qb = $this->getEntityManager()->createQuery("SELECT b FROM Entity\Brands b WHERE b.brand_id = :id");
        $qb->setParameter('id', $id);
        return $qb->getResult();
    }
    public function insertBrand($name)
    {
        $brand = new Brands();
        $brand->setBrandName($name);
        $this->getEntityManager()->persist($brand);
        $this->getEntityManager()->flush();
        return "ok";
    }
    public function updateBrand($id, $name)
    {
        $brand = $this->getEntityManager()->getRepository('Entity\Brands')->find($id);
        if (!$brand) {
            throw new \Exception("Brand not found");
        }
        $brand->setBrandName($name);
        $this->getEntityManager()->persist($brand);
        $this->getEntityManager()->flush();
        return "ok";
    }
    public function deleteBrand($id)
    {
        $brand = $this->getEntityManager()->getRepository('Entity\Brands')->find($id);
        if (!$brand) {
            throw new \Exception("Brand not found");
        }
        $qb = $this->getEntityManager()->createQuery("DELETE FROM Entity\Brands b WHERE b.brand_id = :id");
        $qb->setParameter("id", $id);
      
        return $qb->execute();
    }
    

}
