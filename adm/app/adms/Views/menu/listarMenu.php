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
                <h2 class="display-4 titulo">Listar Itens de Menu</h2>
            </div>
            <?php
            if ($this->Dados['botao']['cad_menu']) {
                ?>
                <a href="<?php echo URLADM . 'cadastrar-menu/cad-menu'; ?>">
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
        if (empty($this->Dados['listItensMenu'])) {
            ?>
            <div class="alert alert-danger" role="alert">
                Nenhum item de menu encontrado!
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
                        <th class="d-none d-sm-table-cell">ordem</th>
                        <th class="d-none d-lg-table-cell">Situação</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->Dados['listItensMenu'] as $itenMenu) {
                        extract($itenMenu);
                        ?>
                        <tr>
                            <th><?php echo $id; ?></th>
                            <td>
                                <?php echo "<i class='" . $icone . "'></i> - " . $nome; ?>
                            </td>
                            <td class="d-none d-sm-table-cell"><?php echo $ordem; ?></td>
                            <td class="d-none d-lg-table-cell">
                                <span class="badge badge-<?php echo $cor_cr; ?>"><?php echo $nome_sit; ?></span>
                            </td>
                            <td class="text-center">
                                <span class="d-none d-md-block">
                                    <?php
                                    if ($this->Dados['botao']['ordem_menu']) {
                                        echo "<a href='" . URLADM . "alt-ordem-item-menu/alt-ordem-item-menu/$id' class='btn btn-outline-secondary btn-sm'><i class='fas fa-angle-double-up'></i></a> ";
                                    }
                                    if ($this->Dados['botao']['vis_menu']) {
                                        echo "<a href='" . URLADM . "ver-menu/ver-menu/$id' class='btn btn-outline-primary btn-sm'>Visualizar</a> ";
                                    }
                                    if ($this->Dados['botao']['edit_menu']) {
                                        echo "<a href='" . URLADM . "editar-menu/edit-menu/$id' class='btn btn-outline-warning btn-sm'>Editar</a> ";
                                    }
                                    if ($this->Dados['botao']['del_menu']) {
                                        echo "<a href='" . URLADM . "apagar-menu/apagar-menu/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
                                    }
                                    ?>
                                </span>
                                <div class="dropdown d-block d-md-none">
                                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Ações
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                        <?php
                                        if ($this->Dados['botao']['vis_menu']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "ver-menu/ver-menu/$id'>Visualizar</a>";
                                        }
                                        if ($this->Dados['botao']['edit_menu']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "editar-menu/edit-menu/$id'>Editar</a>";
                                        }
                                        if ($this->Dados['botao']['del_menu']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "apagar-menu/apagar-menu/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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
            <?php
            echo $this->Dados['paginacao'];
            ?>
        </div>
    </div>
</div>
