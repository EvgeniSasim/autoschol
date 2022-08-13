<?php 
    $title_section = $args['tetle_section'];
    $steps = $args['steps'];
?>
<section class="step-edu-section">
    <div class="container">
        <h3><?php echo $title_section; ?></h3>
        <div class="steps-list">
            <?php foreach ($steps as $key => $step) {
                $img = $step['icon'];
            ?>
            <div class="steps-list__item">
                <div class="steps-list__item__img">
                    <img 
                        src="<?php echo $img['url'] ?>" 
                        alt="<?php echo $img['alt'] ?>"
                        title="<?php echo $img['title'] ?>"
                        width="<?php echo $img['width'] ?>"
                        height="<?php echo $img['height'] ?>"
                        loading="lazy"
                    >
                </div>
                <div class="steps-list__item__title">
                    <span><?php echo $step['title']; ?></span>
                </div>
                <div class="steps-list__item__descr">
                    <?php echo $step['descr']; ?> 
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</section>