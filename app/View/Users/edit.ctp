<script>
jQuery(function($){
   $("#UserRg").mask("99999999*");
});
</script>
<div style="margin-top:5xp;">
	
  <?php echo $this->element('menu-useredit') ?>
</div> 
<div style="margin-top:130px; margin-left:9px; background:#f7f7f7; padding:10px; border-radius:3px; width:98%; font-size:14px;">
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
</div>