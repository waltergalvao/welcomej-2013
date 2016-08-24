<?php $idbox = 0; ?>

<?php echo $this->Form->create('Configuration', array( 'action' => 'usersbusca', 'inputDefaults' => array( 'div' => false, 'label' => false)));
	echo $this->Form->input('busca', array( 'style' => 'padding:5px; color:#8c8c8c;', 'placeHolder' => 'Pesquisar usuário'));
	echo $this->Form->input('tipo', array( 'options' => array( 'nome' => 'NOME','cpf' => 'CPF'), 'style' => 'padding:5px; color:#8c8c8c;')); ?>
	<button type="submit" class="whitishBtn button_small">Buscar</button>
	<?php echo $this->form->end(); ?>
<?php foreach ($inscrito as $type) { ?>
	<?php $idbox = $idbox + 1; ?>
	<div style="box-shadow:0px 0px 15px rgba(0,0,0,0.1), inset 0px 0px 25px rgba(0,0,0,0.01); padding:5px; background:#fff; font-size:15px; margin-top:5px;">
		<table width="100%" style="table-layout: fixed;">
			<tr align="center" class="inscritodata">
				<td align="left"><?php echo $type['User']['nome'] ?></td>
				<td><?php echo $type['User']['cpf'] ?></td>
				<td><?php echo $type['Company']['nome'] ?></td>
				<td><?php echo $type['User']['cargo'] ?></td>
				<td>
				<?php 
				if ($type['User']['presenca']) 
					echo "<div style=\"padding:5px; color:green;\">Presença Confirmada</div>";
				else
					echo "Não confirmado";
				?>
				</td>
				<td><?php echo " <a data-toggle=\"modal\" href=\"#myModal$idbox\" class=\"whitishBtn button_small\" href=\"#\">INFO</a>" ?></td>
				<td align="right">
					<?php if ($type['User']['presenca']) { ?>
			<?php echo $this->Form->postLink(
                '<button style="margin:5px; width:130px;" class="redishBtn button_small" href="#">Desconfirmar</button>',
                array('action' => 'desconfirmaruser', $type['User']['user_id']),
                array('confirm' => 'Deseja desconfirmar presença do usuário?', 'escape' => false));
			 ?>		 		 						
					<?php } else { ?>
			<?php echo $this->Form->postLink(
                '<button style="margin:5px; width:130px;" class="greenishBtn button_small" href="#">Confirmar</button>',
                array('action' => 'confirmaruser', $type['User']['user_id']),
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
                <?php echo "$('#tabs$idbox').tabs();"; ?>
                //hover states on the static widgets
                $('#dialog_link, ul#icons li').hover(
                    function() { $(this).addClass('ui-state-hover'); },
                    function() { $(this).removeClass('ui-state-hover'); }
                );
            });
        </script>

  <!--Basic Modal Start-->
  <?php echo "<div class=\"modal hide\" id=\"myModal$idbox\" >" ?>
    <div class="modal-header">
  <a class="close" data-dismiss="modal">×</a>
    <h3><?php echo $type['User']['nome'] ?></h3>
    </div>
    <div class="modal-body">
   
 <?php echo "<div id=\"tabs$idbox\" style=\"overflow:hidden;\""; ?>
 <div id="tabs" style="overflow:hidden;">
				<ul>
					<li><a href="#tabs-1">Informações Gerais</a></li>
					<li><a href="#tabs-2">Informações de Contato</a></li>
					<li><a href="#tabs-3">Endereço</a></li>
				</ul>
				<div id="tabs-1">
					<h3>Dados do usuário</h3>
					<div style="padding:5px 0 5px 0;">Nome: <?php echo $type['User']['nome'] ?></div>
					<div style="padding:5px 0 5px 0;">RG: <?php echo $type['User']['rg'] ?></div>
					<div style="padding:5px 0 5px 0;">CPF: <?php echo $type['User']['cpf'] ?></div>
					<div style="padding:5px 0 5px 0;">Data Nascimento: <?php $date = date_create($type['User']['data_nascimento']); echo date_format($date,'d/m/Y'); ?></div>
					<div style="padding:5px 0 5px 0;">Alimentação: <?php echo $type['User']['alimentacao'] ?></div>
					<div style="padding:5px 0 5px 0;">Deficiencia: <?php echo $type['User']['deficiencia'] ?></div>
					<div style="padding:5px 0 5px 0;">Cargo: <?php echo $type['User']['cargo'] ?></div>
					<div style="padding:5px 0 5px 0;">Email: <?php echo $type['User']['email'] ?></div>
					<div style="padding:5px 0 5px 0;">EJ: <?php echo $type['Company']['nome'] ?></div>
					<div style="padding:5px 0 5px 0;"><?php if ($type['User']['presenca']) { ?> <div class="greenishBtn" style="padding:5px; width:125px;">Presença Confirmada</div><?php } else { ?> <div class="redishBtn" style="padding:5px; width:155px;">Presença Não Confirmada</div><?php } ?></div>
				</div>
				<div id="tabs-2">
					<h3>Endereço Eletrônico</h3>
					<div style="padding:5px; font-size:14px; margin-top;5px;"><?php echo $type['User']['email'] ?></div>
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
						<div style="padding:5px 0 5px 0;">Cidade: <?php echo $type['Address']['cidade'] ?></div>
						<div style="padding:5px 0 5px 0;">UF: <?php echo $type['Address']['uf'] ?></div>
						<div style="padding:5px 0 5px 0;">Rua: <?php echo $type['Address']['rua'] ?></div>
						<div style="padding:5px 0 5px 0;">Bairro: <?php echo $type['Address']['bairro'] ?></div>
						<div style="padding:5px 0 5px 0;">Numero: <?php echo $type['Address']['numero'] ?></div>
						<div style="padding:5px 0 5px 0;">Cep: <?php echo $type['Address']['cep'] ?></div>
						<div style="padding:5px 0 5px 0;">Complemento: <?php echo $type['Address']['complemento'] ?></div>
				</div>
</div>
    </div>
    <div class="modal-footer">
    <a data-dismiss="modal" class="greyishBtn button_small" href="#">Fechar</a>
    <?php echo $this->Html->link('Editar Usuário', array( 'action' => 'edituser',$type['User']['user_id']), array( 'class' => 'greyishBtn button_small')) ?>
    </div>
    </div>
    <!--Basic Modal End-->
<?php  } ?>

<?php
echo $this->Paginator->numbers(array('class' => 'paginatorbutton', 'separator' => '')); ?>

