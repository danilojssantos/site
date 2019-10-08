<?php
if (!defined('URL')) {
    header("Location: /");
    exit();
}
if (!empty($this->Dados['dados_usuario'][0])) {
    extract($this->Dados['dados_usuario'][0]);
    ?>
    <div class="content p-1">
        <div class="list-group-item">
            <div class="d-flex">
                <div class="mr-auto p-2">
                    <h2 class="display-4 titulo">Ver Usuário</h2>
                </div>
                <div class="p-2">
                    <span class="d-none d-md-block">
                        <?php
                        if ($this->Dados['botao']['list_usuario']) {
                            echo "<a href='" . URLADM . "usuarios/listar' class='btn btn-outline-info btn-sm'>Listar</a> ";
                        }
                        if ($this->Dados['botao']['edit_usuario']) {
                            echo "<a href='" . URLADM . "editar-usuario/edit-usuario/$id' class='btn btn-outline-warning btn-sm'>Editar</a> ";
                        }
                        if ($this->Dados['botao']['edit_senha']) {
                            echo "<a href='" . URLADM . "editar-senha/edit-senha/$id' class='btn btn-outline-danger btn-sm'>Editar Senha</a> ";
                        }
                        if ($this->Dados['botao']['del_usuario']) {
                            echo "<a href='" . URLADM . "apagar-usuario/apagar-usuario/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
                        }
                        ?>
                    </span>
                    <div class="dropdown d-block d-md-none">
                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                            <?php
                            if ($this->Dados['botao']['list_usuario']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "usuarios/listar'>Listar</a>";
                            }
                            if ($this->Dados['botao']['edit_usuario']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "editar-usuario/edit-usuario/$id'>Editar</a>";
                            }
                            if ($this->Dados['botao']['edit_senha']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "editar-senha/edit-senha/$id'>Editar Senha</a>";
                            }
                            if ($this->Dados['botao']['del_usuario']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "apagar-usuario/apagar-usuario/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
                            }
                            ?>
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
                <dt class="col-sm-3">Foto</dt>
                <dd class="col-sm-9">                    
                    <?php
                    if (!empty($imagem)) {
                        echo "<img src='" . URLADM . "assets/imagens/usuario/" . $id . "/" . $imagem . "' witdh='150' height='150'>";
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

                <dt class="col-sm-3">Recuperar Senha</dt>
                <dd class="col-sm-9"><?php
                    if (!empty($recuperar_senha)) {
                        echo URLADM . "atual-senha/atual-senha?chave=" . $recuperar_senha;
                    }
                    ?></dd>

                <dt class="col-sm-3">Nível de Acesso</dt>
                <dd class="col-sm-9"><?php echo $nome_nivac; ?></dd>

                <dt class="col-sm-3">Situação</dt>
                <dd class="col-sm-9">
                    <span class="badge badge-<?php echo $cor_cr; ?>"><?php echo $nome_sit; ?></span>
                </dd>

                <dt class="col-sm-3">Inserido</dt>
                <dd class="col-sm-9"><?php echo date('d/m/Y H:i:s', strtotime($created)); ?></dd>

                <dt class="col-sm-3">Alterado</dt>
                <dd class="col-sm-9"><?php
                    if (!empty($modified)) {
                        echo date('d/m/Y H:i:s', strtotime($modified));
                    }
                    ?>
                </dd>
            </dl>


        </div>
    </div>
    <?php
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Usuário não encontrado!</div>";
    $UrlDestino = URLADM . 'usuarios/listar';
    header("Location: $UrlDestino");
}
