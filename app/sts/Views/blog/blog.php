<?php
if (!defined('URL')) {
    header("Location: /");
    exit();
}
?>
<main role="main">

    <div class="jumbotron blog">
        <div class="container">
            <h2 class="display-4 text-center" style="margin-bottom: 40px;">Blog</h2>
            <div class="row">
                <div class="col-md-8 blog-main">
                    <?php
                    if (empty($this->Dados['artigos'])) {
                        echo "<div class='alert alert-danger'>Erro: Nenhum artigo encontrado!</div>";
                    }
                    foreach ($this->Dados['artigos'] as $artigo) {
                        extract($artigo);
                        ?>
                        <div class="row featurette">
                            <div class="col-md-7 order-md-2 blog-text anim_right">
                                <a href="<?php echo URL . 'artigo/' . $slug; ?>">
                                    <h2 class="featurette-heading text-danger"><?php echo $titulo; ?></h2>
                                </a>
                                <p class="lead"><?php echo $descricao; ?> <a href="<?php echo URL . 'artigo/' . $slug; ?>" class="text-danger">Continuar lendo</a></p>
                            </div>
                            <div class="col-md-5 order-md-1 anim_left">
                                <a href="<?php echo URL . 'artigo/' . $slug; ?>">
                                    <img class="featurette-image img-fluid mx-auto" src="<?php echo URL . 'assets/imagens/artigo/' . $id . '/' . $imagem; ?>" alt="<?php echo $titulo; ?>">
                                </a>
                            </div>
                        </div>
                        <hr class="featurette-divider">
                        <?php
                    }

                    echo $this->Dados['paginacao'];
                    ?>
                </div>
                <aside class="col-md-4 blog-sidebar">
                    <div class="p-3 mb-3 bg-light rounded">
                        <h4 class="font-italic">Sobre</h4>
                        <p class="mb-0">Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
                    </div>

                    <div class="p-3">
                        <h4 class="font-italic">Recentes</h4>
                        <ol class="list-unstyled mb-0">
                            <li><a href="#">Artigo 1</a></li>
                            <li><a href="#">Artigo 2</a></li>
                            <li><a href="#">Artigo 3</a></li>
                            <li><a href="#">Artigo 4</a></li>
                            <li><a href="#">Artigo 5</a></li>
                            <li><a href="#">Artigo 6</a></li>
                            <li><a href="#">Artigo 7</a></li>
                            <li><a href="#">Artigo 8</a></li>
                            <li><a href="#">Artigo 9</a></li>
                        </ol>
                    </div>

                    <div class="p-3">
                        <h4 class="font-italic">Destaque</h4>
                        <ol class="list-unstyled">
                            <li><a href="#">Artigo 7</a></li>
                            <li><a href="#">Artigo 3</a></li>
                            <li><a href="#">Artigo 8</a></li>
                        </ol>
                    </div>
                </aside>
            </div>
        </div>
    </div>					

</main>
