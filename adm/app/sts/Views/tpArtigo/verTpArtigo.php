<?php
if (!defined('URL')) {
    header("Location: /");
    exit();
}
if (!empty($this->Dados['dados_TpArtigo'][0])) {
    extract($this->Dados['dados_TpArtigo'][0]);
    ?>
    <div class="content p-1">
        <div class="list-group-item">
            <div class="d-flex">
                <div class="mr-auto p-2">
                    <h2 class="display-4 titulo">Ver Tipo de Artigo</h2>
                </div>
                <div class="p-2">
                    <span class="d-none d-md-block">
                        <?php
                        if ($this->Dados['botao']['list_tp_artigo']) {
                            echo "<a href='" . URLADM . "tp-artigo/listar' class='btn btn-outline-info btn-sm'>Listar</a> ";
                        }
                        if ($this->Dados['botao']['edit_tp_artigo']) {
                            echo "<a href='" . URLADM . "editar-tp-artigo/edit-tp-artigo/$id' class='btn btn-outline-warning btn-sm'>Editar</a> ";
                        }
                        if ($this->Dados['botao']['del_tp_artigo']) {
                            echo "<a href='" . URLADM . "apagar-tp-artigo/apagar-tp-artigo/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
                        }
                        ?>
                    </span>
                    <div class="dropdown d-block d-md-none">
                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                            <?php
                            if ($this->Dados['botao']['list_tp_artigo']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "tp-artigo/listar'>Listar</a>";
                            }
                            if ($this->Dados['botao']['edit_tp_artigos']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "editar-tp-artigo/edit-tp-artigo/$id'>Editar</a>";
                            }
                            if ($this->Dados['botao']['del_tp_artigo']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "apagar-tp-artigo/apagar-tp-artigo/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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
    $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Robots da Página não encontrado!</div>";
    $UrlDestino = URLADM . 'robots/listar';
    header("Location: $UrlDestino");
}
