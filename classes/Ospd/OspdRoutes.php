<?php
namespace Ospd;

/**
 * PHP version 5.6
 * 
 * @category PHP
 * @package  Ospd_Build
 * @author   Dean Sellars <dino@sellars.org>
 * @license  no license
 * @link     http://jcres.test
 */

class AuxRoutes implements \Gen\Routes
{
    private $usersTable;
    private $detailsTable;
    private $authentication;
    private $ranksTable;
    private $divisionTable;
    private $squadsTable;
    private $creditsTable;
//    private $layout;
    /** 
     * Constructs the AuxRoutes
     *
     * @return Array registration form
     */   
    public function __construct()
    {
        include __DIR__ . '/../../includes/Aux/DatabaseConnection.php';
        $this->squadsTable = new \Gen\DatabaseTable($pdo, 'squads', 'sid');
        $this->ranksTable = new \Gen\DatabaseTable($pdo, 'ranks', 'rankNo');
        $this->divisionsTable = new \Gen\DatabaseTable($pdo, 'divisions', 'divNo');  
        $this->detailsTable = new \Gen\DatabaseTable($pdo, 'details', 'detailNum', '\Aux\Entity\Detail' );
        $this->usersTable = new \Gen\DatabaseTable($pdo, 'user', 'uid', '\Aux\Entity\User', [&$this->ranksTable, &$this->divisionsTable, &$this->squadsTable]);
        $this->authentication = new \Gen\Authentication($this->usersTable, 'username', 'password', 'uid');
     //   $this->creditsTable = new \Gen\Authentication($pdo, 'credits', 'credit_id', '\Aux\Entity\Credit' );
    }  // end construct

    /** 
     * This sets up the array for the route
     *
     * @return Array registration form
     */
    public function getRoutes()
    {
        $detailsController = new \Aux\Controllers\Details($this->detailsTable, $this->usersTable, $this->authentication);
        $userController = new \Aux\Controllers\Register($this->usersTable, $this->ranksTable, $this->divisionsTable, $this->squadsTable);
        $loginController = new \Aux\Controllers\Login($this->authentication);
        $resetController = new \Aux\Controllers\Reset($this->usersTable);
        
        $routes = [
            'user/permissions' => [
                'GET' => [
                    'controller' => $userController,
                    'action' => 'permissions'
                ],
                'POST' => [
                    'controller' => $userController,
                    'action' => 'savePermissions'
                ],
                'login' => true,
                'permissions' => \Aux\Entity\User::ADMIN
            ],
            'user/register' => [
                'GET' => [
                     'controller' => $userController,
                     'action' => 'registrationForm'
                ],
                'POST' => [
                    'controller' => $userController,
                    'action' => 'registerUser'
                ],
            ],
            'user/success' => [
               'GET' => [
                   'controller' => $userController,
                    'action' => 'success' 
                ]
            ],

            'user/ulist' => [
                'GET' => [
                        'controller' => $userController,
                        'action' => 'ulist' // rename after php upgrade
                ],
                'login' => true ,
                'permissions' => \Aux\Entity\User::ADMIN 
            ],
            'user/edit' => [
                'GET' => [
                    'controller' => $userController,
                    'action' => 'editUserForm'
                ],
                'POST' => [
                    'controller' => $userController,
                    'action' => 'editUser'
                ],
                'login' => true,
                'permissions' => \Aux\Entity\User::ADMIN
            ],
            'login/error' => [
                'GET' => [
                    'controller' => $loginController,
                    'action' => 'error'
                ]
            ],
            'login/permissionserror' => [
                'GET' => [
                    'controller' => $loginController, 
                    'action' => 'permissionsError'
                ]
            ],
            'login/status' => [
                'GET' => [
                    'controller' => $loginController,
                    'action' => 'status'
                ]
            ],
            'login/loa' => [
                'GET' => [
                    'controller' => $loginController,
                    'action' => 'loa'
                ]
            ],
            'login/success' => [
                'GET' => [
                    'controller' => $loginController,
                    'action' =>  'success'
                ]
            ],
            'logout' => [
                'GET' => [
                     'controller' => $loginController,
                     'action' => 'logout'
                ]
            ],
            'disable' => [
                'GET' => [
                     'controller' => $loginController,
                     'action' => 'disable'
                ]
            ],
            'login' => [
                'GET' => [
                    'controller' => $loginController,
                    'action' => 'loginForm'
                ],
                'POST' => [
                    'controller' => $loginController,
                    'action' => 'processLogin'
                ]
            ],
            '' => [
                'GET' => [
                    'controller' => $loginController,
                    'action' => 'home',
                    'routes' => $routes
                ]
            ],
            'reset' => [
                'GET' => [
                    'controller' => $resetController,
                    'action' => 'resetForm'
                ],
                'POST' => [
                    'controller' => $resetController,
                    'action' => 'processReset'
                ]
            ],
            'reset/password' => [
                'GET' => [
                    'controller' => $resetController,
                    'action' => ''
                ]
            ],
 
            'detail/list' => [
                    'GET' => [
                        'controller' => $detailsController,
                        'action' => 'dlist'
                    ],
                    'login' => true
                ],
           
        ]; // end of routes
        return $routes;
} //end of getRoutes

    public function getAuthentication() {
        return $this->authentication;
    }

    public function checkPermission($permission)
    {
        $user = $this->authentication->getUser();

        if ($_SESSION['status'] & $permission){
            return true;
        } else {
            return false;
        }
    }
} // end class AuxRoutes