<?php 
class Contact extends AppModel {
	public $useTable = 'contacts';
	public $primaryKey = 'contact_id';
	public $belongsTo = array('User' => array( 'foreignKey' => 'user_id'));
    
    public $validate = array(
    	'ddd' => array(
	    	array(
		    	'rule' => 'NotEmpty',
		    	'message' => 'Campo deve ser preenchido'
		    	),
		   	array(
		   		'rule' => array('maxLength',2),
		   		'message' => 'DDD deve ter 2 algarismos.'
			),
			array(
				'rule' => array('minLength',2),
				'message' => 'DDD deve ter 2 algarismos'
			)
	    ),
    	'telefone' => array(
	    	array(
		    	'rule' => 'NotEmpty',
		    	'message' => 'Campo deve ser preenchido'
		    	),
			array(
				'rule' => array('minLength',8),
				'message' => 'Telefone deve ter pelo menos 8 algarismos'
			)
	    ),
    	'tipo' => array(
	    	array(
		    	'rule' => 'NotEmpty',
		    	'message' => 'Campo deve ser preenchido'
		    	)
	    )
	);
}
 ?>