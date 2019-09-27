<nav class="navbar navbar-expand navbar-dark bg-primary">
    <a class="sidebar-toggle text-light mr-3">
        <span class="navbar-toggler-icon"></span>
    </a>
    <a class="navbar-brand" href="#">DaniloJoaquim.com.br</a>

    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle menu-header" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown">
                    <?php if (isset($_SESSION['usuario_imagem']) AND ( !empty($_SESSION['usuario_imagem']))) { ?>
                        <img class="rounded-circle" src="<?php echo URLADM . 'assets/imagens/usuario/' . $_SESSION['usuario_id'] . '/' . $_SESSION['usuario_imagem']; ?>" width="20" height="20"> &nbsp;<span class="d-none d-sm-inline">
                        <?php } else { ?>
                            <img class="rounded-circle" src="<?php echo URLADM . 'assets/imagens/usuario/icone_usuario.png'; ?>" width="20" height="20"> &nbsp;<span class="d-none d-sm-inline">
                                <?php
                            }
                            $nome = explode(" ", $_SESSION['usuario_nome']);
                            $prim_nome = $nome[0];
                            echo $prim_nome;
                            ?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="#"><i class="fas fa-user"></i> Perfil</a>
                    <a class="dropdown-item" href="<?php echo URLADM . 'login/logout'; ?>"><i class="fas fa-sign-out-alt"></i> Sair</a>
                </div>
            </li>
        </ul>                
    </div>
</nav>
