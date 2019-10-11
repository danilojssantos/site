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
                <h2 class="display-4 titulo">Editar Carousel</h2>
            </div>

            <?php
            if ($this->Dados['botao']['vis_carousel']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'ver-carousel/ver-carousel/' . $valorForm['id']; ?>" class="btn btn-outline-primary btn-sm">Visualizar</a>
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
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Nome</label>
                    <input name="nome" type="text" class="form-control" placeholder="Nome do slide" value="<?php
                    if (isset($valorForm['nome'])) {
                        echo $valorForm['nome'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Titulo</label>
                    <input name="titulo" type="text" class="form-control" placeholder="Titulo a ser apresentado no slide" value="<?php
                    if (isset($valorForm['titulo'])) {
                        echo $valorForm['titulo'];
                    }
                    ?>">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-8">
                    <label><span class="text-danger">*</span> Descrição</label>
                    <input name="descricao" type="text" class="form-control" id="nome" placeholder="Descrição a ser apresentado no menu" value="<?php
                    if (isset($valorForm['descricao'])) {
                        echo $valorForm['descricao'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Posição do texto</label>
                    <select name="posicao_text" id="posicao_text" class="form-control">
                        <?php
                            if ($valorForm['posicao_text'] == "text-left") {
                                echo "<option value=''>Selecione</option>";
                                echo "<option value='text-left' selected>Esquerdo</option>";
                                echo "<option value='text-center'>Center</option>";
                                echo "<option value='text-right'>Direito</option>";
                            } elseif ($valorForm['posicao_text'] == "text-center")  {
                                echo "<option value=''>Selecione</option>";
                                echo "<option value='text-left'>Esquerdo</option>";
                                echo "<option value='text-center' selected>Center</option>";
                                echo "<option value='text-right'>Direito</option>";
                            }elseif ($valorForm['posicao_text'] == "text-right")  {
                                echo "<option value=''>Selecione</option>";
                                echo "<option value='text-left'>Esquerdo</option>";
                                echo "<option value='text-center'>Center</option>";
                                echo "<option value='text-right' selected>Direito</option>";
                            }else{
                                echo "<option value='' selected>Selecione</option>";
                                echo "<option value='text-left'>Esquerdo</option>";
                                echo "<option value='text-center'>Center</option>";
                                echo "<option value='text-right'>Direito</option>";                        
                            }
                        ?>
                    </select>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Titulo do Botão</label>
                    <input name="titulo_botao" type="text" class="form-control" placeholder="Titulo do botão" value="<?php
                    if (isset($valorForm['titulo_botao'])) {
                        echo $valorForm['titulo_botao'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Link</label>
                    <input name="link" type="text" class="form-control" placeholder="Link do botão" value="<?php
                    if (isset($valorForm['link'])) {
                        echo $valorForm['link'];
                    }
                    ?>">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label><span class="text-danger">*</span> Cor do Botão</label>
                    <select name="adms_cor_id" id="adms_cor_id" class="form-control">
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['cr'] as $cr) {
                            extract($cr);
                            if ($valorForm['adms_cor_id'] == $id_cr) {
                                echo "<option value='$id_cr' selected>$nome_cr</option>";
                            } else {
                                echo "<option value='$id_cr'>$nome_cr</option>";
                            }
                        }
                        ?>
                    </select>
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
                <div class="form-group col-md-6">
                    <input name="imagem_antiga" type="hidden" value="<?php
                    if (isset($valorForm['imagem_antiga'])) {
                        echo $valorForm['imagem_antiga'];
                    } elseif (isset($valorForm['imagem'])) {
                        echo $valorForm['imagem'];
                    }
                    ?>">

                    <label><span class="text-danger">*</span> Foto (1920x846)</label>
                    <input name="imagem_nova" type="file" onchange="previewImagem();">
                </div>
                <div class="form-group col-md-6">
                    <?php
                    if (isset($valorForm['imagem']) AND ! empty($valorForm['imagem'])) {
                        $imagem_antiga = URL . 'assets/imagens/carousel/' . $valorForm['id'] . '/' . $valorForm['imagem'];
                    } elseif (isset($valorForm['imagem_antiga']) AND ! empty($valorForm['imagem_antiga'])) {
                        $imagem_antiga = URL . 'assets/imagens/carousel/' . $valorForm['id'] . '/' . $valorForm['imagem_antiga'];
                    } else {
                        $imagem_antiga = URL . 'assets/imagens/carousel/preview_img.jpg';
                    }
                    ?>
                    <img src="<?php echo $imagem_antiga; ?>" alt="Imagem do Carousel" id="preview-user" class="img-thumbnail" style="width: 250px; height: 120px;">
                </div>
            </div>

            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditCarousel" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
