<?php 
    $title = $args['zagolovok'];
    $trainings = $args['trainings'];
?>
<section class="advantages-section trainings">
    <div class="container">
        <h3><?php echo $title; ?></h3>
        <div class="advantage-list">
            <?php foreach ($trainings as $key => $training) { 
                $img = $training['ikonka'];
                $link = $training['ssylka'];
            ?>
            <a href="<?php echo $link; ?>" class="advantage-list__item trainings">
                <div class="advantage-list__item__head">
                    <h4><?php echo $training['zagolovok']; ?></h4>
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
                <div class="advantage-list__item__descr trainings">
                    <p><?php echo $training['opisanie'] ?></p>
                    <ul class="training-list">
                        <?php 
                            $list = $training['spisok'];
                            foreach ($list as $key => $item) {
                                $img = $item['ikonka'];
                                $listItem = explode(":", $item['opisanie']);
                                $newStringItem = '<span>'. $listItem[0] .'</span>:' . $listItem[1];
                        ?>
                            <li>
                                <img 
                                    src="<?php echo $img['url'] ?>" 
                                    alt="<?php echo $img['alt'] ?>"
                                    title="<?php echo $img['title'] ?>"
                                    width="<?php echo $img['width'] ?>"
                                    height="<?php echo $img['height'] ?>"
                                    loading="lazy"
                                >
                                <?php echo $newStringItem; ?>
                            </li>
                        <?php
                            }
                        ?>
                    </ul>
                </div>
            </a>
            <?php } ?>
        </div>
    </div>
</section>
