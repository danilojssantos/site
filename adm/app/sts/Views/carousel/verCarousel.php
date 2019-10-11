<?php
if (!defined('URL')) {
    header("Location: /");
    exit();
}
if (!empty($this->Dados['dados_carousel'][0])) {
    extract($this->Dados['dados_carousel'][0]);
    ?>
    <div class="content p-1">
        <div class="list-group-item">
            <div class="d-flex">
                <div class="mr-auto p-2">
                    <h2 class="display-4 titulo">Ver Carousel</h2>
                </div>
                <div class="p-2">
                    <span class="d-none d-md-block">
                        <?php
                        if ($this->Dados['botao']['list_carousel']) {
                            echo "<a href='" . URLADM . "carousel/listar' class='btn btn-outline-info btn-sm'>Listar</a> ";
                        }
                        if ($this->Dados['botao']['edit_carousel']) {
                            echo "<a href='" . URLADM . "editar-carousel/edit-carousel/$id' class='btn btn-outline-warning btn-sm'>Editar</a> ";
                        }
                        if ($this->Dados['botao']['del_carousel']) {
                            echo "<a href='" . URLADM . "apagar-carousel/apagar-carousel/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
                        }
                        ?>
                    </span>
                    <div class="dropdown d-block d-md-none">
                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ações
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar"> 
                            <?php
                            if ($this->Dados['botao']['list_carousel']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "carousel/listar'>Listar</a>";
                            }
                            if ($this->Dados['botao']['edit_carousel']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "editar-carousel/edit-carousel/$id'>Editar</a>";
                            }
                            if ($this->Dados['botao']['del_carousel']) {
                                echo "<a class='dropdown-item' href='" . URLADM . "apagar-carousel/apagar-carousel/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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
                        echo "<img src='" . URL . "assets/imagens/carousel/" . $id . "/" . $imagem . "' width='250' height='120'>";
                    }
                    ?>
                </dd>

                <dt class="col-sm-3">ID</dt>
                <dd class="col-sm-9"><?php echo $id; ?></dd>

                <dt class="col-sm-3">Nome</dt>
                <dd class="col-sm-9"><?php echo $nome; ?></dd>                

                <dt class="col-sm-3">Titulo</dt>
                <dd class="col-sm-9"><?php echo $titulo; ?></dd>   

                <dt class="col-sm-3">Descrição</dt>
                <dd class="col-sm-9"><?php echo $descricao; ?></dd>

                <dt class="col-sm-3">Posição do Texto</dt>
                <dd class="col-sm-9">
                    <?php
                    if ($posicao_text == 'text-left') {
                        echo "Esquerdo";
                    } elseif ($posicao_text == 'text-center') {
                        echo "Centralizado";
                    } elseif ($posicao_text == 'text-right') {
                        echo "Direito";
                    }
                    ?>
                </dd>

                <dt class="col-sm-3">Botão</dt>
                <dd class="col-sm-9"><?php echo "<a href='$link' class='btn btn-outline-$cor_crbtn btn-sm'>$titulo_botao</a> "; ?></dd>

                <dt class="col-sm-3">Link</dt>
                <dd class="col-sm-9"><?php echo $link; ?></dd>
                
                <dt class="col-sm-3">Ordem</dt>
                <dd class="col-sm-9"><?php echo $ordem; ?></dd>

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
    $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Slide de carousel não encontrado!</div>";
    $UrlDestino = URLADM . 'carousel/listar';
    header("Location: $UrlDestino");
}
