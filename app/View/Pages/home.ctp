 <script>
jQuery(function($){
	$("#UserCpf").mask("99999999999");
   $("#UserTelefonefixo").mask("(99) 9999-9999?9");
   $("#UserTelefonecelular").mask("(99) 9999-9999?9");
   $("#UserEmertelefone").mask("(99) 9999-9999?9");
   $("#UserCep").mask("99999999");
});
</script>

<?php echo $this->Html->link('<div class="botaoej"><div class="animated tada">EJCOMP</div></div>', array( 'controller' => 'pages', 'action' => 'ejcomp'), array( 'escape' => false)) ?>
<div class="quadrocentralizado">

<div class="messageerro"><?php echo $this->Session->flash(); ?></div>
		<div class="naoinscrito" id="animate">

   			<a href="logins/add">
   			<a data-toggle="modal" href="#myModal" href="#">
   			<div class="quadroincrevase">
   				<div class="barinscrevase">Inscreva-se</div>
   			</div>
   			</a>
   			</a>
   		</div>

   		<div class="inscrito">
   			<div class="quadrologin">
				<?php echo $this->Form->create('Login',
				array(
				'action' => 'login', 
				'inputDefaults' => array(
            	'label' => false,
            	'div' => false
             	)))?>
				<span>CPF:</span><br>
				<?php echo $this->Form->input('Login.cpf') ?><br><br>
				<span>Senha:</span><br>
				<?php echo $this->Form->input('Login.pass',array('type' => 'password')) ?>
				<div style="margin-top:27px;">
					<div class="passreset"><a data-toggle="modal" href="#myModal2" href="#">Esqueci minha senha</a></div>
					<button type="submit" class="botao">Login</button>	
				<?php echo $this->form->end(); ?>
				</div>
   			</div>
		</div>

<?php 
	  $data1 = date_create($config['Configuration']['inicio_inscricoes']);
	  $data1show = date_format($data1, 'd/m/Y');
	  $data1calc = strtotime($config['Configuration']['inicio_inscricoes']);

	  $data2 = date_create($config['Configuration']['fim_inscricoes']);
	  $data2show = date_format($data2, 'd/m/Y');
	  $data2calc = strtotime($config['Configuration']['fim_inscricoes']);

	  $data3 = date_create($config['Configuration']['fim_geral']);
	  $data3show = date_format($data3, 'd/m/Y');
	  $data3calc = strtotime($config['Configuration']['fim_geral']);

	  $hoje = strtotime("now");
					?>
		<div class="datas">
			<?php 
			if ($hoje > $data1calc && $hoje < $data2calc) 
				echo "<div class=\"data1\" style=\"margin:0; opacity:1.0\">";
			else
				echo "<div class=\"data1\" style=\"margin:0;\">";
				?>
				<h1><?php echo $data1show;?></h1>
				Início das Inscrições
			</div>
			<?php 
			if ($hoje > $data2calc && $hoje	< $data3calc) 
				echo "<div class=\"data1\" style=\"margin:0; opacity:1.0\">";
			else
				echo "<div class=\"data1\" style=\"margin:0;\">";
				?>
				<h1><?php echo $data2show ?></h1>
				Fim das Inscrições
			</div>
			<?php 
			if ($hoje > $data3calc) 
				echo "<div class=\"data1\" style=\"margin:0; opacity:1.0\">";
			else
				echo "<div class=\"data1\" style=\"margin:0;\">";
				?>
				<h1><?php echo $data3show ?></h1>
				Fechamento Geral
			</div>
		</div>
		<div class="numinscritos">Vagas Trainee: <?php echo $vagastrainee ?> | Vagas Membros: <?php echo $vagasmembro ?></div>
</div>
<script type="text/javascript">
	// Função única que fará a transação
	function getEndereco() {
			// Se o campo CEP não estiver vazio
			if($.trim($("#UserCep").val()) != ""){
				/* 
					Para conectar no serviço e executar o json, precisamos usar a função
					getScript do jQuery, o getScript e o dataType:"jsonp" conseguem fazer o cross-domain, os outros
					dataTypes não possibilitam esta interação entre domínios diferentes
					Estou chamando a url do serviço passando o parâmetro "formato=javascript" e o CEP digitado no formulário
					http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+$("#cep").val()
				*/
				$.getScript("http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+$("#UserCep").val(), function(){
					// o getScript dá um eval no script, então é só ler!
					//Se o resultado for igual a 1
			  		if(resultadoCEP["resultado"]){
						// troca o valor dos elementos
						if (resultadoCEP["logradouro"] != "")
							$("#UserRua").val(unescape(resultadoCEP["tipo_logradouro"])+" "+unescape(resultadoCEP["logradouro"]));
						if (resultadoCEP["bairro"] != "")
							$("#UserBairro").val(unescape(resultadoCEP["bairro"]));
						if (resultadoCEP["cidade"] != "")
							$("#UserCidade").val(unescape(resultadoCEP["cidade"]));
						//$("#estado").val(unescape(resultadoCEP["uf"]));
					}else{
						alert("Endereço não encontrado");
					}
				});				
			}			
	}
</script>

  <div class="modal3 hide" id="myModal" style="max-height:1000px !important; z-index:2000;" >
    <div class="modal-header">
    	<h3 style="margin-left:5px;">Formulário de Inscrição</h3>
    </div>
    
    <div class="modal-body">
		 	<?php echo $this->Form->create('Login',
				array(
				'action' => 'add', 
				'inputDefaults' => array(
		        'label' => false,
		        'div' => false
		             	)))?>
			<div style="clear:both">
				<div class="forminput" style="margin-top:0;">
					Nome Completo:<br><?php echo $this->Form->input('User.nome'); ?>
				</div>
				<div class="forminput" style="margin-top:0;">
					RG:<br><?php echo $this->Form->input('User.rg'); ?> 
				</div>
				<div class="forminput" id="inputform" style="margin-top:0;">
					CPF:<br><?php echo $this->Form->input('User.cpf'); ?>
				</div>
			</div>
			<div style="clear:both">

				<div class="forminput">
					Data de Nascimento:<br>
					<input type="date" name="data[User][data_nascimento]" id="UserDataNascimento" style="width:149px;" max="1996-12-31" min="1910-12-31" value="">
				</div>

				<div class="forminput">
					Telefone Fixo<br><?php echo $this->Form->input('User.telefonefixo'); ?>
				</div>
				<div class="forminput">
					Telefone Celular<br><?php echo $this->Form->input('User.telefonecelular'); ?>
				</div>
			</div>

			<div style="clear:both">
				<div class="forminput">
					Nome Contato de Emergência<br><?php echo $this->Form->input('User.emernome'); ?>
				</div>
				
				<div class="forminput">
					Telefone Contato de Emer.<br><?php echo $this->Form->input('User.emertelefone'); ?>
				</div>
				<div class="forminput">
					<span style="font-size:9px !important;">Portador de Necessidades Especiais</span>:<br><?php echo $this->Form->input('User.deficiencia', array( 'options' => array('Não' => 'Não', 'Sim' => 'Sim'), 'class' => 'selectgrande')) ?>
				</div>		
			</div>

			<div style="clear:both">
				<div class="forminput">
					CEP <a href="http://www.buscacep.correios.com.br/" target="blank">(procure seu CEP)</a>
					<br><?php echo $this->Form->input('User.cep',array('onBlur' => 'getEndereco()')); ?>
				</div>
				<div class="forminput">
					Cidade<br><?php echo $this->Form->input('User.cidade'); ?>
				</div>
				<div class="forminput">
					Rua<br><?php echo $this->Form->input('User.rua'); ?>
				</div>
			</div>
			<div style="clear:both">
				<div class="forminput">
					Bairro<br><?php echo $this->Form->input('User.bairro'); ?>
				</div>
				
				<div class="forminput">
					Numero<br><?php echo $this->Form->input('User.numero'); ?>
				</div>
			
				<div class="forminput">
					Complemento<br><?php echo $this->Form->input('User.complemento', array( 'novalidate'=>true)); ?>
				</div>
			</div>

			<div style="clear:both">
				<div class="forminput">
					Estado:<br><?php echo $this->Form->input('User.uf', array( 'default' => 'SP','options' => array( 'AC' => 'AC', 'AL' => 'AL', 'AP' => 'AP', 'AM' => 'AM', 'BA' => 'BA', 'CE' => 'CE', 'DF' => 'DF', 'ES' => 'ES', 'GO' => 'GO', 'MA' => 'MA', 'MT' => 'MT', 'MS' => 'MS', 'MG' => 'MG', 'PA' => 'PA', 'PB' => 'PB', 'PR' => 'PR', 'PE' => 'PE', 'PI' => 'PI', 'RJ' => 'RJ', 'RN' => 'RN', 'RS' => 'RS', 'RO' => 'RO', 'RR' => 'RR', 'SC' => 'SC', 'SP' => 'SP', 'SE' => 'SE', 'TO' => 'TO'), 'class' => 'selectgrande')); ?>
				</div>
			<div class="forminput">
					EJ:<br><?php echo $this->Form->input('User.company_id', array( 'class' => 'selectgrande')); ?>
				</div>
			</div>
				<div class="forminput">
					Cargo na EJ:<br><?php echo $this->Form->input('User.cargo', array( 'options' => array( 'Trainee' => 'Trainee', 'Membro' => 'Membro'), 'default' => 'Trainee', 'class' => 'selectgrande')); ?>
				</div>
			<div style="clear:both">
				<div class="forminput">
					Alimentação:<br><?php echo $this->Form->input('User.alimentacao', array( 'options' => array( 'Vegetariano' => 'Vegetariano', 'Vegano' => 'Vegano', 'Comum' => 'Comum'), 'default' => 'Comum', 'class' => 'selectgrande')); ?>
				</div>
			<div class="forminput">
					Email:<br><?php echo $this->Form->input('User.email'); ?>
				</div>
				<div class="forminput">
					<br><?php echo $this->Form->input('User.confirmaemail', array( 'placeholder' => 'Redigite seu email')); ?>
				</div>
			</div>

			<div style="clear:both">
				<div class="forminput">
					Senha de Acesso:<br><?php echo $this->Form->input('User.pass', array( 'type' => 'password', 'autocomplete' => 'off')); ?>
				</div>
				<div class="forminput">
					<br><?php echo $this->Form->input('User.confirmapass', array( 'placeholder' => 'Redigite sua senha', 'type' => 'password', 'autocomplete' => 'off')); ?>
				</div>
			</div>
			<div style="clear:both">
			</div>
			<br>
    </div>

    <div class="modal-footer">
    <button type="submit" class="greenishBtn button_small" style="margin-left:10px">Inscrever-se</button>
    <?php echo $this->Form->end(); ?>
    </div>
   </div>
    <!--Basic Modal End-->

<div class="modal hide" id="myModal2" style="max-height:1000px !important;" >
    <div class="modal-header">
    	<h3 style="margin-left:5px;">Recuperar senha</h3>
    </div>
    
    <div class="modal-body" >
		<div class="forminput" style="float:none; margin:0px;">
		<?php echo $this->Form->create('Login', array( 'action' => 'recuperaSenha', 'inputDefaults' => array( 'div' => false, 'label' => false))) ?>
			CPF
			<div class="popuptip" style="margin-left:180px; margin-top:-10px;">Não utilize pontuação. Um email será enviado para o endereço do associado.</div>
				<br><?php echo $this->Form->input('cpf', array( 'style' => 'padding:5px;', 'id' => 'recovercpf')); ?>
		</div>
    </div>

    <div class="modal-footer">
    <button type="submit" class="greenishBtn button_small">Recuperar</button>
    <?php echo $this->Form->end(); ?>
    </div>
</div>