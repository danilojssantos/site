<body class="text-center">
    <form class="form-signin" method="POST" action="">
        <img class="mb-4" src="<?php echo URLADM . 'assets/imagens/logo_login/logo.png'; ?>" alt="Celke" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Atualizar a Senha</h1>
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        if (isset($this->Dados['form'])) {
            $valorForm = $this->Dados['form'];
        }
        ?>
        <div class="form-group">
            <label>Senha</label>
            <input name="senha" type="password" class="form-control" placeholder="Digite a senha">
        </div>
        <input name="AtualSenha" type="submit" class="btn btn-lg btn-warning btn-block" value="Atualizar">
        <p class="text-center">Lembrou? <a href="<?php echo URLADM . 'login/acesso' ?>">Clique aqui</a> para logar</p>
    </form>
</body>
