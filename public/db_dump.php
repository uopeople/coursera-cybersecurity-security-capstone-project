<html lang=en>

<?php
include __DIR__ . '/../setup.php';

use lib\db\Dump;

?>

<head>
    <meta http-equiv=Content-Type content="text/html; charset=utf-8">
    <meta name=viewport content="width=device-width, initial-scale=1"/>
    
    <meta name=author content="Daniel Petrescu">
    <meta name=author content="Claudio Kressibucher">
    <meta name=author content="Giuseppe Arcidiacono">
    <title>Dump | Messaging System</title>

    <!-- CSS -->
    <link rel=stylesheet media=all href=css/index.css>

    <!-- Fonts -->
    <link rel=stylesheet href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
</head>

<body>
<div id="header">
    <h1>DB Dump</h1>
</div>
<div class="container main">
        <div>
            
            <div>
            <?php
            if (isset($_SESSION['user']))
            {
                $user = $_SESSION["user"];
                $userid = $user->getId();
                $dump = new Dump();
                $filename = $dump->loadAllrowsFromAllTable();
                if(!file_exists($filename))
                {
                    header('Location: /login.php', true, 303);
                    exit();
                }

            }
            else 
            {
                header('Location: /login.php', true, 303);
                exit();
            }       
            
           ?>
           
        <a href="<?php echo $filename ?>">Dump Database </a>
            </div>
</body>

</html>