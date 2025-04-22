<?php

namespace Repository;



use Doctrine\ORM\EntityRepository;
use Entity\Products;



class ProductRepository extends EntityRepository
{
    public function getAllProducts()
    {
        $qb = $this->getEntityManager()->createQuery("SELECT p FROM Entity\Products p");
        return $qb->getResult();
    }
    public function getProductById($id)
    {
        $qb = $this->getEntityManager()->createQuery("SELECT p FROM Entity\Products p WHERE p.product_id = :id");
        $qb->setParameter('id', $id);
        return $qb->getResult();
    }
    public function insertProduct($categoryid, $brandid, $name, $modelyear, $listprice)
    {
        $category = $this->getEntityManager()->getRepository('Entity\Categories')->find($categoryid);
        if (!$category) {
            throw new \Exception("Category not found");
        }
        $brand = $this->getEntityManager()->getRepository('Entity\Brands')->find($brandid);
        if (!$brand) {
            throw new \Exception("Brand not found");
        }
        $product = new Products();
        $product->setCategories($category);
        $product->setBrands($brand);
        $product->setProductName($name);
        $product->setModelYear($modelyear);
        $product->setListPrice($listprice);
        $this->getEntityManager()->persist($product);
        $this->getEntityManager()->flush();
        return "ok";
    }
    public function updateProduct($id, $categoryid, $brandid, $name, $modelyear, $listprice)
    {
        $product = $this->getEntityManager()->getRepository('Entity\Products')->find($id);
        if (!$product) {
            throw new \Exception("Product not found");
        }
        $category = $this->getEntityManager()->getRepository('Entity\Categories')->find($categoryid);
        if (!$category) {
            throw new \Exception("Category not found");
        }
        $brand = $this->getEntityManager()->getRepository('Entity\Brands')->find($brandid);
        if (!$brand) {
            throw new \Exception("Brand not found");
        }
        $product->setCategories($category);
        $product->setBrands($brand);
        $product->setProductName($name);
        $product->setModelYear($modelyear);
        $product->setListPrice($listprice);
        $this->getEntityManager()->persist($product);
        $this->getEntityManager()->flush();
        return "ok";
    }
    public function deleteProduct($id)
    {
        $brand = $this->getEntityManager()->getRepository('Entity\Products')->find($id);
        if (!$brand) {
            throw new \Exception("Brand not found");
        }
        $qb = $this->getEntityManager()->createQuery("DELETE FROM Entity\Products p WHERE p.product_id = :id");
        $qb->setParameter("id", $id);
        return $qb->execute();
    }
    
    public function getProductbyFilter()
    {
        $whereClauses = [];
        $parameters = [];

        if (!empty($_REQUEST['brandid'])) {
            $whereClauses[] = "b.brand_id = :brandid";
            $parameters['brandid'] = $_REQUEST['brandid'];
        }

        if (!empty($_REQUEST['categoryid'])) {
            $whereClauses[] = "c.category_id = :categoryid";
            $parameters['categoryid'] = $_REQUEST['categoryid'];
        }

        if (!empty($_REQUEST['listpricemin'])) {
            $whereClauses[] = "p.list_price >= :listpricemin";
            $parameters['listpricemin'] = $_REQUEST['listpricemin'];
        }

        if (!empty($_REQUEST['listpricemax'])) {
            $whereClauses[] = "p.list_price <= :listpricemax";
            $parameters['listpricemax'] = $_REQUEST['listpricemax'];
        }

        if (!empty($_REQUEST['annee'])) {
            $whereClauses[] = "p.model_year = :annee";
            $parameters['annee'] = $_REQUEST['annee'];
        }

        // Construire la requête DQL
        if (!empty($whereClauses)) {
            $where = 'WHERE ' . implode(' AND ', $whereClauses);
        } else {
            $where = '';
        }
        $req = "SELECT p FROM Entity\Products p JOIN p.categories c JOIN p.brands b $where";

        $qb = $this->getEntityManager()->createQuery($req);

        foreach ($parameters as $key => $value) {
            $qb->setParameter($key, $value);
        }

        return $qb->getResult();
    }
    public function getProductbyBrand()
    {
        $qb = $this->getEntityManager()->createQuery("SELECT p FROM Entity\Products p JOIN p.brands b WHERE b.brand_id = :brandid");
        $qb->setParameter('brandid', $_REQUEST['id']);
        return $qb->getResult();
    }
    public function getProductByCategory()
    {
        $qb = $this->getEntityManager()->createQuery("SELECT p FROM Entity\Products p JOIN p.categories c WHERE c.category_id = :categoryid");
        $qb->setParameter('categoryid', $_REQUEST['id']);
        return $qb->getResult();
    }
}
