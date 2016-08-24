<div style="margin-top:5px;background:#f7f7f7; padding:10px; border-radius:3px; font-size:14px;">
	<div class="barcontato">Configurações</div>

	<div style="padding:5px; background:rgba(0,0,0,0.02); margin-top:5px;">
		<?php echo $this->Form->create('Configuration', array('inputDefaults' => array( 'label' => false, ))); ?>
		Vagas Trainee
		<?php echo $this->Form->input('vagas_trainee') ?>
		<br>Vagas Veterano
		<?php echo $this->Form->input('vagas_veterano') ?>
		<br>Data de início das inscrições
		<?php echo $this->Form->input('inicio_inscricoes', array( 'dateFormat' => 'DMY', 'timeFormat' => '24')) ?>
		<br>Data final das inscrições, após essa essa data, usuários não conseguem mais confirmar/desconfirmar presença.
		<?php echo $this->Form->input('fim_inscricoes', array( 'dateFormat' => 'DMY', 'timeFormat' => '24')) ?>
		<br>Data final geral. Após essa data, usuários não poderão mais editar seus dados.
		<?php echo $this->Form->input('fim_geral', array( 'dateFormat' => 'DMY', 'timeFormat' => '24')) ?>
		<br>Valor da Inscrição
		<?php echo $this->Form->input('valor_inscricao', array( 'label' => 'R$')) ?>
		<br>Certificados liberados
		<?php echo $this->Form->input('certificado', array( 'options' => array( '0' => 'Não', '1' => 'Sim'))) ?>
		<br><button type="submit" class="greyishBtn button_small">Editar</button>
		<?php echo $this->Form->end(); ?>
	</div>
</div>