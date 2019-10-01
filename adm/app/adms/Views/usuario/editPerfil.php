<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Editar Perfil</h2>
            </div>
            <div class="p-2">
                <a href="<?php echo URLADM . 'ver-perfil/perfil'; ?>" class="btn btn-outline-primary btn-sm">Visualizar</a>
            </div>
        </div><hr>
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        if (isset($this->Dados['form'])) {
            $valorForm = $this->Dados['form'];
        }
        if (isset($this->Dados['form'][0])) {
            $valorForm = $this->Dados['form'][0];
        }
        ?>
        <form method="POST" action=""> 
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Nome</label>
                    <input name="nome" type="text" class="form-control" placeholder="Digite o nome completo" value="<?php if (isset($valorForm['nome'])) {
            echo $valorForm['nome'];
        } ?>">
                </div>
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Apelido</label>
                    <input name="apelido" type="text" class="form-control" placeholder="Como gostaria de ser chamado" value="<?php if (isset($valorForm['apelido'])) {
            echo $valorForm['apelido'];
        } ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> E-mail</label>
                    <input name="email" type="text" class="form-control" placeholder="Seu melhor e-mail" value="<?php if (isset($valorForm['email'])) {
            echo $valorForm['email'];
        } ?>">
                </div>
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Usuário</label>
                    <input name="usuario" type="text" class="form-control" id="nome" placeholder="Digite o usuário" value="<?php if (isset($valorForm['usuario'])) {
            echo $valorForm['usuario'];
        } ?>">
                </div>
            </div>
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EdiPerfil" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
