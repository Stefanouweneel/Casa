<?php
if(isset($_POST['submit']) && !empty($_POST['submit'])) {
  if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
    $secret = '6LdAJB0UAAAAAEIJNKw83-PqlvzqC2XMoFHWg_UF';

    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
    $responseData = json_decode($verifyResponse);
    if($responseData->success) {

      $mailTo    = "info@casahypotheken.nl";
      $onderwerp = "bericht vanaf website";
      $afzender  = "info@casahypotheken.nl";

      $aanhef    = (ISSET($_POST["aanhef"]))    ? $_POST["aanhef"] : "";
      $naam    = (ISSET($_POST["naam"]))    ? $_POST["naam"] : "";
      $adres    = (ISSET($_POST["adres"]))    ? $_POST["adres"] : "";
      $postcode = (ISSET($_POST["postcode"]))    ? $_POST["postcode"] : "";
      $plaats    = (ISSET($_POST["plaats"]))    ? $_POST["plaats"] : "";
      $email   = (ISSET($_POST["email"]))   ? $_POST["email"] : "";
      $tel     = (ISSET($_POST["tel"]))     ? $_POST["tel"] : "";
      $bericht = (ISSET($_POST["bericht"])) ? $_POST["bericht"] : "";

      if($aanhef != "" && $naam != "" && $adres != "" && $postcode != "" && $plaats != "" && $email != "" && $tel != "" && $bericht != "") {
      	$data .= "Aanhef: $aanhef\n";
      	$data .= "Naam: $naam\n";
      	$data .= "Adres: $adres\n";
      	$data .= "Postcode: $postcode\n";
      	$data .= "Plaats: $plaats\n";
      	$data .= "Email: $email\n";
      	$data .= "Telefoon: $tel\n\n";
      	$data .= preg_replace("/\n/","\r\n",$bericht);

      	mail($mailTo,$onderwerp,$data,"From: $afzender");
      	$succMsg = "<p><b>Hartelijk dank. Uw bericht is verzonden. Wij nemen zo snel mogelijk contact met u op.</b></p>";
      }
      else {
      $errMsg = "<p><b>U heeft nog niet alle velden ingevuld.</b></p>";
      }
    }
  }
  else {
    $errMsg = "<p><b>Klik alstublieft ook de reCAPTCHA box aan.</b></p>";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>CASA Bedrijfshypotheken</title>
  <link href="css/style.css" rel="stylesheet">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/sidebar.css" rel="stylesheet">
</head>
<body>
  <form method="post" action="contact.php">

    <?php echo $succMsg ?>
    <?php echo $errMsg ?>

    <label class="label-text">Aanhef:</label>
    <input class="text" name="aanhef"><br>

    <label class="label-text">Naam:</label>
    <input class="text" name="naam"><br>

    <label class="label-text">Adres:</label>
    <input class="text" name="adres"><br>

    <label class="label-text">Postcode:</label>
    <input class="text" name="postcode"><br>

    <label class="label-text">Plaats:</label>
    <input class="text" name="plaats"><br>

    <label class="label-text">Telefoonummer:</label>
    <input class="text" name="tel"><br>

    <label class="label-text">Email-adres:</label>
    <input class="text" name="email"><br>

    <label class="label-text">Uw bericht:</label>
    <textarea class="textarea" name="bericht"></textarea><br>

    <div class="g-recaptcha" data-sitekey="6LdAJB0UAAAAAIz20KIjwYYgcEIwK6c_MGXqGI-i"></div><br>

    <input type="submit" name="submit" value="Verstuur">
  </form>
  <script src="js/jquery.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>
</html>
