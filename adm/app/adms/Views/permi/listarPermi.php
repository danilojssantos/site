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
                <h2 class="display-4 titulo">
                    <?php
                    echo "Listar Permissões";
                    if (!empty($this->Dados['dados_nivac'])) {
                        echo " - {$this->Dados['dados_nivac'][0]['nome']}";
                    }
                    ?>
                </h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_nivac']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'nivel-acesso/listar'; ?>" class="btn btn-outline-info btn-sm">Nível de Acesso</a>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
        if (empty($this->Dados['listPermi'])) {
            ?>
            <div class="alert alert-danger" role="alert">
                Nenhuma permissão encontrada!
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
                        <th>Página</th>
                        <th class="d-none d-sm-table-cell">Permissão</th>
                        <th class="d-none d-sm-table-cell">Menu</th>
                        <th class="d-none d-sm-table-cell">Dropdown</th>
                        <th class="d-none d-sm-table-cell">Ordem</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $qnt_linhas_exe = 1;
                    foreach ($this->Dados['listPermi'] as $permissao) {
                        extract($permissao);
                        ?>
                        <tr>
                            <th><?php echo $id; ?></th>
                            <td>
                                <span tabindex="0" data-placement="top" data-toggle="tooltip" title="<?php echo $obs_pg; ?>">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                <?php echo $nome_pagina; ?>
                            </td>
                            <td class="d-none d-sm-table-cell">
                                <?php
                                if ($this->Dados['botao']['lib_permi']) {
                                    if ($permissao == 1) {
                                        echo "<a href='" . URLADM . "lib-permi/lib-permi/$id?niv={$this->Dados['dados_nivac'][0]['id']}&pg={$this->Dados['pg']}'><span class='badge badge-pill badge-success'>Liberado</span></a>";
                                    } else {
                                        echo "<a href='" . URLADM . "lib-permi/lib-permi/$id?niv={$this->Dados['dados_nivac'][0]['id']}&pg={$this->Dados['pg']}'><span class='badge badge-pill badge-danger'>Bloqueado</span></a>";
                                    }
                                } else {
                                    if ($permissao == 1) {
                                        echo "<span class='badge badge-pill badge-success'>Liberado</span>";
                                    } else {
                                        echo "<span class='badge badge-pill badge-danger'>Bloqueado</span>";
                                    }
                                }
                                ?>
                            </td>
                            <td class="d-none d-sm-table-cell">
                                <?php
                                if ($this->Dados['botao']['lib_menu']) {
                                    if ($lib_menu == 1) {
                                        echo "<a href='" . URLADM . "lib-menu/lib-menu/$id?niv={$this->Dados['dados_nivac'][0]['id']}&pg={$this->Dados['pg']}'><span class='badge badge-pill badge-success'>Liberado</span></a>";
                                    } else {
                                        echo "<a href='" . URLADM . "lib-menu/lib-menu/$id?niv={$this->Dados['dados_nivac'][0]['id']}&pg={$this->Dados['pg']}'><span class='badge badge-pill badge-danger'>Bloqueado</span></a>";
                                    }
                                } else {
                                    if ($lib_menu == 1) {
                                        echo "<span class='badge badge-pill badge-success'>Liberado</span>";
                                    } else {
                                        echo "<span class='badge badge-pill badge-danger'>Bloqueado</span>";
                                    }
                                }
                                ?>
                            </td>
                            <td class="d-none d-sm-table-cell">
                                <?php
                                if ($this->Dados['botao']['lib_dropdown']) {
                                    if ($dropdown == 1) {
                                        echo "<a href='" . URLADM . "lib-dropdown/lib-dropdown/$id?niv={$this->Dados['dados_nivac'][0]['id']}&pg={$this->Dados['pg']}'><span class='badge badge-pill badge-success'>Sim</span></a>";
                                    } else {
                                        echo "<a href='" . URLADM . "lib-dropdown/lib-dropdown/$id?niv={$this->Dados['dados_nivac'][0]['id']}&pg={$this->Dados['pg']}'><span class='badge badge-pill badge-danger'>Não</span></a>";
                                    }
                                } else {
                                    if ($dropdown == 1) {
                                        echo "<span class='badge badge-pill badge-success'>Sim</span>";
                                    } else {
                                        echo "<span class='badge badge-pill badge-danger'>Não</span>";
                                    }
                                }
                                ?>
                            </td>
                            <td><?php echo $ordem; ?></td>
                            <td class="text-center">
                                <span class="d-none d-md-block">
                                    <?php
                                    if ($this->Dados['botao']['ordem_menu']) {
                                        if (($qnt_linhas_exe <= 1) AND ( $this->Dados['pg'] == 1)) {
                                            echo "<button class='btn btn-outline-secondary btn-sm disabled'><i class='fas fa-angle-double-up'></i></button> ";
                                        } else {
                                            echo "<a href='" . URLADM . "alt-ordem-menu/alt-ordem-menu/$id?niv={$this->Dados['dados_nivac'][0]['id']}&pg={$this->Dados['pg']}' class='btn btn-outline-secondary btn-sm'><i class='fas fa-angle-double-up'></i></a> ";
                                        }
                                    }
                                    $qnt_linhas_exe++;
                                    if ($this->Dados['botao']['edit_niv_ac_pg_menu']) {
                                        echo "<a href='" . URLADM . "editar-niv-ac-pg-menu/edit-niv-ac-pg-menu/$id?niv={$this->Dados['dados_nivac'][0]['id']}&pg={$this->Dados['pg']}' class='btn btn-outline-warning btn-sm'>Editar</a> ";
                                    }

                                    ?>
                                </span>                                
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
