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
                <h2 class="display-4 titulo">Editar Artigo</h2>
            </div>

            <?php
            if ($this->Dados['botao']['vis_art']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'ver-artigo/ver-artigo/' . $valorForm['id']; ?>" class="btn btn-outline-primary btn-sm">Visualizar</a>
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
            
            <h2 class="display-4 titulo">Conteúdo</h2>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Nome</label>
                    <input name="titulo" type="text" class="form-control" placeholder="Titulo do artigo" value="<?php
                    if (isset($valorForm['titulo'])) {
                        echo $valorForm['titulo'];
                    }
                    ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Prévia do Artigo</label>
                    <textarea name="descricao" id="editor-um" class="form-control" rows="3"><?php
                        if (isset($valorForm['descricao'])) {
                            echo $valorForm['descricao'];
                        }
                        ?>
                    </textarea>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Conteúdo do Artigo</label>
                    <textarea name="conteudo" id="editor-dois" class="form-control" rows="3"><?php
                        if (isset($valorForm['conteudo'])) {
                            echo $valorForm['conteudo'];
                        }
                        ?>
                    </textarea>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Resumo Público</label>
                    <textarea name="resumo_publico" id="editor-tres" class="form-control" rows="3"><?php
                        if (isset($valorForm['resumo_publico'])) {
                            echo $valorForm['resumo_publico'];
                        }
                        ?>
                    </textarea>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Situação</label>
                    <select name="adms_sit_id" id="adms_sit_id" class="form-control">
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['sit'] as $sit) {
                            extract($sit);
                            if ($valorForm['adms_sit_id'] == $id_sit) {
                                echo "<option value='$id_sit' selected>$nome_sit</option>";
                            } else {
                                echo "<option value='$id_sit'>$nome_sit</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Tipo de Artigo</label>
                    <select name="sts_tps_artigo_id" id="sts_tps_artigo_id" class="form-control">
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['tpart'] as $tpart) {
                            extract($tpart);
                            if ($valorForm['sts_tps_artigo_id'] == $id_tpart) {
                                echo "<option value='$id_tpart' selected>$nome_tpart</option>";
                            } else {
                                echo "<option value='$id_tpart'>$nome_tpart</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Categoria do Artigo</label>
                    <select name="sts_cats_artigo_id" id="sts_cats_artigo_id" class="form-control">
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['catart'] as $catart) {
                            extract($catart);
                            if ($valorForm['sts_cats_artigo_id'] == $id_catart) {
                                echo "<option value='$id_catart' selected>$nome_catart</option>";
                            } else {
                                echo "<option value='$id_catart'>$nome_catart</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>         

            <?php
            if ($this->Dados['botao']['edit_autor_art']) {
                ?>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label><span class="text-danger">*</span> Autor do Artigo</label>
                        <select name="adms_usuario_id" id="adms_usuario_id" class="form-control">
                            <option value="">Selecione</option>
                            <?php
                            $cont = 1;
                            foreach ($this->Dados['select']['user'] as $user) {
                                extract($user);
                                if ($valorForm['adms_usuario_id'] == $id_user) {
                                    echo "<option value='$id_user' selected>$nome_user</option>";
                                    $cont = 2;
                                } elseif (($_SESSION['usuario_id'] == $id_user) AND ( $cont == 1)) {
                                    echo "<option value='$id_user' selected>$nome_user</option>";
                                } else {
                                    echo "<option value='$id_user'>$nome_user</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <?php
            } 
            ?>

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
                        $imagem_antiga = URL . 'assets/imagens/artigo/' . $valorForm['id'] . '/' . $valorForm['imagem'];
                    } elseif (isset($valorForm['imagem_antiga']) AND ! empty($valorForm['imagem_antiga'])) {
                        $imagem_antiga = URL . 'assets/imagens/artigo/' . $valorForm['id'] . '/' . $valorForm['imagem_antiga'];
                    } else {
                        $imagem_antiga = URL . 'assets/imagens/artigo/preview_img.jpg';
                    }
                    ?>
                    <img src="<?php echo $imagem_antiga; ?>" alt="Imagem do artigo" id="preview-user" class="img-thumbnail" style="width: 300px; height: 150px;">
                </div>
            </div>  

            <hr>
            <h2 class="display-4 titulo">SEO</h2>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Slug</label>
                    <input name="slug" type="text" class="form-control" placeholder="Slug do artigo" value="<?php
                    if (isset($valorForm['slug'])) {
                        echo $valorForm['slug'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Palavra chave</label>
                    <input name="keywords" type="text" class="form-control" placeholder="Palavra chave do artigo" value="<?php
                    if (isset($valorForm['keywords'])) {
                        echo $valorForm['keywords'];
                    }
                    ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Descrição</label>
                    <input name="description" type="text" class="form-control" placeholder="Descrição do artigo. Máximo 180 letras" value="<?php
                    if (isset($valorForm['description'])) {
                        echo $valorForm['description'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Titulo do Site</label>
                    <input name="author" type="text" class="form-control" placeholder="Titulo do Site" value="<?php
                    if (isset($valorForm['author'])) {
                        echo $valorForm['author'];
                    }
                    ?>">
                </div>
            </div>            

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Situação Buscadores</label>
                    <select name="sts_robot_id" id="sts_robot_id" class="form-control">
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['rob'] as $rob) {
                            extract($rob);
                            if ($valorForm['sts_robot_id'] == $id_rob) {
                                echo "<option value='$id_rob' selected>$tipo_rob - $nome_rob</option>";
                            } else {
                                echo "<option value='$id_rob'>$nome_rob</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>  


            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditArtigo" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
