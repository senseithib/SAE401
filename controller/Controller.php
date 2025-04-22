<?php
/**
 * Contrôleur principal du site BikeStores.
 * Gère l'authentification, la session et la navigation selon le rôle utilisateur.
 * Refactorisé pour une meilleure lisibilité et modularité.
 */
require __DIR__ . "../../bootstrap.php";

use Entity\Employees;

class Controller
{
    // Constantes pour les rôles et actions autorisées
    private const ROLES = [
        'employee' => [
            'cookies' => ['emailE', 'mdpE'],
            'actions' => ['accueilE', 'magasinE', 'GestionE', 'accountE', 'update', 'insert', 'delete', 'logout', 'mention'],
            'view'    => 'Employee'
        ],
        'chief' => [
            'cookies' => ['emailEC', 'mdpEC'],
            'actions' => ['accueilEC', 'magasinEC', 'GestionEC', 'accountEC', 'updateEC', 'insertEC', 'deleteEC', 'logout', 'mention'],
            'view'    => 'Chef'
        ],
        'it' => [
            'cookies' => ['emailIT', 'mdpIT'],
            'actions' => ['accueilIT', 'magasinIT', 'GestionIT', 'accountIT', 'updateIT', 'insertIT', 'deleteIT', 'logout', 'mention'],
            'view'    => 'IT'
        ]
    ];

    private $action;
    private $email;
    private $mdp;
    private $emailIT;
    private $mdpIT;
    private $add;
    private $modif;
    private $sup;
    private $id;
    private $PHPSESSID;
    private $emailE;
    private $mdpE;
    private $click;
    private $emailEC;
    private $mdpEC;
    
    

    public function __construct(array $params = [])
    {
        foreach ($params as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public function __set($property, $value)
    {
        $this->$property = $value;
    }

    public function __get($property)
    {
        return $this->$property;
    }

    public function invoke($entityManager)
    {
        // Authentification via cookies pour chaque rôle
        foreach (self::ROLES as $role => $data) {
            [$cookieEmail, $cookiePwd] = $data['cookies'];
            if (isset($_COOKIE[$cookieEmail], $_COOKIE[$cookiePwd])) {
                $this->email = $_COOKIE[$cookieEmail];
                $this->mdp = $_COOKIE[$cookiePwd];
                $user = $entityManager->getRepository(Employees::class)->findOneBy([
                    "employee_email" => $this->email,
                    "employee_password" => $this->mdp,
                    "employee_role" => $role
                ]);
                if ($user) {
                    $this->refreshCookies($cookieEmail, $cookiePwd, $user);
                    $this->setSession($user);

                    $validActions = $data['actions'];
                    $viewFolder = $data['view'];

                    if (isset($this->action) && in_array($this->action, $validActions)) {
                        if ($this->action === 'logout') {
                            $this->logout($cookieEmail, $cookiePwd);
                            require_once("view/indexView.php");
                            return;
                        }
                        require_once("view/{$viewFolder}/{$this->action}.php");
                    } else {
                        $_SESSION["action"] = $validActions[0];
                        require_once("view/{$viewFolder}/{$validActions[0]}.php");
                    }
                    return;
                }
            }
        }

        // Gestion des actions publiques ou non authentifiées
        $this->handlePublicActions($entityManager);
    }

    /**
     * Rafraîchit les cookies d'identification.
     */
    private function refreshCookies($cookieEmail, $cookiePwd, $user)
    {
        setcookie($cookieEmail, $user->getEmployeeEmail(), time() + 7200);
        setcookie($cookiePwd, $user->getEmployeePassword(), time() + 7200);
    }

    /**
     * Initialise la session utilisateur.
     */
    private function setSession($user)
    {
        $_SESSION["AccountEmployee"] = [
            "id" => $user->getEmployeeId(),
            "role" => $user->getEmployeeRole()
        ];
        $_SESSION["StoreEmployee"] = $user->getStoreId()->getStoreId();
    }

    /**
     * Déconnecte l'utilisateur en supprimant les cookies et réinitialisant la session.
     */
    private function logout($cookieEmail, $cookiePwd)
    {
        session_reset();
        setcookie($cookieEmail, "", 0);
        setcookie($cookiePwd, "", 0);
        session_reset();
    }

    /**
     * Gère les actions accessibles sans authentification ou lors de la connexion.
     */
    private function handlePublicActions($entityManager)
    {
        switch ($this->action ?? '') {
            case 'form':
                require_once("view/indexView.php");
                break;
            case 'log':
                $this->processLogin($entityManager);
                break;
            case 'accueilC':
                require_once("view/Client/accueilC.php");
                break;
            case 'magasinC':
                require_once("view/Client/magasin.php");
                break;
            case 'mention':
                require_once("view/mention.php");
                break;
            case 'Deco':
            case 'logout':
                $this->logoutAll();
                require_once("view/indexView.php");
                break;
            default:
                require_once("view/indexView.php");
        }
    }

    /**
     * Traite la connexion utilisateur.
     */
    private function processLogin($entityManager)
    {
        if (isset($_POST["email"], $_POST["mdp"])) {
            $this->email = trim($_POST["email"]);
            $this->mdp = trim($_POST["mdp"]);
            foreach (self::ROLES as $role => $data) {
                $user = $entityManager->getRepository(Employees::class)->findOneBy([
                    "employee_email" => $this->email,
                    "employee_password" => $this->mdp,
                    "employee_role" => $role
                ]);
                if ($user) {
                    [$cookieEmail, $cookiePwd] = $data['cookies'];
                    setcookie($cookieEmail, $user->getEmployeeEmail(), time() + 187200);
                    setcookie($cookiePwd, $user->getEmployeePassword(), time() + 187200);
                    $_SESSION["action"] = $data['actions'][0];
                    $this->setSession($user);
                    require_once("view/{$data['view']}/{$data['actions'][0]}.php");
                    return;
                }
            }
            session_reset();
            $_SESSION["error"] = "Identifiants incorrects.";
            require_once("view/indexView.php");
        } else {
            session_reset();
            $_SESSION["error"] = "Erreur de connexion.";
            require_once("view/indexView.php");
        }
    }

    /**
     * Déconnecte tous les utilisateurs (tous rôles confondus).
     */
    private function logoutAll()
    {
        session_reset();
        foreach (self::ROLES as $data) {
            foreach ($data['cookies'] as $cookie) {
                if (isset($_COOKIE[$cookie])) {
                    setcookie($cookie, "", 0);
                }
            }
        }
        session_reset();
    }
}