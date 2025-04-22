<?php

namespace Repository;

use Entity\Stocks;
use Entity\Stores;
use Entity\Products;

use Doctrine\ORM\EntityRepository;

class StockRepository extends EntityRepository
{
    public function getAllStock()
    {
        $qb = $this->getEntityManager()->createQuery("SELECT s FROM Entity\Stocks s");
        return $qb->getResult();
    }
    public function getStockById($id)
    {
        $qb = $this->getEntityManager()->createQuery("SELECT s FROM Entity\Stocks s WHERE s.stock_id = :id");
        $qb->setParameter('id', $id);
        return $qb->getResult();
    }
    public function getStockByStore($storeid)
    {
        $qb = $this->getEntityManager()->createQuery("SELECT s FROM Entity\Stocks s WHERE s.store = :storeid");
        $qb->setParameter('storeid', $storeid);
        return $qb->getResult();
    }
    public function getProductByStore($storeId)
    {
        $qb = $this->getEntityManager()->createQuery("
        SELECT p 
        FROM Entity\Stocks s
        JOIN s.products p
        JOIN s.stores st
        WHERE st.store_id = :storeId
    ");
        $qb->setParameter('storeId', $storeId);
        return $qb->getResult();
    }
    public function insertStock($productid, $storeid, $quantity)
    {
        $product = $this->getEntityManager()->getRepository('Entity\Products')->find($productid);
        if (!$product) {
            throw new \Exception("Product not found");
        }
        $store = $this->getEntityManager()->getRepository('Entity\Stores')->find($storeid);
        if (!$store) {
            throw new \Exception("Store not found");
        }
        $stock = new Stocks();
        $stock->setProduct($product);
        $stock->setStore($store);
        $stock->setQuantity($quantity);
        $this->getEntityManager()->persist($stock);
        $this->getEntityManager()->flush();
        return "ok";
    }
    public function updateStock($id, $quantity)
    {
        $stock = $this->getEntityManager()->getRepository('Entity\Stocks')->find($id);
        if (!$stock) {
            throw new \Exception("Stock not found");
        }



        $stock->setQuantity($quantity);
        $this->getEntityManager()->persist($stock);
        $this->getEntityManager()->flush();
        return "ok";
    }
   

    public function deleteStock($id)
    {
        $brand = $this->getEntityManager()->getRepository('Entity\Stocks')->getStockById($id);
        if (!$brand) {
            throw new \Exception("Brand not found");
        }
        $qb = $this->getEntityManager()->createQuery("DELETE FROM Entity\Stocks s WHERE s.stock_id = :id");
        $qb->setParameter("id", $id);
        return $qb->execute();
    }
}
