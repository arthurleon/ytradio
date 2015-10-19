<html>
    <head>
        <link rel="stylesheet" href="../css/reset.css">
    </head>
    <body>
<?php

require_once 'config.inc.php';
$uso = '12345678900';
//$cpf = '';
//$cpf = '500';
//$cpf = '12345678900';
//$cpf = 'aaaaaaaaa';
$cpf = '12345678911';

if (!$cpf):
    trigger_error('Informe seu CPF', E_USER_NOTICE);
elseif ($cpf == '500'):
    trigger_error('Formato não é mais utilizado!', E_USER_DEPRECATED);
elseif ($cpf == $uso):
    trigger_error('CPF em uso!', E_USER_WARNING);
elseif (!preg_match('/^[0-9]*$/i', $cpf) && strlen($cpf) != 11):
    trigger_error('CPF inválido!', E_USER_ERROR);
else:
    echo 'CPF Válido';
endif;

echo ':(';
echo '<hr>';

function Error($Error, $Message, $File, $Line){
    $error = ($Error == E_USER_ERROR ? "red" : ($Error == E_USER_WARNING ? "darkorange" : "blue"));
    echo "<p style='color:{$error}'>Erro na linha #: {$Line}: {$Message}<br>";
    echo "<small>{$File}</small></p>";
    
    if($Error == E_USER_ERROR):
        die;
    endif;
}

//set_error_handler('Error');

//$cpf = '';
//$cpf = '500';
//$cpf = '12345678900';
//$cpf = 'aaaaaaa';
//$cpf = '12345678911';

if (!$cpf):
    trigger_error('Informe seu CPF', E_USER_NOTICE);
elseif ($cpf == '500'):
    trigger_error('Formato não é mais utilizado!', E_USER_DEPRECATED);
elseif ($cpf == $uso):
    trigger_error('CPF em uso!', E_USER_WARNING);
elseif (!preg_match('/^[0-9]*$/i', $cpf) && strlen($cpf) != 11):
    trigger_error('CPF inválido!', E_USER_ERROR);
else:
    echo 'CPF Válido';
endif;

echo ':(';

echo '<hr>';

$eu = null;

if (!$eu):
    $a = new Exception("Eu é null", E_USER_NOTICE);
endif;

var_dump($a);

echo '<hr>';

try {
    if (!$eu):
        throw new Exception("Eu é null de novo", E_USER_NOTICE);
    endif;
} catch (Exception $e) {
    echo "<p>Erro #{$e->getCode()}: {$e->getMessage()}<br>";
    echo "<small>{$e->getFile()} na linha {$e->getLine()}</small>";
    
    echo '<hr>';
    echo $e->xdebug_message;
}

echo '<hr>';
trigger_error('Esta é uma NOTICE', E_USER_NOTICE);
trigger_error('Esta é uma WARNING', E_USER_WARNING);
//trigger_error('Esta é um ERROR', E_USER_ERROR);
echo '<hr>';
WSError("Este é um ACCEPT", WS_ACCEPT);
WSError("Este é um INFO", WS_INFO);
WSError("Este é um ALERT", WS_ALERT);
WSError("Este é um ERROR", WS_ERROR);

phpinfo();
?>
        </body>
</html>