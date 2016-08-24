<div style="margin-top:5xp;">
<?php echo $this->element('menu-useredit') ?>

</div>

<div style="margin-top:130px; margin-left:9px; background:#f7f7f7; padding:10px; border-radius:3px; width:98%; font-size:14px;">

<div class="barcontato">Alterar Senha</div>

<?php echo $this->Form->create('User',array( 'action' => 'mudarsenha', 'inputDefaults' => array( 'div' => false, 'label' => false))) ?>

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