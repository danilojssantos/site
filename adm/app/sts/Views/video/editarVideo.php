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
                <h2 class="display-4 titulo">Editar Vídeo</h2>
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
                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Titulo</label>
                    <input name="titulo" type="text" class="form-control" placeholder="Titulo da área de vídeo" value="<?php
                    if (isset($valorForm['titulo'])) {
                        echo $valorForm['titulo'];
                    }
                    ?>">
                </div>
            </div>
            
            <div class="form-row">                
                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Descrição</label>
                    <input name="descricao" type="text" class="form-control" placeholder="Descrição do vídeo" value="<?php
                    if (isset($valorForm['descricao'])) {
                        echo $valorForm['descricao'];
                    }
                    ?>">
                </div>
            </div>
            
            <div class="form-row">
                <label><span class="text-danger">*</span> Embed do Vídeo</label>
                <textarea name="video" class="form-control" rows="3"><?php
                    if (isset($valorForm['video'])) {
                        echo $valorForm['video'];
                    }
                    ?>
                </textarea>
            </div>
            

            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditVideo" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
