<?php
require_once "phpmailer/PHPMailerAutoload.php";
require_once "Database.php";
$mail = new PHPMailer();

//$mail->isSMTP();
//
//$mail->Host = "smtp.mail.ru";
//$mail->SMTPAuth = true;
//$mail->Username = "p_opalev";
//$mail->Password = "p4815162342";
//$mail->SMTPSecure = "ssl";
//$mail->Port = "465";
//
//$mail->CharSet = "UTF-8";
//$mail->From = "p_opalev@mail.ru";
//$mail->FromName = "Pavel";
////$mail->addAddress('opalevp77@gmail.com');
////$mail->addCC('opalevp77@gmail.com');
//
//$mail->isHTML(true);
//
//$mail->Subject = "Tema pisma";
//$mail->Body = "Hello google";
//$mail->AltBody = "Hello google";
//
//
//if ($mail->send()) {
//    echo 'mail send';
//} else {
//    echo 'mail not send';
//    echo "erorr: " . $mail->ErrorInfo;
//}



//$mail = new PHPMailer();
//
//
//$mail->isSMTP();
//
//$mail->Host = "smtp.mail.ru";
//$mail->SMTPAuth = true;
//$mail->Username = "p_opalev";
//$mail->Password = "p4815162342";
//$mail->SMTPSecure = "ssl";
//$mail->Port = "465";
//
//$mail->CharSet = "UTF-8";
//$mail->From = "p_opalev@mail.ru";
//$mail->FromName = "Pavel";
//$mail->addAddress("p_opalev@mail.ru");
////$mail->addCC('opalevp77@gmail.com');
//
//$mail->Subject = "Tema pisma";
//$mail->Body = "Hello google";
//$mail->AltBody = "Hello google";
//$link = mysqli_connect('localhost','root','','test','3306');
////$db = mysqli_select_db($link,'test');
//$sql=mysqli_query($link,"SELECT email FROM test ");
//
//while($row=mysqli_fetch_array($sql,MYSQLI_ASSOC))
//
//{
//
//    $mail->AddBCC($row['email']);
//
//}
//
//$mail->IsHTML(true);
////
////$mail->Subject = $_POST['subj']; // subject
////
////$mail->Body = $_POST['mail']; // message
//
//$mail->Send();
//
//$mail->ClearBCCs();

abstract class Mail{

    public $mysqli;

    public function __construct()
    {

        return $this->mysqli = Database::getInstance()->getConnection();

    }

    abstract function send();

}

class MailRu extends Mail{
    public function send()
    {
        $mail = new PHPMailer();


        $mail->isSMTP();

        $mail->Host = "smtp.mail.ru";
        $mail->SMTPAuth = true;
        $mail->Username = "p_opalev";
        $mail->Password = "p4815162342";
        $mail->SMTPSecure = "ssl";
        $mail->Port = "465";

        $mail->CharSet = "UTF-8";
        $mail->From = "p_opalev@mail.ru";
        $mail->FromName = "Pavel";
        $mail->addAddress("");


        $mail->Subject = "Tema pisma";
        $mail->Body = "Hello google";
        $mail->AltBody = "Hello google";
//        $link = mysqli_connect('localhost','root','','test','3306');

//        $sql=mysqli_query($link,"SELECT email FROM test WHERE email LIKE '%mail.ru'" );

        $sql_query = "SELECT email FROM test WHERE email LIKE '%mail.ru'";

        $row = $this->mysqli->query($sql_query);

        foreach($row as $value){
            $mail->AddBCC($value['email']);
        }
//        while($row = $this->mysqli->($sql_query))
//
//        {
//
//            $mail->AddBCC($row['email']);
//
//
//        }

        $mail->IsHTML(true);

        $mail->Send();

        $mail->ClearBCCs();

    }
}
class Gmail extends Mail{
    public function send()
    {
        // TODO: Implement send() method.
        $mail = new PHPMailer();


        $mail->isSMTP();

        $mail->Host = "smtp.gmail.com";
        $mail->SMTPDebug = 2;
        $mail->SMTPAuth = true;
        $mail->Username = "opalevp77@gmail.com";
        $mail->Password = "p4815162342";
        $mail->SMTPSecure = "ssl;";
        $mail->Port = "465";

        $mail->CharSet = "UTF-8";
        $mail->From = "p_opalev@mail.ru";
        $mail->FromName = "Pavel";
        $mail->addAddress("opalevp77@gmail.com");
        $mail->AddReplyTo('p_opalev@mail.ru');

        $mail->Subject = "Tema pisma";
        $mail->Body = "Hello google";
        $mail->AltBody = "Hello google";
//        $link = mysqli_connect('localhost','root','','test','3306');

//        $sql=mysqli_query($link,"SELECT email FROM test WHERE email LIKE '%gmail.com'");
//
//        while($row=mysqli_fetch_array($sql,MYSQLI_ASSOC))
//
//        {
//
//            $mail->AddBCC($row['email']);
//
//        }

        $sql_query = "SELECT email FROM test WHERE email LIKE '%gmail.com'";

        $row = $this->mysqli->query($sql_query);

        foreach($row as $value){
            $mail->AddBCC($value['email']);
        }

        $mail->IsHTML(true);

        $mail->Send();

        $mail->ClearBCCs();
    }
}

class MailFactory{

    public static function create($email)
    {
        if ($email == 'gmail.com') {
            return new Gmail($email);
        } elseif($email == 'mail.ru') {
            return new MailRu($email);
        }else
            return "Error";
    }

}

$create = MailFactory::create('gmail.com');
$create->send();

