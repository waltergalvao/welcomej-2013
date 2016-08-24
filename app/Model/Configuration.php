<?php 
class Configuration extends AppModel {
	public $useTable = 'configurations';
	public $primaryKey = 'configuration_id';

	public $validate = array(
		'fim_inscricoes' => array(
			array(
				'rule' => 'checaData',
				'message' => 'Insira uma data válida'
			)
		),
		'inicio_inscricoes' => array(
			array(
				'rule' => 'checaData',
				'message' => 'Insira uma data válida'
			)
		),
		'fim_geral' => array(
				array(
				'rule' => 'checaData',
				'message' => 'Insira uma data válida'
			)
		),
		'valor_inscricao' => array(
			array(
				'rule' => 'notEmpty',
				'message' => 'Campo deve ser preenchido'
			),
        array(      
            'rule' => 'numeric',
            'message' => 'Somente valores númericos são aceitos.'
        ),
	        array(      
	            'rule' => array('maxLength', 45),
	            'message' => 'Máximo de 45 caractéres.'
	        )
		)
	);

    public function checaData($data) {
        $date = array_shift($data);

        // Compara os valores dos emails
        list($yy,$mm,$dd)=explode("-",$date);
        $dd = substr($dd,0,2); // Ultima parte da data esta com horário também, então pegamos apenas os 2 primeiros digitos, que é o dia.

        if (is_numeric($yy) && is_numeric($mm) && is_numeric($dd)) 
        { 
            return checkdate($mm,$dd,$yy); 
        } 
        return false;        
    }
 } ?>