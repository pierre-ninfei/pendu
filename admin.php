<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="pendu.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=PT+Sans&family=Shippori+Antique+B1&display=swap" rel="stylesheet">
	<title>Ajoutez un mot à la liste</title>
</head>

<body>
	<header>
		<a href="index.php" class="admin"> <-- retour au jeu du pendu </a>
	</header>
	<?php 
		if(isset($_POST['send'])){
			if(!empty($_POST['admot'])){
				$data = strtoupper($_POST['admot']. "\r\n");
				$ret = file_put_contents('mots.txt', $data, FILE_APPEND | LOCK_EX);
				if($ret === true){
					echo $ret ." a été enregistré dans la base de données.";
				}
			}
			header("Location: index.php");
		}
	?>
	<h1>Saisissez un nouveau mot a entrer dans la base de données.</h1>
	<form method="post" action="">
		<input style='background-color:white; border-radius:10px;' type="text" name="admot"><br/><br/>
		<input style='background-color:white; border-radius:10px;' type="submit" value="Enregistrer le mot" name="send">
	</form>
</body>
</html>