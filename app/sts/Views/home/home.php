<?php
if (!defined('URL')) {
    header("Location: /");
    exit();
}

//var_dump($this->Dados['sts_carousels']);
?>
<main role="main">
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators"> 
            <?php
            $cont_marc = 0;
            foreach ($this->Dados['sts_carousels'] as $carousel) {
                echo "<li data-target='#myCarousel' data-slide-to='$cont_marc'></li>";
                $cont_marc++;
            }
            ?>
        </ol>
        <div class="carousel-inner">
            <?php
            $cont_slide = 0;
            foreach ($this->Dados['sts_carousels'] as $carousel) {
                extract($carousel);
                ?>
                <div class="carousel-item <?php
                if ($cont_slide == 0) {
                    echo 'active';
                }
                ?>">
                    <img class="first-slide img-fluid" src="<?php echo URL . '/assets/imagens/carousel/' . $id . '/' . $imagem; ?>" alt="Primeiro conteúdo">
                </div>
                <?php
                $cont_slide++;
            }
            ?>
        </div>
        <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</main>