<?php
include '../_util/whitelist.php';
include '../_util/config.php';
session_start();

if(!isset($_SESSION["uid"])) header("/login");

$username = "";
$id = mysqli_real_escape_string($conn, $_SESSION["uid"]);

if($dataFetch = mysqli_query($conn, "SELECT username FROM users WHERE uid='$id' LIMIT 1")) {
  $username = mysqli_fetch_object($dataFetch)->username;
} else {
  $username = "Error loading username.";
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
    <link rel="stylesheet" href="styles.css"/>
    <script>
      function redirect(url) {
        window.location.href = url;
      }
    </script>
  </head>
  <body>
    <div id="layout_wrapper">
      <div id="nav_wrapper">
        <div id="search" align="center">
          <input type="search" placeholder="Find or start a conversation" id="contact-search"/>
        </div>
        <nav id="personal_nav">
          <img id="avatar" src="https://cdn.discordapp.com/avatars/610282858418012161/e8e1f22001b4bbc086cc93fbe8a3ec83.png?size=256" draggable="false"/>
          <span id="username_label"><?php echo htmlspecialchars($username); ?></span>
          <img src="../img/settingsgraphic.svg" id="settings-btn" draggable="false" onclick="redirect('/settings');"/>
        </nav>
        <nav id="channel_nav">
          <div class="channel_item">
            <img src="https://cdn.discordapp.com/avatars/610282858418012161/e8e1f22001b4bbc086cc93fbe8a3ec83.png?size=256" class="channel_thumbnail"/>
            <span class="channel_label">Drew</span>
            <span class="channel_close">&#10006;</span>
          </div>
          <div class="channel_item">
            <img src="https://cdn.discordapp.com/avatars/610282858418012161/e8e1f22001b4bbc086cc93fbe8a3ec83.png?size=256" class="channel_thumbnail"/>
            <span class="channel_label">Drew</span>
            <span class="channel_close">&#10006;</span>
          </div>
          <div class="channel_item">
            <img src="https://cdn.discordapp.com/avatars/610282858418012161/e8e1f22001b4bbc086cc93fbe8a3ec83.png?size=256" class="channel_thumbnail"/>
            <span class="channel_label">Drew</span>
            <span class="channel_close">&#10006;</span>
          </div>
          <div class="channel_item">
            <img src="https://cdn.discordapp.com/avatars/610282858418012161/e8e1f22001b4bbc086cc93fbe8a3ec83.png?size=256" class="channel_thumbnail"/>
            <span class="channel_label">Drew</span>
            <span class="channel_close">&#10006;</span>
          </div>
          <div class="channel_item">
            <img src="https://cdn.discordapp.com/avatars/610282858418012161/e8e1f22001b4bbc086cc93fbe8a3ec83.png?size=256" class="channel_thumbnail"/>
            <span class="channel_label">Drew</span>
            <span class="channel_close">&#10006;</span>
          </div>
          <div class="channel_item">
            <img src="https://cdn.discordapp.com/avatars/610282858418012161/e8e1f22001b4bbc086cc93fbe8a3ec83.png?size=256" class="channel_thumbnail"/>
            <span class="channel_label">Drew</span>
            <span class="channel_close">&#10006;</span>
          </div>
        </nav>
      </div>
    </div>
  </body>
</html>
