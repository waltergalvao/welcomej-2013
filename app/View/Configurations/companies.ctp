<?php $idbox = 0; $idbox2 = 0; $presente = 0;?>

<?php echo $this->Form->create('Configuration', array( 'action' => 'companiesbusca', 'inputDefaults' => array( 'div' => false, 'label' => false)));
	echo $this->Form->input('busca', array( 'style' => 'padding:5px; color:#8c8c8c;', 'placeHolder' => 'Pesquisar EJ'));
	echo $this->Form->input('tipo', array( 'options' => array( 'nome' => 'NOME'), 'style' => 'padding:5px; color:#8c8c8c;')); ?>
	<button type="submit" class="whitishBtn button_small">Buscar</button>
	<?php echo $this->form->end(); ?>

<?php foreach ($company as $info) { ?>
	<?php $idbox = $idbox + 1;   $presente = 0;?>

<script type="text/javascript">
$(document).ready(function() {  

	<?php echo "$(\"#boxej2$idbox\").click(function() {" ?>
	    <?php echo "$(\"#boxuser$idbox\").slideToggle();" ?>
	});

});  
</script>

	
	<?php echo "<div style=\"padding:10px; background:#565656; margin-top:5px;\" id=\"boxej$idbox\">" ?>
	<?php echo "<div style=\"padding:10px; background:rgba(0,0,0,0.3); \" id=\"boxej2$idbox\">" ?><font color="#fff"><h1><?php echo $info['Company']['nome']; ?></h1></font>
	<?php echo " <a data-toggle=\"modal\" href=\"#myModalC$idbox\" class=\"whitishBtn button_small\" href=\"#\" style=\"float:right; margin-top:-28px;\" onclick=\"return false;\">INFO</a>" ?>
	</div>
	<?php 
		echo "<div id=\"boxuser$idbox\" style=\"display:none;\">";
		;?>	
	<?php foreach ($info['User'] as $type) { ?>
	<?php $idbox2 = $idbox2 + 1;?>
	


		<div class="datalargebox">
			<table width="100%" style="table-layout: fixed;">
				<tr align="center" class="inscritodata">
					<td align="left"><?php echo $type['nome'] ?></td>
					<td><?php echo $type['cpf'] ?></td>
					<td><?php echo $type['cargo'] ?></td>
					<td>
					<?php 
					if ($type['presenca']) 
						echo "<div style=\"padding:5px; color:green;\">Presença Confirmada</div>";
					else
						echo "Não confirmado";
					?>
					</td>
					<td><?php echo " <a data-toggle=\"modal\" href=\"#myModal$idbox2\" class=\"whitishBtn button_small\" href=\"#\">INFO</a>" ?></td>
					<td align="right">
						<?php if ($type['presenca']) { ?>
				<?php echo $this->Form->postLink(
	                '<button style="margin:5px; width:130px;" class="redishBtn button_small" href="#">Desconfirmar</button>',
	                array('action' => 'desconfirmaruser2', $type['user_id']),
	                array('confirm' => 'Deseja desconfirmar presença do usuário?', 'escape' => false));
				 ?>		 		 						
						<?php } else { ?>
				<?php echo $this->Form->postLink(
	                '<button style="margin:5px; width:130px;" class="greenishBtn button_small" href="#">Confirmar</button>',
	                array('action' => 'confirmaruser2', $type['user_id']),
	                array('confirm' => 'Deseja confirmar presença do usuário?', 'escape' => false));
				 ?>		 
						<?php } ?>
					</td>
				</tr>
			</table>
		</div>


	<script type="text/javascript">
	            $(function(){
	                // Tabs
	                <?php echo "$('#tabs$idbox2').tabs();"; ?>
	                //hover states on the static widgets
	                $('#dialog_link, ul#icons li').hover(
	                    function() { $(this).addClass('ui-state-hover'); },
	                    function() { $(this).removeClass('ui-state-hover'); }
	                );
	            });
	        </script>

	  <!--Basic Modal Start-->
	  <?php echo "<div class=\"modal hide\" id=\"myModal$idbox2\" >" ?>
	    <div class="modal-header">
	  <a class="close" data-dismiss="modal">×</a>
	    <h3><?php echo $type['nome'] ?></h3>
	    </div>
	    <div class="modal-body">
	   
	 <?php echo "<div id=\"tabs$idbox2\" style=\"overflow:hidden;\""; ?>
	 <div id="tabs" style="overflow:hidden;">
					<ul>
						<li><a href="#tabs-1">Informações Gerais</a></li>
						<li><a href="#tabs-2">Informações de Contato</a></li>
						<li><a href="#tabs-3">Endereço</a></li>
					</ul>
					<div id="tabs-1">
						<h3>Dados do usuário</h3>
						<div style="padding:5px 0 5px 0;">Nome: <?php echo $type['nome'] ?></div>
						<div style="padding:5px 0 5px 0;">RG: <?php echo $type['rg'] ?></div>
						<div style="padding:5px 0 5px 0;">CPF: <?php echo $type['cpf'] ?></div>
						<div style="padding:5px 0 5px 0;">Data Nascimento: <?php $date = date_create($type['data_nascimento']); echo date_format($date,'d/m/Y'); ?></div>
						<div style="padding:5px 0 5px 0;">Alimentação: <?php echo $type['alimentacao'] ?></div>
						<div style="padding:5px 0 5px 0;">Deficiencia: <?php echo $type['deficiencia'] ?></div>
						<div style="padding:5px 0 5px 0;">Cargo: <?php echo $type['cargo'] ?></div>
						<div style="padding:5px 0 5px 0;">Email: <?php echo $type['email'] ?></div>
						<div style="padding:5px 0 5px 0;">EJ: <?php echo $info['Company']['nome'] ?></div>
						<div style="padding:5px 0 5px 0;"><?php if ($type['presenca']) { ?> <div class="greenishBtn" style="padding:5px; width:125px;">Presença Confirmada</div><?php $presente = $presente + 1;} else { ?> <div class="redishBtn" style="padding:5px; width:155px;">Presença Não Confirmada</div><?php } ?></div>
					</div>
					<div id="tabs-2">
						<h3>Endereço Eletrônico</h3>
						<div style="padding:5px; font-size:14px; margin-top;5px;"><?php echo $type['email'] ?></div>
						<br>
						<h3>Contatos</h3>
						<?php 
						if ($type['Contact'] != NULL) {
						foreach ($type['Contact'] as $contact) { ?>
							<div style="padding:5px; font-size:14px; margin-top;5px;"><?php echo '('.$contact['ddd'].') '.$contact['telefone'].' - '.$contact['tipo']; ?></div>
						<?php } } else { echo "Nenhum contato encontrado"; } ?> 
				   		<br><br>
						<h3>Contatos de Emergência</h3>
						<?php 
						if ($type['Emergency'] != NULL) {
						foreach ($type['Emergency'] as $contactemer) { ?>
							<div style="padding:5px; font-size:14px; margin-top;5px;"><?php echo $contactemer['nome_contato'] ?>: <?php echo '('.$contactemer['ddd'].') '.$contactemer['telefone'] ?></div>
						<?php } } else { echo "Nenhum contato de emergência encontrado"; } ?>
					</div>
					<div id="tabs-3">
						<h3>Localização do usuário</h3>
						<?php if ($type['Address'] != NULL) { ?>
							<div style="padding:5px 0 5px 0;">Cidade: <?php echo $type['Address']['cidade'] ?></div>
							<div style="padding:5px 0 5px 0;">UF: <?php echo $type['Address']['uf'] ?></div>
							<div style="padding:5px 0 5px 0;">Rua: <?php echo $type['Address']['rua'] ?></div>
							<div style="padding:5px 0 5px 0;">Bairro: <?php echo $type['Address']['bairro'] ?></div>
							<div style="padding:5px 0 5px 0;">Numero: <?php echo $type['Address']['numero'] ?></div>
							<div style="padding:5px 0 5px 0;">Cep: <?php echo $type['Address']['cep'] ?></div>
							<div style="padding:5px 0 5px 0;">Complemento: <?php echo $type['Address']['complemento'] ?></div>
						<?php } else { echo "Nenhum dado encontrado"; } ?>
					</div>
	</div>
	    </div>
	    <div class="modal-footer">
	    <a data-dismiss="modal" class="greyishBtn button_small" href="#">Fechar</a>
	    <?php echo $this->Html->link('Editar Usuário', array( 'action' => 'edituser',$type['user_id']), array( 'class' => 'greyishBtn button_small')) ?>
	    </div>
	    </div>
	    <!--Basic Modal End-->
	
	<?php  } ?>
		<p style="color:white; margin-top:5px;">Usuários: <?php echo count($info['User']);?> - Confirmados: <?php echo $presente; ?></p>
	    </div></div> <!-- fim do container -->


	  <!--Basic Modal Start-->
	  	<?php echo "<div class=\"modal hide\" id=\"myModalC$idbox\" >" ?>
	    	<div class="modal-header">
	  			<a class="close" data-dismiss="modal">×</a>
	    		<h3><?php echo $info['Company']['nome'] ?></h3>
	    	</div>
	    
	    	<div class="modal-body">
	   		<?php echo $this->Form->create('Configuration', array( 'inputDefaults' => array( 'label' => false, 'div' => true), 'action' => 'editcompany')) ?>
		   	
		   	<?php echo $this->Form->hidden('Company.company_id', array( 'value' => $info['Company']['company_id'])) ?>
		   	<div style="padding:5px;">
		   		Nome:
		   		<?php echo $this->Form->input('Company.nome', array( 'value' => $info['Company']['nome'], 'style' => 'padding:5px;')) ?>
		   	</div>
		   	<div style="padding:5px;">
		   		CNPJ:
		   		<?php echo $this->Form->input('Company.cnpj', array( 'value' => $info['Company']['cnpj'], 'style' => 'padding:5px;')) ?>
		   	</div>
		   <div style="padding:5px;">
		   		Campus:
		   		<?php echo $this->Form->input('Company.campus', array( 'value' => $info['Company']['campus'], 'style' => 'padding:5px;')) ?>
		   	</div>
		   <div style="padding:5px;">
		   		Cidade:
		   		<?php echo $this->Form->input('Company.cidade', array( 'value' => $info['Company']['cidade'], 'style' => 'padding:5px;')) ?>
		   	</div>
		   	<div style="padding:5px;">
		   		Filiação:
		   		<?php echo $this->Form->input('Company.status_filiacao', array( 'value' => $info['Company']['status_filiacao'], 'style' => 'padding:5px;')) ?>
		   	</div>
		   	<div style="padding:5px;">
		   		Email:
		   		<?php echo $this->Form->input('Company.email', array( 'value' => $info['Company']['email'], 'style' => 'padding:5px;')) ?>
		   	</div>	
			</div>
	    	
	    	<div class="modal-footer">
	    		<a data-dismiss="modal" class="greyishBtn button_small" href="#">Fechar</a>
	    		<button type="submit" class="greenishBtn button_small">Editar</a>
	    	</div>
	    	<?php echo $this->Form->end(); ?>
	    </div>
	    <!--Basic Modal End-->
		<?php } ?>
<div style="padding:5px;"><?php echo $this->Paginator->numbers(array('class' => 'paginatorbutton', 'separator' => '')); ?></div>