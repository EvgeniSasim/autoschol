<?php 
    $title = $args['zagolovok'];
    $advantages = $args['preimushhestva'];
?>
<section class="advantages-section">
    <div class="container">
        <h3><?php echo $title; ?></h3>
        <div class="advantage-list">
            <?php foreach ($advantages as $key => $advantage) { 
                $img = $advantage['ikonka_bloka'];
            ?>
            <div class="advantage-list__item">
                <div class="advantage-list__item__head">
                    <h4><?php echo $advantage['zagolovok']; ?></h4>
                    <div class="advantage-list__item__head__icon">
                        <img 
                            src="<?php echo $img['url'] ?>" 
                            alt="<?php echo $img['alt'] ?>"
                            title="<?php echo $img['title'] ?>"
                            width="<?php echo $img['width'] ?>"
                            height="<?php echo $img['height'] ?>"
                            loading="lazy"
                        >
                    </div>
                </div>
                <div class="advantage-list__item__descr">
                    <p><?php echo $advantage['opisanie'] ?></p>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</section>