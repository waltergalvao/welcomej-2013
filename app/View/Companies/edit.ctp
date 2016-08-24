<div style="margin-top:5xp;">
<div class="imgopacity"><?php echo $this->Html->link($this->Html->image('editardados.png'), array( 'controller' => 'companies', 'action' => 'edit'), array( 'escape' => false )); ?></div>
<?php echo $this->Html->link($this->Html->image('alterarsenha.png'), array( 'controller' => 'companies', 'action' => 'mudarsenha'), array( 'escape' => false )); ?>

</div>
<script>
jQuery(function($){
   $("#CompanyCnpj").mask("99.999.999/9999-99");
});
</script>


<div style="margin-top:5px; background:#f7f7f7; padding:10px; border-radius:3px; width:98%; font-size:14px;">
	<?php echo $this->Form->create('Company',
		array(
		'inputDefaults' => array(
        'label' => false,
        'div' => false
             	))); ?>
<div style="margin-top:10px;">
			<div style="margin-left:2px;">Nome:</div><?php echo $this->Form->input('Company.nome', array( 'style' => 'padding:5px;')); ?></div>
<div style="margin-top:10px;">
			<div style="margin-left:2px;">CNPJ:</div><?php echo $this->Form->input('Company.cnpj', array( 'type' => 'text','style' => 'padding:5px;')); ?></div>
<div style="margin-top:10px;">	
			<div style="margin-left:2px;">Campus:</div><?php echo $this->Form->input('Company.campus', array( 'style' => 'padding:5px;')); ?></div>
<div style="margin-top:10px;">
			<div style="margin-left:2px;">Cidade:</div><?php echo $this->Form->input('Company.cidade', array( 'style' => 'padding:5px;')); ?></div>
<div style="margin-top:10px;">
			<div style="margin-left:2px;">Filiada a NEJUNESP:</div><?php echo $this->Form->input('Company.status_filicao', array( 'style' => 'padding:5px;', 'options' => array( 'NÃO' => 'NÃO', 'SIM' => 'SIM'))); ?></div>
<div style="margin-top:10px;">
			<div style="margin-left:2px;">Email:</div><?php echo $this->Form->input('Company.email', array( 'style' => 'padding:5px;')); ?>
</div>

			<div style="margin-top:5px;"><button class="greyishBtn button_small">Editar</button></div>

	<?php echo $this->Form->end(); ?>
</div>
</div>