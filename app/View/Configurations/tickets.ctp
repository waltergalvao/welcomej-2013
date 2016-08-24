<h1 style="display:block; padding:5px;">Termos de Ciência</h1>
<?php $idb = 0; $idb2 = 0;?>
	<?php foreach ($tickets as $type) { 
		$idb = $idb + 1; ?>
<div style="margin-top:5px;background:#f7f7f7; padding:10px; border-radius:3px; font-size:14px;">
	<table style="border-collapse:separate; border-spacing:10px;">
		<tr>
			<td><?php $extensao = substr(strrchr($type['Userticket']['photo'],'.'),1);
            echo "<a data-toggle=\"modal\" href=\"#myModal$idb\">"; 
            if ($extensao != 'pdf') {
                echo $this->Html->image("/app/webroot/files/userticket/photo/".$type['Userticket']['userticket_id']."/thumb_".$type['Userticket']['photo'], array( 'style' => 'box-shadow: 0 0 20px 0 rgba(0,0,0,0.3);'));
            }
            else {
                echo "<a target=\"blank\" href=\"../app/webroot/files/userticket/photo/".$type['Userticket']['userticket_id']."/".$type['Userticket']['photo']."\">"; 
                echo $this->Html->image('pdf.png');
                echo "</a>";
            }
            ?>
            </a>

            </td>
			<td><?php echo $type['User']['nome'] ?></td>
			<td><?php $date = date_create($type['Userticket']['created']);
				echo date_format($date, 'd/m/Y H:i:s'); ?>
			<td><?php echo "<button class=\"blackishBtn button_small\" data-toggle=\"modal\" href=\"#myModal$idb\">Info</button>"?></td>
		</tr>
    <tr>
    <td> <!--Basic Modal Start-->
            <?php echo "<div class=\"modal4 hide\" id=\"myModal$idb\" >" ?>
             <div class="modal-header">
            <a class="close" data-dismiss="modal">×</a>
            <h3>Avaliar termo</h3>
            </div>
            <div class="modal-body">
            <?php if ($extensao != 'pdf') {
                echo $this->Html->image("/app/webroot/files/userticket/photo/".$type['Userticket']['userticket_id']."/thumb_".$type['Userticket']['photo'], array( 'style' => 'box-shadow: 0 0 20px 0 rgba(0,0,0,0.3);'));
            }
            else {
                echo "<a target=\"blank\" href=\"../app/webroot/files/userticket/photo/".$type['Userticket']['userticket_id']."/".$type['Userticket']['photo']."\">"; 
                echo $this->Html->image('pdf.png');
                echo "</a>";
            } ?>
            </div>
            <div class="modal-footer">
            <?php echo $this->Form->create('Configuration', array( 'action' => 'aprovaTicket', 'inputDefaults' => array( 'div' => false))) ?>
            <?php echo $this->Form->hidden('userticket_id', array( 'value' => $type['Userticket']['userticket_id'])) ?>
            <?php echo $this->Form->hidden('acao', array( 'value' => '1')) ?>
            <button type="submit" style="float:left; margin-left:5px;" class="greenishBtn button_small">Aprovar</button>
            <?php echo $this->Form->end(); ?>


            <?php echo $this->Form->create('Configuration', array( 'action' => 'aprovaTicket', 'inputDefaults' => array( 'div' => false))) ?>
            <?php echo $this->Form->hidden('userticket_id', array( 'value' => $type['Userticket']['userticket_id'])) ?>
            <?php echo $this->Form->hidden('acao', array( 'value' => '0')) ?>
            <button type="submit" style="float:left; margin-left:5px;" class="redishBtn button_small">Recusar</button>
            <?php echo $this->Form->end(); ?>
            </div>
            </div>
            <!--Basic Modal End-->
    </td>
    <td></td>
    <td></td>
    <td></td>
    </tr>
	</table>

</div>




	<?php } ?>



<h1 style="display:block; padding:5px;">Comprovantes de Pagamento</h1>
	<?php foreach ($paytickets as $type) { 
		$idb2 = $idb2 + 1; ?>
<div style="margin-top:5px;background:#f7f7f7; padding:10px; border-radius:3px; font-size:14px;">
	<table style="border-collapse:separate; border-spacing:10px;">
		<tr>
			<td><?php 
            $extensao = substr(strrchr($type['Ticket']['photo'],'.'),1);
            if ($extensao != 'pdf') {
               echo "<a data-toggle=\"modal\" href=\"#myModal2$idb2\">"; echo $this->Html->image("/app/webroot/files/ticket/photo/".$type['Ticket']['ticket_id']."/thumb_".$type['Ticket']['photo'], array( 'style' => 'box-shadow: 0 0 20px 0 rgba(0,0,0,0.3);')); ?></a> 
            <?php } else {
                echo "<a target=\"blank\" href=\"../app/webroot/files/ticket/photo/".$type['Ticket']['ticket_id']."/".$type['Ticket']['photo']."\">"; 
                echo $this->Html->image('pdf.png');
                echo "</a>";                
            } ?>
        </td>
			<td><?php echo $type['Company']['nome'] ?></td>
			<td><?php $date = date_create($type['Ticket']['created']);
				echo date_format($date, 'd/m/Y H:i:s'); ?>
			<td><?php echo "<button class=\"blackishBtn button_small\" data-toggle=\"modal\" href=\"#myModal2$idb2\">Info</button>"?></td>
		</tr>
    <tr>
    <td>
             <!--Basic Modal Start-->
              <?php echo "<div class=\"modal4 hide\" id=\"myModal2$idb2\" >" ?>
                 <div class="modal-header">
                <a class="close" data-dismiss="modal">×</a>
                <h3>Avaliar comprovante</h3>
                </div>
                <div class="modal-body">
                    <?php 
                    if ($extensao != 'pdf') {
                        echo $this->Html->image("/app/webroot/files/ticket/photo/".$type['Ticket']['ticket_id']."/".$type['Ticket']['photo'], array( 'style' => 'display:block; margin:0 auto;box-shadow: 0 0 20px 0 rgba(0,0,0,0.3);')); } else {
                        echo "<a target=\"blank\" href=\"../app/webroot/files/ticket/photo/".$type['Ticket']['ticket_id']."/".$type['Ticket']['photo']."\">"; 
                        echo $this->Html->image('pdf.png');
                        echo "</a>";                
                            } ?>
                </div>
                
                <div style="padding:5px; margin-left:10px;">Número de inscritos confirmados: <?php echo $type['Ticket']['usuarios'] ?></div>
                <div style="padding:5px; margin-left:10px;">Preço atual do convite: R$<?php echo number_format((float)$config['Configuration']['valor_inscricao'], 2, ',', ''); ?></div>
                <div style="padding:5px; margin-left:10px;">Valor a ser pago por EJ: R$<?php $valor = $type['Ticket']['usuarios'] * $config['Configuration']['valor_inscricao']; echo number_format((float)$valor, 2, ',', ''); ?></div>
                <div class="modal-footer">
                <?php echo $this->Form->create('Configuration', array( 'action' => 'aprovaPayTicket', 'inputDefaults' => array( 'div' => false))) ?>
                <?php echo $this->Form->hidden('ticket_id', array( 'value' => $type['Ticket']['ticket_id'])) ?>
                <?php echo $this->Form->hidden('acao', array( 'value' => '1')) ?>
                <button type="submit" style="float:left; margin-left:5px;" class="greenishBtn button_small">Aprovar</button>
                <?php echo $this->Form->end(); ?>


                <?php echo $this->Form->create('Configuration', array( 'action' => 'aprovaPayTicket', 'inputDefaults' => array( 'div' => false))) ?>
                <?php echo $this->Form->hidden('ticket_id', array( 'value' => $type['Ticket']['ticket_id'])) ?>
                <?php echo $this->Form->hidden('acao', array( 'value' => '0')) ?>
                <button type="submit" style="float:left; margin-left:5px;" class="redishBtn button_small">Recusar</button>
                <?php echo $this->Form->end(); ?>
                </div>
                </div>
    </td>
    <td></td>
    <td></td>
    <td></td>
    </tr>
	</table>

</div>
    <!--Basic Modal End-->

	<?php } ?>