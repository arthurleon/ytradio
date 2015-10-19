<?php

// SITE CONFIG ##########################
// Base
define(HOME, 'http://localhost/ytradio/');

// Banco de dados
define(HOST, 'localhost');
define(USER, 'root');
define(PASS, '9hammer9');
define(DBSA, 'ytradio');

//set brazillian date
date_default_timezone_set("America/Sao_Paulo");

// error reporting & debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

// CLASSES AUTO LOAD ####################
function __autoload($Class) {
    //pastas em uso
    $cDir = ['Conn', 'Helpers','../admin/system/audioclip/model','../admin/system/login/model','../admin/system/band/model'];
    //verifica se as inclusões deram certo
    $iDir = null;
    
    // OBSERVAR A DIREÇÃO DAS BARRAS CASO USE WINDOWS
    
    foreach ($cDir as $dirName):
//        echo "dirName: {$dirName}<br>";
//        $path = __DIR__."//{$dirName}//{$Class}.class.php";
//        echo "path: {$path}<br>";
//        $cond1 = (is_null($iDir) ? 'true' : 'false');
//        echo "iDir is null: {$cond1}<br>";
//        $cond2 = (file_exists(__DIR__."//{$dirName}//{$Class}.class.php") ? "true" : "false");
//        echo "cond2: {$cond2}<br>";
//        $cond3 = (!is_dir(__DIR__ . "//{$dirName}//{$Class}.class.php") ? "true" : "false");
//        echo "cond3: {$cond3}<br>";
//        
        if(!$iDir && file_exists(__DIR__ . "/{$dirName}/{$Class}.class.php") && !is_dir(__DIR__ . "/{$dirName}/{$Class}.class.php")):
            include_once (__DIR__ . "/{$dirName}/{$Class}.class.php");
            $iDir = true;
        endif;
    endforeach;
    
    if(!$iDir):
        trigger_error("Não foi possível incluir {$Class}.class.php", E_USER_ERROR);
        die;
    endif;
}

// ERROR HANDLING #######################
//CSS Constants :: Error Messages
define('WS_ACCEPT', 'accept');
define('WS_INFO', 'info');
define('WS_ALERT', 'alert');
define('WS_ERROR', 'error');

//WSError :: Display Thrown Errors :: Front
function WSError($ErrMsg, $ErrNo, $ErrDie = null) {
    $cssClass = ($ErrNo == E_USER_NOTICE ? WS_INFO : ($ErrNo == E_USER_WARNING ? WS_ALERT : ($ErrNo == E_USER_ERROR ? WS_ERROR : $ErrNo)));
    echo "<p class=\"trigger {$cssClass}\">{$ErrMsg}<span class=\"ajax_close\"></span></p>";
    if ($ErrDie):
        die;
    endif;
}

//PHPError :: Customize PHP Trigger
function PHPError($ErrNo, $ErrMsg, $ErrFile, $ErrLine) {
    $cssClass = ($ErrNo == E_USER_NOTICE ? WS_INFO : ($ErrNo == E_USER_WARNING ? WS_ALERT : ($ErrNo == E_USER_ERROR ? WS_ERROR : $ErrNo)));
    echo "<p class=\"trigger {$cssClass}\">";
    echo "Erro na linha: {$ErrLine} ::</b> {$ErrMsg}<br>";
    echo "<small>{$ErrFile}</small>";
    echo "<span class=\"ajax_close\"></span></p>";
    if ($ErrNo == E_USER_ERROR):
        die;
    endif;
}

set_error_handler('PHPError');
