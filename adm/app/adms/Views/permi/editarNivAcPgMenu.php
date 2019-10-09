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
                <h2 class="display-4 titulo">Editar Item de Menu da Página</h2>
            </div>
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
                <div class="form-group col-md-12">
                    <label><span class="text-danger">*</span> Item de Menu</label>
                    <select name="adms_menu_id" id="adms_menu_id" class="form-control">
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['menu'] as $menu) {
                            extract($menu);
                            if ($valorForm['adms_menu_id'] == $id_menu) {
                                echo "<option value='$id_menu' selected>$nome_menu</option>";
                            } else {
                                echo "<option value='$id_menu'>$nome_menu</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditNivAcPgMenu" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>
