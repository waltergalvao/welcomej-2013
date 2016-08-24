<div style="margin-top:5xp;">
<div class="imgopacity"><?php echo $this->Html->link($this->Html->image('editardados.png'), array( 'controller' => 'companies', 'action' => 'edit'), array( 'escape' => false )); ?></div>
<?php echo $this->Html->link($this->Html->image('alterarsenha.png'), array( 'controller' => 'companies', 'action' => 'mudarsenha'), array( 'escape' => false )); ?>
</div>

<div style="margin-top:5px; background:#f7f7f7; padding:10px; border-radius:3px; width:98%; font-size:14px;">

<div class="barcontato">Alterar Senha</div>

<?php echo $this->Form->create('Company',array( 'action' => 'mudarsenha', 'inputDefaults' => array( 'div' => false, 'label' => false))) ?>

<div style="padding:5px;">
	Antiga senha:<br>
	<?php echo $this->Form->input('oldpass', array( 'style' => 'padding:5px;', 'type' => 'password')) ?>
</div><div style="padding:5px;">

	Nova senha:<br>
	<?php echo $this->Form->input('newpass', array( 'style' => 'padding:5px;', 'type' => 'password')) ?>
</div><div style="padding:5px;">
	Repetir nova senha<br>
	<?php echo $this->Form->input('newpassconfirm', array( 'style' => 'padding:5px;', 'placeholder' => 'Insira novamente sua nova senha', 'type' => 'password')); ?>
</div>
<button type="submit" class="greyishBtn button_small">Editar</button>
<?php echo $this->Form->end(); ?>
<br>
Ao mudar de senha, você será deslogado do sistema.