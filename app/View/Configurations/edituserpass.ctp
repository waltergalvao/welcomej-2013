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
			<div style="margin-left:2px;">Senha do Usuário:</div><?php echo $this->Form->input('User.newpass', array( 'style' => 'padding:5px;', 'type' => 'password')); ?>
</div>
<div style="margin-top:10px;">
			<div style="margin-left:2px;">Digite novamente:</div><?php echo $this->Form->input('User.newpassconfirm', array( 'style' => 'padding:5px;', 'type' => 'password')); ?>
</div>
			<div style="margin-top:5px;"><button class="greyishBtn button_small">Editar</button></div>

	<?php echo $this->Form->end(); ?>