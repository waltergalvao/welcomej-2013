<script type="text/javascript">
  // Função única que fará a transação
  function getEndereco() {
      // Se o campo CEP não estiver vazio
      if($.trim($("#AddressCep").val()) != ""){
        /* 
          Para conectar no serviço e executar o json, precisamos usar a função
          getScript do jQuery, o getScript e o dataType:"jsonp" conseguem fazer o cross-domain, os outros
          dataTypes não possibilitam esta interação entre domínios diferentes
          Estou chamando a url do serviço passando o parâmetro "formato=javascript" e o CEP digitado no formulário
          http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+$("#cep").val()
        */
        $.getScript("http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+$("#AddressCep").val(), function(){
          // o getScript dá um eval no script, então é só ler!
          //Se o resultado for igual a 1
            if(resultadoCEP["resultado"]){
            // troca o valor dos elementos
            $("#AddressRua").val(unescape(resultadoCEP["tipo_logradouro"])+" "+unescape(resultadoCEP["logradouro"]));
            $("#AddressBairro").val(unescape(resultadoCEP["bairro"]));
            $("#AddressCidade").val(unescape(resultadoCEP["cidade"]));
            //$("#estado").val(unescape(resultadoCEP["uf"]));
          }else{
            alert("Endereço não encontrado");
          }
        });       
      }     
  }
</script>

<script>
jQuery(function($){
   $("#AddressCep").mask("99999999");
});
</script>
<div style="margin-top:5xp;">
  
  <?php echo $this->element('menu-useredit') ?>
</div> 
<div style="margin-top:130px; margin-left:9px; background:#f7f7f7; padding:10px; border-radius:3px; width:98%; font-size:14px;">
  <?php echo $this->Form->create('Address',
    array(
    'inputDefaults' => array(
        'label' => false,
        'div' => false
              )))?>
<div style="margin-top:10px;">
      <div style="margin-left:2px;">Rua:</div><?php echo $this->Form->input('Address.rua', array( 'style' => 'padding:5px;')); ?></div>
<div style="margin-top:10px;">
      <div style="margin-left:2px;">Número:</div><?php echo $this->Form->input('Address.numero', array( 'style' => 'padding:5px;')); ?> </div>
<div style="margin-top:10px;">  
      <div style="margin-left:2px;">Bairro:</div><?php echo $this->Form->input('Address.bairro', array( 'style' => 'padding:5px;')); ?></div>
<div style="margin-top:10px;">
      <div style="margin-left:2px;">CEP:</div><?php echo $this->Form->input('Address.cep', array( 'style' => 'padding:5px;')); ?></div>
<div style="margin-top:10px;">
      <div style="margin-left:2px;">Complemento:</div><?php echo $this->Form->input('Address.complemento', array( 'style' => 'padding:5px;')); ?>
</div>
<div style="margin-top:10px;">
      <div style="margin-left:2px;">Cidade:</div><?php echo $this->Form->input('Address.cidade', array( 'style' => 'padding:5px;')); ?>
</div>
<div style="margin-top:10px;">
      <div style="margin-left:2px;">Estado:</div><?php echo $this->Form->input('Address.uf',array( 'default' => 'SP', 'options' => array( 'AC' => 'AC', 'AL' => 'AL', 'AP' => 'AP', 'AM' => 'AM', 'BA' => 'BA', 'CE' => 'CE', 'DF' => 'DF', 'ES' => 'ES', 'GO' => 'GO', 'MA' => 'MA', 'MT' => 'MT', 'MS' => 'MS', 'MG' => 'MG', 'PA' => 'PA', 'PB' => 'PB', 'PR' => 'PR', 'PE' => 'PE', 'PI' => 'PI', 'RJ' => 'RJ', 'RN' => 'RN', 'RS' => 'RS', 'RO' => 'RO', 'RR' => 'RR', 'SC' => 'SC', 'SP' => 'SP', 'SE' => 'SE', 'TO' => 'TO'), 'style' => 'padding:5px;')); ?>
</div>
      <div style="margin-top:5px;"><button class="greyishBtn button_small">Editar</button></div>

  <?php echo $this->Form->end(); ?>
</div>
</div>