<?php 
class Address extends AppModel {
	public $useTable = 'addresses';
	public $primaryKey = 'address_id';

	public $validate = array(
    'cep' => array(
            array( 'rule' => 'NotEmpty',
            'message' => 'Campo deve ser preenchido.'),
        array(
            'rule' => array('minLength', 8),
            'message' => 'CEP deve conter 8 números.'
        ),
        array(      
            'rule' => array('maxLength', 8),
            'message' => 'CEP deve conter 8 números.'
        ),
        array(      
            'rule' => 'numeric',
            'message' => 'Somente números são aceitos.'
        )
        ),
    'cidade' => array(
            array( 'rule' => 'NotEmpty',
            'message' => 'Campo deve ser preenchido.'),

            array( 'rule' => '/[a-zA-Z]+/',
            'message' => 'Somente letras são aceitas'),

            array(      
                'rule' => array('maxLength', 45),
                'message' => 'Máximo de 45 caractéres.'
            )
            ), 
    'uf' => array(
            array( 'rule' => 'NotEmpty',
            'message' => 'Campo deve ser preenchido.'),
            array( 'rule' => '/[a-zA-Z]+/',
            'message' => 'Somente letras são aceitas')
            ),        
    'rua' => array(
            array( 'rule' => 'NotEmpty',
            'message' => 'Campo deve ser preenchido.'),

            array(      
                'rule' => array('maxLength', 45),
                'message' => 'Máximo de 45 caractéres.'
            )
        ),
    'numero' => array(
            array( 'rule' => 'NotEmpty',
            'message' => 'Campo deve ser preenchido.'),
            array(      
                'rule' => array('maxLength', 15),
                'message' => 'Máximo de 15 caractéres.'
            )
        ),
    'bairro' => array(
            array( 'rule' => 'NotEmpty',
            'message' => 'Campo deve ser preenchido.'),
            array(      
                'rule' => array('maxLength', 45),
                'message' => 'Máximo de 45 caractéres.'
            )
        ),
    'complemento' => array(
            array(      
                'rule' => array('maxLength', 45),
                'message' => 'Máximo de 45 caractéres.'
            )
        )
    );
}
 ?>