<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vagrant</title>
</head>

<body>
    <h1>Testando conexão com MySQL</h1>
    <?php
    $servername = "192.168.56.6";
    $username = "phpuser";
    $password = "pass";

    $con = mysqli_connect($servername, $username, $password);

    if ($con->connect_error) {
        die("Falho a conexão com o MySQL.");
    }

    echo "Conectado com o <b>MySQL</b>.";
    ?>
</body>

</html>