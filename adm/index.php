<?php
ob_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <?php
    require './core/Config.php';
    require './vendor/autoload.php';

    use Core\ConfigController as Home;

    $Url = new Home();
    $Url->carregar();
    ?>
</html>
