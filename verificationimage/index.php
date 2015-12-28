<? session_start(); ?>

<?
	$submitted = false;
	if(isset($_POST['verificationcode'])) {
		$submitted = true;
		include("verification_image.class.php");
		$image = new verification_image();
		// do this when the form is submitted

		if($image->validate_code($_POST['verificationcode'])) {
			$message = sprintf('Your code was succesfully entered! <a href="%s"></a>', $_SERVER['PHP_SELF']);
		} else {
			$message = "Code not entered correctly: <br />";
			$message .= "<ul><li>You entered:" . $_POST['verificationcode'] . "</li>";
			$message .= "<li>Correct code:" . $_SESSION['verification_key'] . "</li></ul>";

		}
	}
?>

<html>
	<head>
	</head>
	<body>
		<? if($submitted) { ?>
			<?=$message ?>
		<? } else { ?>
		<form action="<?=$_SERVER['PHP_SELF'] ?>" method="POST">
		<table>
			<tr>
				<td></td>
				<td>
					<img src="picture.php" /> 
				</td>
			</tr>
			<tr>
				<td>Type this code over:</td>
				<td>
					<input type="text" name="verificationcode" />
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="submit" value="Validate your form" />
				</td>
			</tr>
		</form>
		
			
		<? } ?>
	</body>
</html>

