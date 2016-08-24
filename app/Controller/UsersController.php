<?php 
class UsersController extends AppController {

	public function beforeFilter() {
		$this->loadModel('Company'); // Carrega dados das EJ
		if ($this->Session->read('usuarioCargo') == 'COMPANY') { //Redireciona para página index das EJs caso uma EJ tente acessar uma action de USER
			$this->redirect(array('controller' => 'companies', 'action' => 'index'), null, true);
		}
		else if ($this->Session->read('usuarioCargo') == 'ADMIN') { //Redireciona para página index da Administração caso um ADMIN tente acessar uma action de USER
			$this->redirect(array('controller' => 'configuracoes', 'action' => 'index'), null, true);
		}
		else if ($this->Session->read('usuarioID') == '' || $this->Session->read('usuarioPass') == '' || $this->Session->read('usuarioCPF') == ''|| $this->Session->read('usuarioCargo') == '') {
			if ($this->Session->valid()) //Verifica se existe sessão aberta
				$this->Session->destroy();
			$this->redirect(array( 'controller' => 'pages', 'action' => 'home'),null,true);
		} else {
			$usercount = $this->User->find('count', array('conditions' => array( 'User.user_id' => $this->Session->read('usuarioID'), 'User.cpf' => $this->Session->read('usuarioCPF'), 'User.pass' => $this->Session->read('usuarioPass'))));

			if ( $usercount == 0) {
				$this->Session->destroy();
				$this->redirect(array( 'controller' => 'pages', 'action' => 'home'),null,true);
			}
		}	
	}

	public function checaData() { //Checa data em relação com fim geral
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

	public function checaData2() { //Checa data em relação com fim das inscrições
		$this->loadModel('Configuration');
		$config = $this->Configuration->find('first', array( 'conditions' => array( 'Configuration.configuration_id' => '1')));	
		$datafim = strtotime($config['Configuration']['fim_inscricoes']);
		$hoje = strtotime(date('Y-m-d h:m:s'));	

		if ($hoje > $datafim) {
				$this->Session->setFlash('Alterações de dados já não são mais possíveis.','msg-erro');
				$this->redirect(array( 'action' => 'index'));	
		} else {
			return true;
		}
	}

	public function checaVagas($cargo) {
		$this->loadModel('Configuration');
		$config = $this->Configuration->find('first', array( 'conditions' => array( 'Configuration.configuration_id' => '1')));	
		$vagasocupadas = $this->User->find('count', array( 'conditions' => array( 'User.cargo' => $cargo, 'User.presenca' => '1')));

		if ($cargo == 'Trainee') {
			if ($config['Configuration']['vagas_trainee'] - $vagasocupadas > 0) {
				return true;
			}
			else {
				return false;
			}
		}
		else if ($cargo == 'Membro') {
			if ($config['Configuration']['vagas_veterano'] - $vagasocupadas > 0) { 
				return true;
			}
			else {
				return false;
			}
		}
		else {
			return false;
		}
	}

	public function index() {
		$this->loadModel('Configuration');
		$this->set('config', $this->Configuration->find('first', array( 'conditions' => array( 'Configuration.certificado' => 1))));
		$this->set('info',$this->User->find('first', array( 'conditions' => array( 'User.user_id' => $this->Session->read('usuarioID')))));
	}

	public function mudarsenha() {
		if ($this->request->is('post')) {	
			$oldpass = $this->request->data['User']['oldpass'];
			$newpass = $this->request->data['User']['newpass'];
			$newpasscon = $this->request->data['User']['newpassconfirm'];

			$oldpass1en = md5($oldpass.'Ch4V&L0c@');
        	$oldpass2en = md5($oldpass1en);

			$newpass1en = md5($newpass.'Ch4V&L0c@');
        	$newpass2en = md5($newpass1en);

			$newpasscon1en = md5($newpasscon.'Ch4V&L0c@');
        	$newpasscon2en = md5($newpasscon1en);
        	if ($this->User->find('count', array( 'conditions' => array( 'User.user_id' => $this->Session->read('usuarioID'), 'User.pass' => $oldpass2en))) != 1) {
				$this->Session->setFlash('Antiga senha inválida.','msg-erro');
				$this->redirect(array('controller' => 'users','action' => 'mudarsenha'));        		
        	}
			else if ($newpasscon2en != $newpass2en) {
				$this->Session->setFlash('As novas senhas não coincidem.','msg-erro');
				$this->redirect(array('controller' => 'users','action' => 'mudarsenha'));           		
        	} else if (strlen($newpass) < 6) {
 				$this->Session->setFlash('Senha deve ter ao menos 6 caractéres','msg-erro');
				$this->redirect(array('controller' => 'users','action' => 'mudarsenha'));         		
        	} else {
        		$this->User->set(array( 'user_id' => $this->Session->read('usuarioID'),'pass' => $newpass2en));
        		if($this->User->save()) {
 					$this->Session->setFlash('Senha alterada com sucesso','msg-good');
					$this->redirect(array('controller' => 'users','action' => 'mudarsenha'));         			
        		}
        	}
		}
	}

	public function comprovante() {
		$this->loadModel('Userticket');
		$this->set('info',$this->Userticket->find('first',array( 'conditions' => array( 'Userticket.user_id' => $this->Session->read('usuarioID')))));
		if ($this->request->is('post') && $this->checadata()) {
			$this->request->data['Userticket']['user_id'] = $this->Session->read('usuarioID');
			if ($this->Userticket->find('count', array( 'conditions' => array( 'Userticket.user_id' => $this->Session->read('usuarioID'))))	 > 0) {
				$this->Session->setFlash('Erro ao adcionar termo.','msg-erro');
				$this->redirect(array('controller' => 'users','action' => 'comprovante'));
			}
			if ($this->Userticket->save($this->request->data)) {
				$this->Session->setFlash('Termo adcionado com sucesso.','msg-good');
				$this->redirect(array('controller' => 'users','action' => 'comprovante'));
			} else {
				$this->Session->setFlash('Erro ao adcionar termo.','msg-erro');
				$this->redirect(array('controller' => 'users','action' => 'comprovante'));
				}
		}
	}

	public function comprovantedelete($id = null) {
		if ($this->request->is('get'))
			throw new MethodNotAllowedException();
		$this->loadModel('Userticket');
		$checagem = $this->Userticket->find('count', array( 'conditions' => array( 'Userticket.userticket_id' => $id, 'Userticket.user_id' => $this->Session->read('usuarioID'), 'Userticket.valida NOT LIKE' => '1')));
		if ($checagem == 1 && $this->checadata()) {
			if ($this->Userticket->delete($id)) {
				$this->Session->setFlash('Termo deletado com sucesso.','msg-good');
				$this->redirect(array('action' => 'comprovante'));
			}			
		}
		else {
			$this->Session->setFlash('Erro ao deletar termo.','msg-erro');
			$this->redirect(array('controller' => 'users','action' => 'comprovante'));			
		}
	}
	public function edit() {			
			$this->User->id = $this->Session->read('usuarioID');
			if ($this->request->is('get')) {
				$this->request->data = $this->User->read();
			} else {
				if ($this->checadata2()) {
					if ($this->User->save($this->request->data)) {
						$this->Session->setFlash('Edição realizada com sucesso.','msg-good');
						$this->redirect(array('action' => 'edit'));
					} else {
					$this->Session->setFlash('Edição não pode ser executada.','msg-erro');
					}
				}
			}
	}
	public function localizacao() {
		$this->loadModel('Address');
		$endereco = $this->Address->find('first', array( 'conditions' => array( 'Address.user_id' => $this->Session->read('usuarioID'))));
		$this->Address->id = $endereco['Address']['address_id'];
		if ($this->request->is('get')) {
			$this->request->data = $this->Address->read();
		} else {
			if ( $this->checadata2()) {
				if ($this->Address->save($this->request->data)) {
					$this->Session->setFlash('Edição realizada com sucesso.','msg-good');
					$this->redirect(array('action' => 'localizacao'));
				} else {
					$this->Session->setFlash('Edição não pode ser executada.','msg-erro');
				}
			}
		}	
	}
	public function contatosemergencia() {
		$this->loadModel('Emergency');
		$this->set('contatos', $this->Emergency->find('all', array( 'conditions' => array( 'Emergency.user_id' => $this->Session->read('usuarioID')))));		
	}

	public function ContatoEmergenciaAdd() {
		$this->loadModel('Emergency');
		if ($this->request->is('post') && $this->checadata()) {
			if ($this->Emergency->save($this->request->data)) {
				$this->Session->setFlash('Contato de emergência adcionado com sucesso.','msg-good');
				$this->redirect(array('controller' => 'users','action' => 'contatosemergencia'));
			} else {
				$this->Session->setFlash('Erro ao adcionar contato.','msg-erro');
				$this->redirect(array('controller' => 'users','action' => 'contatosemergencia'));
				}
		}		
	}

	public function ContatoEmergenciaEdit($id = null) {		
		$this->loadModel('Emergency');
			$this->Emergency->id = $id;
			$checagem = $this->Emergency->find('count', array( 'conditions' => array( 'Emergency.emergency_id' => $id, 'Emergency.user_id' => $this->Session->read('usuarioID'))));
			if ($checagem == 0) {
				$this->Session->setFlash('Sem autorização.','msg-erro');
				$this->redirect(array('controller' => 'users','action' => 'contatosemergencia'));
			}
			if ($this->request->is('get')) {
				$this->request->data = $this->Emergency->read();
			} else if ($this->checadata2()){
				if ($this->Emergency->save($this->request->data)) {
					$this->Session->setFlash('Edição realizada com sucesso.','msg-good');
					$this->redirect(array('controller' => 'users','action' => 'contatosemergencia'));
				} else {
					$this->Session->setFlash('Edição não pode ser executada.','msg-erro');
				}
			}		
	}
	public function contatos() {
		$this->loadModel('Contact');
		$this->set('contatos', $this->Contact->find('all', array( 'conditions' => array( 'Contact.user_id' => $this->Session->read('usuarioID')))));
	}

	public function ContatoEdit($id = null) {
		
		
		$this->loadModel('Contact');
			$this->Contact->id = $id;
			$checagem = $this->Contact->find('count', array( 'conditions' => array( 'Contact.Contact_id' => $id, 'Contact.user_id' => $this->Session->read('usuarioID'))));
			if ($checagem == 0) {
				$this->Session->setFlash('Sem autorização.','msg-erro');
				$this->redirect(array('controller' => 'users','action' => 'contatosemergencia'));
			}
			if ($this->request->is('get')) {
				$this->request->data = $this->Contact->read();
			} else if ($this->checadata2()) {
				if ($this->Contact->save($this->request->data)) {
					$this->Session->setFlash('Edição realizada com sucesso.','msg-good');
					$this->redirect(array('controller' => 'users','action' => 'contatos'));
				} else {
					$this->Session->setFlash('Edição não pode ser executada.','msg-erro');
				}
			}		
	}

	public function ContatoAdd() {
		
		$this->loadModel('Contact');
		if ($this->request->is('post') && $this->checadata()) {
			if ($this->Contact->save($this->request->data)) {
				$this->Session->setFlash('Contato adcionado com sucesso.','msg-good');
				$this->redirect(array('controller' => 'users','action' => 'contatos'));
			} else {
				$this->Session->setFlash('Erro ao adcionar contato.','msg-erro');
				$this->redirect(array('controller' => 'users','action' => 'contatos'));
				}
		}
	}

	public function confirmarpresenca() {
		$this->loadModel('Emergency');
		$this->loadModel('Contact');
		$this->loadModel('Address');
		$this->loadModel('Userticket');
		$userdata = $this->User->find('first',array('conditions' => array( 'User.user_id' => $this->Session->read('usuarioID'))));
		if ($this->Emergency->find('count',array('conditions' => array( 'Emergency.user_id' => $this->Session->read('usuarioID')))) == 0) {
			$this->Session->setFlash('Você deve ter pelo menos um contato de emergência.','msg-erro');
			$this->redirect(array('controller' => 'users','action' => 'index'));
		}
		else if ($this->Contact->find('count',array('conditions' => array( 'Contact.user_id' => $this->Session->read('usuarioID')))) == 0) {
			$this->Session->setFlash('Você deve ter pelo menos um contato registrado.','msg-erro');
			$this->redirect(array('controller' => 'users','action' => 'index'));
		}
		else if ($this->Address->find('count',array('conditions' => array( 'Address.user_id' => $this->Session->read('usuarioID'), 'Address.rua NOT LIKE' => '', 'Address.cep NOT LIKE' => '', 'Address.bairro NOT LIKE' => '', 'Address.numero NOT LIKE' => '', 'Address.cidade NOT LIKE' => '' ))) == 0) {
			$this->Session->setFlash('Você deve ter um endereço válido.','msg-erro');
			$this->redirect(array('controller' => 'users','action' => 'index'));
		}
		else if ($this->checaData2()) {
			if ($this->checaVagas($userdata['User']['cargo'])) {
				//if ($userdata['User']['maioridade'] == 0 && $this->Userticket->find('count',array( 'conditions' => array('Usrticket.valida' => 1, 'Userticket.user_id' => $this->Session->read('usuarioID'))) == 1) == 0) {
				//	$this->Session->setFlash('Você deve enviar um termo de autorização e esperar pela aprovação do mesmo antes de confirmar sua presença.','msg-erro');
				//	$this->redirect(array('controller' => 'users','action' => 'index'));				
				//} Segundo o Nardz, o usuário pode confirmar presença mesmo sem o termo de ciencia para menor de idade
				$this->User->set(array( 'presenca' => 1));
				$this->User->id = $this->Session->read('usuarioID');
				if ($this->User->save($this->Session->read('usuarioID'))) {
					$this->Session->setFlash('Usuário Confirmado com sucesso.','msg-good');
					$this->redirect(array('action' => 'index'));
				}
				else {
					$this->Session->setFlash('Erro ao Confirmar usuário.','msg-erro');
					$this->redirect(array('controller' => 'users','action' => 'index'));			
				} 
			} else {
				$this->Session->setFlash('Vagas insuficientes.','msg-erro');
				$this->redirect(array('controller' => 'users','action' => 'index'));				
			}
		} else {
			$this->Session->setFlash('Confirmação de inscrições encerradas.','msg-erro');
			$this->redirect(array('controller' => 'users','action' => 'index'));				
		}
	}

	public function desconfirmarpresenca() {
		$this->loadModel('Emergency');
		$this->loadModel('Contact');
		$this->loadModel('Address');
		$userdata = $this->User->find('first',array('conditions' => array( 'User.user_id' => $this->Session->read('usuarioID'))));
		
		if ($this->Emergency->find('count',array('conditions' => array( 'Emergency.user_id' => $this->Session->read('usuarioID')))) == 0) {
			$this->Session->setFlash('Você deve ter pelo menos um contato de emergência.','msg-erro');
			$this->redirect(array('controller' => 'users','action' => 'index'));
		}
		else if ($this->Contact->find('count',array('conditions' => array( 'Contact.user_id' => $this->Session->read('usuarioID')))) == 0) {
			$this->Session->setFlash('Você deve ter pelo menos um contato registrado.','msg-erro');
			$this->redirect(array('controller' => 'users','action' => 'index'));
		}
		else if ($this->Address->find('count',array('conditions' => array( 'Address.user_id' => $this->Session->read('usuarioID'), 'Address.rua NOT LIKE' => '', 'Address.cep NOT LIKE' => '', 'Address.bairro NOT LIKE' => '', 'Address.numero NOT LIKE' => '', 'Address.cidade NOT LIKE' => '' ))) == 0) {
			$this->Session->setFlash('Você deve ter um endereço válido.','msg-erro');
			$this->redirect(array('controller' => 'users','action' => 'index'));
		}
		else if ( $this->checaData2()) {
			$this->User->set(array( 'presenca' => 0));
			$this->User->id = $this->Session->read('usuarioID');
			if ($this->User->save($this->Session->read('usuarioID'))) {
				$this->Session->setFlash('Usuário desconfirmado com sucesso.','msg-good');
				$this->redirect(array('action' => 'index'));
			}
			else {
				$this->Session->setFlash('Erro ao desconfirmar usuário.','msg-erro');
				$this->redirect(array('controller' => 'users','action' => 'index'));			
			}
		} else {
			$this->Session->setFlash('Confirmação de inscrições encerradas.','msg-erro');
			$this->redirect(array('controller' => 'users','action' => 'index'));
		}
	}
	public function termodownload() {}
	public function precertificado() {}
	public function certificado() {
		$this->layout = 'certificado';
		$user = $this->User->find('first', array( 'conditions' => array( 'User.user_id' => $this->Session->read('usuarioID'))));
		if ($user['User']['presenca'] == 1)
			$this->set('user',$user);
		else {
				$this->Session->setFlash('Somente usuários que participaram do evento tem direito ao certificado.','msg-erro');
				$this->redirect(array('controller' => 'users','action' => 'index'));				
		}
	}
}
?>