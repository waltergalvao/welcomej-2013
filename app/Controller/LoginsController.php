<?php
class LoginsController extends AppController
{
    // var $uses = null; works too
    var $uses = array();


    public function validaUsuario($usuario, $senha) {
        $this->loadModel('Company'); // Carrega dados das EJ
        $this->loadModel('User'); // Carrega dados do Usuario
        $this->loadModel('Configuration');
        $config = $this->Configuration->find('first', array( 'conditions' => array( 'Configuration.configuration_id' => '1')));
        
        // Armazena data para checar login da EJ
        $datafim = strtotime($config['Configuration']['fim_inscricoes']);
        $hoje = strtotime(date('Y-m-d h:m:s'));    
        // Usa a função addslashes para escapar as aspas
        $nusuario = addslashes($usuario);
        $nsenha = addslashes($senha);

        // Encripta senha
        $encripsenha = md5($nsenha.'Ch4V&L0c@');
        $crysenha = md5($encripsenha);

        // Consulta SQL (query) para procurar um usuário
        $user = $this->User->find('first', array('conditions' => array( 'User.cpf' => $nusuario, 'User.pass' => $crysenha)));
        $ej = $this->Company->find('first', array('conditions' => array( 'Company.user' => $nusuario, 'Company.pass' => $crysenha)));


        if (isset($user['User']['cpf'])) {
            $this->Session->write('usuarioID', $user['User']['user_id']); // Armazena valor do CPF, Senha e Cargo em variáveis da Sessão
            $this->Session->write('usuarioCPF', $user['User']['cpf']);
            $this->Session->write('usuarioPass', $user['User']['pass']);
            $this->Session->write('usuarioCargo', $user['User']['niv_acesso']);
            return true;
        }
        else if (isset($ej['Company']['user'])) {
            if ( $hoje > $datafim) {
                $this->Session->write('usuarioID', $ej['Company']['company_id']); // Armazena valor do CPF, Senha e Cargo em variáveis da Sessão
                $this->Session->write('usuarioPass', $ej['Company']['pass']);
                $this->Session->write('usuarioCargo', 'COMPANY');
                return true;
            }
            else {
                $this->Session->setFlash('EJ\'s só poderão fazer login após fim das inscrições','msg-erro'); //Redireciona para Home e envia mensagem de erro
                $this->redirect(array('controller' => 'pages', 'action' => 'display'));                   
            }
        }
        else {
            return false;
        }
    }

    public function recuperaSenha() {
        $this->loadModel('User');
        $this->loadModel('Company');
        $cpf = $this->request->data['Login']['cpf'];
        if ($this->User->find('count', array( 'conditions' => array( 'User.cpf' => $cpf))) == 1 ) {

            // É um user
            $user = $this->User->find('first', array( 'conditions' => array( 'User.cpf' => $cpf)));
            // Nova senha será gerada apartir da encriptação do CPF, e então selecionamos os 6 primeiros caractéres
            $novasenha = md5($user['User']['cpf']);
            $novasenha = substr($novasenha,0,6);

            $encsenha = md5($novasenha.'Ch4V&L0c@');
            $crysenha = md5($encsenha);

            $this->User->set(array('pass' => $crysenha, 'user_id' => $user['User']['user_id']));
            $this->User->save();
            
            $to = $user['User']['email'];
            $subject = '[Welcomej] Senha resetada';
            $headers = "From: Welcomej@welcomej.com\r\n";
            $headers .= "Reply-To: contact@welcomej.com \r\n";
            $headers .= "CC: contact@welcomej.com\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
            $message = "Sua senha de acesso ao sistema foi resetada.<br>Nova senha: $novasenha";
            if(mail($to, $subject, $message, $headers)) {
                 $this->Session->setFlash('Um email foi enviado para a conta do associado. Cheque a <b>caixa de spam!</b>','msg-good'); //Redireciona para Home e envia mensagem de erro
                $this->redirect(array('controller' => 'pages', 'action' => 'display'));               
            }

        } else if ( $this->Company->find('count', array( 'conditions' => array( 'Company.user' => $cpf))) == 1) {

            // É uma EJ
            $company = $this->Company->find('first', array( 'conditions' => array( 'Company.user' => $cpf)));

            // Nova senha será gerada apartir da encriptação do username, e então selecionamos os 6 primeiros caractéres
            $novasenha = md5($company['Company']['user']);
            $novasenha = substr($novasenha,0,6);

            $encsenha = md5($novasenha.'Ch4V&L0c@');
            $crysenha = md5($encsenha);

            $this->Company->set(array('pass' => $crysenha, 'company_id' => $company['Company']['company_id']));
            $this->Company->save();
            
            $to = $company['Company']['email'];
            $subject = '[Welcomej] Senha resetada';
            $headers = "From: Welcomej@welcomej.com\r\n";
            $headers .= "Reply-To: contact@welcomej.com \r\n";
            $headers .= "CC: contact@welcomej.com\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
            $message = "Sua senha de acesso ao sistema foi resetada.<br>Nova senha: $novasenha";
            if(mail($to, $subject, $message, $headers)) {
                 $this->Session->setFlash('Um email foi enviado para a conta do associado. Cheque a <b>caixa de spam!</b>','msg-good'); //Redireciona para Home e envia mensagem de erro
                $this->redirect(array('controller' => 'pages', 'action' => 'display'));               
            }

        } else {
                $this->Session->setFlash('Não encotramos nenhum um usuário com esse CPF.','msg-erro'); //Redireciona para Home e envia mensagem de erro
                $this->redirect(array('controller' => 'pages', 'action' => 'display'));            
        }
    }
    public function expulsaVisitante() {
        $this->Session->destroy();
        $this->redirect(array('controller' => 'pages', 'action' => 'display'));
    }

    public function logout() {
         $this->Session->destroy(); // Destrói
         $this->redirect( array('controller' => 'pages', 'action' => 'display'));
    }
    public function login() {
        $this->loadModel('User'); // Carrega dados dos Usuarios
        $this->loadModel('Company'); // Carrega dados das EJ

        if ($this->request->is('post') && !empty($this->request->data)) {
            $usuario = $this->request->data['Login']['cpf']; // Armazena valor do login
            $senha = $this->request->data['Login']['pass']; //Armazena valor da senha
            if ($this->validaUsuario($usuario, $senha) == true) {
                #if ($senha != "123456")
                    $this->Session->setFlash('Logado com sucesso.','msg-good'); //Redireciona para Home e envia mensagem de erro
                if ($this->Session->read('usuarioCargo') == 'USER') {
                    $this->redirect(array('controller' => 'users', 'action' => 'index')); //Redireciona para Home se login for válido
                } else if ($this->Session->read('usuarioCargo') == 'COMPANY') {
                    if ($senha == "123456") {
                        $this->Session->setFlash('Altere a sua senha de acesso.','msg-warn'); //Redireciona para Home e envia mensagem de erro
                        $this->redirect(array('controller' => 'companies', 'action' => 'mudarsenha')); //Redireciona para Home se login for válido
                    }
                    else {
                        $this->redirect(array('controller' => 'companies', 'action' => 'index')); //Redireciona para Home se login for válido
                    }
                } else if ($this->Session->read('usuarioCargo') == 'ADMIN') {
                    $this->redirect(array('controller' => 'configurations', 'action' => 'index')); //Redireciona para Home se login for válido   
                }               
            } else {
                $this->Session->setFlash('Login inválido.','msg-erro'); //Redireciona para Home e envia mensagem de erro
                $this->redirect(array('controller' => 'pages', 'action' => 'display'));
            }
        }
    }

    public function add() {
        $this->loadModel('User');
        $this->loadModel('Address');
        $this->loadModel('Contact');
        $this->loadModel('Configuration');
        $this->loadModel('Emergency');

        $this->layout = 'inscricao';
        $isPost = $this->request->is('post');
        if ($isPost && !(empty($this->request->data))) {

            if ($this->request->data['User']['data_nascimento'] == NULL)
                $this->set('errodata','deu erro mané'); // Usado para validação de data de nascimento, por algum motivo o Model não deu conta

            #$this->User->data_nascimento = $this->request->data['User']['niverano'].'-'.$this->request->data['User']['nivermes'].'-'.$this->request->data['User']['niverdia']; //Atribui o valor que vai salvar na data de aniversario
            #$dataniver = $this->request->data['User']['niverano'].'-'.$this->request->data['User']['nivermes'].'-'.$this->request->data['User']['niverdia'];
            $dataniver = $this->request->data['User']['data_nascimento'];

            // Encripta senha
            $esenha = $this->request->data['User']['pass'];
            $encrysenha = md5($esenha.'Ch4V&L0c@');
            $crysenha = md5($encrysenha);

            $esenha2 = $this->request->data['User']['confirmapass'];
            $encrysenha2 = md5($esenha2.'Ch4V&L0c@');
            $crysenha2 = md5($encrysenha2);

            $this->request->data['User']['pass'] = $crysenha;
            $this->request->data['User']['confirmapass'] = $crysenha2;

            //Faz checagem do número de vagas
            $config = $this->Configuration->find('first', array( 'conditions' => array( 'configuration_id' => 1)));
            if ($this->request->data['User']['cargo'] == 'Trainee')
                $vagas = $config['Configuration']['vagas_trainee'];
            else
                $vagas = $config['Configuration']['vagas_veterano'];
            
            $vagasocupadas = $this->User->find('count', array( 'conditions' => array( 'cargo' => $this->request->data['User']['cargo'])));

            //Avalia idade do usuario
            if ($this->request->data['User']['data_nascimento'] != NULL) 
            {
                $dataniver2 = date_create($dataniver);
                $datahoje = date_create(date('Y-m-d'));
                $dataniver = $datahoje->diff($dataniver2);
                $diferenca = $dataniver->y;
                if ($diferenca >= 18)
                    $this->request->data['User']['maioridade'] = 1;
            }

            //Calcula se já acabou data de inscrições
            $today = strtotime(date('Y-m-d h:m:s'));
            $fiminsc = strtotime($config['Configuration']['fim_inscricoes']);
            $inicioinsc = strtotime($config['Configuration']['inicio_inscricoes']);

            // Se tiver vaga, o usuário já entra como confirmado
            if ($vagas - $vagasocupadas > 0) {
                $this->request->data['User']['presenca'] = 1;
            } else {
                $this->request->data['User']['presenca'] = 0;
            }

                if ( ($fiminsc > $today) && ($today > $inicioinsc) ) {
                    if (1) { //if ( ( $vagas - $vagasocupadas) > 0) { //Nardz falou que todos vao conseguir se cadastrar a inicio, puis um if(1) porque ia dar trampo achar qual o } correspondente.
                        if ($this->User->save($this->request->data)) {
                            $id = $this->User->id;
                            $this->Address->set(array(
                                'user_id' => $id,
                                'rua' => $this->request->data['User']['rua'],
                                'numero' => $this->request->data['User']['numero'],
                                'bairro' => $this->request->data['User']['bairro'],
                                'cep' => $this->request->data['User']['cep'],
                                'complemento' => $this->request->data['User']['complemento'],
                                'cidade' => $this->request->data['User']['cidade'],
                                'uf' => $this->request->data['User']['uf']
                            ));
                            $this->Address->save();

                            $dddtelefonecelular = explode(') ',$this->request->data['User']['telefonecelular']);
                            $dddtelefonecelular2 = str_replace('(','',$dddtelefonecelular[0]);
                            $telefonecelular = str_replace('-','',$dddtelefonecelular[1]);

                            $dddtelfixo = explode(') ',$this->request->data['User']['telefonefixo']);
                            $dddtelfixo2 = str_replace('(','',$dddtelfixo[0]);
                            $telefonefixo = str_replace('-','',$dddtelfixo[1]);

                            $emerdddtel = explode(') ',$this->request->data['User']['emertelefone']);
                            $emerdddtel2 = str_replace('(','',$emerdddtel[0]);
                            $emertelefone = str_replace('-','',$emerdddtel[1]);

                            $this->Emergency->create();
                            $this->Emergency->set(array(
                                'ddd' => $emerdddtel2,
                                'telefone' => $emertelefone,
                                'nome_contato' => $this->request->data['User']['emernome'],
                                'user_id' => $id
                                ));
                            $this->Emergency->save();

                            $this->Contact->create();
                            $this->Contact->set(array(
                                'ddd' => $dddtelefonecelular2,
                                'telefone' => $telefonecelular,
                                'tipo' => 'Celular',
                                'user_id' => $id
                                ));
                            $this->Contact->save();

                            $this->Contact->create();
                            $this->Contact->set(array(
                                'ddd' => $dddtelfixo2,
                                'telefone' => $telefonefixo,
                                'tipo' => 'Fixo',
                                'user_id' => $id
                                ));
                            $this->Contact->save();

                            if ($this->validaUsuario($this->request->data['User']['cpf'], $esenha) == true) {
                                if ($this->Session->read('usuarioCargo') == 'USER')
                                    $this->redirect(array('controller' => 'users', 'action' => 'index')); //Redireciona para Home se login for válido
                            }
                        } else { $this->Session->setFlash('Erro ao tentar salvar usuário.','msg-erro'); } // nao conseguiu salvar   
                    } else {
                    $this->Session->setFlash('Todas vagas já foram ocupadas.','msg-erro'); //Redireciona para Home e envia mensagem de erro
                    $this->redirect(array('controller' => 'logins', 'action' => 'add')); //Redireciona para Home se login for válido
                    } // nao tem vaga
            } else {
                if ( ($fiminsc < $today) ) {
                    $this->Session->setFlash('Inscrições já foram encerradas.','msg-erro'); //Redireciona para Home e envia mensagem de erro
                    $this->redirect(array('controller' => 'logins', 'action' => 'add')); //Redireciona para Home se login for válido
                } else if ( ($today < $inicioinsc) ) {
                    $this->Session->setFlash('Inscrições não estão abertas.','msg-erro'); //Redireciona para Home e envia mensagem de erro
                    $this->redirect(array('controller' => 'logins', 'action' => 'add')); //Redireciona para Home se login for válido                
                }
            }// Data de inscricao ja termino
        } //nao e post
    }

}
    
?>