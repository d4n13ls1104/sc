<?php
include "../_util/whitelist.php";
include "../_util/config.php";

// Error varriable in case any errors occur when attempting to register user
$error = "";

// Field Vars
$email = "";
$username = "";
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
		// Check if there are any accounts already registered with that email
		$emailCheck = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email' LIMIT 1");

		if(mysqli_num_rows($emailCheck) > 0) {
			// The email is already registered
			$error = "An account with that email is already registered.";
		}
	} else {
		$error = "Email was not provided.";
	}
	// END OF EMAIL VALIDATION //

	// USERNAME VALIDATION //

	if(isset($_POST["username"]) && !empty($_POST["username"])) {
		// Sanitization
		$username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
		$username = mysqli_real_escape_string($conn, $username);

		// If username doesn't contain only alphanumeric characters
		if(!ctype_alnum($username)) {
			$error = "Username may only contain alphanumeric characters.";
		}
		if(strlen($username) > 16) {
			$error = "Username can contain only up to 16 characters.";
		}
	} else {
		$error = "Username was not provided.";
	}
	// END OF USERNAME VALIDATION //

	// PASSWORD VALIDATION //
	if(isset($_POST["password"]) && !empty($_POST["password"])) {
		$password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);
		$password = mysqli_real_escape_string($conn, $password);

		$hasUpper = preg_match("@[A-Z]@", $password);
		$hasLower = preg_match("@[a-z]@", $password);
		$hasNumber = preg_match("@[0-9]@", $password);
		$hasSpecialChar = preg_match("@[^\w]@", $password);

		if(!$hasUpper || !$hasLower || !$hasNumber || !$hasSpecialChar || strlen($password) < 8) {
			$error = "Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.";
		}
	} else {
		$error = "Password was not provided.";
	}
	// END OF PASSWORD VALIDATION //

	// FINAL VALIDATION (check if users already exist with that username or email) //
	if(empty($error)) {
		$emailCheck = mysqli_query($conn, "SELECT 1 FROM users WHERE email='$email' LIMIT 1");
		$usernameCheck = mysqli_query($conn, "SELECT 1 FROM users WHERE username='$username'");

		if(mysqli_num_rows($emailCheck) > 0) {
			$error = "The email you provided is already registered.";
		}

		if(mysqli_num_rows($usernameCheck) > 0) {
			$error = "Username is taken.";
		}

		// If no error occured whilst checking for already existing data
		if(empty($error)) {
			$options = array(
				"cost" => 12
			 );

			$password = password_hash($password, PASSWORD_BCRYPT, $options);

			$registerQuery = mysqli_query($conn, "INSERT INTO users (email, username, password) VALUES ('$email', '$username', '$password')");

			if(!$registerQuery) die("An unexpected error occured. Please try again later.");

			header("Location: /login");

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
      <div id="logout"><a href="/_util/logout.php">LOGOUT</a></div>
      <div id="logotext"><h1 style="color:#fff;">Sand</h1><h1 style="color:#26aa5a;">Chat</h1></div>
    </div>

    <div id="register-wrapper">
			<span id="error"><?php echo $error ?></span>
      <h1>Create an account</h1>
      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" autocomplete="off">
        <input type="text" class="input" placeholder="Email" name="email"/>
        <input type="text" class="input" placeholder="Username" name="username"/>
        <input type="password" class="input" placeholder="Password" name="password" style="border-bottom-left-radius:10px;border-bottom-right-radius:10px;"/>
        <button id="submit" name="submit" type="submit">Create Account</button>
      </form>
    </div>

  </body>
</html>
