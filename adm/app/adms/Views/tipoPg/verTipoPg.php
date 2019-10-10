<?php
if (!defined('URL')) {
    header("Location: /");
    exit();
}
if (!empty($this->Dados['dados_tpg'][0])) {
    extract($this->Dados['dados_tpg'][0]);
    ?>
    <div class="content p-1">
        <div class="list-group-item">
            <div class="d-flex">
                <div class="mr-auto p-2">
                    <h2 class="display-4 titulo">Ver Tipo de Página</h2>
                </div>
                <div class="p-2">
                    <span class="d-none d-md-block">
                        <?php
                        if ($this->Dados['botao']['list_tpg']) {
                            echo "<a href='" . URLADM . "tipo-pg/listar' class='btn btn-outline-info btn-sm'>Listar</a> ";
                        }
                        if ($this->Dados['botao']['edit_tpg']) {
                            echo "<a href='" . URLADM . "editar-tipo-pg/edit-tipo-pg/$id' class='btn btn-outline-warning btn-sm'>Editar</a> ";
                        }
                        if ($this->Dados['botao']['del_tpg']) {
                            echo "<a href='" . URLADM . "apagar-tipo-pg/apagar-tipo-pg/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
                        }
                        ?>
                    </span>
                    <div class="dropdown d-block d-md-none">
                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                            <?php
                            if ($this->Dados['botao']['list_tpg']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "tipo-pg/listar'>Listar</a>";
                            }
                            if ($this->Dados['botao']['edit_tpg']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "editar-tipo-pg/edit-tipo-pg/$id'>Editar</a>";
                            }
                            if ($this->Dados['botao']['del_tpg']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "apagar-tipo-pg/apagar-tipo-pg/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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

                <dt class="col-sm-3">ID</dt>
                <dd class="col-sm-9"><?php echo $id; ?></dd>

                <dt class="col-sm-3">Nome</dt>
                <dd class="col-sm-9"><?php echo $nome; ?></dd>

                <dt class="col-sm-3">Tipo</dt>
                <dd class="col-sm-9"><?php echo $tipo; ?></dd>

                <dt class="col-sm-3">Ordem</dt>
                <dd class="col-sm-9"><?php echo $ordem; ?></dd>

                <dt class="col-sm-3">Observação</dt>
                <dd class="col-sm-9"><?php echo $obs; ?></dd>

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
    $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Grupo de página não encontrado!</div>";
    $UrlDestino = URLADM . 'grupo-pg/listar';
    header("Location: $UrlDestino");
}
