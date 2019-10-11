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
                <h2 class="display-4 titulo">Listar Carousel</h2>
            </div>
            <?php
            if ($this->Dados['botao']['cad_carousel']) {
                ?>
                <a href="<?php echo URLADM . 'cadastrar-carousel/cad-carousel'; ?>">
                    <div class="p-2">
                        <button class="btn btn-outline-success btn-sm">
                            Cadastrar
                        </button>
                    </div>
                </a>
                <?php
            }
            ?>

        </div>
        <?php
        if (empty($this->Dados['listCarousel'])) {
            ?>
            <div class="alert alert-danger" role="alert">
                Nenhum slide de carousel encontrado!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php
        }
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th class="d-none d-sm-table-cell">Imagem</th>
                        <th class="d-none d-sm-table-cell">Ordem</th>
                        <th class="d-none d-lg-table-cell">Situação</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->Dados['listCarousel'] as $carousel) {
                        extract($carousel);
                        ?>
                        <tr>
                            <th><?php echo $id; ?></th>
                            <td><?php echo $nome; ?></td>
                            <td class="d-none d-sm-table-cell">
                                <?php echo "<img src='" . URL . "assets/imagens/carousel/$id/$imagem' width='150' height='60'>"; ?>
                            </td>
                            <td><?php echo $ordem; ?></td>
                            <td class="d-none d-lg-table-cell">
                                <?php
                                if ($this->Dados['botao']['alt_sit_carousel']) {
                                    echo "<a href='" . URLADM . "alt-sit-carousel/alt-sit-carousel/$id'><span class='badge badge-pill badge-$cor_cr'>$nome_sit</span></a>";
                                } else {
                                    echo "<span class='badge badge-pill badge-$cor_cr'>$nome_sit</span>";
                                }
                                ?>
                            </td>
                            <td class="text-center">
                                <span class="d-none d-md-block">
                                    <?php
                                    if ($this->Dados['botao']['ordem_carousel']) {
                                        echo "<a href='" . URLADM . "alt-ordem-carousel/alt-ordem-carousel/$id' class='btn btn-outline-secondary btn-sm'><i class='fas fa-angle-double-up'></i></a> ";
                                    }
                                    if ($this->Dados['botao']['vis_carousel']) {
                                        echo "<a href='" . URLADM . "ver-carousel/ver-carousel/$id' class='btn btn-outline-primary btn-sm'>Visualizar</a> ";
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
                                        if ($this->Dados['botao']['vis_carousel']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "ver-carousel/ver-carousel/$id'>Visualizar</a>";
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
                            </td>
                        </tr>
                        <?php
                    }
                    ?>

                </tbody>
            </table>