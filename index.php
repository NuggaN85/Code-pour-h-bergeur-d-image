<?php 
$poids_max = 512000; // Poids max de l'image en octets (1Ko = 1024 octets) 
$repertoire = 'uploads/'; // Repertoire d'upload 
if (isset($_FILES['fichier'])) 
{ 

// On vérife le type du fichier 
if ($_FILES['fichier']['type'] != 'image/png' && $_FILES['fichier']['type'] != 'image/jpeg' && $_FILES['fichier']['type'] != 'image/jpg' && $_FILES['fichier']['type'] != 'image/gif' ) 
{ 
$erreur = 'Le fichier doit être au format *.jpeg, *.jpg, *.png, *.gif'; 
} 

// On vérifie le poids de l'image 
elseif ($_FILES['fichier']['size'] > $poids_max) 
{ 
$erreur = 'L\'image doit être inférieur à ' . $poids_max/1024 . 'Ko.'; 
} 

// On vérifie si le répertoire d'upload existe 
elseif (!file_exists($repertoire)) 
{ 
$erreur = 'Erreur, le dossier d\'upload n\'existe pas.'; 
} 

// Si il y a une erreur on l'affiche sinon on peut uploader 
if(isset($erreur)) 
{ 
echo '' . $erreur . '<br><a href="javascript:history.back(1)">Retour</a>'; 
} 
else 
{ 

// On définit l'extention du fichier puis on le nomme par le timestamp actuel 
if ($_FILES['fichier']['type'] == 'image/jpeg') { $extention = '.jpeg'; } 
if ($_FILES['fichier']['type'] == 'image/jpg') { $extention = '.jpg'; } 
if ($_FILES['fichier']['type'] == 'image/png') { $extention = '.png'; } 
if ($_FILES['fichier']['type'] == 'image/gif') { $extention = '.gif'; } 
$nom_fichier = time().$extention; 

// On upload le fichier sur le serveur. 
if (move_uploaded_file($_FILES['fichier']['tmp_name'], $repertoire.$nom_fichier)) 
{ 
$url = 'www.monsite.com/'.$repertoire.''.$nom_fichier.''; 
echo 'Votre image à été uploadée sur le serveur avec succes!<br>Voici le lien: <br />
	<br/>
	<img src="uploads/'.$nom_fichier.'" width="150px" height="150px" border="2px" /><br/>
	<br/>
<b>BBcode img</b> =  <input type="text" value="[img]' . $url . '/img" /><br />
<br />
<b>BBcode url</b> = <input type="text" value="[url]' . $url . '/url" /><br />
<br />
<b>HTML direct </b> <input type="text" value="'.$url.'" />

';
} 
else 
{ 
echo 'L\'image n\'a pas pu être uploadée sur le serveur.'; 
} 

} 

} 
else 
{ 
?> 
<form method="post" enctype="multipart/form-data"> 
<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $poids_max; ?>">
<input type="file" name="fichier"> 
<input type="submit" value="Envoyer"> 
</form> 
<?php 
} 
?>
