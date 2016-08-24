<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Controller', 'Controller');
App::import('Core', 'l10n');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	public $helpers = array('Form','Html','Session','Js');

	public function beforeRender() {
		$this->loadModel('Company');
		$this->loadModel('User');
		$this->loadModel('Configuration');
		$this->set('modelatual',$this->name);
		if ($this->Session->read('usuarioCargo') == 'USER' || $this->Session->read('usuarioCargo') == 'ADMIN') {
			$this->set('dadosuser', $this->User->find('first', array( 'conditions' => array( 'User.cpf' => $this->Session->read('usuarioCPF') ) ) ) );
			$this->set('modeluser','User');
		}
		else {
			$this->set('dadosuser', $this->Company->find('first', array( 'conditions' => array( 'Company.company_id' => $this->Session->read('usuarioID') ) ) ) );
			$this->set('modeluser','Company');
		}
		$this->set('companies', $this->Company->find('list',array( 'fields' => array('Company.company_id', 'Company.nome'),	'order' => array('Company.nome' => 'ASC'))));
		
		// Envia configurações para todas views
		$config = $this->Configuration->find('first', array( 'conditions' => array( 'Configuration.configuration_id' => 1)));
		$this->set('config', $config);

		// Envia número de vagas para todas views
		$qtdtrainee = $this->User->find('count', array( 'conditions' => array('User.cargo' => 'Trainee', 'User.presenca' => '1')));
		$qtdmembro = $this->User->find('count', array( 'conditions' => array('User.cargo' => 'Membro', 'User.presenca' => '1')));
		$vagastrainee = $config['Configuration']['vagas_trainee'] - $qtdtrainee;
		$vagasmembro = $config['Configuration']['vagas_veterano'] - $qtdmembro;
		$this->set('vagastrainee',$vagastrainee);
		$this->set('vagasmembro',$vagasmembro);
	}

	public function checaVagasT() {
		$this->loadModel('Configuration');
		$this->loadModel('User');
		$qtdtrainee = $this->User->find('count', array( 'conditions' => array('User.cargo' => 'Trainee')));
		$vagastrainee = $config['Configuration']['vagas_trainee'] - $qtdtrainee;

		if ($vagastrainee > 0)
			return true;
		else
			return false;
	}

	public function checaVagasM() {
		$this->loadModel('Configuration');
		$this->loadModel('User');
		$qtdmembro = $this->User->find('count', array( 'conditions' => array('User.cargo' => 'Membro')));
		$vagasmembro = $config['Configuration']['vagas_veterano'] - $qtdmembro;

		if ($vagasmembro > 0)
			return true;
		else
			return false;
	}
}

