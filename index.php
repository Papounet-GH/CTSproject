<?php
//on démarre une session
if(!isset($_SESSION)){session_start();}

//on inclut la connexion à la base
require_once("class_conn.php");
$db = new Database(
    "localhost",
    "ods_db",
    "root",
    "root"
);

//on écrit nos requêtes
$resinit=$db->Select("SELECT DISTINCT(`type_cdc`) FROM `catalogue_cdc`"); //requête pour première liste déroulante
$result=$db->Select('SELECT * FROM `catalogue_cables`'); //requête pour le catalogue des câbles

?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <title>
      Cable Tray Sizing - Outil de pré-dimensionnement des chemins de câbles
    </title>
    <meta charset="utf-8" />
    <meta name="author" content="christophe farin" />
    <meta
      name="description"
      content="Cable Tray Sizing a été conçu pour proposer aux utilisateurs des fonctions avancées de calculs et de contrôles pour la définition de chemins de câbles. Ces fonctions concernent le volume et la charge acceptables basées sur des données standards de chemins de câbles et de câbles."
    />
    <meta
      name="keywords"
      content="ingénierie, bureau d'études, chemin de câbles, cheminement de câbles, électricité, instrumentation, courant fort, courant faible"
    />
    <!-- meta uniquement pour les mobiles -->
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, user-scalable=no"
    />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" type="text/javascript"></script>
    <script type="text/javascript" src='datatables/media/js/jquery.js'></script>
    <script type="text/javascript" src="datatables/media/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="datatables/media/css/jquery.dataTables.min.css"/>
    <script type="text/javascript" src="scripts/table.js"></script>
    <link type="text/css" rel="stylesheet" href="styles/cts.css" />
    <link rel="stylesheet" href="styles/css/all.min.css" />
  </head>
  <body>
    <nav class="navbar">
      <ul class="navbar-menu">
        <li class="navbar-item logo">
          <a href="#" class="navbar-link">
            <span class="navbar-title">christophe-farin.fr</span>
            <i class="fas fa-chevron-right navbar-icon"></i>
          </a>
        </li>
        <li class="navbar-item">
          <a href="#" class="navbar-link">
            <i class="fas fa-home navbar-icon"></i>
            <span class="navbar-title">Home</span>
          </a>
        </li>
        <li class="navbar-item">
          <a href="#" class="navbar-link">
            <i class="fas fa-circle-info navbar-icon"></i>
            <span class="navbar-title">Information</span>
          </a>
        </li>
        <li class="navbar-item">
          <a href="#" class="navbar-link">
            <i class="fas fa-circle-question navbar-icon"></i>
            <span class="navbar-title">Help</span>
          </a>
        </li>
        <li class="navbar-item">
          <a href="about-me/about-me.html" class="navbar-link">
            <i class="fas fa-user navbar-icon"></i>
            <span class="navbar-title">About me</span>
          </a>
        </li>
      </ul>
    </nav>
    <header>
      <h1>
        Cable Tray Sizing - Outil de pré-dimensionnement des chemins de câbles
      </h1>
    </header>
    <section id="welcome">
      <div class="photo">
        <img src="images/icon_CTS.png" alt="Logo CTS" />
      </div>
      <h2>Bienvenue</h2>
      <div class="desc">
        <p>
          Avec « Cable tray sizing », pré-dimensionnez vos chemins de câbles
          pour tous vos projets industriels ou tertiaires. A partir des « cable
          routing », identifiez et repérez les tronçons de chemins de câbles que
          vous souhaitez dimensionner. Munissez-vous de la liste de câbles
          devant être supportés par chacun des tronçons.<br />
          Vous êtes près pour découvrir les astuces et les fonctions et de cette
          application en ligne.
        </p>
      </div>
    </section>
    <section id="cable-tray-data">
      <h2>Choisissez les caractéristiques du chemin de câbles</h2>
      <div class="desc">
        <p>
          Choisir le type du chemin de câbles et sa hauteur, sa largeur minimum
          (par défaut cette valeur est la plus petite du catalogue), sa largeur maximum (par défaut
          cette valeur est la plus grande).<br />
          Ce choix est important si l’encombrement disponible pour
          l’installation du cheminement est réduit ou si l’on souhaite utiliser
          des chemins de câbles de dimension standard.<br />
          Le pourcentage de réserve (30% par défaut) est modifiable. Le nombre de couches de câbles dans le cheminement peut être renseigné pour limiter la superposition des câbles. S’il n’y a pas de limitation, alors ne rien inscrire dans cette zone.
        </p>
      </div>
      <div class="data-input">
        <form method="post" action="param.php">
          <table cellspacing="0" id="my-table">
            <thead>
              <tr>
                <th scope="col">Type</th>
                <th scope="col">Hauteur</th>
                <th scope="col">Largeur min</th>
                <th scope="col">Largeur max</th>
                <th scope="col">Réserve</th>
                <th scope="col">Nb de couches de câbles</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                  <td>
                    <select name="t" id="types" class="boxInput" onChange="getHauteur(this.value)">
                      <option value="">Sélectionnez le type</option>
                      <?php
                        foreach($resinit as $types) {
                        if (isset($t) && $t==$types["type_cdc"]) {
                      ?>
                        <option selected="selected"><?php echo $types["type_cdc"];?></option>
                      <?php
                        }
                        else {
                      ?>
                        <option value="<?php echo $types["type_cdc"]; ?>"><?php echo $types["type_cdc"]; ?></option>
                      <?php
                      }}
                      ?>
                    </select>
                  </td>
                  <td>
                    <select name="h" id="hauteurs" class="boxInput" onChange="getLargeurmin(this.value)">
                      <option value="">Sélectionnez la hauteur</option>
                    </select>
                  </td>
                  <td>
                    <select name="lmin" id="largeursmin" class="boxInput" onChange="getLargeurmax(this.value)">
                      <option value="">Sélectionnez la largeur Min</option>
                      <?php
                        if (isset($lmin)) {
                      ?>
                        <option selected="selected"><?php echo $lmin;?></option>
                      <?php
                      	}
                      ?>    
                    </select>
                  </td>
                  <td>
                    <select name="lmax" id="largeursmax" class="boxInput" onChange="controlValue()">
                      <option value="">Sélectionnez la largeur Max</option>
                      <?php
                        if (isset($lmax)) {
                      ?>
                        <option selected="selected"><?php echo $lmax;?></option>
                      <?php
                      	}
                      ?>    
                    </select>
                  </td>
                  <td>
                    <input type="number" name="r" id="reserve" min="0" max="100" value="<?php if (isset($r)){echo $r;} else {echo '30';} ?>" class="boxInput" onChange="" required>
                  </td>
                  <td>
                    <input type="number" name="nbc" id="nbcouches" min="1" class="boxInput" value="<?php echo $nbc; ?>" onChange="">
                  </td>
              </tr>
            </tbody>
          </table>
          <div class="centre-btn">
            <input type="submit" id="valider" name="valider" value="Valider les caractéristiques du chemin de câbles">
          </div>
            <?php
            //vérif pour debug
            var_dump($t);
            var_dump($h);
            var_dump($lmin);
            var_dump($lmax);
            var_dump($r);
            var_dump($nbc);
            echo "$nbc";
            // vardump($_SESSION['param']['types']);
            // vardump($_SESSION['param']['hauteurs']);
            // vardump($_SESSION['param']['largeursmin']);
            // vardump($_SESSION['param']['largeursmax']);
            // vardump($_SESSION['param']['reserve']);
            // var_dump($_SESSION['param']['nbcouches']);
            ?>
        </form>
      </div>
    </section>
    <section id="cable-select">
      <h2>Sélectionner tous les câbles contenus dans le chemin de câbles</h2>
      <div class="desc">
        <p>
          Sélectionner chaque type de câbles passant dans le cheminement depuis le catalogue de câbles proposé puis modifier la quantité si nécessaire dans la liste des câbles sélectionnées.<br />
          <br />
        </p>
      </div>
      <div class="half-section-left" onmouseover=selvide();>
        <h3>Catalogue de câbles</h3>
        <p><br />
        </p>
        <table id="tableft" class='display compact'>
          <thead>
            <th>Type de câble</th>
            <th>Actions</th>
          </thead>
          <tbody>
            <?php
              foreach($result as $typecables){
            ?>
              <tr>
                <td><?= $typecables['type_cable'] ?></td>
                <td><a href="panier.php?action=ajout&amp;l=<?= $typecables['type_cable'] ?>&amp;q=1 ?>" >Sélectionner</a></td>
              </tr>
            <?php
              }
            ?>
          </tbody>
        </table>
      </div>
      <div class="half-section-right">
        <h3>Liste des câbles sélectionnés</h3>
        <p><br />
        </p>
        <form method="post" action="panier.php">
          <table id="tabright" class='display compact'>
            <thead>
              <th>Type de câble</th>
              <th>Quantité</th>
              <th>Actions</th>
            </thead>
            <tbody>
              <?php
                $nbArticles=count($_SESSION['panier']['libelleProduit']);
                if ($nbArticles <= 0)
                    //echo "$nbArticles"
                    ;
                else {
                  for ($i=0 ;$i < $nbArticles ; $i++)
                  {
                    ?>
                      <tr>
                        <td><?=($_SESSION['panier']['libelleProduit'][$i])?></td>
                        <td><input type="number" name="q" id="qty" value="<?=($_SESSION['panier']['qteProduit'][$i])?>" min="1" /></td>
                        <td><a href="panier.php?action=suppression&amp;l=<?=($_SESSION['panier']['libelleProduit'][$i]) ?>" >Poubelle</a></td>
                      </tr>
                    <?php
                  }
                }
              ?>
            </tbody>
          </table>
          <div class="centre-btn">
            <a id="valider" href="panier.php?action=refresh" >Valider la sélection</a>
          </div>
        </form>
      </div>
    </section>
    <!-- taskbar pour les messages en bas d'écran -->
    <div class="centre">
      <div class="taskbar">
        <div class="alert" id="control" style="display:none;">
          <span class="closebtn">&times;</span>
          <strong>Warning!</strong> La largeur max doit être supérieure ou égale à la largeur min.
        </div>
        <div class="alert info" id="vide" style="display:none;">
          <span class="closebtn">&times;</span>
          <strong>Info!</strong> Votre sélection est vide.
        </div>
      </div>
    </div>
    <footer>
      <p><a href="">©Christophe FARIN</a> 2022</p>
      <p>Page web créée avec l'aide précieuse du site de Pierre GIRAUD</p>
      <p>
        <a href="https://www.pierre-giraud.com">www.pierre-giraud.com/</a>
      </p>
    </footer>
    <script src="scripts/cts.js" type="text/javascript"></script>
  </body>
</html>
