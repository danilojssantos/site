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
                    <a href="<?php echo URLADM . 'ver-pagina-site/ver-pagina-site/' . $valorForm['id']; ?>" class="btn btn-outline-primary btn-sm">Visualizar</a>
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
                    <label><span class="text-danger">*</span> Classe</label>
                    <input name="controller" type="text" class="form-control" placeholder="Nome da Classe" value="<?php
                    if (isset($valorForm['controller'])) {
                        echo $valorForm['controller'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Endereço</label>
                    <input name="endereco" type="text" class="form-control" placeholder="Nome da classe minuscula e sem espaço" value="<?php
                    if (isset($valorForm['endereco'])) {
                        echo $valorForm['endereco'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Nome da Página</label>
                    <input name="nome_pagina" type="text" class="form-control" placeholder="Nome da Página a ser apresentado no menu" value="<?php
                    if (isset($valorForm['nome_pagina'])) {
                        echo $valorForm['nome_pagina'];
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
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Titulo</label>
                    <input name="titulo" type="text" class="form-control" placeholder="Titulo da página para os buscadores" value="<?php
                    if (isset($valorForm['titulo'])) {
                        echo $valorForm['titulo'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Palavra Chave</label>
                    <input name="keywords" type="text" class="form-control" placeholder="Palavra chave da página" value="<?php
                    if (isset($valorForm['keywords'])) {
                        echo $valorForm['keywords'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Descrição</label>
                    <input name="description" type="text" class="form-control" placeholder="Descrição da página para os buscadores" value="<?php
                    if (isset($valorForm['description'])) {
                        echo $valorForm['description'];
                    }
                    ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Empresa</label>
                    <input name="author" type="text" class="form-control" placeholder="Nome da empresa na página para os buscadores" value="<?php
                    if (isset($valorForm['author'])) {
                        echo $valorForm['author'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Liberada no Menu</label>
                    <select name="lib_bloq" id="lib_bloq" class="form-control">
                        <?php
                        if ($valorForm['lib_bloq'] == 1) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1' selected>Sim</option>";
                            echo "<option value='2'>Não</option>";
                        } elseif ($valorForm['lib_bloq'] == 2) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1'>Sim</option>";
                            echo "<option value='2' selected>Não</option>";
                        } else {
                            echo "<option value='' selected>Selecione</option>";
                            echo "<option value='1'>Sim</option>";
                            echo "<option value='2'>Não</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Buscadores</label>
                    <select name="sts_robot_id" id="sts_robot_id" class="form-control">
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['rob'] as $rob) {
                            extract($rob);
                            if ($valorForm['sts_robot_id'] == $id_rob) {
                                echo "<option value='$id_rob' selected>$nome_rob</option>";
                            } else {
                                echo "<option value='$id_rob'>$nome_rob</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>



            <div class="form-row">                
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Situação da Página</label>
                    <select name="sts_situacaos_pg_id" id="sts_situacaos_pg_id" class="form-control">
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['sitpg'] as $sitpg) {
                            extract($sitpg);
                            if ($valorForm['sts_situacaos_pg_id'] == $id_sitpg) {
                                echo "<option value='$id_sitpg' selected>$nome_sitpg</option>";
                            } else {
                                echo "<option value='$id_sitpg'>$nome_sitpg</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Tipo da Página</label>
                    <select name="sts_tps_pg_id" id="sts_tps_pg_id" class="form-control">
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['tpg'] as $tpg) {
                            extract($tpg);
                            if ($valorForm['sts_tps_pg_id'] == $id_tpg) {
                                echo "<option value='$id_tpg' selected>$nome_tpg</option>";
                            } else {
                                echo "<option value='$id_tpg'>$tipo_tpg - $nome_tpg</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <input name="imagem_antiga" type="hidden" value="<?php
                    if (isset($valorForm['imagem_antiga'])) {
                        echo $valorForm['imagem_antiga'];
                    } elseif (isset($valorForm['imagem'])) {
                        echo $valorForm['imagem'];
                    }
                    ?>">

                    <label><span class="text-danger">*</span> Foto (1200x627)</label>
                    <input name="imagem_nova" type="file" onchange="previewImagem();">
                </div>
                <div class="form-group col-md-6">
                    <?php
                    if (isset($valorForm['imagem']) AND ! empty($valorForm['imagem'])) {
                        $imagem_antiga = URL . 'assets/imagens/pagina/' . $valorForm['id'] . '/' . $valorForm['imagem'];
                    } elseif (isset($valorForm['imagem_antiga']) AND ! empty($valorForm['imagem_antiga'])) {
                        $imagem_antiga = URL . 'assets/imagens/pagina/' . $valorForm['id'] . '/' . $valorForm['imagem_antiga'];
                    } else {
                        $imagem_antiga = URL . 'assets/imagens/pagina/preview_img.jpg';
                    }
                    ?>
                    <img src="<?php echo $imagem_antiga; ?>" alt="Imagem da página no site" id="preview-user" class="img-thumbnail" style="width: 300px; height: 150px;">
                </div>
            </div>

            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditPagina" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
