<?php
		$datafim = date_create($config['Configuration']['fim_inscricoes']);
		$datahoje = date_create(date('Y-m-d h:m:s'));
		$diferencadata = date_diff($datafim,$datahoje);
		$diferenca = $diferencadata->format('%R%a');

	if ($info['User']['presenca'] == 0) {
	?>

	<div class="msgbar msg_Alert hide_onC"><span class="iconsweet">!
		</span><p>
			<?php 
			if ($diferenca <= 0) {
				echo "Você tem até ". date_format($datafim, 'd/m/Y - H\h i\m')." para confirmar a sua participação no evento!"; 
			}
			else { 
				echo "Confirmações encerradas. Seu Status: Não confirmado";
			}
			?>
		</p>
	</div> 
	<?php } ?>
<div style="margin-top:5xp;">
	<?php if ($info['User']['maioridade'] == '0') { ?>
	<div class="imgopacity"><?php echo $this->Html->link($this->Html->image('enviarautorizacao.png'), array( 'controller' => 'Users', 'action' => 'comprovante'), array( 'escape' => false )); ?></div>
	<?php } ?>

	<?php 
	if ($diferenca <= 0 ) {
		if ($info['User']['presenca'] == 0) { ?>
			<div class="imgopacity"><?php echo $this->Html->link($this->Html->image('confirmarinscricao.png'), array( 'controller' => 'Users', 'action' => 'confirmarpresenca'), array( 'escape' => false )); ?></div>

		<?php } else { ?>
			<div class="imgopacity"><?php echo $this->Html->link($this->Html->image('desconfirmarinscricao.png'), array( 'controller' => 'Users', 'action' => 'desconfirmarpresenca'), array( 'escape' => false )); ?></div>
		<?php } ?>
	<?php } ?>
	<?php if ($config['Configuration']['certificado'] == 1 && $info['User']['presenca'] == 1)  {?>	
			<div class="imgopacity"><?php echo $this->Html->link($this->Html->image('certificado.png'), array( 'controller' => 'Users', 'action' => 'precertificado'), array( 'escape' => false )); ?></div>
	<?php } ?>	
</div> 
<div style="margin-top:140px;">
</div>
</div>