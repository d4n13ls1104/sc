<?php
include "../_util/whitelist.php";
include "../_util/config.php";
session_start();

if(isset($_SESSION["uid"])) {
	header("Location: /home");
}

// Error variable in case any errors occur when attempting to login user
$error = "";

// Field vars
$email = "";
$password = "";

// If form is being submitted
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
	// EMAIL VALIDATION //
	if(isset($_POST["email"]) && !empty($_POST["email"])) {
		// Sanitize
		$email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
		$email = mysqli_real_escape_string($conn, $email);
		$email = strtolower($email);

		// Validate
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$error = "The email you provided is invalid.";
		}
	} else {
		$error = "Email was not provided";
	}
	// END OF EMAIL VALIDATION //

	// PASSWORD VALIDATION //
	if(isset($_POST["password"]) && !empty($_POST["password"])) {
		// Sanitization
		$password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);
		$password = mysqli_real_escape_string($conn, $password);
	} else {
		$error = "Password was not provided.";
	}
	// END OF PASSWORD VALIDATION //

	if(!$error) {
		$credentialCheck = mysqli_query($conn, "SELECT uid, username, password FROM users WHERE email='$email'");

		if($credentialCheck) {
			if(mysqli_num_rows($credentialCheck) > 0) {
				$row = mysqli_fetch_assoc($credentialCheck);
				$passwordCorrect = password_verify($password, $row["password"]);
				if($passwordCorrect) {
					$_SESSION["uid"] = $row["uid"];
					$_SESSION["username"] = $row["username"];
					header("Location: /home");
				} else {
					$error = "Invalid Credentials.";
				}
			}
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en-us">
  <head>
    <meta charset="utf-8"/>
    <meta name="robots" content="noindex"/>
    <title>Sandchat</title>
    <link rel="shortcut icon" href="../_util/favicon.ico"/>
    <link rel="stylesheet" href="styles.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  </head>
  <body>
    <div id="header">
      <img src="../img/sandchatlogo.png" id="logo"/>
      <div id="logotext"><h1 style="color:#fff;">Sand</h1><h1 style="color:#26aa5a;">Chat</h1></div>
    </div>

    <div id="register-wrapper">
			<span id="error"><?php echo $error ?></span>
      <h1>Login</h1>
      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" autocomplete="off">
        <input type="text" class="input" placeholder="Email" name="email"/>
        <input type="password" class="input" placeholder="Password" name="password" style="border-bottom-left-radius:10px;border-bottom-right-radius:10px;"/>
				<span>By logging into this site you agree to our <a href="/privacy" target="_blank">Privacy Policy</a> & <a href="/privacy" target="_blank">Terms of Service</a></span>
        <button id="submit" name="submit" type="submit">Login</button>
      </form>
    </div>
  </body>
</html>
