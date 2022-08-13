<?php 
    $title = $args['zagolovok'];
    $columns = $args['ikonka_s_podpisyu'];
?>
<section class="in-numbers-section">
    <div class="container">
        <h2><?php echo $title; ?></h2>
        <div class="in-numbers-wrapper">
        <?php foreach ($columns as $key => $col) { 
            $img = $col['ikonka'];    
        ?>
            <div class="in-numbers-col">
                <div class="in-numbers-col__icon">
                <img 
                    src="<?php echo $img['url'] ?>" 
                    alt="<?php echo $img['alt'] ?>"
                    title="<?php echo $img['title'] ?>"
                    width="<?php echo $img['width'] ?>"
                    height="<?php echo $img['height'] ?>"
                    loading="lazy"
                >
                </div>
                <div class="in-numbers-col__descr">
                    <span><?php echo $col['zagolovok_pod_ikonkoj']; ?></span>
                </div>
            </div>
        <?php } ?>
        </div>
    </div>
</section>