<div style="margin-top:5px; background:#f7f7f7; padding:10px; border-radius:3px; font-size:14px;">
	<?php if ($info == NULL) { ?>
	<a href="termodownload">
		<div style="padding:10px; background:#fff; width:380px;">
		<div style="float:left;"><?php echo $this->Html->image('pdfsmall.gif') ?></div>
		<div style="margin-left:35px; line-height:25px;">Baixar modelo de termo</div>
	</div>
</a>
	<div class="barcontato" style="width:390px; margin-top:10px;">Termo de Ciência</div>

	<div style="width:400px; background:rgba(0,0,0,0.05); margin-top:5px;">
		<?php echo $this->Form->create('Userticket', array('type' => 'file', 'inputDefaults' => array( 'label' => false))); ?>
		<?php echo $this->Form->input('Userticket.photo_dir', array('type' => 'hidden')); ?>
		<table width="350px" >
			<tr>
				<td><?php echo $this->Form->input('Userticket.photo', array('type' => 'file', 'style' => '-webkit-box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);	box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);')); ?></td>
				<td><button type="submit" class="greyishBtn button_small">Enviar</button></td>
			</tr>
		</table>
		<p style="color:#969696">Extensões aceitas: .jpg/.png/.pdf (Tamanho Máximo: 1024KB)</p>
	</div>
	<?php } else { 
		$extensao = substr(strrchr($info['Userticket']['photo'],'.'),1);
		if ($extensao != 'pdf') { ?>
		<?php echo $this->Html->image("/app/webroot/files/userticket/photo/".$info['Userticket']['userticket_id']."/".$info['Userticket']['photo']); ?>
		<?php } else { ?>
		<?php echo "<a href=\"../app/webroot/files/userticket/photo/".$info['Userticket']['userticket_id']."/".$info['Userticket']['photo']."\">"; ?>
		<?php echo $this->Html->image('pdf.png') ?>
		</a>
		<?php } ?>
			<div style="margin-top:5px; height:60px;">
			<div class="uploadinfo" style="width:240px; margin-left:0px; ">Data de Envio:
					<?php
					$date = date_create($info['Userticket']['created']);
					echo date_format($date, 'd/m/Y H:i:s'); ?>
			 </div>
			<div class="uploadinfo" style="width:140px;">
				Status: 
				<?php 
				if ( $info['Userticket']['valida'] == 0)
					$status = "Aguardando";
				else if ( $info['Userticket']['valida'] == 1)
					$status = "Aprovado";
				else
					$status = "Rejeitado";
				?>
				<?php echo $status ?>
			</div>
			
			<?php if ( $info['Userticket']['valida'] != 1) {		
			echo $this->Form->postLink(
                '<div class="uploadinfo" style="width:60px; color:red;"><span class="iconsweet" style="font-size:12px;">X</span> Excluir</div>',
                array('action' => 'comprovantedelete', $info['Userticket']['userticket_id']),
                array('confirm' => 'Deseja excluir o termo?', 'escape' => false));
			 } ?>
		</div>
			<?php 
			if ( $info['Userticket']['valida'] == 2) 
				echo "Seu comprovante foi rejeitado. Exclua o comprovante e faça um novo upload";
			?>
	<?php } ?>
</div>