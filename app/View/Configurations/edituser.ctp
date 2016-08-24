<div class="imgopacity"><?php echo $this->Html->link($this->Html->image('editardados.png'), array( 'controller' => 'configurations', 'action' => 'edituser',$userid), array( 'escape' => false )); ?></div>
<div class="imgopacity"><?php echo $this->Html->link($this->Html->image('alterarsenha.png'), array( 'controller' => 'configurations', 'action' => 'edituserpass',$userid), array( 'escape' => false )); ?>
</div>
<div style="background:#f7f7f7; margin-top:120px; padding:10px; border-radius:3px; width:99%; font-size:14px;">
	<?php echo $this->Form->create('User',
		array(
		'inputDefaults' => array(
        'label' => false,
        'div' => false
             	)))?>
<div style="margin-top:10px;">
			<div style="margin-left:2px;">Nome Completo:</div><?php echo $this->Form->input('User.nome', array( 'style' => 'padding:5px;')); ?></div>
<div style="margin-top:10px;">
			<div style="margin-left:2px;">RG:</div><?php echo $this->Form->input('User.rg', array( 'style' => 'padding:5px;')); ?> </div>
<div style="margin-top:10px;">
			<div style="margin-left:2px;">CPF:</div><?php echo $this->Form->input('User.cpf', array( 'style' => 'padding:5px;')); ?> </div>
<div style="margin-top:10px;">	
			<div style="margin-left:2px;">Email:</div><?php echo $this->Form->input('User.email', array( 'style' => 'padding:5px;')); ?> </div>
<div style="margin-top:10px;">	
			<div style="margin-left:2px;">Alimentação:</div><?php echo $this->Form->input('User.alimentacao', array( 'style' => 'padding:5px;','options' => array( 'Vegetariano' => 'Vegetariano', 'Vegano' => 'Vegano', 'Comum' => 'Comum'), 'default' => 'Comum', 'class' => 'selectgrande')); ?></div>
<div style="margin-top:10px;">
			<div style="margin-left:2px;">Portador de Necessidades Especiais:</div><?php echo $this->Form->input('User.deficiencia', array( 'style' => 'padding:5px;','options' => array('Não' => 'Não', 'Sim' => 'Sim'), 'class' => 'selectgrande')) ?></div>
<div style="margin-top:10px;">
			<div style="margin-left:2px;">EJ:</div><?php echo $this->Form->input('User.company_id', array( 'style' => 'padding:5px;')); ?></div>
<div style="margin-top:10px;">
			<div style="margin-left:2px;">Cargo na EJ:</div><?php echo $this->Form->input('User.cargo', array( 'style' => 'padding:5px;','options' => array( 'Trainee' => 'Trainee', 'Membro' => 'Membro'), 'default' => 'Trainee', 'class' => 'selectgrande')); ?>
</div>
			<div style="margin-top:5px;"><button class="greyishBtn button_small">Editar</button></div>

	<?php echo $this->Form->end(); ?>
</div>