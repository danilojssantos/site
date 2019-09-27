<?php
if (!defined('URL')) {
    header("Location: /");
    exit();
}

?>

<div class="d-flex">
<nav class="sidebar">
                <ul class="list-unstyled">
                    <li><a href="#"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li>
                        <a href="#submenu1" data-toggle="collapse">
                            <i class="fas fa-user"></i> Usuário
                        </a>
                        <ul id="submenu1" class="list-unstyled collapse">
                            <li><a href="listar.html"><i class="fas fa-users"></i> Usuários</a></li>
                            <li><a href="#"><i class="fas fa-key"></i> Nível de Acesso</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#submenu2" data-toggle="collapse"><i class="fas fa-list-ul"></i> Menu</a>
                        <ul id="submenu2" class="list-unstyled collapse">
                            <li><a href="#"><i class="fas fa-file-alt"></i> Páginas</a></li>
                            <li><a href="#"><i class="fab fa-elementor"></i> Item de Menu</a></li>
                        </ul>

                    </li>
                    <li><a href="#"> Item 1</a></li>
                    <li><a href="#"> Item 2</a></li>
                    <li><a href="#"> Item 3</a></li>
                    <li class="active"><a href="#"> Item 4</a></li>
                    <li><a href="#"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
                </ul>
            </nav>
