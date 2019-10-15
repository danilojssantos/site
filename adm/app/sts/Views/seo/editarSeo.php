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
                <h2 class="display-4 titulo">Editar Seo</h2>
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
                    <label>
                        <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Nome da página no Facebook">
                            <i class="fas fa-question-circle"></i>
                        </span> 
                        <span class="text-danger">*</span> og_site_name Facebook
                    </label>
                    <input name="og_site_name" type="text" class="form-control" placeholder="Nome da página no Facebook" value="<?php
                    if (isset($valorForm['og_site_name'])) {
                        echo $valorForm['og_site_name'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-6">                   
                    <label>
                        <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Local ou idioma da página no Facebook. Ex: pt_BR">
                            <i class="fas fa-question-circle"></i>
                        </span> 
                        <span class="text-danger">*</span> og_locale Facebook
                    </label>
                    <input name="og_locale" type="text" class="form-control" placeholder="Local ou idioma da página no Facebook. Ex: pt_BR" value="<?php
                    if (isset($valorForm['og_locale'])) {
                        echo $valorForm['og_locale'];
                    }
                    ?>">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-6">                    
                    <label>
                        <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="ID da página no Facebook">
                            <i class="fas fa-question-circle"></i>
                        </span> 
                        <span class="text-danger">*</span> FB:admins
                    </label>
                    <input name="fb_admins" type="text" class="form-control" placeholder="ID da página no Facebook" value="<?php
                    if (isset($valorForm['fb_admins'])) {
                        echo $valorForm['fb_admins'];
                    }
                    ?>">
                </div>
                <div class="form-group col-md-6">                   
                    <label>
                        <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Nome de usuário no twiter. Ex: @celkecursos">
                            <i class="fas fa-question-circle"></i>
                        </span> 
                        <span class="text-danger">*</span> Nome do Twiter
                    </label>
                    <input name="twitter_site" type="text" class="form-control" placeholder="Nome de usuário no twiter. Ex: @celkecursos" value="<?php
                    if (isset($valorForm['twitter_site'])) {
                        echo $valorForm['twitter_site'];
                    }
                    ?>">
                </div>
            </div>
            
            

            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditSeo" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
