use PHPMailer\PHPMailer\Exception;


// Load Composer's autoloader
//require 'vendor/autoload.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
if(isset($_POST['btn'])){
  extract($_POST);
  //smtp email passados pelo post
  $_smtps = explode(PHP_EOL, $smtp);
  $_emails = explode(PHP_EOL, $emails);
  $msg = $_POST['msg'];
  $from = $_POST['setfrom'];
  $y = count($_smtps);
  $x = count($_emails);
  $c = 0;
  $sucess = 0;
  $erro = 0;
  //condiçao do while
  $contador = $x / $y;
  foreach ($_smtps as $_smtp) {
    $server = explode(";", $_smtp)[0];
    $user = explode(";", $_smtp)[1];
    $pass = explode(";", $_smtp)[2];
    $port = explode(";", $_smtp)[3];
    $i= 0;
    while ($i<$contador) {
      $envio = $_emails[$c];
      $_email =explode(";", $envio)[0];
      $_nome = explode(";", $envio)[1];
      $conteudo = $msg;
      $nome = "%NOME%";
      $_msg =str_replace($nome, $_nome, $conteudo);
      $emailclient = explode(";", $envio)[0];
      $nameclient = explode(";", $envio)[1];
    // Instantiation and passing `true` enables exceptions
      $mail = new PHPMailer(true);

      try {
          //Server settings
          $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
          $mail->isSMTP();                                            // Send using SMTP
          $mail->Host       = $server;                    // Set the SMTP server to send through
          $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
          $mail->Username   = $user;                     // SMTP username
          $mail->Password   = $pass;                               // SMTP password
          $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
          $mail->Port       = $port;                                   // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

          //Recipients
          $mail->setFrom('contato@email.com', $from);
          $mail->addAddress($emailclient, $nameclient );     // Add a recipient
         // $mail->addAddress($emailclient);               // Name is optional

          // Attachments
        // $mail->addAttachment($path_file);         // Add attachments
         //$mail->addAttachment($arquivo);    // Optional name

          // Content
          $mail->isHTML(true);                                  // Set email format to HTML
          $mail->Subject = $assunto;
          $mail->Body    = $_msg;
          $mail->AltBody = 'Para visualizar corretamente, use um visualizador de e-mail com suporte a HTML';

          $mail->send();
          $sucess ++;
      } catch (Exception $e) {
          $erro ++;
          $data = date("H:i:s");
          $log ="Erro: ".$_email." "."Envio: ".$c." "."smtp: ".$server." ".$user." ".$data;
      }     
        $c ++;
        $i ++;
        }
      }
    }

?>
