<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Database\Type;

use Cake\I18n\Time;
Time::$defaultLocale = 'es-PE';
Time::setToStringFormat('dd/MM/yyyy'); // este formato es para mostrar en las index
Type::build('datetime')->useLocaleParser(false);

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    
    static protected $activo = ['S'=>'Si','N'=>'No'];
    static protected $eliminado = ['S'=>'Si','N'=>'No'];
    
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * @return void
     */
     public $helpers = [
        'Html' => ['className' => 'Bootstrap.BootstrapHtml'],
        'Form' => ['className' => 'Bootstrap.BootstrapForm'],
        'Paginator' => ['className' => 'Bootstrap.BootstrapPaginator'],
        'Modal' => ['className' => 'Bootstrap.BootstrapModal']
    ];

    public function initialize()
    {
        parent::initialize();
        

        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'loginRedirect' => [
                'controller' => 'Users',
                'action' => 'index'
            ],
            'logoutRedirect' => [
                'controller' => 'Users',
                'action' => 'login'
            ],
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login'
            ],
            'authenticate' => [
                'Form' => [
                    'userModel' => 'Users',
                    'fields' => array(
                        'username' => 'email',
                        'password' => 'password'
                    ),
                    'scope' => array('status' => 1)
                ]
            ],
            'authError' => 'Proporsione sus credenciales para entraral sistema.'
        ]);
    }
    
    public function parseFechaPostgresql($date = null){
        $date = explode("/", $date)[2] .'-'. explode("/", $date)[0] .'-'. explode("/", $date)[1];
        return Time::parse($date);
    }

    public function beforeFilter(Event $event)
    {
        $this->set('usuarioLogueado', $this->Auth->user());
        $this->set('activo', ['S'=>'Si','N'=>'No']);
        $this->set('eliminado', ['S'=>'Si','N'=>'No']);
    }

}