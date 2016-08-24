<?php 
class CompaniesController extends AppController {

	public function beforeFilter() {
		$this->loadModel('Company'); // Carrega dados das EJ

		if ($this->Session->read('usuarioCargo') == 'USER') { //Redireciona para página index das EJs caso uma EJ tente acessar uma action de USER
			$this->redirect(array('controller' => 'users', 'action' => 'index'), null, true);
		}
		else if ($this->Session->read('usuarioCargo') == 'ADMIN') { //Redireciona para página index da Administração caso um ADMIN tente acessar uma action de USER
			$this->redirect(array('controller' => 'configuracoes', 'action' => 'index'), null, true);
		}
		else if ($this->Session->read('usuarioID') == '' || $this->Session->read('usuarioPass') == '' || $this->Session->read('usuarioCargo') == '') {
			if ($this->Session->valid()) //Verifica se existe sessão aberta
				$this->Session->destroy();
			$this->redirect(array( 'controller' => 'pages', 'action' => 'home'),null,true);
		} else { 
			$usercount = $this->Company->find('count', array('conditions' => array( 'Company.company_id' => $this->Session->read('usuarioID'), 'Company.pass' => $this->Session->read('usuarioPass'))));
			if ( $usercount == 0) {
				$this->Session->destroy();
				$this->redirect(array( 'controller' => 'pages', 'action' => 'home'),null,true);
			}
		}	
	}

	public function index() {
		$this->loadModel('User');
		$this->loadModel('Configuration');
		
		$this->set('tcon',$this->User->find('count', array( 'conditions' => array( 'User.company_id' => $this->Session->read('usuarioID'), 'User.cargo' => 'Trainee','User.presenca' => 1))));
		$this->set('mcon',$this->User->find('count', array( 'conditions' => array( 'User.company_id' => $this->Session->read('usuarioID'), 'User.cargo' => 'Membro','User.presenca' => 1))));
		$this->set('t',$this->User->find('count', array( 'conditions' => array( 'User.company_id' => $this->Session->read('usuarioID'), 'User.cargo' => 'Trainee'))));
		$this->set('m',$this->User->find('count', array( 'conditions' => array( 'User.company_id' => $this->Session->read('usuarioID'), 'User.cargo' => 'Membro'))));

		$config = $this->Configuration->find('first', array( 'conditions' => array( 'Configuration.configuration_id' => '1')));
	}

	public function checaData() {
		$this->loadModel('Configuration');
		$config = $this->Configuration->find('first', array( 'conditions' => array( 'Configuration.configuration_id' => '1')));	
		$datafim = strtotime($config['Configuration']['fim_geral']);
		$hoje = strtotime(date('Y-m-d h:m:s'));	

		if ($hoje > $datafim) {
				$this->Session->setFlash('Alterações de dados já não são mais possíveis.','msg-erro');
				$this->redirect(array( 'action' => 'index'));	
		} else {
			return true;
		}
	}
	public function checaPay() {
		$this->loadModel('Ticket');
		if ($this->Ticket->find('count',array( 'conditions' => array('Ticket.company_id' => $this->Session->read('usuarioID'), 'Ticket.valida' => 1)))	 == 1)
			return false;
		else
			return true;
	}

	public function checaVagas($cargo) {
		$this->loadModel('Configuration');
		$this->loadModel('User');
		$config = $this->Configuration->find('first', array( 'conditions' => array( 'Configuration.configuration_id' => '1')));	
		$vagasocupadas = $this->User->find('count', array( 'conditions' => array( 'User.cargo' => $cargo, 'User.presenca' => '1')));

		if ($cargo == 'Trainee') {
			if ($config['Configuration']['vagas_trainee'] - $vagasocupadas > 0)
				return true;
			else
				return false;
		}
		else if ($cargo == 'Membro') {
			if ($config['Configuration']['vagas_veterano'] - $vagasocupadas > 0)
				return true;
			else
				return false;
		}
		else {
			return false;
		}

	}

	public function mudarsenha() {
		if ($this->request->is('post')) {	
			$oldpass = $this->request->data['Company']['oldpass'];
			$newpass = $this->request->data['Company']['newpass'];
			$newpasscon = $this->request->data['Company']['newpassconfirm'];

			$oldpass1en = md5($oldpass.'Ch4V&L0c@');
        	$oldpass2en = md5($oldpass1en);

			$newpass1en = md5($newpass.'Ch4V&L0c@');
        	$newpass2en = md5($newpass1en);

			$newpasscon1en = md5($newpasscon.'Ch4V&L0c@');
        	$newpasscon2en = md5($newpasscon1en);
        	if ($this->Company->find('count', array( 'conditions' => array( 'Company.company_id' => $this->Session->read('usuarioID'), 'Company.pass' => $oldpass2en))) != 1) {
				$this->Session->setFlash('Antiga senha inválida.','msg-erro');
				$this->redirect(array('controller' => 'companies','action' => 'mudarsenha'));        		
        	}
			else if ($newpasscon2en != $newpass2en) {
				$this->Session->setFlash('As novas senhas não coincidem.','msg-erro');
				$this->redirect(array('controller' => 'companies','action' => 'mudarsenha'));           		
        	} else if (strlen($newpass) < 6) {
 				$this->Session->setFlash('Senha deve ter ao menos 6 caractéres','msg-erro');
				$this->redirect(array('controller' => 'companies','action' => 'mudarsenha'));         		
        	} else {
        		$this->Company->set(array( 'company_id' => $this->Session->read('usuarioID'),'pass' => $newpass2en));
        		if($this->Company->save()) {
 					$this->Session->setFlash('Senha alterada com sucesso','msg-good');
					$this->redirect(array('controller' => 'companies','action' => 'mudarsenha'));         			
        		}
        	}
		}
	}

	public function edit() {
			$this->Company->id = $this->Session->read('usuarioID');
			if ($this->request->is('get')) {
				$this->request->data = $this->Company->read();
			} else if ($this->checaData()){
				if ($this->Company->save($this->request->data)) {
					$this->Session->setFlash('Edição realizada com sucesso.','msg-good');
					$this->redirect(array('action' => 'edit'));
				} else {
					$this->Session->setFlash('Edição não pode ser executada.','msg-erro');
				}
			}
	}
	
	public function inscritos($id = null) {
		$this->loadModel('User');
		$this->set('inscrito',$this->Company->User->find('all', array('order' => array( 'cargo' => 'ASC'), 'conditions' => array( 'User.company_id' => $this->Session->read('usuarioID')))));
		$this->set('confirmados',$this->Company->User->find('count', array('conditions' => array( 'User.company_id' => $this->Session->read('usuarioID'), 'presenca' => '1'))));
	}

	public function desconfirmaruser($id = null) {
		if ($this->request->is('get'))
			throw new MethodNotAllowedException();
		$this->loadModel('Configuration');
		$config = $this->Configuration->find('first', array( 'conditions' => array( 'Configuration.configuration_id' => '1')));
		$this->loadModel('User');
		$checagem = $this->User->find('count', array( 'conditions' => array( 'User.user_id' => $id, 'User.company_id' => $this->Session->read('usuarioID'))));
		$userdata = $this->User->find('first',array('conditions' => array( 'User.user_id' => $id)));
		if ($checagem == 1 && $this->checaData() && $this->checaPay()) {

			$this->User->set(array( 'presenca' => 0));
			$this->User->id = $id;
			if ($this->User->save($id)) {
				$this->Session->setFlash('Usuário desconfirmado com sucesso.','msg-good');
				$this->redirect(array('action' => 'inscritos'));
			}			
		}
		else {
			$this->Session->setFlash('Erro ao desconfirmar usuário.','msg-erro');
			$this->redirect(array('controller' => 'companies','action' => 'inscritos'));			
		}
	}

	public function confirmaruser($id = null) {
		if ($this->request->is('get'))
			throw new MethodNotAllowedException();
		$this->loadModel('Configuration');
		$config = $this->Configuration->find('first', array( 'conditions' => array( 'Configuration.configuration_id' => '1')));
		$this->loadModel('User');
		$checagem = $this->User->find('count', array( 'conditions' => array( 'User.user_id' => $id, 'User.company_id' => $this->Session->read('usuarioID'))));
		$userdata = $this->User->find('first',array('conditions' => array( 'User.user_id' => $id)));
		if ($checagem == 1 && $this->checaData() && $this->checaPay() && $this->checaVagas($userdata['User']['cargo'])) {

			$this->User->set(array( 'presenca' => 1));
			$this->User->id = $id;
			if ($this->User->save($id)) {
				$this->Session->setFlash('Usuário confirmado com sucesso.','msg-good');
				$this->redirect(array('action' => 'inscritos'));
			}			
		}
		else {
			$this->Session->setFlash('Erro ao confirmar usuário.','msg-erro');
			$this->redirect(array('controller' => 'companies','action' => 'inscritos'));			
		}
	}
	public function buscainscrito() {
		$this->loadModel('User');
		if( $this->request->is('post') && !(empty($this->request->data))) {
			$tipo = $this->request->data['Company']['tipo'];
			$busca = $this->request->data['Company']['busca'];
			$this->set('resultado', $this->Company->User->find('all', array( 'order' => array( 'cargo' => 'ASC'), 'conditions' => array( 'User.company_id' => $this->Session->read('usuarioID'), "User.$tipo LIKE" => '%'.$busca.'%'))));
		}
	}

	public function payment() {
		$this->loadModel('Bank');
		$this->loadModel('User');
		$this->set('bancos',$this->Bank->find('all'));
		$this->set('confirmados',$this->Company->User->find('count', array('conditions' => array( 'User.company_id' => $this->Session->read('usuarioID'), 'presenca' => '1'))));
	}
	public function comprovante() {
		$this->loadModel('Ticket');
		$this->loadModel('Configuration');
		$this->loadModel('User');
		$config = $this->Configuration->find('first', array( 'conditions' => array( 'Configuration.configuration_id' => '1')));
		$this->set('info',$this->Ticket->find('first', array('conditions' => array( 'Ticket.company_id' => $this->Session->read('usuarioID')))));
		
		if ($this->request->is('post')) {
			$usuarios = $this->User->find('count', array( 'conditions' => array( 'User.company_id' => $this->Session->read('usuarioID'), 'User.presenca' => 1)));
			$this->request->data['Ticket']['usuarios'] = $usuarios;
			$this->request->data['Ticket']['company_id'] = $this->Session->read('usuarioID');
			if ($this->Ticket->find('count', array( 'conditions' => array('Ticket.company_id' => $this->Session->read('usuarioID')))) > 0) { //Checa se usuario ja tem um ticket, relação POG hasOne
				$this->Session->setFlash('Erro ao adcionar comprovante.','msg-erro');
				$this->redirect(array('controller' => 'companies','action' => 'comprovante'));
			}
			if ($this->Ticket->save($this->request->data)) {
				$this->Session->setFlash('Comprovante adcionado com sucesso.','msg-good');
				$this->redirect(array('controller' => 'companies','action' => 'comprovante'));
			} else {
				$this->Session->setFlash('Erro ao adcionar comprovante.','msg-erro');
				$this->redirect(array('controller' => 'companies','action' => 'comprovante'));
				}
		}
	}

	public function comprovantedelete($id = null) {
		if ($this->request->is('get'))
			throw new MethodNotAllowedException();
		$this->loadModel('Configuration');
		$config = $this->Configuration->find('first', array( 'conditions' => array( 'Configuration.configuration_id' => '1')));
		$this->loadModel('Ticket');
		$checagem = $this->Ticket->find('count', array( 'conditions' => array( 'Ticket.ticket_id' => $id, 'Ticket.company_id' => $this->Session->read('usuarioID'), 'Ticket.valida NOT LIKE' => '1')));
			if ($checagem == 1) {
				if ($this->Ticket->delete($id)) {
					$this->Session->setFlash('Comprovante deletado com sucesso.','msg-good');
					$this->redirect(array('action' => 'comprovante'));
				}			
			}
			else {
				$this->Session->setFlash('Erro ao deletar comprovante.','msg-erro');
				$this->redirect(array('controller' => 'companies','action' => 'comprovante'));			
			}
	}
}
 ?>