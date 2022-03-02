<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="pendu.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=PT+Sans&family=Shippori+Antique+B1&display=swap" rel="stylesheet">
	<title>On se fait une partie ?</title>
</head>

<header>
	<h1 style="font-size:30px;"> LE JEU DU PENDU - EDITION 2022 METO</h1>
	<a class="admin" href="admin.php">Ajoutez un nouveau mot</a>
</header>

<body>
	<?php
		include 'functions.php';

		//reset button
		if(isset($_POST['newWord'])){
			unset($_SESSION['answer']);
			unset($_SESSION['incorrectGuesses']);
		}

		//récupération d'une nouvelle partie
		if(!isset($_SESSION['answer'])){
			$_SESSION['attempts'] = 0;
			$answer = fetchWordArray($WORDLISTFILE);
	        $_SESSION['answer'] = $answer;
	        $_SESSION['hidden'] = hideCharacters($answer);
	        echo '<div class="try_word"><p class="tries"> Il reste '.($MAX_ATTEMPTS - $_SESSION['attempts']).' essais.</p><br><br>';
		}
		else{
			//récupération de la valeur de l'utilisateur, et check de conformité
			if(isset($_POST['userInput'])){
				$userInput = $_POST['userInput'];
				$_SESSION['hidden'] = checkAndReplace(strtoupper($userInput), $_SESSION['hidden'], $_SESSION['answer']);
				checkGameOver($MAX_ATTEMPTS, $_SESSION['attempts'], $_SESSION['answer'], $_SESSION['hidden']);
			}
			$_SESSION['attempts'] = $_SESSION['attempts'] +1;

			//comptage des essais restants
			if($MAX_ATTEMPTS - $_SESSION['attempts'] >= 0){
			echo '<p class="tries"> Il reste '.($MAX_ATTEMPTS - $_SESSION['attempts']).' essais.</p><br>';
			}
		}
		echo "<p class='mot'>";
		$hidden = $_SESSION['hidden'];
		foreach ($hidden as $char){
			echo $char. " ";
		}
		echo "</p></div>";

		//affichage du pendu
		if($_SESSION['attempts'] == 1){
			echo "________<br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I <br>
					I     <br>
					I     <br>
					I     <br>
			   _____I_____";
		}
		elseif($_SESSION['attempts'] == 2){
			echo "________<br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I <br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;0<br>
					I     <br>
					I     <br>
			   _____I_____";
		}
		elseif($_SESSION['attempts'] == 3){
			echo "________<br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I <br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;0<br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/<br>
					I     <br>
			   _____I_____";
		}
		elseif($_SESSION['attempts'] == 4){
			echo "________<br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I <br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;0<br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;I<br>
					I     <br>
			   _____I_____";
		}
		elseif($_SESSION['attempts'] == 5){
			echo "________<br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I <br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;0<br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;I&nbsp;&nbsp;\<br>
					I     <br>
			   _____I_____";
		}
		elseif($_SESSION['attempts'] == 6){
			echo "________<br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I <br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;0<br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;I&nbsp;&nbsp;\<br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/<br>
			   _____I_____";
		}
		elseif($_SESSION['attempts'] == 7){
			echo "________<br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I <br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;0<br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;I&nbsp;&nbsp;\<br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;\<br>
			   _____I_____";
		}

		//stockage des lettres entrées
		if(!isset($_SESSION['Guesses'])){
			$arrayGuess = [];
		}
		else{
			$arrayGuess = $_SESSION['Guesses'];
		}

		if(isset($_POST['userInput'])){
		   $arrayGuess[] = $_POST['userInput'];
		}
		$_SESSION['Guesses'] = $arrayGuess;
		
		//display des lettres pour l'utilisateur
			echo "<div class='letters'>
			  	 <b>Liste de lettres utilisées :<br/></b>";	 
		foreach ($arrayGuess as $Guess){
			echo $Guess. "&nbsp;&nbsp;";
		}
			echo "</div>";
	?>

	<!-- check pour des faux input et submit !-->
	<script type="application/javascript">
    function validateInput(){
	    var x=document.forms["inputForm"]["userInput"].value;
	    if(x=="" || x==" "){
	        alert("Sasissez une lettre.");
	        return false;
	    }
	    if(!isNaN(x)){
	        alert("Sasissez une lettre.");
	    	return false;
	    }
	}
	</script>

	<form class="inputform" name="inputForm" method="post" action="">
		Entrez votre lettre : <input class="f_text" type="text" name="userInput" size="1" maxlength="1">
		<input class="formbutton" type="submit" value="Valider" name="check" onclick="return validateInput()"><br><br>
		<input class="formbutton" type="submit" value="Commencer une nouvelle partie" name="newWord">
	</form>

	<script type="text/javascript" language="JavaScript">
	document.forms['inputForm'].elements['userInput'].focus();
	</script>
</body>
</html>