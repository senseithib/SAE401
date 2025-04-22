<?php
namespace Repository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\Id;
use Entity\Employees;

class EmployeeRepository extends EntityRepository
{

    public function ConnexionEmployee($email, $mdp)
    {
        $qb = $this->getEntityManager()->createQuery(
           "SELECT e FROM Entity\Employees e WHERE e.employee_email = :email AND e.employee_password = :mdp AND e.employee_role = 'employee'"
        );
        $qb->setParameter("email", $email);
        $qb->setParameter("mdp", $mdp);
        
        return $qb->getResult();
    }

    public function getAllEmployee()
    {
        return $this->findAll();
    }

    public function getEmployeeById($id)
    {        
        $qb = $this->getEntityManager()->createQuery("SELECT e FROM Entity\Employees e WHERE e.employee_id = :id");
        $qb->setParameter('id', $id);
        return $qb->getResult();
    }

    public function insertEmployee($storeid, $name, $email, $password, $role)
    {
        $store = $this->getEntityManager()->getRepository('Entity\Stores')->find($storeid);
        if (!$store) {
            throw new \Exception("Store not found");
        }
    
        $employee = new Employees();
        $employee->setStore($store);
        $employee->setEmployeeName($name);
        $employee->setEmployeeEmail($email);
        $employee->setEmployeePassword($password);
        $employee->setEmployeeRole($role);
        $this->getEntityManager()->persist($employee);
        $this->getEntityManager()->flush();
        return "ok";
    }
    public function updateEmployee($id, $storeid, $name, $email, $password, $role)
    {
        $employee = $this->getEntityManager()->getRepository('Entity\Employees')->find($id);
        if (!$employee) {
            throw new \Exception("Employee not found");
        }
        $store = $this->getEntityManager()->getRepository('Entity\Stores')->find($storeid);
        if (!$store) {
            throw new \Exception("Store not found");
        }
        $employee->setStore($store);
        $employee->setEmployeeName($name);
        $employee->setEmployeeEmail($email);
        $employee->setEmployeePassword($password);
        $employee->setEmployeeRole($role);
        $this->getEntityManager()->persist($employee);
        $this->getEntityManager()->flush();
        return "ok";
    }
    public function updateConnexE($id, $email, $password,$name)
    {
        $employee = $this->getEntityManager()->getRepository('Entity\Employees')->find($id);
        if (!$employee) {
            throw new \Exception("Employee not found");
        }
        $employee->setEmployeeEmail($email);
        $employee->setEmployeePassword($password);
        $employee->setEmployeeName($name);
        $this->getEntityManager()->persist($employee);
        $this->getEntityManager()->flush();
        return "ok";
    }

    public function getEmployeeByStore($storeId)
    {
        $qb = $this->getEntityManager()->createQuery("SELECT e FROM Entity\Employees e WHERE e.store = :storeId");
        $qb->setParameter('storeId', $storeId);
        return $qb->getResult();
    }



}