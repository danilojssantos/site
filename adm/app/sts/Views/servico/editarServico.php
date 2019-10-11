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
                <h2 class="display-4 titulo">Editar Serviço</h2>
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
                    <input name="titulo" type="text" class="form-control" placeholder="Titulo da área de serviço" value="<?php
                    if (isset($valorForm['titulo'])) {
                        echo $valorForm['titulo'];
                    }
                    ?>">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>
                        <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Página de icone: <a href='https://fontawesome.com/icons?d=gallery' target='_blank'>fontawesome</a>. Somente inserir o nome, Ex: fas fa-volume-up">
                            <i class="fas fa-question-circle"></i>
                        </span> 
                        <span class="text-danger">*</span> Ícone 1
                    </label>
                    <input name="icone_um" type="text" class="form-control" placeholder="Ícone do serviço um" value="<?php
                    if (isset($valorForm['icone_um'])) {
                        echo $valorForm['icone_um'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Nome 1</label>
                    <input name="nome_um" type="text" class="form-control" placeholder="Nome do serviço um" value="<?php
                    if (isset($valorForm['nome_um'])) {
                        echo $valorForm['nome_um'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Descrição 1</label>
                    <input name="descricao_um" type="text" class="form-control" placeholder="Descrição do serviço um" value="<?php
                    if (isset($valorForm['descricao_um'])) {
                        echo $valorForm['descricao_um'];
                    }
                    ?>">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>
                        <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Página de icone: <a href='https://fontawesome.com/icons?d=gallery' target='_blank'>fontawesome</a>. Somente inserir o nome, Ex: fas fa-volume-up">
                            <i class="fas fa-question-circle"></i>
                        </span> 
                        <span class="text-danger">*</span> Ícone 2
                    </label>
                    <input name="icone_dois" type="text" class="form-control" placeholder="Ícone do serviço dois" value="<?php
                    if (isset($valorForm['icone_dois'])) {
                        echo $valorForm['icone_dois'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Nome 2</label>
                    <input name="nome_dois" type="text" class="form-control" placeholder="Nome do serviço dois" value="<?php
                    if (isset($valorForm['nome_dois'])) {
                        echo $valorForm['nome_dois'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Descrição 2</label>
                    <input name="descricao_dois" type="text" class="form-control" placeholder="Descrição do serviço dois" value="<?php
                    if (isset($valorForm['descricao_dois'])) {
                        echo $valorForm['descricao_dois'];
                    }
                    ?>">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>
                        <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Página de icone: <a href='https://fontawesome.com/icons?d=gallery' target='_blank'>fontawesome</a>. Somente inserir o nome, Ex: fas fa-volume-up">
                            <i class="fas fa-question-circle"></i>
                        </span> 
                        <span class="text-danger">*</span> Ícone 3
                    </label>
                    <input name="icone_tres" type="text" class="form-control" placeholder="Ícone do serviço tres" value="<?php
                    if (isset($valorForm['icone_tres'])) {
                        echo $valorForm['icone_tres'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Nome 3</label>
                    <input name="nome_tres" type="text" class="form-control" placeholder="Nome do serviço tres" value="<?php
                    if (isset($valorForm['nome_tres'])) {
                        echo $valorForm['nome_tres'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">*</span> Descrição 3</label>
                    <input name="descricao_tres" type="text" class="form-control" placeholder="Descrição do serviço tres" value="<?php
                    if (isset($valorForm['descricao_tres'])) {
                        echo $valorForm['descricao_tres'];
                    }
                    ?>">
                </div>
            </div>
            

            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditServico" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
