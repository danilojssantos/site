<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">        
        <title>Login</title>
        <link rel="icon" href="<?php echo URLADM . 'assets/imagens/icone/favicon.png'; ?>">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo URLADM . 'assets/css/signin.css'; ?>">
    </head>
    <body class="text-center">
        <form class="form-signin" method="POST" action="">
            <img class="mb-4" src="<?php echo URLADM . 'assets/imagens/logo_login/logo.png'; ?>" alt="Login" width="72" height="72">
            <h1 class="h3 mb-3 font-weight-normal">Área Restrita</h1>
            <?php
            
            //var_dump($this->Dados['form']);
            if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
            if (isset($this->Dados['form'])) {
                $valorForm = $this->Dados['form'];
            }

            ?>

            <div class="form-group">
                <label>Usuário</label>
                <input name="usuario" type="text" class="form-control" placeholder="Digite o usuário" value="<?php if(isset($valorForm['usuario'])) {echo $valorForm['usuario']; } ?>">               
            </div>
            <div class="form-group">
                <label>Senha</label>
                <input name="senha" type="password" class="form-control" placeholder="Digite a senha">
            </div>
            <input name="SendLogin" type="submit" class="btn btn-lg btn-primary btn-block" value="Acessar">
            <p class="text-center">Esqueceu a senha?</p>
        </form>
    </body>
</html>