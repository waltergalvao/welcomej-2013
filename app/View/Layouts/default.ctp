<!DOCTYPE html>
<html>
<head>
<!-- 
    Projeto gerenciado por Gabriel Spadon
    Sistema elaborado por Walter Barros Galvão Neto - w4lternet0@hotmail.com
        Facebook: www.facebook.com/wbgneto
        Skype: wbgneto
    EJCOMP Presidente Prudente - http://www2.fct.unesp.br/empresajr/ejcomp/
-->
<style>
.error-message { color:red; } 
</style>
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
<title>Welcomej - Sistema de inscrição</title>
<link rel="shortcut icon" type="image/x-icon" href="./images/favicon.ico">
<!--Stylesheets-->
<?php 
echo $this->Html->css('reset'); 
echo $this->Html->css('main'); 
echo $this->Html->css('typography'); 
echo $this->Html->css('jquery.ui.all'); 
echo $this->Html->css('bootstrap'); 
echo $this->Html->css('highlight'); 
echo $this->Html->css('jquery.ui.theme.css');
echo $this->Html->css('jquery.ui.tabs.css');
echo $this->Html->css('jquery.ui.slider.css');
echo $this->Html->css('jquery.ui.progressbar.css');
echo $this->Html->css('jquery.ui.datepicker.css');
echo $this->Html->css('jquery.ui.core.css');
echo $this->Html->css('fullcalendar.css');?>
<!--[if lt IE 9]>
    <script src="js/html5.js"></script>
    <![endif]-->
<!--Javascript-->
<?php 
echo $this->html->script('jquery.min.js');
echo $this->html->script('bootstrap-modal.js');
echo $this->html->script('jquery.maskedinput.js');

//Tabs
echo $this->Html->css('jquery-ui-1.8.21.custom.css');

echo $this->Html->script('jquery-ui-1.8.21.custom.min');
?>
<meta charset="UTF-8"></head>
<body>
<?php if (!($this->Session->read('usuarioID')) == '' ) { ?>
<!--Header-->
<header>
    <!--Logo-->
    <div id="logo"><a href="#"><?php echo $this->Html->image('logo.png'); ?></a></div>
</header>
<!--Dreamworks Container-->
<div id="dreamworks_container">
    <!--Primary Navigation-->
    <nav id="primary_nav">
        <ul>
        	<?php if ($this->Session->read('usuarioCargo') == 'USER') {?>
            	<li class="nav_dashboard active"><a href="#">Usuário</a></li>
            <?php } ?>
            
            <?php if ($this->Session->read('usuarioCargo') == 'COMPANY') {?>
            	<li class="nav_forms"><a href="#">EJ</a></li>
            <?php } ?>
            
            <?php if ($this->Session->read('usuarioCargo') == 'ADMIN') {?>
            	<li class="nav_pages"><a href="#">Administrativo</a></li>
            <?php } ?>
        </ul>
    </nav>
<!--Main Content-->
<section id="main_content">

<!--Secondary Navigation-->
<nav id="secondary_nav"> 
<!--UserInfo-->
<dl class="user_info">
	<dt><a href="#"><?php echo $this->Html->image('avatar.png'); ?></a></dt>
    <dd>
        <a class="welcome_user" href="#">Seja bem vindo, <strong><?php $nome = explode(' ',$dadosuser[$modeluser]['nome']); echo $nome[0]; ?></strong></a>
        <span class="log_data"><?php echo $dadosuser[$modeluser]['email'] ?></span>
        <?php echo $this->Html->link('Logout',array('controller' => 'Logins', 'action' => 'logout'), array( 'class' => 'logout')) ?>

    </dd>
</dl>
<h2>Navegação</h2>
<?php echo $this->element('menu', array( 'menu' => $modelatual)) ?>
<!--Content Wrap-->
<div id="content_wrap">
<?php echo $this->Session->flash(); ?>
<?php echo $this->fetch('content'); ?>
    </div>
</div>
</section>
</div>

</body>
<?php } else {?>
        <div id="dreamworks_container">
          <div class="error_pages error_full_page"> <span class="iconsweet">!</span>
            <h1>Sem autorização</h1>
            <p> Aparentemente você está acessando uma área restrita. <br />
              Não se preocupe, pode acontecer com qualquer um. </p>
              <?php echo $this->fetch('content');?>
            <?php echo $this->Html->link('Voltar', array( 'controller' => 'pages' , 'action' => 'index'), array( 'class' => 'redishBtn button_small', 'style' => 'margin:5px;')) ?></div>
        </div>
        <?php } ?>
</html>