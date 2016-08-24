<script>
jQuery(function($){
   $("#ContactTelefone").mask("99999999?9");
   $("#ContactDdd").mask("99");
});
</script>
<div style="margin-top:5xp;">
  
<?php echo $this->element('menu-useredit') ?>
</div> 
<div style="margin-top:130px; margin-left:9px; background:#f7f7f7; padding:10px; border-radius:3px; width:98%; font-size:14px;">
  <?php echo $this->Form->create('Contact',
    array(
    'inputDefaults' => array(
        'label' => false,
        'div' => false
              )))?>
<div style="margin-top:10px;">
    <table class="telefones" style="width:200px;">
      <tr style="text-align:left;">
        <th>DDD</th>
        <th>Telefone</th>
        <th>Tipo</th>
      </tr>
      <tr>
        <td><?php echo $this->Form->input('ddd', array( 'type' => 'text', 'style' => 'padding:5px; width:21px;')); ?></td>
        <td><?php echo $this->Form->input('telefone', array( 'type' => 'text', 'style' => 'padding:5px; width:100px;')); ?></td>
        <td><?php echo $this->Form->input('tipo',array( 'options' => array( 'Fixo' => 'Fixo', 'Celular' => 'Celular') , 'style' => 'padding:5px;')); ?></td>
        <td><button type="submit" class="greyishBtn button_small">Editar</button></td>
      </tr>
        <?php echo $this->Form->end(); ?>
    </table>
</div>
</div>
</div>