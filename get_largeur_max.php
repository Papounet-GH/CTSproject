<?php
require_once("class_conn.php");
$db = new Database(
	"localhost",
	"ods_db",
	"root",
	"root"
);
if(!empty($_POST["hauteur"])) {
$res=$db->Select("SELECT (`largeur`) FROM `catalogue_cdc` WHERE `type_cdc` = '" . $_POST["type_cdc"] . "' AND `hauteur`='" . $_POST["hauteur"] . "'");
$count=count($res);
?>
	<option value="">Sélectionnez la largeur Max</option>
<?php
	foreach($res as $largeurs) {
?>
	<option value="<?php echo $largeurs["largeur"]; ?>"><?php echo $largeurs["largeur"]; ?></option>
<?php
	}
}
?>
