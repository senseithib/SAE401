<?php

header('Content-type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
require __DIR__ . "/../bootstrap.php";

use Entity\Stores;
use Entity\Products;
use Repository\ProductRepository;
use Entity\Stocks;
use Entity\Employees;

$request_method = $_SERVER['REQUEST_METHOD'];
$keyAPI = "e8f1997c763";

// Remplacement du switch principal par des if/elseif
if ($request_method === 'GET') {
    if (isset($_REQUEST["actionGet"])) {
        $action = $_REQUEST["actionGet"];
        if ($action === "employees") {
            if (!isset($_REQUEST['KEY']) || $_REQUEST['KEY'] !== $keyAPI) {
                echo json_encode(["error" => "key required to get employee"]);
            } else {
                $employees = $entityManager->getRepository('Entity\Employees')->getAllEmployee();
                if ($employees == null) {
                    echo json_encode(["error" => "No employees found"]);
                } else {
                    echo json_encode($employees);
                }
            }
        } elseif ($action === "employee") {
            if (!isset($_REQUEST['KEY']) || $_REQUEST['KEY'] !== $keyAPI) {
                echo json_encode(["error" => "key required to get employee"]);
            } elseif (!isset($_REQUEST["id"])) {
                echo json_encode(["error" => "No ID provided"]);
            } else {
                $employee = $entityManager->getRepository('Entity\Employees')->getEmployeeById($_REQUEST["id"]);
                if ($employee == null) {
                    echo json_encode(["error" => "No employee found"]);
                } else {
                    echo json_encode($employee);
                }
            }
        } elseif ($action === "employeeByStore") {
            if (!isset($_REQUEST['KEY']) || $_REQUEST['KEY'] !== $keyAPI) {
                echo json_encode(["error" => "key required to get employee"]);
            } elseif (!isset($_REQUEST["id"])) {
                echo json_encode(["error" => "No ID provided"]);
            } else {
                $employee = $entityManager->getRepository('Entity\Employees')->getEmployeeByStore($_REQUEST["id"]);
                if ($employee == null) {
                    echo json_encode(["error" => "No employee found"]);
                } else {
                    echo json_encode($employee);
                }
            }
        } elseif ($action === "stores") {
            $stores = $entityManager->getRepository('Entity\Stores')->getAllStore();
            if ($stores == null) {
                echo json_encode(["error" => "No stores found"]);
            } else {
                echo json_encode($stores);
            }
        } elseif ($action === "store") {
            if (!isset($_GET["id"])) {
                echo json_encode(["error" => "store No ID provided"]);
            } else {
                $store = $entityManager->getRepository('Entity\Stores')->getStoreById($_REQUEST["id"]);
                if ($store == null) {
                    echo json_encode(["error" => "No store found"]);
                } else {
                    echo json_encode($store);
                }
            }
        } elseif ($action === "products") {
            $repo = $entityManager->getRepository('Entity\Products');
            $products = $repo->getAllProducts();
            if ($products == null) {
                echo json_encode(["error" => "No products found"]);
            } else {
                echo json_encode($products);
            }
        } elseif ($action === "product") {
            if (!isset($_GET["id"])) {
                echo json_encode(["error" => "product No ID provided"]);
            } else {
                $product = $entityManager->getRepository('Entity\Products')->getProductById($_REQUEST["id"]);
                if ($product == null) {
                    echo json_encode(["error" => "No product found"]);
                } else {
                    echo json_encode($product);
                }
            }
        } elseif ($action === "productbybrand") {
            if (!isset($_REQUEST["id"])) {
                echo json_encode(["error" => "product No ID provided"]);
            } else {
                $product = $entityManager->getRepository('Entity\Products')->getProductbyBrand();
                if ($product == null) {
                    echo json_encode(["error" => "No product found"]);
                } else {
                    echo json_encode($product);
                }
            }
        } elseif ($action === "productbycategory") {
            if (!isset($_REQUEST["id"])) {
                echo json_encode(["error" => "product No ID provided"]);
            } else {
                $product = $entityManager->getRepository('Entity\Products')->getProductbyCategory();
                if ($product == null) {
                    echo json_encode(["error" => "No product found"]);
                } else {
                    echo json_encode($product);
                }
            }
        } elseif ($action === "productbyfiltre") {
            $product = $entityManager->getRepository('Entity\Products')->getProductbyFilter();
            if ($product == null) {
                echo json_encode(["error" => "No product found"]);
            } else {
                echo json_encode($product);
            }
        } elseif ($action === "stocks") {
            $stocks = $entityManager->getRepository('Entity\Stocks')->getAllStock();
            if ($stocks == null) {
                echo json_encode(["error" => "No stocks found"]);
            } else {
                echo json_encode($stocks);
            }
        } elseif ($action === "stock") {
            if (!isset($_GET["id"])) {
                echo json_encode(["error" => "stock No ID provided"]);
            } else {
                $stock = $entityManager->getRepository('Entity\Stocks')->getStockById($_REQUEST["id"]);
                if ($stock == null) {
                    echo json_encode(["error" => "No stock found"]);
                } else {
                    echo json_encode($stock);
                }
            }
        } elseif ($action === "stockbystore") {
            if (!isset($_GET["id"])) {
                echo json_encode(["error" => "stock No ID provided"]);
            } else {
                $stock = $entityManager->getRepository('Entity\Stocks')->getStockByStore($_REQUEST["id"]);
                if ($stock == null) {
                    echo json_encode(["error" => "No stock found"]);
                } else {
                    echo json_encode($stock);
                }
            }
        } elseif ($action === "brands") {
            $brands = $entityManager->getRepository('Entity\Brands')->getAllBrands();
            if ($brands == null) {
                echo json_encode(["error" => "No brands found"]);
            } else {
                echo json_encode($brands);
            }
        } elseif ($action === "brand") {
            if (!isset($_GET["id"])) {
                echo json_encode(["error" => "brand No ID provided"]);
            } else {
                $brand = $entityManager->getRepository('Entity\Brands')->getBrandById($_REQUEST["id"]);
                if ($brand == null) {
                    echo json_encode(["error" => "No brand found"]);
                } else {
                    echo json_encode($brand);
                }
            }
        } elseif ($action === "categories") {
            $categories = $entityManager->getRepository('Entity\Categories')->getAllCategories();
            if ($categories == null) {
                echo json_encode(["error" => "No categories found"]);
            } else {
                echo json_encode($categories);
            }
        } elseif ($action === "categorie") {
            if (!isset($_GET["id"])) {
                echo json_encode(["error" => "categorie No ID provided"]);
            } else {
                $categorie = $entityManager->getRepository('Entity\Categories')->getCategorieById($_REQUEST["id"]);
                if ($categorie == null) {
                    echo json_encode(["error" => "No categorie found"]);
                } else {
                    echo json_encode($categorie);
                }
            }
        }
    }
} elseif ($request_method === 'POST') {
    if (!isset($_REQUEST['KEY']) || $_REQUEST['KEY'] !== $keyAPI) {
        echo json_encode(["error" => "Invalid API key"]);
    } elseif (isset($_REQUEST["actionPost"])) {
        $action = $_REQUEST["actionPost"];
        if ($action === "insertEmployee") {
            if (
                !isset($_REQUEST["name"]) || trim($_REQUEST["name"]) === "" ||
                !isset($_REQUEST["role"]) || trim($_REQUEST["role"]) === "null" ||
                !isset($_REQUEST["store"]) || trim($_REQUEST["store"]) === "null" ||
                !isset($_REQUEST["email"]) || trim($_REQUEST["email"]) === "" ||
                !isset($_REQUEST["password"]) || trim($_REQUEST["password"]) === ""
            ) {
                echo json_encode(["error" => "Missing parameters"]);
            } elseif (!preg_match("/^[a-zA-ZÀ-ÿ0-9' -]{1,255}$/", $_REQUEST["name"])) {
                echo json_encode(["error" => "Invalid name parameter"]);
            } elseif (!filter_var($_REQUEST["email"], FILTER_VALIDATE_EMAIL)) {
                echo json_encode(["error" => "Invalid email parameter"]);
            } elseif (!preg_match("/^[a-zA-ZÀ-ÿ0-9!@#$%^&*()_+\-=\[\]{};':\"\\|,.<>\/?~`]{6,255}$/", $_REQUEST["password"])) {
                echo json_encode(["error" => "Invalid password parameter (6 characters minimum)"]);
            } else {
                $st = $entityManager->getRepository('Entity\Stores')->getStoreById($_REQUEST["store"]);
                $result = $entityManager->getRepository('Entity\Employees')->insertEmployee($st[0], $_REQUEST["name"], $_REQUEST["email"], $_REQUEST["password"], $_REQUEST["role"]);
                if ($result === "ok") {
                    echo json_encode(["success" => "Employee added"]);
                } else {
                    echo json_encode(["error" => "Failed to add employee"]);
                }
            }
        } elseif ($action === "insertProduct") {
            if (
                !isset($_REQUEST["name"]) || !isset($_REQUEST["modelyear"]) || !isset($_REQUEST["listprice"]) ||
                !isset($_REQUEST["category"]) || !isset($_REQUEST["brand"]) || trim($_REQUEST["category"]) === "null" || trim($_REQUEST["brand"]) === "null"
            ) {
                echo json_encode(["error" => "Missing parameters"]);
            } elseif (!preg_match("/^[a-zA-ZÀ-ÿ0-9' -]{1,255}$/", $_REQUEST["name"]) || !preg_match("/^[0-9]{4}$/", $_REQUEST["modelyear"]) || !preg_match("/^[0-9]+(\.[0-9]{1,2})?$/", $_REQUEST["listprice"])) {
                echo json_encode(["error" => "Invalid parameters"]);
            } else {
                $category = $entityManager->getRepository('Entity\Categories')->getCategorieById($_REQUEST["category"]);
                $brand = $entityManager->getRepository('Entity\Brands')->getBrandById($_REQUEST["brand"]);
                $result = $entityManager->getRepository('Entity\Products')->insertProduct($category[0], $brand[0], $_REQUEST["name"], $_REQUEST["modelyear"], $_REQUEST["listprice"]);
                if ($result === "ok") {
                    echo json_encode(["success" => "Product added"]);
                } else {
                    echo json_encode(["error" => "Failed to add product"]);
                }
            }
        } elseif ($action === "insertBrand") {
            if (!isset($_REQUEST["name"])) {
                echo json_encode(["error" => "Missing parameters"]);
            } elseif (!preg_match("/^[a-zA-ZÀ-ÿ0-9' -]{1,255}$/", $_REQUEST["name"])) {
                echo json_encode(["error" => "Invalid parameters"]);
            } else {
                $result = $entityManager->getRepository('Entity\Brands')->insertBrand($_REQUEST["name"]);
                if ($result === "ok") {
                    echo json_encode(["success" => "Brand added"]);
                } else {
                    echo json_encode(["error" => "Failed to add brand"]);
                }
            }
        } elseif ($action === "insertCategorie") {
            if (!isset($_REQUEST["name"])) {
                echo json_encode(["error" => "Missing parameters"]);
            } elseif (!preg_match("/^[a-zA-ZÀ-ÿ0-9' -]{1,255}$/", $_REQUEST["name"])) {
                echo json_encode(["error" => "Invalid parameters"]);
            } else {
                $result = $entityManager->getRepository('Entity\Categories')->insertCategorie($_REQUEST["name"]);
                if ($result === "ok") {
                    echo json_encode(["success" => "Categorie added"]);
                } else {
                    echo json_encode(["error" => "Failed to add categorie"]);
                }
            }
        } elseif ($action === "insertStore") {
            if (!isset($_REQUEST["name"]) || !isset($_REQUEST["email"]) || !isset($_REQUEST["phone"]) || !isset($_REQUEST["street"]) || !isset($_REQUEST["zip"]) || !isset($_REQUEST["city"]) || !isset($_REQUEST["state"])) {
                echo json_encode(["error" => "Missing parameters"]);
            } elseif (!preg_match("/^[a-zA-ZÀ-ÿ0-9' -]{1,255}$/", $_REQUEST["name"])) {
                echo json_encode(["error" => "Invalid name parameter"]);
            } elseif (!filter_var($_REQUEST["email"], FILTER_VALIDATE_EMAIL)) {
                echo json_encode(["error" => "Invalid email parameter"]);
            } elseif (!preg_match("/^[0-9\s()+-]{8,25}$/", $_REQUEST["phone"])) {
                echo json_encode(["error" => "Invalid phone parameter"]);
            } elseif (!preg_match("/^[a-zA-ZÀ-ÿ0-9' -]{1,255}$/", $_REQUEST["street"])) {
                echo json_encode(["error" => "Invalid street parameter"]);
            } elseif (!preg_match("/^[0-9]{5}$/", $_REQUEST["zip"])) {
                echo json_encode(["error" => "Invalid zip code parameter"]);
            } elseif (!preg_match("/^[a-zA-ZÀ-ÿ0-9' -]{1,255}$/", $_REQUEST["city"])) {
                echo json_encode(["error" => "Invalid city parameter"]);
            } elseif (!preg_match("/^[a-zA-ZÀ-ÿ0-9' -]{1,10}$/", $_REQUEST["state"])) {
                echo json_encode(["error" => "Invalid state parameter"]);
            } else {
                $result = $entityManager->getRepository('Entity\Stores')->insertStore($_REQUEST["name"], $_REQUEST["email"], $_REQUEST["phone"], $_REQUEST["street"], $_REQUEST["zip"], $_REQUEST["city"], $_REQUEST["state"]);
                if ($result === "ok") {
                    echo json_encode(["success" => "Store added"]);
                } else {
                    echo json_encode(["error" => "Failed to add store"]);
                }
            }
        } elseif ($action === "insertStock") {
            if (!isset($_REQUEST["product"]) || !isset($_REQUEST["store"]) || !isset($_REQUEST["quantity"]) || trim($_REQUEST["product"]) === "null" || trim($_REQUEST["store"]) === "null") {
                echo json_encode(["error" => "Missing parameters"]);
            } elseif (!preg_match("/^[0-9]+$/", $_REQUEST["quantity"])) {
                echo json_encode(["error" => "Invalid parameters"]);
            } else {
                $product = $entityManager->getRepository('Entity\Products')->getProductById($_REQUEST["product"]);
                $store = $entityManager->getRepository('Entity\Stores')->getStoreById($_REQUEST["store"]);
                $result = $entityManager->getRepository('Entity\Stocks')->insertStock($product[0], $store[0], $_REQUEST["quantity"]);
                if ($result === "ok") {
                    echo json_encode(["success" => "Stock added"]);
                } else {
                    echo json_encode(["error" => "Failed to add stock"]);
                }
            }
        }
    }
} elseif ($request_method === 'PUT') {
    if (!isset($_REQUEST['KEY']) || $_REQUEST['KEY'] !== $keyAPI) {
        echo json_encode(["error" => "Invalid API key"]);
    } elseif (isset($_REQUEST["actionPut"])) {
        $action = $_REQUEST["actionPut"];
        if ($action === "updateEmployee") {
            if (!isset($_REQUEST["id"]) || !isset($_REQUEST["name"]) || !isset($_REQUEST["role"]) || !isset($_REQUEST["email"]) || !isset($_REQUEST["store"]) || !isset($_REQUEST["password"])) {
                echo json_encode(["error" => "Missing parameters"]);
            } elseif (!preg_match("/^[a-zA-ZÀ-ÿ0-9' -]{1,255}$/", trim($_REQUEST["name"])) || !preg_match("/^[a-zA-ZÀ-ÿ0-9' -]{2,255}$/", $_REQUEST["role"]) || !filter_var($_REQUEST["email"], FILTER_VALIDATE_EMAIL) || !preg_match("/^[a-zA-ZÀ-ÿ0-9!@#$%^&*()_+\-=\[\]{};':\"\\|,.<>\/?~`]{6,255}$/", $_REQUEST["password"])) {
                echo json_encode(["error" => "Invalid parameters"]);
            } else {
                $store = $entityManager->getRepository('Entity\Stores')->getStoreById($_REQUEST["store"]);
                $result = $entityManager->getRepository('Entity\Employees')->updateEmployee($_REQUEST["id"], $store[0], $_REQUEST["name"], $_REQUEST["email"], $_REQUEST["password"], $_REQUEST["role"]);
                if ($result === "ok") {
                    echo json_encode(["success" => "Employee updated"]);
                } else {
                    echo json_encode(["error" => "Failed to update employee"]);
                }
            }
        } elseif ($action === "udapteConnexE") {
            if (!isset($_REQUEST["id"]) || !isset($_REQUEST["name"]) || !isset($_REQUEST["email"]) || !isset($_REQUEST["password"])) {
                echo json_encode(["error" => "Missing parameters"]);
            } elseif (!preg_match("/^[a-zA-ZÀ-ÿ0-9' -]{1,255}$/", $_REQUEST["name"]) || !filter_var($_REQUEST["email"], FILTER_VALIDATE_EMAIL) || !preg_match("/^[a-zA-ZÀ-ÿ0-9!@#$%^&*()_+\-=\[\]{};':\"\\|,.<>\/?~`]{6,255}$/", $_REQUEST["password"])) {
                echo json_encode(["error" => "Invalid parameters"]);
            } else {
                $result = $entityManager->getRepository('Entity\Employees')->updateConnexE($_REQUEST["id"], $_REQUEST["email"], $_REQUEST["password"], $_REQUEST["name"]);
                if ($result === "ok") {
                    echo json_encode(["success" => "Employee updated"]);
                } else {
                    echo json_encode(["error" => "Failed to update employee"]);
                }
            }
        } elseif ($action === "updateProduct") {
            if (!isset($_REQUEST["id"]) || !isset($_REQUEST["name"]) || !isset($_REQUEST["modelyear"]) || !isset($_REQUEST["listprice"]) || !isset($_REQUEST["category"]) || !isset($_REQUEST["brand"])) {
                echo json_encode(["error" => "Missing parameters"]);
            } elseif (!preg_match("/^[a-zA-ZÀ-ÿ0-9' -]{1,255}$/", trim($_REQUEST["name"])) || !preg_match("/^[0-9]{4}$/", $_REQUEST["modelyear"]) || !preg_match("/^[0-9]+(\.[0-9]{1,2})?$/", $_REQUEST["listprice"])) {
                echo json_encode(["error" => "Invalid parameters"]);
            } else {
                $category = $entityManager->getRepository('Entity\Categories')->getCategorieById($_REQUEST["category"]);
                $brand = $entityManager->getRepository('Entity\Brands')->getBrandById($_REQUEST["brand"]);
                $result = $entityManager->getRepository('Entity\Products')->updateProduct($_REQUEST["id"], $category[0], $brand[0], $_REQUEST["name"], $_REQUEST["modelyear"], $_REQUEST["listprice"]);
                if ($result === "ok") {
                    echo json_encode(["success" => "Product updated"]);
                } else {
                    echo json_encode(["error" => "Failed to update product"]);
                }
            }
        } elseif ($action === "updateBrand") {
            if (!isset($_REQUEST["id"]) || !isset($_REQUEST["name"])) {
                echo json_encode(["error" => "Missing parameters"]);
            } elseif (!preg_match("/^[a-zA-ZÀ-ÿ0-9' -]{1,255}$/", $_REQUEST["name"])) {
                echo json_encode(["error" => "Invalid parameters"]);
            } else {
                $result = $entityManager->getRepository('Entity\Brands')->updateBrand($_REQUEST["id"], $_REQUEST["name"]);
                if ($result === "ok") {
                    echo json_encode(["success" => "Brand updated"]);
                } else {
                    echo json_encode(["error" => "Failed to update brand"]);
                }
            }
        } elseif ($action === "updateCategorie") {
            if (!isset($_REQUEST["id"]) || !isset($_REQUEST["name"])) {
                echo json_encode(["error" => "Missing parameters"]);
            } elseif (!preg_match("/^[a-zA-ZÀ-ÿ0-9' -]{1,255}$/", $_REQUEST["name"])) {
                echo json_encode(["error" => "Invalid parameters"]);
            } else {
                $result = $entityManager->getRepository('Entity\Categories')->updateCategorie($_REQUEST["id"], $_REQUEST["name"]);
                if ($result === "ok") {
                    echo json_encode(["success" => "Categorie updated"]);
                } else {
                    echo json_encode(["error" => "Failed to update categorie"]);
                }
            }
        } elseif ($action === "updateStore") {
            if (!isset($_REQUEST["id"]) || !isset($_REQUEST["name"]) || !isset($_REQUEST["email"]) || !isset($_REQUEST["phone"]) || !isset($_REQUEST["street"]) || !isset($_REQUEST["zip"]) || !isset($_REQUEST["city"]) || !isset($_REQUEST["state"])) {
                echo json_encode(["error" => "Missing parameters"]);
            } elseif (!preg_match("/^[a-zA-ZÀ-ÿ0-9' -]{2,255}$/", $_REQUEST["name"])) {
                echo json_encode(["error" => "Invalid name parameter"]);
            } elseif (!filter_var($_REQUEST["email"], FILTER_VALIDATE_EMAIL)) {
                echo json_encode(["error" => "Invalid email parameter"]);
            } elseif (!preg_match("/^[0-9\s()+-]{8,25}$/", $_REQUEST["phone"])) {
                echo json_encode(["error" => "Invalid phone parameter"]);
            } elseif (!preg_match("/^[a-zA-ZÀ-ÿ0-9' -]{2,255}$/", $_REQUEST["street"])) {
                echo json_encode(["error" => "Invalid street parameter"]);
            } elseif (!preg_match("/^[0-9]{5}$/", $_REQUEST["zip"])) {
                echo json_encode(["error" => "Invalid zip code parameter"]);
            } elseif (!preg_match("/^[a-zA-ZÀ-ÿ0-9' -]{2,255}$/", $_REQUEST["city"])) {
                echo json_encode(["error" => "Invalid city parameter"]);
            } elseif (!preg_match("/^[a-zA-ZÀ-ÿ0-9' -]{1,10}$/", $_REQUEST["state"])) {
                echo json_encode(["error" => "Invalid state parameter"]);
            } else {
                $result = $entityManager->getRepository('Entity\Stores')->updateStore($_REQUEST["id"], $_REQUEST["name"], $_REQUEST["email"], $_REQUEST["phone"], $_REQUEST["street"], $_REQUEST["zip"], $_REQUEST["city"], $_REQUEST["state"]);
                if ($result === "ok") {
                    echo json_encode(["success" => "Store updated"]);
                } else {
                    echo json_encode(["error" => "Failed to update store"]);
                }
            }
        } elseif ($action === "updateStock") {
            if (!isset($_REQUEST["id"]) ||  !isset($_REQUEST["quantity"])) {
                echo json_encode(["error" => "Missing parameters"]);
            } elseif (!preg_match("/^[0-9]+$/", $_REQUEST["quantity"])) {
                echo json_encode(["error" => "Invalid parameters"]);
            } else {
                $result = $entityManager->getRepository('Entity\Stocks')->updateStock($_REQUEST["id"], $_REQUEST["quantity"]);
                if ($result === "ok") {
                    echo json_encode(["success" => "Stock updated"]);
                } else {
                    echo json_encode(["error" => "Failed to update stock"]);
                }
            }
        }
    }
} elseif ($request_method === 'DELETE') {
    if (!isset($_REQUEST['KEY']) || $_REQUEST['KEY'] !== $keyAPI) {
        echo json_encode(["error" => "Invalid API key"]);
    } elseif (isset($_REQUEST["actionDelete"])) {
        $action = $_REQUEST["actionDelete"];
        if ($action === "deleteBrand") {
            if (!isset($_REQUEST["id"])) {
                echo json_encode(["error" => "Missing parameters"]);
            } else {
                $brand = $entityManager->getRepository('Entity\Brands')->deleteBrand($_REQUEST["id"]);
                if ($brand) {
                    echo json_encode(["success" => "Brand updated"]);
                } else {
                    echo json_encode(["error" => "Failed to update stock"]);
                }
            }
        } elseif ($action === "deleteCategorie") {
            if (!isset($_REQUEST["id"])) {
                echo json_encode(["error" => "Missing parameters"]);
            } else {
                $categorie = $entityManager->getRepository('Entity\Categories')->deleteCategorie($_REQUEST["id"]);
                if ($categorie) {
                    echo json_encode(["success" => "Categorie updated"]);
                } else {
                    echo json_encode(["error" => "Failed to update stock"]);
                }
            }
        } elseif ($action === "deleteProduct") {
            if (!isset($_REQUEST["id"])) {
                echo json_encode(["error" => "Missing parameters"]);
            } else {
                $categorie = $entityManager->getRepository('Entity\Products')->deleteProduct($_REQUEST["id"]);
                if ($categorie) {
                    echo json_encode(["success" => "Products updated"]);
                } else {
                    echo json_encode(["error" => "Failed to update stock"]);
                }
            }
        } elseif ($action === "deleteStock") {
            if (!isset($_REQUEST["id"])) {
                echo json_encode(["error" => "Missing parameters"]);
            } else {
                $categorie = $entityManager->getRepository('Entity\Stocks')->deleteStock($_REQUEST["id"]);
                if ($categorie) {
                    echo json_encode(["success" => "Stock updated"]);
                } else {
                    echo json_encode(["error" => "Failed to update stock"]);
                }
            }
        } elseif ($action === "deleteStore") {
            if (!isset($_REQUEST["id"])) {
                echo json_encode(["error" => "Missing parameters"]);
            } else {
                $categorie = $entityManager->getRepository('Entity\Stores')->deleteStore($_REQUEST["id"]);
                if ($categorie) {
                    echo json_encode(["success" => "Stores updated"]);
                } else {
                    echo json_encode(["error" => "Failed to update stock"]);
                }
            }
        }
    }
}