<script>
jQuery(function($){
   $("#ContactDdd").mask("99");
   $("#ContactTelefone").mask("99999999?9");
});
</script>

<div style="margin-top:5xp;">
<?php echo $this->element('menu-useredit') ?>

</div> 
<div style="margin-top:130px; margin-left:9px; background:#f7f7f7; padding:10px; border-radius:3px; width:98%; font-size:14px;">
<div class="barcontato">Contatos <div style="float:right; margin-right:12px; margin-top:-3px;"><a style="margin:5px;" data-toggle="modal" href="#myModal" class="whitishBtn button_small" href="#">Adcionar</a></div></div>
<div style="margin-top:10px;">
      <?php foreach ($contatos as $type) { ?>
      <div class="telefonebox">
      <table class="telefones">
          <tr>
            <td width="130px"><?php echo '('.$type['Contact']['ddd'].') '.$type['Contact']['telefone']; ?></td>
            <td width="50px"><?php echo $type['Contact']['tipo'] ?></td>
            <td width="100px"><?php echo $this->Html->link('<button type="button" class="greyishBtn button_small">Editar</button>', array('action' => 'ContatoEdit', $type['Contact']['contact_id']), array( 'escape' => false )); ?></td>
          </tr>
        </table>
      </div>
      <?php } ?>

</div>
</div>
</div>

  <!--Basic Modal Start-->
  <div class="modal hide" id="myModal" >
    <div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h3>Adcionar contato</h3>
    </div>
    <div class="modal-body">
  <?php echo $this->Form->create('User',
    array(
    'action' => 'ContatoAdd', 
    'inputDefaults' => array(
        'label' => false,
        'div' => false
              )))?>
            <?php echo $this->Form->hidden('Contact.user_id', array( 'value' => $this->Session->read('usuarioID'))) ?>
            <p>DDD<br>
            <?php echo $this->Form->input('Contact.ddd', array('type' => 'text')); ?></p>
            <p>Telefone<br>
            <?php echo $this->Form->input('Contact.telefone', array('type' => 'text')); ?></p>
            <p>Tipo<br>
            <?php echo $this->Form->input('Contact.tipo', array('options' => array('Fixo' => 'Fixo', 'Celular' => 'Celular'))); ?></p>
    </div>
    <div class="modal-footer">
    <a data-dismiss="modal" class="greyishBtn button_small" href="#">Fechar</a>
    <button type="submit" class="bluishBtn button_small">Salvar</button>
    <?php echo $this->Form->end(); ?>
    </div>
    </div>
    <!--Basic Modal End-->
