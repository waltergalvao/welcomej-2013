<?php 
class ConfigurationsController extends AppController {

	public function beforeFilter() {
		$this->loadModel('Company'); // Carrega dados das EJ
		$this->loadModel('User');

		if ($this->Session->read('usuarioCargo') == 'COMPANY') { //Redireciona para página index das EJs caso uma EJ tente acessar uma action de USER
			$this->redirect(array('controller' => 'companies', 'action' => 'index'), null, true);
		}
		else if ($this->Session->read('usuarioCargo') == 'USER') { //Redireciona para página index da Administração caso um ADMIN tente acessar uma action de USER
			$this->redirect(array('controller' => 'users', 'action' => 'index'), null, true);
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

	public function index() {
		$this->loadModel('User');
		$this->loadModel('Company');
		$this->loadModel('Ticket');
		$this->loadModel('Userticket');
		$this->set('usuarios',$this->User->find('count'), array( 'conditions' => array( 'niv_acesso NOT LIKE' => 'ADMIN')));
		$this->set('veteranos',$this->User->find('count', array( 'conditions' => array( 'User.cargo' => 'Membro'))));
		$this->set('trainee',$this->User->find('count', array( 'conditions' => array( 'User.cargo' => 'Trainee'))));

		$this->set('usuarioscon',$this->User->find('count', array( 'conditions' => array( 'User.presenca' => 1))));
		$this->set('veteranoscon',$this->User->find('count', array( 'conditions' => array( 'User.cargo' => 'Membro', 'User.presenca' => 1))));
		$this->set('traineecon',$this->User->find('count', array( 'conditions' => array( 'User.cargo' => 'Trainee', 'User.presenca' => 1))));

		$this->set('ejs',$this->Company->find('count'));
		$this->set('ejspagos',$this->Ticket->find('count', array( 'conditions' => array( 'valida' => 1))));
		$this->set('tickets',$this->Ticket->find('count', array( 'conditions' => array( 'valida' => 0))));
		$this->set('usertickets',$this->Userticket->find('count', array( 'conditions' => array( 'valida' => 0))));		
	}

	public function mudarsenha() {
		$this->loadModel('User');
		if ($this->request->is('post') && $this->checadata()) {	
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
			
	public function checaInsc($vt,$vm) {
		$this->loadModel('User');
		$trainee = $this->User->find('count', array( 'conditions' => array( 'User.cargo' => 'Trainee', 'User.presenca' => '1')));
		$membro = $this->User->find('count', array( 'conditions' => array( 'User.cargo' => 'Membro', 'User.presenca' => '1')));
		if ($membro > $vm) {
			$this->Session->setFlash('Número de vagas para membros não pode ser menor do que número de membros JÁ confirmados.','msg-erro');	
			$this->redirect(array('action' => 'edit'));
		}
		else if ($trainee > $vt) {
			$this->Session->setFlash('Número de vagas para trainees não pode ser menor do que número de trainees JÁ confirmados.','msg-erro');	
			$this->redirect(array('action' => 'edit'));
		} else {
			return true;
		}
	}
	public function edit() {
			$this->Configuration->id = 1;
			if ($this->request->is('get')) {
				$this->request->data = $this->Configuration->read();
			} else if ($this->checaInsc($this->request->data['Configuration']['vagas_trainee'],$this->request->data['Configuration']['vagas_veterano'])) {
				$this->request->data['Configuration']['valor_inscricao'] = str_replace(',','.',$this->request->data['Configuration']['valor_inscricao']);


				$inicioinsc = strtotime($this->request->data['Configuration']['inicio_inscricoes']['year'].'-'.$this->request->data['Configuration']['inicio_inscricoes']['month'].'-'.$this->request->data['Configuration']['inicio_inscricoes']['day'].' '.$this->request->data['Configuration']['inicio_inscricoes']['hour'].':'.$this->request->data['Configuration']['inicio_inscricoes']['min'].':00');
				
				$fiminsc = strtotime($this->request->data['Configuration']['fim_inscricoes']['year'].'-'.$this->request->data['Configuration']['fim_inscricoes']['month'].'-'.$this->request->data['Configuration']['fim_inscricoes']['day'].' '.$this->request->data['Configuration']['fim_inscricoes']['hour'].':'.$this->request->data['Configuration']['fim_inscricoes']['min'].':00');

				$fimgeral = strtotime($this->request->data['Configuration']['fim_geral']['year'].'-'.$this->request->data['Configuration']['fim_geral']['month'].'-'.$this->request->data['Configuration']['fim_geral']['day'].' '.$this->request->data['Configuration']['fim_geral']['hour'].':'.$this->request->data['Configuration']['fim_geral']['min'].':00');

				$hoje = strtotime(date('Y-m-d H:i'));
				if ($fiminsc <= $inicioinsc) {
					$this->Session->setFlash('Fim de inscrição não pode ser antes do início.','msg-erro');
					$this->redirect(array('action' => 'edit'));
				}

				if ($fimgeral <= $fiminsc) {
					$this->Session->setFlash('Fim geral não pode ser antes do fim das inscrições.','msg-erro');
					$this->redirect(array('action' => 'edit'));
				}

				if ($this->request->data['Configuration']['certificado'] == 1 && $hoje < $fimgeral) {
					$this->Session->setFlash('Certificados só podem ser liberados após fim geral..','msg-erro');
					$this->redirect(array('action' => 'edit'));					
				}
				if ($this->Configuration->save($this->request->data)) {
					$this->Session->setFlash('Edição realizada com sucesso.','msg-good');
					$this->redirect(array('action' => 'edit'));
				} else {
					$this->Session->setFlash('Edição não pode ser executada.','msg-erro');
				}
			}
	}

	public function users($id = null) {
		$this->loadModel('User');
		$this->loadModel('Company');

		$options = array( 'order' => array( 'Company.nome' => 'ASC', 'User.cargo' => 'ASC','User.nome' => 'ASC'), 'conditions' => array( 'niv_acesso NOT LIKE' => 'ADMIN'), 'limit' => '10');
		$this->paginate = $options;
		$inscritos = $this->paginate('User');

		$this->set('inscrito',$inscritos);
		$this->set('confirmados',$this->Company->User->find('count', array('conditions' => array( 'presenca' => '1'))));
	}

	public function edituser($id = null) {
		$this->loadModel('User');
			$this->User->id = $id;
			$this->set('userid',$id);
			if ($this->request->is('get')) {
				$this->request->data = $this->User->read();
			} else {
					if ($this->User->save($this->request->data)) {
						$this->Session->setFlash('Edição realizada com sucesso.','msg-good');
						$this->redirect(array('action' => 'edituser', $id));
					} else {
					$this->Session->setFlash('Edição não pode ser executada.','msg-erro');
					}
			}
	}

	public function edituserpass($id = null) {
		$this->loadModel('User');
			$this->User->id = $id;
			$this->set('userid',$id);
			if ($this->request->is('post') && !(empty($this->request->data))) {


			$newpass = $this->request->data['User']['newpass'];
			$newpasscon = $this->request->data['User']['newpassconfirm'];

			$newpass1en = md5($newpass.'Ch4V&L0c@');
        	$newpass2en = md5($newpass1en);

			$newpasscon1en = md5($newpasscon.'Ch4V&L0c@');
        	$newpasscon2en = md5($newpasscon1en);
			
			if ($newpasscon2en != $newpass2en) {
				$this->Session->setFlash('As novas senhas não coincidem.','msg-erro');
				$this->redirect(array('controller' => 'configurations','action' => 'edituserpass', $id));           		
        	} else if (strlen($newpass) < 6) {
 				$this->Session->setFlash('Senha deve ter ao menos 6 caractéres','msg-erro');
				$this->redirect(array('controller' => 'configurations','action' => 'edituserpass', $id));         		
        	} else {
        		$this->User->set(array( 'user_id' => $id,'pass' => $newpass2en));
        		if($this->User->save()) {
 					$this->Session->setFlash('Senha alterada com sucesso','msg-good');
					$this->redirect(array('controller' => 'configurations','action' => 'edituser', $id));         			
        		}
        	}
			}
	}

	public function desconfirmaruser($id = null) {
		if ($this->request->is('get'))
			throw new MethodNotAllowedException();

		$this->loadModel('User');
		$this->loadModel('Company');
		$checagem = $this->User->find('count', array( 'conditions' => array( 'User.user_id' => $id)));
			$this->User->set(array( 'presenca' => 0));
			$this->User->id = $id;
			if ($this->User->save($id)) {
				$this->Session->setFlash('Usuário desconfirmado com sucesso.','msg-good');
				$this->redirect(array('action' => 'users'));
			}
		else {
			$this->Session->setFlash('Erro ao desconfirmar usuário.','msg-erro');
			$this->redirect(array('controller' => 'configurations','action' => 'users'));			
		}
	}

	public function confirmaruser($id = null) {
		if ($this->request->is('get'))
			throw new MethodNotAllowedException();

		$this->loadModel('User');
		$this->loadModel('Company');
		$userdata = $this->User->find('first',array('conditions' => array( 'User.user_id' => $id)));
		$checagem = $this->User->find('count', array( 'conditions' => array( 'User.user_id' => $id)));
		if ($this->checaVagas($userdata['User']['cargo'])) { 
				$this->User->set(array( 'presenca' => 1));
				$this->User->id = $id;
				if ($this->User->save($id)) {
					$this->Session->setFlash('Usuário confirmado com sucesso.','msg-good');
					$this->redirect(array('action' => 'users'));
				} 	
				else {
					$this->Session->setFlash('Erro ao confirmar usuário.','msg-erro');
					$this->redirect(array('controller' => 'configurations','action' => 'users'));			
					}	
		} else {
			$this->Session->setFlash('Vagas insuficientes','msg-erro');
			$this->redirect(array('controller' => 'configurations','action' => 'users'));					
		}
	}

	public function usersbusca() {
		$this->loadModel('User');
		$this->loadModel('Company');
		if( $this->request->is('post') && !(empty($this->request->data))) {
			$tipo = $this->request->data['Configuration']['tipo'];
			$busca = $this->request->data['Configuration']['busca'];
			$this->set('resultado', $this->Company->User->find('all', array( 'order' => array( 'cargo' => 'ASC'), 'conditions' => array(  'niv_acesso NOT LIKE' => 'ADMIN', "User.$tipo LIKE" => '%'.$busca.'%'))));
		}
	}

	public function companies() {
		$this->loadModel('Company');
		$this->loadModel('User');
		$options = array( 'recursive' => 2, 'order' => array( 'Company.nome' => 'ASC'), 'limit' => 10);
		$this->paginate = $options;
		$companies = $this->paginate('Company');
		
		$this->set('company',$companies);
	}
	public function companiesbusca() {
		$this->loadModel('User');
		if( $this->request->is('post') && !(empty($this->request->data))) {
			$tipo = $this->request->data['Configuration']['tipo'];
			$busca = $this->request->data['Configuration']['busca'];
			$this->set('resultado',$this->User->Company->find('all', array( 'recursive' => 2, 'order' => array( 'Company.nome' => 'ASC'), 'conditions' => array( "Company.$tipo LIKE" => '%'.$busca.'%'))));
		}		
	}

	public function editcompany() {
		$this->loadModel('User');
		$this->loadModel('Company');
		if( $this->request->is('post') && !(empty($this->request->data))) {		
				if ($this->Company->save($this->request->data)) {
					$this->Session->setFlash('Edição realizada com sucesso.','msg-good');
					$this->redirect(array('action' => 'companies'));
				} else {
					$this->Session->setFlash('Edição não pode ser executada.','msg-erro');
					$this->redirect(array('action' => 'companies'));
				}
			}			
	}

	public function desconfirmaruser2($id = null) {
		if ($this->request->is('get'))
			throw new MethodNotAllowedException();

		$this->loadModel('User');
		$this->loadModel('Company');
		$checagem = $this->User->find('count', array( 'conditions' => array( 'User.user_id' => $id)));

			$this->User->set(array( 'presenca' => 0));
			$this->User->id = $id;
			if ($this->User->save($id)) {
				$this->Session->setFlash('Usuário desconfirmado com sucesso.','msg-good');
				$this->redirect(array('action' => 'companies'));
			}
		else {
			$this->Session->setFlash('Erro ao desconfirmar usuário.','msg-erro');
			$this->redirect(array('controller' => 'configurations','action' => 'companies'));			
		}
	}

	public function confirmaruser2($id = null) {
		if ($this->request->is('get'))
			throw new MethodNotAllowedException();

		$this->loadModel('User');
		$this->loadModel('Company');
		$checagem = $this->User->find('count', array( 'conditions' => array( 'User.user_id' => $id)));
			$this->User->set(array( 'presenca' => 1));
			$this->User->id = $id;
			if ($this->User->save($id)) {
				$this->Session->setFlash('Usuário confirmado com sucesso.','msg-good');
				$this->redirect(array('action' => 'companies'));
			}
		else {
			$this->Session->setFlash('Erro ao confirmar usuário.','msg-erro');
			$this->redirect(array('controller' => 'configurations','action' => 'companies'));			
		}
	}

	public function tickets() {
		$this->loadModel('Userticket');
		$this->loadModel('Ticket');
		$this->loadModel('User');
		$this->loadModel('Company');
		$this->set('paytickets', $this->Ticket->find('all', array( 'order' => array( 'Ticket.created' => 'ASC'), 'conditions' => array( 'Ticket.valida' => '0'))));
		$this->set('tickets', $this->Userticket->find('all', array( 'order' => array( 'Userticket.created' => 'ASC'), 'conditions' => array( 'Userticket.valida' => '0'))));
		$this->set('config', $this->Configuration->find('first', array( 'conditions' => array( 'Configuration.configuration_id' => 1))));
	}

	public function aprovaTicket() {
		$this->loadModel('Userticket');
		if ($this->request->is('post') && !(empty($this->request->data))) {
			$this->Userticket->id = $this->request->data['Configuration']['userticket_id'];
			$dadosticket = $this->Userticket->find('first', array( 'conditions' => array( 'userticket_id' => $this->request->data['Configuration']['userticket_id'])));
			//Define se está aprovando ou negando ticket
			if ($this->request->data['Configuration']['acao'] == 1) {
				$this->request->data['Userticket']['valida'] = '1'; //Ticket Valido
			}
			else {
				$this->request->data['Userticket']['valida'] = '2'; //Ticket inválido
				# Nardz indeciso, falou que não precisava, depois que precisava, e agora que não precisa /ri
				#$this->User->set(array('user_id' => $dadosticket['Userticket']['user_id'], 'presenca' => '0'));
				#$this->User->save(); //Ticket desaprovado = Usuário desconfirmado
			}
		
			if ($this->Userticket->save($this->request->data)) {
				$this->Session->setFlash('Termo modificado com sucesso','msg-good');
				$this->redirect(array('action' => 'tickets'));				
			}
			else {
				$this->Session->setFlash('Erro ao modificar termo.','msg-erro');
				$this->redirect(array('controller' => 'configurations','action' => 'tickets'));						
			}
		}
	}

	public function mailTicket($to,$nome,$tipo) {
            $subject = '[Welcomej] Confirmação de presença';
            $headers = "From: Welcomej@welcomej.com\r\n";
            $headers .= "Reply-To: contact@welcomej.com \r\n";
            $headers .= "CC: contact@welcomej.com\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html;  charset=utf-8'\r\n";
            $message = "Prezado(a) $nome, <br>	
			Informamos que o status do comprovante de pagamento foi alterado. O atual estado que ele se encontra é: ";
            if ($tipo == 1) {
            	$message .= "Aceito"."<br \><br \>"."Caso haja alguma dúvida ou divergência, favor entrar em contato.";
	        } else {
	            $message .= "Reprovado"."<br \><br \>"."Foi especificado o modelo e a data de entrega para o comprovante, como o mesmo não foi enviado de forma correta
				sua conta está automaticamente desconfirmada do evento e o comprovante anterior foi removido, este processo é irreversível. Caso haja alguma dúvida 
				entre em contato conosco!";
	        }

	        $message .= "<br \><br \>Atenciosamente,<br \>
			Comissão Organizadora <a href='http://www.welcomej.uni.me'>WELCOMEJ</a>.";
            mail($to, $subject, $message, $headers);	
	}

	public function mailTicketEJ($to,$nome,$tipo) {
            $subject = '[Welcomej] Confirmação de presença';
            $headers = "From: Welcomej@welcomej.com\r\n";
            $headers .= "Reply-To: contact@welcomej.com \r\n";
            $headers .= "CC: contact@welcomej.com\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html;  charset=utf-8'\r\n";
            $message = "Prezado(a) Reponsável pela $nome,<br \>
            Informamos que o status do comprovante de pagamento foi alterado. O atual estado que ele se encontra é: ";
            if ($tipo == 1) {
            	$message .= "Aceito"."<br \><br \>"."Caso haja alguma dúvida ou divergência, favor entrar em contato.";
	        } else {
	            $message .= "Reprovado"."<br \><br \>"."Entre em contato com urgência para que o problema possa ser sanado o quanto antes.";
	        }

	        $message .= "<br \><br \>Atenciosamente,<br \>
			Comissão Organizadora <a href='http://www.welcomej.uni.me'>WELCOMEJ</a>.";
            mail($to, $subject, $message, $headers);	
	}

	public function aprovaPayTicket() {
		$this->loadModel('Ticket');
		$this->loadModel('User');
		$this->loadModel('Company');
		if ($this->request->is('post') && !(empty($this->request->data))) {
			$this->Ticket->id = $this->request->data['Configuration']['ticket_id'];
			$dadosticket = $this->Ticket->find('first', array( 'conditions' => array( 'Ticket.ticket_id' => $this->request->data['Configuration']['ticket_id'])));

			$users = $this->User->Company->find('all', array( 'recursive' => 2, 'conditions' => array( 'Company.company_id' => $dadosticket['Ticket']['company_id'])));
			$company = $this->Company->find('first', array( 'conditions' => array( 'Company.company_id' => $dadosticket['Ticket']['company_id'])));
			//Define se está aprovando ou negando ticket
			if ($this->request->data['Configuration']['acao'] == 1) {
				$this->request->data['Ticket']['valida'] = '1'; //Comprovante aprovado
				foreach ($users as $type) { //Para cada usuario dispara um email
					foreach ($type['User'] as $usuario) {
						$this->mailTicket($usuario['email'],$usuario['nome'],'1');
					}
				}
				$this->mailTicketEJ($company['Company']['email'],$company['Company']['nome'],'1');
			}
			else {
				$this->request->data['Ticket']['valida'] = '2'; //Comprovante reprovado
				foreach ($users as $type) { //Para cada usuario dispara um email
					foreach ($type['User'] as $usuario) {
						$this->mailTicket($usuario['email'],$usuario['nome'],'2');
					}
				}
				$this->mailTicketEJ($company['Company']['email'],$company['Company']['nome'],'0');
			}

			if ($this->Ticket->save($this->request->data)) {
				$this->Session->setFlash('Termo modificado com sucesso','msg-good');
				$this->redirect(array('action' => 'tickets'));				
			}
			else {
				$this->Session->setFlash('Erro ao modificar termo.','msg-erro');
				$this->redirect(array('controller' => 'configurations','action' => 'tickets'));						
			}
		}
	}

	public function desconfirmaUser($id) {
		$this->User->set(array( 'presenca' => 0));
		$this->User->id = $id;
		$this->User->save($id);		
	}
	public function varreduraunderage() {
		$this->loadModel('User');
		$this->loadModel('Userticket');
		$usuarios = $this->User->find('all', array( 'recursive' => 0, 'coditions' => array( 'maioridade' => '0', 'presenca' => '1')));
		$contausuarios = $this->User->find('count', array( 'recursive' => 0, 'coditions' => array( 'maioridade' => '0', 'presenca' => '1')));
		$i = 0;
		foreach( $usuarios as $key => $user) {
			$i++;
			$userid = $user['User']['user_id'];
			$contatermo = $this->Userticket->find('count', array( 'conditions' => array( 'Userticket.user_id' => $userid)));
			if ($contatermo) {
				$infotermo = $this->Userticket->find('first', array( 'conditions' => array( 'Userticket.user_id' => $userid)));
				if ($infotermo['Userticket']['valida'] != '1')
					$this->desconfirmaUser($userid);
			}
			else {
				$this->desconfirmaUser($userid);
			}

			if ($contausuarios == $i) {
				$this->Session->setFlash('Varredura completa.','msg-erro');
				$this->redirect(array('controller' => 'configurations','action' => 'edit'));	
			}
		}
	}
}
 ?>