<div class="indexbox">
	Vagas Restantes Trainee: <?php $tleft = $config['Configuration']['vagas_trainee'] - $traineecon; echo $tleft; ?><br>
	Vagas Restantes Membro: <?php $mleft = $config['Configuration']['vagas_veterano'] - $veteranoscon; echo $mleft; ?><br>
</div>
<br>
<div class="indexbox">
	Usuários inscritos: <?php echo $usuarios ?><br>
	Veteranos inscritos: <?php echo $veteranos ?><br>
	Trainees inscritos: <?php echo $trainee ?>
</div>
<br>
<div class="indexbox">
	Usuários confirmados: <?php echo $usuarioscon ?><br>
	Veteranos confirmados: <?php echo $veteranoscon ?><br>
	Trainees confirmados: <?php echo $traineecon ?>
</div>
<br>
<div class="indexbox">
	EJs inscritas: <?php echo $ejs ?><br>
	EJs que já pagaram: <?php echo $ejspagos; ?>
</div>
<br>