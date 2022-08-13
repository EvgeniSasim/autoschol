<?php 
    $title = $args['title_schedule_section'];
    $schedule = get_field('schedule', 'option');
    $schedule_btn = $args['knopka_pod_sekcziej'];
    $idForm = url_to_postid($schedule_btn);
    $cat_prav_page = $args['cat_prav_page'];
?>
<section class="schedule-section">
    <div class="container">
        <h3><?php echo $title; ?></h3>
        <div class="schedule-short-descr">
            <span>Вы можете присоединиться в группу, по которой уже началось обучение или записаться в новую группу</span>
        </div>
        <div class="schedule-filter">
            <ul class="btn-list">
                <?php 
                    $i = 0;
                    foreach ($schedule as $key => $name) { 
                    $cat_prav = $name['vyberite_kategoriyu_prav'];
                    if($cat_prav === $cat_prav_page) {
                    $i++;
                ?>
                <li 
                    data-name="name-<?php echo $key; ?>" 
                    class="btn-list__item <?php if($i === 1) { echo 'active'; } ?>">
                    <span><?php echo $name['ukazhite_tip_gruppy'] ?></span>
                </li>
                <?php } } ?>
            </ul>
        </div>
        <div class="schedule-tables-wrapper">
            <?php $i = 0;
                  foreach ($schedule as $key => $table) {
                  $cat_prav = $table['vyberite_kategoriyu_prav'];
                  if($cat_prav === $cat_prav_page) {
                  $i++;
            ?>
            <div class="schedule-table <?php if($i === 1) { echo 'active'; } ?>">
                <table>
                    <thead>
                        <tr>
                            <td><span>Дата начала</span></td>
                            <td><span>Дата окончания</span></td>
                            <td><span>Дни занятий</span></td>
                            <td><span>Время</span></td>
                            <td><span>Стоимость</span></td>
                            <td><span>Преподаватель</span></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($table['gruppa'] as $key => $row) { ?>
                        <tr>
                            <td><span><?php echo $row['data_nachala'];?></span>
                            <?php if($row['idyot_nabor']) { echo '<br/><span>идет донабор</span>'; } ?>
                            </td>
                            <td><span><?php echo $row['data_okonchaniya'];?></span></td>
                            <td><?php foreach ($row['dni_zanyatij'] as $key => $day) { ?>
                                    <span><?php echo $day["label"]; ?></span><br/>
                            <?php } ?></td>
                            <td>
                                <span>с <?php echo $row['vremya_s'];?></span>
                                <span>до <?php echo $row['vremya_do'];?></span>
                            </td>
                            <td><span><?php echo $row['stoimost'];?></span></td>
                            <td><?php foreach ($row['prepodavatel'] as $key => $teach) { ?>
                                    <a href="<?php echo get_permalink($teach->ID); ?>" target="_blank">
                                        <?php echo $teach->post_title; 
                                    ?></a><br/>
                            <?php } ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php } } ?>
        </div>
        <?php if($schedule_btn) { ?>
        <div class="schedule-btn">
            <button class="primary-btn <?php echo "btn-" .$idForm;?>"><?php echo get_the_title($idForm); ?></button>
        </div>
        <?php } ?>
    </div>
</section>
<?php 
    $subTitle = $args['podzagolovok'];
    $descr = $args['opisanie'];
?>
<section class="modal-window schedule" data-cat="<?php echo $cat_prav_page; ?>" id="<?php echo $idForm.'-modal'; ?>">
    <div class="container">
       <div class="modal-wrapper">
            <span class="close-modal"></span>
            <h3><?php echo get_the_title($idForm); ?></h3>
            <div class="trigger-subtitle additional-services">
                <p><?php echo $subTitle; ?></p>
            </div>
            <div class="trigger-description">
                <p><?php echo $descr; ?></p>
            </div>
            <div class="trigger-form">
                <?php echo do_shortcode('[contact-form-7 id="'. $idForm .'" title=""]'); ?>
            </div>
            <div class="notification">
                <span>Мы ценим ваш запрос!<br/> В ближайшее время с Вами свяжется один из Наших специалистов.</span>
            </div>
       </div>
    </div>
</section>
<script>
    let checkboxList = document.querySelectorAll('.wpcf7-form input[type="checkbox"]');
    let dataAttrList = document.querySelectorAll('#select__schedule option');
    let dataCatPage = document.querySelector('.modal-window.schedule').getAttribute('data-cat');
    let checkboxValue;
    let dataCat;
    let dataType;
    const selectDate = () => {
        dataAttrList.forEach((option) => { 
            dataCat = option.getAttribute('data-cat');
            dataType = option.getAttribute('data-type');
            if(dataCatPage !== dataCat) {
                option.hidden = true;
            }
            if(checkboxValue !== undefined) {
                if(checkboxValue !== dataType) {
                    option.hidden = true;
                } else if(checkboxValue === dataType && dataCatPage === dataCat) {
                    option.hidden = false;
                }
            }
           if( document.querySelectorAll('select > option[hidden]').length === dataAttrList.length) {
                document.querySelector('select > option#not_data').selected = true;
           } else {
            document.querySelector('select > option#not_data').selected = false;
           }
        });
    } 
    checkboxList.forEach((item) => { 
        item.addEventListener('change', () => {
            if(item.value === 'Утро') {
                checkboxValue = 'utro';
            }
            if(item.value === 'Вечер') {
                checkboxValue = 'vech';
            }
            if(item.value === 'Выходные') {
                checkboxValue = 'vuh';
            }
            selectDate();
        });
        selectDate();
     });
</script>
<?php 
    $scripts = '
        tabMenu(".schedule-filter > .btn-list > .btn-list__item",".schedule-table");
        modal("'. $idForm .'");
    ';
    add_action( 'wp_enqueue_scripts', 'add_scripts_ui' );
    do_action( 'wp_enqueue_scripts', $scripts );
?>