<?php $idbox = 0; $usercon = 0;?>

<?php echo $this->Form->create('Company', array( 'action' => 'buscainscrito', 'inputDefaults' => array( 'div' => false, 'label' => false)));
	echo $this->Form->input('busca', array( 'style' => 'padding:5px; color:#8c8c8c;', 'placeHolder' => 'Pesquisar usuário'));
	echo $this->Form->input('tipo', array( 'options' => array( 'nome' => 'NOME','cpf' => 'CPF'), 'style' => 'padding:5px; color:#8c8c8c;')); ?>
	<button type="submit" class="whitishBtn button_small">Buscar</button>
	<?php echo $this->form->end(); ?>
<?php foreach ($inscrito as $type) { ?>
	<?php $idbox = $idbox + 1; ?>
	<div class="datalargebox">
		<table width="100%" style="table-layout: fixed;">
			<tr align="center" class="inscritodata">
				<td align="left"><?php echo $type['User']['nome'] ?></td>
				<td><?php echo $type['User']['cpf'] ?></td>
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
                '<button style="margin:5px;" class="redishBtn button_small" href="#">Desconfirmar</button>',
                array('action' => 'desconfirmaruser', $type['User']['user_id']),
                array('confirm' => 'Deseja desconfirmar presença do usuário?', 'escape' => false));
                $usercon = $usercon + 1;
			 ?>		 		 						
					<?php } else { ?>
			<?php echo $this->Form->postLink(
                '<button style="margin:5px;" class="greenishBtn button_small" href="#">Confirmar</button>',
                array('action' => 'confirmaruser', $type['User']['user_id']),
                array('confirm' => 'Deseja confirmar presença do usuário?', 'escape' => false));
                $usercon = $usercon + 1;
			 ?>		 	
					<?php } ?>
				</td>
			</tr>
		</table>
	</div>


  <!--Basic Modal Start-->
  <?php echo "<div class=\"modal hide\" id=\"myModal$idbox\" >" ?>
    <div class="modal-header">
  <a class="close" data-dismiss="modal">×</a>
    <h3><?php echo $type['User']['nome'] ?></h3>
    </div>
    <div class="modal-body">
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
    <div class="modal-footer">
    <a data-dismiss="modal" class="greyishBtn button_small" href="#">Fechar</a>
    </div>
    </div>
    <!--Basic Modal End-->
<?php  } ?>
<br>
Número total de usuários: <?php echo $idbox; ?><br>
Preço por membro: R$<?php echo $config['Configuration']['valor_inscricao']; ?><br>
Preço a pagar por <?php echo $usercon ?>x usuário(s) confirmado(s): <?php $preco = $confirmados * $config['Configuration']['valor_inscricao']; echo "R$:$preco"; ?>