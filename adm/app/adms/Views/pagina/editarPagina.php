<?php
if (isset($this->Dados['form'])) {
    $valorForm = $this->Dados['form'];
}
if (isset($this->Dados['form'][0])) {
    $valorForm = $this->Dados['form'][0];
}
//var_dump($this->Dados['select']);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Editar Página</h2>
            </div>

            <?php
            if ($this->Dados['botao']['vis_pagina']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'ver-pagina/ver-pagina/' . $valorForm['id']; ?>" class="btn btn-outline-primary btn-sm">Visualizar</a>
                </div>
                <?php
            }
            ?>

        </div><hr>
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <form method="POST" action="" enctype="multipart/form-data"> 
            <input name="id" type="hidden" value="<?php
            if (isset($valorForm['id'])) {
                echo $valorForm['id'];
            }
            ?>">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Nome da Página</label>
                    <input name="nome_pagina" type="text" class="form-control" placeholder="Nome da Página a ser apresentado no menu" value="<?php
                    if (isset($valorForm['nome_pagina'])) {
                        echo $valorForm['nome_pagina'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Classe</label>
                    <input name="controller" type="text" class="form-control" placeholder="Nome da Classe" value="<?php
                    if (isset($valorForm['controller'])) {
                        echo $valorForm['controller'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Método</label>
                    <input name="metodo" type="text" class="form-control" placeholder="Nome do Método" value="<?php
                    if (isset($valorForm['metodo'])) {
                        echo $valorForm['metodo'];
                    }
                    ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Classe no menu</label>
                    <input name="menu_controller" type="text" class="form-control" placeholder="Nome da classe no menu" value="<?php
                    if (isset($valorForm['menu_controller'])) {
                        echo $valorForm['menu_controller'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Método no menu</label>
                    <input name="menu_metodo" type="text" class="form-control" placeholder="Nome do método no menu" value="<?php
                    if (isset($valorForm['menu_metodo'])) {
                        echo $valorForm['menu_metodo'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-4">
                    <label>
                        <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Página de icone: <a href='https://fontawesome.com/icons?d=gallery' target='_blank'>fontawesome</a>. Somente inserir o nome, Ex: fas fa-volume-up">
                            <i class="fas fa-question-circle"></i>
                        </span> Ícone</label>
                    <input name="icone" type="text" class="form-control" placeholder="Ícone a ser apresentado no menu" value="<?php
                    if (isset($valorForm['icone'])) {
                        echo $valorForm['icone'];
                    }
                    ?>">
                </div>
            </div>


            <div class="form-group">
                <label><span class="text-danger">*</span> Observação</label>
                <textarea name="obs" class="form-control" rows="3"><?php
                    if (isset($valorForm['obs'])) {
                        echo $valorForm['obs'];
                    }
                    ?>
                </textarea>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Página Pública</label>
                    <select name="lib_pub" id="lib_pub" class="form-control">
                        <?php
                            if ($valorForm['lib_pub'] == 1) {
                                echo "<option value=''>Selecione</option>";
                                echo "<option value='1' selected>Sim</option>";
                                echo "<option value='2'>Não</option>";
                            } elseif ($valorForm['lib_pub'] == 2)  {
                                echo "<option value=''>Selecione</option>";
                                echo "<option value='1'>Sim</option>";
                                echo "<option value='2' selected>Não</option>";
                            }else{
                                echo "<option value='' selected>Selecione</option>";
                                echo "<option value='1'>Sim</option>";
                                echo "<option value='2'>Não</option>";                                
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Situação da Página</label>
                    <select name="adms_sits_pg_id" id="adms_sits_pg_id" class="form-control">
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['sitpg'] as $sitpg) {
                            extract($sitpg);
                            if ($valorForm['adms_sits_pg_id'] == $id_sitpg) {
                                echo "<option value='$id_sitpg' selected>$nome_sitpg</option>";
                            } else {
                                echo "<option value='$id_sitpg'>$nome_sitpg</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Grupo da Página</label>
                    <select name="adms_grps_pg_id" id="adms_grps_pg_id" class="form-control">
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['grpg'] as $grpg) {
                            extract($grpg);
                            if ($valorForm['adms_grps_pg_id'] == $id_grpg) {
                                echo "<option value='$id_grpg' selected>$nome_grpg</option>";
                            } else {
                                echo "<option value='$id_grpg'>$nome_grpg</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Tipo da Página</label>
                    <select name="adms_tps_pg_id" id="adms_tps_pg_id" class="form-control">
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['tpg'] as $tpg) {
                            extract($tpg);
                            if ($valorForm['adms_tps_pg_id'] == $id_tpg) {
                                echo "<option value='$id_tpg' selected>$nome_tpg</option>";
                            } else {
                                echo "<option value='$id_tpg'>$tipo_tpg - $nome_tpg</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>


            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditPagina" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
