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
    <meta charset="utf-8">
    <meta name="robots" content="noindex"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Sandchat</title>
		<link rel="shortcut icon" href="../_util/favicon.ico"/>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
  </head>
  <body class="bg-gray-100">
    <div class="bg-white lg:w-4/12 md:6/12 w-10/12 m-auto my-10 shadow-md rounded-lg">
            <div class="py-8 px-8 rounded-xl">
                <h1 class="font-medium text-3xl mt-2 text-center">Login</h1>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" autocomplete="off" class="mt-6">
                    <div class="my-5 text-sm">
                        <label for="email" class="block text-black">Username</label>
                        <input type="text" name="email" autofocus id="email" class="rounded-md px-4 py-3 mt-3 focus:outline-none bg-gray-100 w-full" placeholder="Email" />
                    </div>
                    <div class="my-5 text-sm">
                        <label for="password" class="block text-black">Password</label>
                        <input type="password" name="password" class="rounded-md px-4 py-3 mt-3 focus:outline-none bg-gray-100 w-full" placeholder="Password" />
                        <div class="flex justify-end mt-2 text-xs text-gray-600">
                           <a href="#" title="Coming Soon I guess">Forgot Password?</a>
                        </div>
                        <div class="flex mt-2 inline-block text-red-600">
                          <span><?php echo $error; ?></span>
                        </div>
                    </div>

                    <button class="block text-center text-white bg-indigo-500 p-3 duration-300 rounded-md hover:bg-indigo-600 w-full" name="submit">Login</button>
                </form>

                <p class="mt-12 text-xs text-center font-light text-gray-400"> Don't have an account? <a href="/register" class="text-black font-medium"> Create One </a>  </p>
            </div>
        </div>
  </body>
</html>
