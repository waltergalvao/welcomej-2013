<?php if ($menu == 'Users' || $menu =='Configurations') {?>
	<ul>
	<?php if ($this->Session->read('usuarioCargo') == 'USER') { ?>
		<li><?php echo $this->Html->link('<span class="iconsweet">G</span>Principal',array( 'controller' => 'users', 'action' => 'index'), array( 'escape' => false )); ?></li>
		  <li><?php echo $this->Html->link('<span class="iconsweet">a</span>Configurações Pessoais',array( 'controller' => 'users', 'action' => 'edit'), array( 'escape' => false )); ?></li>
		    <li><span class="iconsweet"></span></li>
		</ul>
		</nav>
	<?php } else if ($this->Session->read('usuarioCargo') == 'ADMIN') { ?>
		<li><?php echo $this->Html->link('<span class="iconsweet">1</span>Principal',array( 'controller' => 'configurations', 'action' => 'index'), array( 'escape' => false )); ?></li>
		<li><?php echo $this->Html->link('<span class="iconsweet">p</span>Inscritos',array( 'controller' => 'configurations', 'action' => 'users'), array( 'escape' => false )); ?></li>
		<li><?php echo $this->Html->link('<span class="iconsweet">c</span>EJ\'s',array( 'controller' => 'configurations', 'action' => 'companies'), array( 'escape' => false )); ?></li>
		<li><?php echo $this->Html->link('<span class="iconsweet">C</span>Comprovantes',array( 'controller' => 'configurations', 'action' => 'tickets'), array( 'escape' => false )); ?></li>
		  <li><?php echo $this->Html->link('<span class="iconsweet">i</span>Configurações',array( 'controller' => 'configurations', 'action' => 'edit'), array( 'escape' => false )); ?></li>
		    <li><span class="iconsweet"></span></li>
		    </ul>
		    </nav>
	<?php } ?>
<?php } else if ($menu == 'Companies') { ?>
<ul>
	<li><?php echo $this->Html->link('<span class="iconsweet">1</span>Principal',array( 'controller' => 'companies', 'action' => 'index'), array( 'escape' => false )); ?></li>
  <li><?php echo $this->Html->link('<span class="iconsweet">j</span>Configurações EJ',array( 'controller' => 'companies', 'action' => 'edit'), array( 'escape' => false )); ?></li>
  <li><?php echo $this->Html->link('<span class="iconsweet">c</span>Inscritos',array( 'controller' => 'companies', 'action' => 'inscritos'), array( 'escape' => false )); ?></li>
  <li><?php echo $this->Html->link('<span class="iconsweet">(</span>Gerar Pagamento',array( 'controller' => 'companies', 'action' => 'payment'), array( 'escape' => false )); ?></li>
  <li><?php echo $this->Html->link('<span class="iconsweet">C</span>Enviar Comprovante',array( 'controller' => 'companies', 'action' => 'comprovante'), array( 'escape' => false )); ?></li>
    <li><span class="iconsweet"></span></li>
</ul>
</nav>
<?php } ?>