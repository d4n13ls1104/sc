<?php
include '../_util/whitelist.php';
session_start();

if(!isset($_SESSION["uid"])) header("/login");
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Sandchat</title>
    <meta charset="utf-8"/>
      <link rel="shortcut icon" href="../_util/favicon.ico"/>
      <link rel="stylesheet" href="styles.css"/>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"/>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  </head>
  <body>
    <div id="banner" class="container-fluid">
      <img src="../img/sandchatlogo.png" id="logo" draggable="false"/>
      <div class="items-right">
        <div style="display:table-cell;vertical-align:middle;">
          <a id="logout" href="/_util/logout.php">LOGOUT</a>
        </div>
      </div>
    </div>
    <div id="layout-wrapper">
      <div id="contact-wrapper">
        <div class="contact-item">
          <img class="contact-avatar" src="../img/sandchatlogo.png"/>
          <span class="contact-label">Sand Tee Global</span>
        </div>
      </div>
      <div id="chat-wrapper" align="center">
          <input id="message-input" type="text" name="message" placeholder="Message Sand Tee Global"/>
      </div>
    </div>
  </body>
</html>
