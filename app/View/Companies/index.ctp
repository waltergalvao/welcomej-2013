<div class="indexbox" style=" display:inline-block; width:300px;">
	Fim das inscrições: <?php $fiminsc = date_create($config['Configuration']['fim_inscricoes']); echo date_format($fiminsc, 'd/m/Y H:i:s'); ?>
</div>
<div class="indexbox" style=" display:inline-block; width:340px; margin-left:5px;">
	Fechamento Geral do Sistema: <?php $fiminsc = date_create($config['Configuration']['fim_geral']); echo date_format($fiminsc, 'd/m/Y H:i:s'); ?>
</div>
<br>
<br>

<div class="indexbox">
	Trainees: <?php echo $t; ?><br>
	Membros: <?php echo $m; ?><br>
</div>
<br>
<div class="indexbox">
	Trainees confirmados: <?php echo $tcon; ?><br>
	Membros confirmados: <?php echo $mcon; ?><br>
</div>
<br>