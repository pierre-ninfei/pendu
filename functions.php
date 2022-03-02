<?php

	//defining variables
	$MAX_ATTEMPTS = 7;
	$WORDLISTFILE = 'mots.txt';

	//retrieving words from mots.txt
	function fetchWordArray($wordfile){
		$file = fopen($wordfile, 'r');

		if($file){
			$random_line = null;
			$line = null;
			$count = 0;
			while(($line = fgets($file)) !== false){
				$count++;
				if(rand() % $count == 0){
					$random_line = trim($line);
				}
			}
			if(!feof($file)){
				fclose($file);
				return null;
			}
			else{
				fclose($file);
			}
		}
		$answer = str_split($random_line);
		return $answer;
	}

	//choose a word from the words pool and hide it's characters
	function hideCharacters($answer){
		$noOfHiddenChars = floor((sizeof($answer)/2)+1);
		$count = 0;
		$hidden = $answer;
		while($count < $noOfHiddenChars){
			$rand_element = rand(0, sizeof($answer)-2);
			if($hidden[$rand_element] != '_'){
				$hidden = str_replace($hidden[$rand_element], '_', $hidden, $replace_count);
				$count = $count + $replace_count;
			}
		}
		return $hidden;
	}

	//replaces letters if the users guesses right
	function checkAndReplace($userinput, $hidden, $answer){
		$i = 0;
		$wrongGuess = true;
		while($i < count($answer)){
			if($answer[$i] == $userinput){
				$hidden[$i] = $userinput;
				$wrongGuess = false;
			}
			$i = $i+1;
		}
		if(!$wrongGuess){
			$_SESSION['attempts'] = $_SESSION['attempts']-1;
		}
		return $hidden;
	}

	//check if the game is over and won or lost
	function checkGameOver($MAX_ATTEMPTS, $userAttempts, $answer, $hidden){
		if($userAttempts >= $MAX_ATTEMPTS){
			echo "Dommage ! la partie est terminée. Le mot était : ";
			foreach ($answer as $letter){
				echo strtolower($letter);
			}
			echo "<br><form action = '' method ='post'><input type='submit' name='newWord' value='Veux-tu réessayer ?' class='formbutton'></form><br>";
		}
		if($hidden == $answer){
			echo "Bravo ! Tu as gagné ! Le mot est bien : ";
			foreach ($answer as $letter){
				echo strtolower($letter);
			}
			echo "<br><form action = '' method ='post'><input type='submit' name='newWord' value='Réessayer avec un autre mot ?' class='formbutton'></form><br>";
		}
	}
?>