<?php
if (!defined('URL')) {
    header("Location: /");
    exit();
}
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Perfil</h2>
            </div>
            <div class="p-2">
                <span class="d-none d-md-block">
                    <a href="<?php echo URLADM . 'editar-perfil/alt-perfil'; ?>" class="btn btn-outline-warning btn-sm">Editar</a>
                    <a href="<?php echo URLADM . 'alterar-senha/alt-senha'; ?>" class="btn btn-outline-danger btn-sm">Editar a Senha</a>
                </span>
                <div class="dropdown d-block d-md-none">
                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">    
                        <a class="dropdown-item" href="<?php echo URLADM . 'editar-perfil/alt-perfil'; ?>">Editar</a>
                        <a class="dropdown-item" href="<?php echo URLADM . 'alterar-senha/alt-senha'; ?>">Editar a Senha</a>
                    </div>
                </div>
            </div>
        </div><hr>
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <dl class="row">
            <?php
            if (!empty($this->Dados['dados_perfil'][0])) {
                extract($this->Dados['dados_perfil'][0]);
                ?>
                <dt class="col-sm-3">Foto</dt>
                <dd class="col-sm-9">                    
                    <?php
                    if (!empty($_SESSION['usuario_imagem'])) {
                        echo "<img src='" . URLADM . "assets/imagens/usuario/" . $_SESSION['usuario_id'] . "/" . $_SESSION['usuario_imagem'] . "' witdh='150' height='150'>";
                    } else {
                        echo "<img src='" . URLADM . "assets/imagens/usuario/icone_usuario.png' witdh='150' height='150'>";
                    }
                    ?>
                </dd>

                <dt class="col-sm-3">ID</dt>
                <dd class="col-sm-9"><?php echo $id; ?></dd>

                <dt class="col-sm-3">Nome</dt>
                <dd class="col-sm-9"><?php echo $nome; ?></dd>                

                <dt class="col-sm-3">Apelido</dt>
                <dd class="col-sm-9"><?php echo $apelido; ?></dd>   

                <dt class="col-sm-3">E-mail</dt>
                <dd class="col-sm-9"><?php echo $email; ?></dd>

                <dt class="col-sm-3">Usuário</dt>
                <dd class="col-sm-9"><?php echo $usuario; ?></dd>
                <?php
            }
            ?>
        </dl>
    </div>
</div>
