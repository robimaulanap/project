<?php
    $conn = mysqli_connect("localhost", "root", "", "mailer");

    function query($query){
        global $conn;
        $result = mysqli_query($conn, $query);
        // $rows = [];
        // while ($row = mysqli_fetch_assoc($result)) {
        //     $rows[] = $row;
        // }
        return $result;
    }
    

    function register($data){
        global $conn;
        
        $username = strtolower(stripslashes($data["username"]));
        $email = $data["email"];
        $password = mysqli_real_escape_string($conn, $data["password"]);
        $password2 = mysqli_real_escape_string($conn, $data["password2"]);

        // cek emal telah terdaftar atau belum
        $result = mysqli_query($conn, "SELECT email FROM user WHERE email = '$email'");
        if ( mysqli_fetch_assoc($result) ) {
            echo "<script>
                alert('Gagal, Email telah terdaftar');
            </script>";
            return false;
        }

        
        // cek konfirmasi password
        if ($password !== $password2) {
            echo "<script> alert('Gagal, Password tidak sesuai') </script>";
            return false;
        }

        // encripsi password
        $password = password_hash($password, PASSWORD_DEFAULT);

        // upload data ke database
        mysqli_query($conn, "INSERT INTO user VALUES('', '$username', '$email', '$password')");

        // mengembalikan nilai 1(benar)/-1(salah)
        return mysqli_affected_rows($conn);
    }

    function tambah($data){
        // var_dump($data);
        global $conn;

        $nama = htmlspecialchars( $data["nama"] );
        $email = htmlspecialchars( $data["email"] );
        $idUser = $data[0];
    
        $query = "INSERT INTO data
                    VALUES ('', '$idUser', '$nama', '$email')
                ";
        mysqli_query($conn, $query);
    
        return mysqli_affected_rows($conn);
    }

    function hapus($id){
        global $conn;
        mysqli_query($conn, "DELETE FROM data WHERE id = $id");
        return mysqli_affected_rows($conn);
    }

    
    use PHPMailer\PHPMailer\PHPMailer;    
    function sendEmail($data){
        require_once 'PHPMailer/src/Exception.php';
        require_once 'PHPMailer/src/PHPMailer.php';
        require_once 'PHPMailer/src/SMTP.php';
        $mail = new PHPMailer();

        $emailUser = $_SESSION['emailUser'];
        $password = $_SESSION['password'];
        $userId = $_SESSION['idUser'];    
        $subject = $data['subject'];
        $pesan = $data['pesan'];
        $file = $data['file'];
        

        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = $emailUser;
        $mail->Password   = $password;
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;

        $mail->setFrom('robi.m.putra@gmail.com', 'Mailer Broadcast');
        $dataEmail = query("SELECT * FROM data WHERE id_user= '$userId' ORDER BY id DESC");
        foreach($dataEmail as $row){
            $mail->addAddress($row['email'], $row['name']);
        }
        // $mail->addAddress('cssimgo@gmail.com', 'Joe User');
            
        //Content
        $mail->isHTML(true);      //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $pesan;
        $mail->addAttachment($file);

        $mail->send();
        echo 'Message has been sent';
        if($mail->Send()){
            echo "<script>alert('Kirim Pesan Sukses')</script>";
            echo "<meta http-equiv='refresh' content='0; url=index.php'>";
        }else{
            echo "<script>alert('GAGAL')</script>";
            echo "<meta http-equiv='refresh' content='0; url=index.php'>";
        }

        // catch (Exception $e) {
        //     echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        // }
    }

?>