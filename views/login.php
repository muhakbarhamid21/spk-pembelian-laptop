<?php
session_start();
if (isset($_SESSION['success_message_register'])) {
  echo "<script>alert('" . $_SESSION['success_message_register'] . "');</script>";
  unset($_SESSION['success_message_register']);
}

if (!empty($_SESSION['message'])) {
  $message = $_SESSION['message'];
  echo "<script>alert('" . $_SESSION['message'] . "');</script>";
}
session_unset();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href='../assets/css/bootstrap.css' rel='stylesheet'>
  <link href='../assets/css/customStyle.css' rel='stylesheet'>
  <link rel="icon" href="../assets/img/favicon.ico" type="image/x-icon">
  <title>Login</title>
  <style>
    body {
      background: linear-gradient(135deg, #89fffd, #ef32d9);
      font-family: 'Poppins', sans-serif;
    }

    .formLogin {
      background: white;
      padding: 2rem;
      border-radius: 15px;
      box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    .formLogin img {
      width: 80px;
      margin-bottom: 1rem;
    }

    #labelLogin {
      font-size: 1.5rem;
      font-weight: 600;
      color: #333;
      margin-bottom: 1.5rem;
    }

    .form-control {
      margin-bottom: 1rem;
      border-radius: 10px;
      box-shadow: inset 0 3px 6px rgba(0, 0, 0, 0.1);
    }

    .btn-primary {
      background: #ef32d9;
      background: linear-gradient(135deg, #ef32d9, #89fffd);
      border: none;
      font-weight: 600;
      padding: 0.75rem;
      border-radius: 10px;
      transition: background 0.3s ease;
    }

    .btn-primary:hover {
      background: linear-gradient(135deg, #89fffd, #ef32d9);
    }

    .btn-secondary {
      margin-top: 1rem;
      background: #ffffff;
      color: #ef32d9;
      border: 2px solid #ef32d9;
      font-weight: 600;
      padding: 0.75rem;
      border-radius: 10px;
      transition: background 0.3s ease, color 0.3s ease;
    }

    .btn-secondary:hover {
      background: #ef32d9;
      color: #ffffff;
    }

    .alert {
      margin-bottom: 1rem;
      border-radius: 10px;
      font-weight: 500;
    }
  </style>
</head>

<body>
  <div class='container-fluid d-flex vh-100 justify-content-center align-items-center'>
    <div class='formLogin'>
      <div id='labelLogin'>Login</div>
      <form method='POST' action='../controllers/cek_login.php'>
        <input type='text' class='form-control' name='username' placeholder='Username' required>
        <input type='password' class='form-control' name='password' placeholder='Password' required>
        <input type='submit' class='btn btn-primary w-100' value='Login'>
      </form>
      <div class='mt-3'><a href='register.php' class='text-decoration-none' style='color: #ef32d9; font-weight: 600;'>Belum punya akun? Register di sini.</a></div>
    </div>
  </div>
</body>

</html>