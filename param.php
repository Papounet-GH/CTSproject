<?php

if(!isset($_SESSION)){session_start();}

if(isset($_POST['valider'])){
   //récupération des variables en POST ou GET
   $t = (isset($_POST['t'])? $_POST['t']:  (isset($_GET['t'])? $_GET['t']:null )) ;
   $h = (isset($_POST['h'])? $_POST['h']:  (isset($_GET['h'])? $_GET['h']:null )) ;
   $lmin = (isset($_POST['lmin'])? $_POST['lmin']:  (isset($_GET['lmin'])? $_GET['lmin']:null )) ;
   $lmax = (isset($_POST['lmax'])? $_POST['lmax']:  (isset($_GET['lmax'])? $_GET['lmax']:null )) ;
   $r = (isset($_POST['r'])? $_POST['r']:  (isset($_GET['r'])? $_GET['r']:null )) ;
   $nbc = (isset($_POST['nbc'])? $_POST['nbc']:  (isset($_GET['nbc'])? $_GET['nbc']:null )) ;
}
//Suppression des espaces verticaux
$t = preg_replace('#\v#', '',$t);

//On traite $q qui peut être un entier simple ou un tableau d'entiers
$h = intval($h);
$lmin = intval($lmin);
$lmax = intval($lmax);
$r = intval($r);
$nbc = intval($nbc);
if ($nbc==0){$nbc='';};


/**
 * Verifie si le jeu de paramètres existe, le crée sinon
 * @param string $types
 * @param int $hauteurs
 * @param int $largeursmin
 * @param int $largeursmax
 * @param int $reserve
 * @param int $nbcouches
 * @return void
 */
if (!isset($_SESSION['param'])){
   $_SESSION['param']=array();
   $_SESSION['param']['types'] = array();
   $_SESSION['param']['hauteurs'] = array();
   $_SESSION['param']['largeursmin'] = array();
   $_SESSION['param']['largeursmax'] = array();
   $_SESSION['param']['reserve'] = array();
   $_SESSION['param']['nbcouches'] = array();
}

if (isset($_SESSION['param'])){
   array_push( $_SESSION['param']['types'],$t);
   array_push( $_SESSION['param']['hauteurs'],$h);
   array_push( $_SESSION['param']['largeursmin'],$lmin);
   array_push( $_SESSION['param']['largeursmax'],$lmax);
   array_push( $_SESSION['param']['reserve'],$r);
   array_push( $_SESSION['param']['nbcouches'],$nbc);
}
include_once("index.php");
//exit();
    
?>