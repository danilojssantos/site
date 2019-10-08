<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Editar Senha</h2>
            </div>
            <?php
            if ($this->Dados['botao']['vis_usuario']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'ver-usuario/ver-usuario/' . $this->Dados['form']; ?>" class="btn btn-outline-primary btn-sm">Visualizar</a>
                </div>
                <?php
            }
            ?>

        </div><hr>
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <form method="POST" action="">   
            <input name="id" type="hidden" value="<?php echo $this->Dados['form']; ?>">

            <div class="form-group">
                <label>Senha</label>
                <input name="senha" type="password" class="form-control" placeholder="Senha com mínimo 6 caracteres">
            </div>
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditSenha" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
