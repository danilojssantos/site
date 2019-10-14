<?php
if (!defined('URL')) {
    header("Location: /");
    exit();
}
if (!empty($this->Dados['dados_pagina'][0])) {
    extract($this->Dados['dados_pagina'][0]);
    ?>
    <div class="content p-1">
        <div class="list-group-item">
            <div class="d-flex">
                <div class="mr-auto p-2">
                    <h2 class="display-4 titulo">Detalhes da Página</h2>
                </div>
                <div class="p-2">
                    <span class="d-none d-md-block">
                        <?php
                        if ($this->Dados['botao']['list_pagina']) {
                            echo "<a href='" . URLADM . "pagina-site/listar' class='btn btn-outline-info btn-sm'>Listar</a> ";
                        }
                        if ($this->Dados['botao']['edit_pagina']) {
                            echo "<a href='" . URLADM . "editar-pagina-site/edit-pagina-site/$id' class='btn btn-outline-warning btn-sm'>Editar</a> ";
                        }
                        if ($this->Dados['botao']['del_pagina']) {
                            echo "<a href='" . URLADM . "apagar-pagina-site/apagar-pagina-site/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
                        }
                        ?>
                    </span>
                    <div class="dropdown d-block d-md-none">
                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                            <?php
                            if ($this->Dados['botao']['list_pagina']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "pagin-sitea/listar'>Listar</a>";
                            }
                            if ($this->Dados['botao']['edit_pagina']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "editar-pagina-site/edit-pagina-site/$id'>Editar</a>";
                            }
                            if ($this->Dados['botao']['del_pagina']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "apagar-pagina-site/apagar-pagina-site/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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
                <dt class="col-sm-3">Imagem</dt>
                <dd class="col-sm-9">                    
                    <?php
                    if (!empty($imagem)) {
                        echo "<img src='" . URL . "assets/imagens/pagina/" . $id . "/" . $imagem . "' width='250' height='130'>";
                    }
                    ?>
                </dd>

                <dt class="col-sm-3">ID</dt>
                <dd class="col-sm-9"><?php echo $id; ?></dd>

                <dt class="col-sm-3">Classe</dt>
                <dd class="col-sm-9"><?php echo $controller; ?></dd>

                <dt class="col-sm-3">Endereço</dt>
                <dd class="col-sm-9"><?php echo $endereco; ?></dd>  

                <dt class="col-sm-3">Nome da Página</dt>
                <dd class="col-sm-9"><?php echo $nome_pagina; ?></dd>               

                <dt class="col-sm-3">Titulo</dt>
                <dd class="col-sm-9"><?php echo $titulo; ?></dd>              

                <dt class="col-sm-3">Observação</dt>
                <dd class="col-sm-9"><?php echo $obs; ?></dd>              

                <dt class="col-sm-3">Palavra Chave</dt>
                <dd class="col-sm-9"><?php echo $keywords; ?></dd>              

                <dt class="col-sm-3">Descrição</dt>
                <dd class="col-sm-9"><?php echo $description; ?></dd>              

                <dt class="col-sm-3">Empresa</dt>
                <dd class="col-sm-9"><?php echo $author; ?></dd>              

                <dt class="col-sm-3">Liberada no Menu</dt>
                <dd class="col-sm-9">
                    <?php 
                    if($lib_bloq == 1){
                        echo "<span class='badge badge-pill badge-success'>sim</span>";
                    }else{
                        echo "<span class='badge badge-pill badge-danger'>Não</span>";
                    }                    
                     ?>
                </dd>              

                <dt class="col-sm-3">Ordem</dt>
                <dd class="col-sm-9"><?php echo $ordem; ?></dd>              

                <dt class="col-sm-3">Tipo da Página</dt>
                <dd class="col-sm-9"><?php echo $tipo_tpgs . " - " . $nome_tpgs; ?></dd>        

                <dt class="col-sm-3">Página nos Buscadores</dt>
                <dd class="col-sm-9"><?php echo $tipo_rob . " - " . $nome_rob; ?></dd>

                <dt class="col-sm-3">Situação</dt>
                <dd class="col-sm-9">
                    <span class="badge badge-<?php echo $cor_cr; ?>"><?php echo $nome_sitpg; ?></span>
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
    $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Página não encontrada!</div>";
    $UrlDestino = URLADM . 'pagina/listar';
    header("Location: $UrlDestino");
}
