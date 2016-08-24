<?php 
class Company extends AppModel {
	public $useTable = 'companies';
	public $primaryKey = 'company_id';
	public $hasMany = array('User');
}
 ?>