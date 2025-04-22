<?php

namespace Repository;

use Doctrine\ORM\EntityRepository;
use Entity\Categories;
class CategorieRepository extends EntityRepository
{
    public function getAllCategories()
    {
        $qb = $this->getEntityManager()->createQuery("SELECT c FROM Entity\Categories c");
        return $qb->getResult();
    }
    public function getCategorieById($id)
    {
        $qb = $this->getEntityManager()->createQuery("SELECT c FROM Entity\Categories c WHERE c.category_id = :id");
        $qb->setParameter('id', $id);
        return $qb->getResult();
    }
    public function insertCategorie($name)
    {
        $categorie = new Categories();
        $categorie->setCategoryName($name);
        $this->getEntityManager()->persist($categorie);
        $this->getEntityManager()->flush();
        return "ok";
    }
    public function updateCategorie($id, $name)
    {
        $categorie = $this->getEntityManager()->getRepository('Entity\Categories')->find($id);
        if (!$categorie) {
            throw new \Exception("Categorie not found");
        }
        $categorie->setCategoryName($name);
        $this->getEntityManager()->persist($categorie);
        $this->getEntityManager()->flush();
        return "ok";
    }
    public function deleteCategorie($id)
    {
        $brand = $this->getEntityManager()->getRepository('Entity\Categories')->getCategorieById($id);
        if (!$brand) {
            throw new \Exception("Brand not found");
        }
        $qb = $this->getEntityManager()->createQuery("DELETE FROM Entity\Categories c WHERE c.category_id = :id");
        $qb->setParameter("id", $id);
        return $qb->execute();
    }
}
