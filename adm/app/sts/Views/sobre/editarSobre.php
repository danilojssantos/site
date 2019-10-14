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
                <h2 class="display-4 titulo">Editar Sobre da Página Blog</h2>
            </div>

        </div><hr>
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <form method="POST" action="" enctype="multipart/form-data"> 
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Titulo</label>
                    <input name="titulo" type="text" class="form-control" placeholder="Titulo da área de vídeo" value="<?php
                    if (isset($valorForm['titulo'])) {
                        echo $valorForm['titulo'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-6">
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
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Descrição</label>
                    <textarea name="descricao" class="form-control" rows="3"><?php
                        if (isset($valorForm['descricao'])) {
                            echo $valorForm['descricao'];
                        }
                        ?>
                    </textarea>
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
                        $imagem_antiga = URL . 'assets/imagens/sobre_autor/1/' . $valorForm['imagem'];
                    } elseif (isset($valorForm['imagem_antiga']) AND ! empty($valorForm['imagem_antiga'])) {
                        $imagem_antiga = URL . 'assets/imagens/sobre_autor/1/' . $valorForm['imagem_antiga'];
                    } else {
                        $imagem_antiga = URL . 'assets/imagens/sobre_autor/preview_img.jpg';
                    }
                    ?>
                    <img src="<?php echo $imagem_antiga; ?>" alt="Imagem do Sobre na Pagina Blog" id="preview-user" class="img-thumbnail" style="width: 300px; height: 150px;">
                </div>
            </div>           

            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditSobre" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
