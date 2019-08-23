
  <main role="main">

<div class="jumbotron sobre-empresa">
    <div class="container">
        <h2 class="display-4 text-center" style="margin-bottom: 40px;">Sobre a Empresa</h2>
        <?php
        $cont_sob_emp = 1;
        foreach ($this->Dados['sts_sobs_emps'] as $sob_emp) {
            extract($sob_emp);
            if ($cont_sob_emp == 1) {
                ?>
                <div class="row featurette">
                    <div class="col-md-7 order-md-2 anim_right">
                        <h2 class="featurette-heading"><?php echo $titulo; ?></h2>
                        <p class="lead"><?php echo $descricao; ?></p>
                    </div>
                    <div class="col-md-5 order-md-1 anim_left">
                        <img class="featurette-image img-fluid mx-auto" src="<?php echo URL . 'assets/imagens/sob_emp/' . $id . '/' . $imagem; ?>" alt="<?php echo $titulo; ?>">
                    </div>
                </div>
                <hr class="featurette-divider">
                <?php
                $cont_sob_emp = 2;
            } else {
                ?>
                <div class = "row featurette">
                    <div class = "col-md-7 anim_left">
                        <h2 class = "featurette-heading"><?php echo $titulo; ?> </h2>
                        <p class = "lead"><?php echo $descricao; ?></p>
                    </div>
                    <div class = "col-md-5 anim_right">
                        <img class = "featurette-image img-fluid mx-auto" src = "<?php echo URL . 'assets/imagens/sob_emp/' . $id . '/' . $imagem; ?>" alt="<?php echo $titulo; ?>">
                    </div>
                </div>
                <hr class = "featurette-divider">
                <?php
                $cont_sob_emp = 1;
            }
        }
        ?>


    </div>
</div>                  

</main>