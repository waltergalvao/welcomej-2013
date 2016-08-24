<?php 
class User extends AppModel {
	public $useTable = 'users';
	public $primaryKey = 'user_id';

	public $hasMany = array(
        'Emergency' => array(
            'foreignKey'   => 'user_id'
        ),
        'Contact' => array(
            'foreignKey'   => 'user_id'
        ) 
    );
    public $hasOne = array(
    	'Address' => array( 'foreignKey' => 'user_id')
	    );
    public $belongsTo = array('Company');
    public $recursive = 2;
public $validate = array(
    'nome' => array(
        array( 
            'rule' => 'NotEmpty',
            'message' => 'Campo deve ser preenchido' 
        ),
        array(
            'rule' => 'isUnique',
            'message' => 'Nome já registrado'
        ),
        array(
            'rule' => array('minLength', 3),
            'message' => 'Nome deve ser completo.'
        ),
        array(      
            'rule' => array('maxLength', 45),
            'required' => true,
            'message' => 'Máximo de 45 caractéres.'
        ),
            array( 'rule' => '/^[-_a-zA-Z]$/',
            'message' => 'Somente letras são aceitas')
    ),
    'emernome' => array(
        array( 
            'rule' => 'NotEmpty',
            'message' => 'Campo deve ser preenchido' 
        ),
        array(
            'rule' => array('minLength', 3),
            'message' => 'Nome deve ser completo.'
        ),
        array(      
            'rule' => array('maxLength', 45),
            'message' => 'Máximo de 45 caractéres.'
        ),
            array( 'rule' => '/^[-_a-zA-Z]$/',
            'message' => 'Somente letras são aceitas')
    ),
    'cpf'=> array(
        array( 'rule' => 'NotEmpty',
            'message' => 'Campo deve ser preenchido' 
        ),
        array(
            'rule' => 'isUnique',
            'message' => 'CPF já registrado'
        ),
        array(      
            'rule' => 'numeric',
            'message' => 'Somente números são aceitos.'
        ),
        array(
            'rule' => array('minLength', 11),
            'message' => 'CPF deve conter 11 números.'
        ),
        array(      
            'rule' => array('maxLength', 11),
            'message' => 'CPF deve conter 11 números.'
        ),
        array(
            'rule' => 'ValidaCPF',
            'message' => 'Insira um CPF válido'
        )
    ),

    'rg'=> array(
        array(
            'rule' => 'isUnique',
            'message' => 'RG já registrado'  
        ),
         array(
            'rule' => array('minLength', 9),
            'message' => 'RG deve conter 9 números.'
        ),
        array(      
                'rule' => array('maxLength', 15),
                'message' => 'Máximo de 15 caractéres.'
            )
    ),

    'email' => array(
        array(
            'rule' => 'isUnique',
            'message' => 'Email já registrado'
        ),
        array(
            'rule' => 'NotEmpty',
            'message' => 'Campo deve ser preenchido'
        ),
        array(      
              'rule' => array('maxLength', 45),
              'message' => 'Máximo de 45 caractéres.'
            )
    ),

    'confirmaemail' => array(
        array(
            'rule' => 'ConfirmaEmail',
            'message' => 'Os emails não coincidem'
        )
    ),

    'pass' => array(
        array(
            'rule' => 'NotEmpty',
            'message' => 'Campo deve ser preenchido'
        ),
        array(
            'rule' => array('minLength',6),
            'message' => 'Senha deve conter pelo menos 6 caractéres'
        ),
        array(      
            'rule' => array('maxLength', 45),
            'message' => 'Máximo de 45 caractéres.'
        )
    ),

    'data_nascimento' => array(
            array(
                'rule' => 'NotEmpty',
                'message' => 'Campo deve ser preenchido'
            ),

            array( 
                'rule' => 'checaData',
                'message' => 'Insira uma data válida'
            )
    ),
    'confirmapass' => array(
        array(
            'rule' => 'ConfirmaSenha',
            'message' => 'As senhas não coincidem'
        )
    ),

    'telefonefixo' => array(
        array( 'rule' => 'NotEmpty',
            'message' => 'Campo deve ser preenchido' ),
            array(      
                'rule' => array('maxLength', 20),
                'message' => 'Máximo de 20 caractéres.'
            )
    ),
    'emertelefone' => array(
        array( 'rule' => 'NotEmpty',
            'message' => 'Campo deve ser preenchido' ),
            array(      
                'rule' => array('maxLength', 20),
                'message' => 'Máximo de 20 caractéres.'
            )
    ),
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

            array( 'rule' => '/^[-_a-zA-Z]$/',
            'message' => 'Somente letras são aceitas'),

            array(      
                'rule' => array('maxLength', 45),
                'message' => 'Máximo de 45 caractéres.'
            )
            ), 
    'uf' => array(
            array( 'rule' => 'NotEmpty',
            'message' => 'Campo deve ser preenchido.'),
            array( 'rule' => '/^[-_a-zA-Z]$/',
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
        ),
    'company_id' => array(
            array( 'rule' => 'NotEmpty',
            'message' => 'Campo deve ser preenchido.')
        ),
    'cargo' => array(
            array( 'rule' => 'NotEmpty',
            'message' => 'Campo deve ser preenchido.')
        ),
    'alimentacao' => array(
            array( 'rule' => 'NotEmpty',
            'message' => 'Campo deve ser preenchido.' )
        ),
    'deficiencia' => array(
            array( 'rule' => 'NotEmpty',
            'message' => 'Campo deve ser preenchido.' )
        ),
    'telefonecelular' => array(
            array( 'rule' => 'NotEmpty',
            'message' => 'Campo deve ser preenchido.' )
        ),
    'telefonefixo' => array(
            array( 'rule' => 'NotEmpty',
            'message' => 'Campo deve ser preenchido.' )
        )
    );

    public function ConfirmaEmail($data) {
        $confirmaemail = array_shift($data);
        $email = $this->data[$this->alias]['email']; // Pega o valor do campo "email"
        // Compara os valores dos emails
        if ($confirmaemail == $email)
            return true;
        else
            return false;
    }

    public function ConfirmaSenha($data) {
        $confirmasenha = array_shift($data);
        $senha = $this->data[$this->alias]['pass']; // Pega o valor do campo "email"
        // Compara os valores dos emails
        if ($confirmasenha == $senha)
            return true;
        else
            return false;
    }

    public function checaData($data) {
        $date = array_shift($data);

        // Compara os valores dos emails
        list($yy,$mm,$dd)=explode("-",$date); 
        if (is_numeric($yy) && is_numeric($mm) && is_numeric($dd)) 
        { 
            return checkdate($mm,$dd,$yy); 
        } 
        return false;        
    }
    public function ValidaCPF($data) {
    $cpf = array_shift($data);
   // Verifiva se o número digitado contém todos os digitos
    $cpf = str_pad(preg_replace('[^0-9]', '', $cpf), 11, '0', STR_PAD_LEFT);
    
    // Verifica se nenhuma das sequências abaixo foi digitada, caso seja, retorna falso
    if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999')
    {
        return false;
    }
    else
    {   // Calcula os números para verificar se o CPF é verdadeiro
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf{$c} * (($t + 1) - $c);
                }

                $d = ((10 * $d) % 11) % 10;

                if ($cpf{$c} != $d) {
                    return false;
                }
            }

            return true;
        }
    }
}
 ?>