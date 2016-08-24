<script>
jQuery(function($){
	$("#UserCpf").mask("99999999999");
   $("#UserTelefonefixo").mask("(99) 9999-9999?9");
   $("#UserTelefonecelular").mask("(99) 9999-9999?9");
   $("#UserCep").mask("99999999");
   $("#UserEmertelefone").mask("(99) 9999-9999?9");
});
</script>

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

<div style="width: 560px; margin-top:90px; margin-left:auto; margin-right:auto; overflow:none;"><?php echo $this->Session->flash(); ?></div>
  <div class="modal2" id="myModal" style="max-height:1000px !important;" >
    <div class="modal-header">
    	<h3 style="margin-left:5px;">Formulário de Inscrição</h3>
    </div>
    
    <div class="modal-body" >
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
					<div class="popuptip">Utilize somente números, sem pontuação.</div>
					CPF:<br><?php echo $this->Form->input('User.cpf'); ?>
				</div>
			</div>
			<div style="clear:both">
				<div class="forminput">
					Data de Nascimento:<br>
					<input type="date" name="data[User][data_nascimento]" id="UserDataNascimento" style="width:149px;" max="1997-12-31" min="1910-12-31">
					<?php if (isset($errodata)) { echo "<font style=\"color: red\"><br>Data inválida</font>"; 	} ?>
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
					<div class="popuptip" style="margin-left:190px;">Não altere caso não possua.</div>
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
				<div class="popuptip" style="width:110px;">Confirme seu email</div>
					<br><?php echo $this->Form->input('User.confirmaemail', array( 'placeholder' => 'Redigite seu email')); ?>
				</div>
			</div>

			<div style="clear:both">
				<div class="forminput">
					Senha de Acesso:<br><?php echo $this->Form->input('User.pass', array( 'type' => 'password', 'autocomplete' => 'off', 'value' => '')); ?>
				</div>
				<div class="forminput">
				<div class="popuptip" style="margin-left:363px;">Confirme sua senha</div>
					<br><?php echo $this->Form->input('User.confirmapass', array( 'placeholder' => 'Redigite sua senha', 'type' => 'password', 'autocomplete' => false, 'value' => '')); ?>
				</div>
			</div>
			<div style="clear:both">
			</div>
			<br>
    </div>

    <div class="modal-footer">
    <button type="submit" class="greenishBtn button_small" style="margin-left:10px;">Inscrever-se</button>
    </div>
	   </div>
    <!--Basic Modal End-->