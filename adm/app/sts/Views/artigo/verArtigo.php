<?php
if (!defined('URL')) {
    header("Location: /");
    exit();
}
if (!empty($this->Dados['dados_Artigo'][0])) {
    extract($this->Dados['dados_Artigo'][0]);
    ?>
    <div class="content p-1">
        <div class="list-group-item">
            <div class="d-flex">
                <div class="mr-auto p-2">
                    <h2 class="display-4 titulo">Ver Artigo</h2>
                </div>
                <div class="p-2">
                    <span class="d-none d-md-block">
                        <?php
                        if ($this->Dados['botao']['list_art']) {
                            echo "<a href='" . URLADM . "artigo/listar' class='btn btn-outline-info btn-sm'>Listar</a> ";
                        }
                        if ($this->Dados['botao']['edit_art']) {
                            echo "<a href='" . URLADM . "editar-artigo/edit-artigo/$id' class='btn btn-outline-warning btn-sm'>Editar</a> ";
                        }
                        if ($this->Dados['botao']['edit_autor_art']) {
                            echo "<a href='" . URLADM . "editar-autor-artigo/edit-autor-artigo/$id' class='btn btn-outline-warning btn-sm'>Editar Autor</a> ";
                        }
                        if ($this->Dados['botao']['del_art']) {
                            echo "<a href='" . URLADM . "apagar-artigo/apagar-artigo/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
                        }
                        ?>
                    </span>
                    <div class="dropdown d-block d-md-none">
                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                            <?php
                            if ($this->Dados['botao']['list_art']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "artigo/listar'>Listar</a>";
                            }
                            if ($this->Dados['botao']['edit_art']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "editar-artigo/edit-artigo/$id'>Editar</a>";
                            }
                            if ($this->Dados['botao']['edit_autor_art']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "editar-autor-artigo/edit-autor-artigo/$id'>Editar Autor</a>";
                            }
                            if ($this->Dados['botao']['del_art']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "apagar-artigo/apagar-artigo/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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
            <h2 class="display-4 titulo">Conteúdo</h2>
            <dl class="row">
                <dt class="col-sm-3">Imagem</dt>
                <dd class="col-sm-9">                    
                    <?php
                    if (!empty($imagem)) {
                        echo "<img src='" . URL . "assets/imagens/artigo/" . $id . "/" . $imagem . "' width='250' height='120'>";
                    }
                    ?>
                </dd>

                <dt class="col-sm-3">ID</dt>
                <dd class="col-sm-9"><?php echo $id; ?></dd>

                <dt class="col-sm-3">Titulo</dt>
                <dd class="col-sm-9"><?php echo $titulo; ?></dd> 

                <dt class="col-sm-3">Prévia</dt>
                <dd class="col-sm-9"><?php echo $descricao; ?></dd> 

                <dt class="col-sm-3">Conteúdo</dt>
                <dd class="col-sm-9"><?php echo $conteudo; ?></dd>                 

                <dt class="col-sm-3">Resumo Público</dt>
                <dd class="col-sm-9"><?php echo $resumo_publico; ?></dd>

                <dt class="col-sm-3">Situação</dt>
                <dd class="col-sm-9">
                    <span class="badge badge-<?php echo $cor_cr; ?>"><?php echo $nome_sit; ?></span>
                </dd>

                <dt class="col-sm-3">Tipo do Artigo</dt>
                <dd class="col-sm-9"><?php echo $nome_tpart; ?></dd> 

                <dt class="col-sm-3">Categoria do Artigo</dt>
                <dd class="col-sm-9"><?php echo $nome_catart; ?></dd> 

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
            
            <hr>
            <h2 class="display-4 titulo">SEO</h2>
            <dl class="row">
                <dt class="col-sm-3">Slug</dt>
                <dd class="col-sm-9"><?php echo $slug; ?></dd> 

                <dt class="col-sm-3">Palavra Chave</dt>
                <dd class="col-sm-9"><?php echo $keywords; ?></dd> 

                <dt class="col-sm-3">Descrição</dt>
                <dd class="col-sm-9"><?php echo $description; ?></dd> 

                <dt class="col-sm-3">Titulo do Site</dt>
                <dd class="col-sm-9"><?php echo $author; ?></dd>  

                <dt class="col-sm-3">Situação Buscadores</dt>
                <dd class="col-sm-9"><?php echo $tipo_rob ." - " . $nome_rob; ?></dd> 

                <dt class="col-sm-3">Autor do Artigo</dt>
                <dd class="col-sm-9"><?php echo $nome_user; ?></dd> 

                <dt class="col-sm-3">Quantidade Acessos</dt>
                <dd class="col-sm-9"><?php echo $qnt_acesso; ?></dd> 
            </dl>


        </div>
    </div>
    <?php
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Artigo não encontrado!</div>";
    $UrlDestino = URLADM . 'artigo/listar';
    header("Location: $UrlDestino");
}
