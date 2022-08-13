<?php 
$subtitle = $args['pod_zagolovok'];
$rows = $args['soderzhimoe_verhnej_sekczii'];
?>
<section class="about-us-section">
    <div class="container">
        <h4><?php echo $args['pod_zagolovok']; ?></h4>
        <?php foreach ($rows as $key => $row) { 
            $img = $row['izobrazhenie'];    
        ?>
        <div class="about-us__row">
            <div class="about-us__row__img">
                <img 
                    src="<?php echo $img['url'] ?>" 
                    alt="<?php echo $img['alt'] ?>"
                    title="<?php echo $img['title'] ?>"
                    width="<?php echo $img['width'] ?>"
                    height="<?php echo $img['height'] ?>"
                    loading="lazy"
                >
            </div>
            <div class="about-us__row__content">
                <?php echo $row['tekstovyj_redaktor']; ?>
            </div>
        </div>
        <?php } ?>
    </div>
</section>