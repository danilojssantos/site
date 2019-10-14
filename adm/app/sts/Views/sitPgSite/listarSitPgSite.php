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
                <h2 class="display-4 titulo">Listar Situação de Página do Site</h2>
            </div>
            <?php
            if ($this->Dados['botao']['cad_sit_pg']) {
                ?>
                <a href="<?php echo URLADM . 'cadastrar-sit-pg-site/cad-sit-pg-site'; ?>">
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
        if (empty($this->Dados['listSitPgSite'])) {
            ?>
            <div class="alert alert-danger" role="alert">
                Nenhuma situação de página do site encontrado!
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
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($this->Dados['listSitPgSite'] as $sitPgSite) {
                        extract($sitPgSite);
                        ?>
                        <tr>
                            <th><?php echo $id; ?></th>
                            <td>
                                <?php
                                    echo "<span class='badge badge-pill badge-$cor_cr'>$nome</span>";
                                ?>
                            </td>
                            <td class="text-center">
                                <span class="d-none d-md-block">
                                    <?php
                                    if ($this->Dados['botao']['vis_sit_pg']) {
                                        echo "<a href='" . URLADM . "ver-sit-pg-site/ver-sit-pg-site/$id' class='btn btn-outline-primary btn-sm'>Visualizar</a> ";
                                    }
                                    if ($this->Dados['botao']['edit_sit_pg']) {
                                        echo "<a href='" . URLADM . "editar-sit-pg-site/edit-sit-pg-site/$id' class='btn btn-outline-warning btn-sm'>Editar</a> ";
                                    }
                                    if ($this->Dados['botao']['del_sit_pg']) {
                                        echo "<a href='" . URLADM . "apagar-sit-pg-site/apagar-sit-pg-site/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
                                    }
                                    ?>
                                </span>
                                <div class="dropdown d-block d-md-none">
                                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Ações
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                        <?php
                                        if ($this->Dados['botao']['vis_sit_pg']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "ver-sit-pg-site/ver-sit-pg-site/$id'>Visualizar</a>";
                                        }
                                        if ($this->Dados['botao']['edit_sit_pg']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "editar-sit-pg-site/edit-sit-pg-site/$id'>Editar</a>";
                                        }
                                        if ($this->Dados['botao']['del_sit_pgt']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "apagar-sit-pg-site/apagar-sit-pg-site/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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
