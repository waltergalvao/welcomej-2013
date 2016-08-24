<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>WelcoMEJ - Sistema de Inscrições</title>
		<?php echo $this->Html->css('css'); ?>
		<link rel="shortcut icon" type="image/x-icon" href="./images/favicon.ico">
<?php 
echo $this->Html->css('reset'); 
echo $this->Html->css('main'); 
echo $this->Html->css('typography'); 
echo $this->Html->css('jquery.ui.all'); 
echo $this->Html->css('bootstrap'); 
echo $this->Html->css('highlight'); ?>
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
	</head>
	<body>
<?php echo $this->fetch('content'); ?>
	</body>
</html>