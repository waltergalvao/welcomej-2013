<script>
jQuery(function($){
   $("#EmergencyTelefone").mask("99999999?9");
   $("#EmergencyDdd").mask("99");
});
</script>
<div style="margin-top:5xp;">
  
<?php echo $this->element('menu-useredit') ?>
</div> 
<div style="margin-top:130px; margin-left:9px; background:#f7f7f7; padding:10px; border-radius:3px; width:98%; font-size:14px;">
  <?php echo $this->Form->create('Emergency',
    array(
    'inputDefaults' => array(
        'label' => false,
        'div' => false
              )))?>
<div style="margin-top:10px;">
    <table class="telefones" style="width:200px;">
      <tr style="text-align:left;">
        <th>Nome</th>
        <th>DDD</th>
        <th>Telefone</th>
      </tr>
      <tr>
        <td><?php echo $this->Form->input('nome_contato', array( 'type' => 'text', 'style' => 'padding:5px; width:200px;')); ?></td>
        <td><?php echo $this->Form->input('ddd', array( 'type' => 'text', 'style' => 'padding:5px; width:21px;')); ?></td>
        <td><?php echo $this->Form->input('telefone', array( 'type' => 'text', 'style' => 'padding:5px; width:100px;')); ?></td>
        <td><button type="submit" class="greyishBtn button_small">Editar</button></td>
      </tr>
        <?php echo $this->Form->end(); ?>
    </table>
</div>
</div>
</div>