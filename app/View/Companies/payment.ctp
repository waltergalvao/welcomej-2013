<div style="margin-top:5px; padding:10px; display:inline-block; box-shadow:0px 0px 15px rgba(0,0,0,0.1), inset 0px 0px 15px rgba(0,0,0,0.05);  background:#fff; font-size:15px;">
<?php foreach ($bancos as $type) { ?>
<?php echo $type['Bank']['banco'] ?><br>
Titular: <?php echo $type['Bank']['titular']; ?><br>
Agência: <?php echo $type['Bank']['agencia'] ?> - <?php echo $type['Bank']['tipo'] ?>: <?php echo $type['Bank']['conta'] ?>
<?php } ?>
</div>
<br><br>
Preço por usuário: R$<?php echo $config['Configuration']['valor_inscricao']; ?><br>
Número de usuários confirmados: <?php echo $confirmados; ?><br>
Preço a pagar pelos usuários confirmados: <?php $preco = $confirmados * $config['Configuration']['valor_inscricao']; echo "R$:$preco"; ?>
