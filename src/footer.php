        </main>
        <footer class="footer">
            <div class="container">
                <div class="footer-wrapper">
                    <div class="footer-item">
                        <?php
                            if ( is_front_page() ) {
                                $logo_img = '';
                                if( $custom_logo_id = get_theme_mod('custom_logo') ){
                                    $logo_img = wp_get_attachment_image( $custom_logo_id, 'full', false, array(
                                        'class'    => 'navbar-brand',
                                        'itemprop' => 'logo',
                                    ) );
                                }
                                echo $logo_img;
                            } else {
                                the_custom_logo();
                            }
                        ?>
                        <span><?php the_field('yuridicheskoe_nazvanie_kompanii', 'option');?></span>
                    </div>
                    <div class="footer-item">
                        <h4><?php the_field('zagolovok_kolonki_gde_ukazany_adres_i_vremya_raboty', 'option');?></h4>
                        <div class="widgets-info">
                            <div class="widgets-info__adress">
                                <?php
                                $addresses = get_field('adresa', 'option');
                                foreach ($addresses as $adress) { ?>
                                    <span class="adress"><?php echo $adress['vvedite_adres']; ?></span>
                                <?php } ?>
                            </div>
                            <div class="widgets-info__schedule">
                                <?php
                                $schedule = get_field('rezhim_raboty', 'option');
                                foreach ($schedule as $item) { ?>
                                <div class="widgets-info__schedule__item">
                                    <span class="days"><?php echo $item['days']; ?>:&nbsp;</span>
                                    <span class="hours"><?php echo $item['hours']; ?></span>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="footer-item">
                        <h4><?php the_field('zagolovok_kolonki_s_kontaktami', 'option');?></h4>
                        <div class="widgets-contacts">
                            <div class="widgets-contacts__phone-numbers">
                                <?php
                                $numbers = get_field('nomera_telefonov', 'option');
                                foreach ($numbers as $number) { ?>
                                <a href="tel:<?php echo $number['nomer_telefona']; ?>"><?php echo $number['nomer_telefona']; ?></a>        
                                <?php } ?>
                            </div>
                            <div class="widgets-contacts__emails">
                                <?php
                                $emails = get_field('email_adresa', 'option');
                                foreach ($emails as $email) { ?>
                                <a href="mailto:<?php echo $email['vvedite_e-mail']; ?>"><?php echo $email['vvedite_e-mail']; ?></a>        
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="footer-item">
                        <h4><?php the_field('zagolovok_kolonki_s_soczialnymi_setyami', 'option');?></h4>
                        <div class="social-list">
                            <?php
                                $socials = get_field('dobavit_soczialnye_seti', 'option');
                                foreach ($socials as $key => $soc) {
                                    $socName = $soc['vybrat_soczialnuyu_set'];
                                    $socUrl = $soc['ukazhite_url'];
                            ?>
                                <a href="<?php echo $socUrl['url']; ?>" target="<?php echo $socUrl['target'] ?>">
                                    <i class="fa fa-<?php echo $socName['value']; ?>" aria-hidden="true"></i>
                                    <span><?php echo $socName['label']; ?></span>
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-coperight">
                <?php 
                    $url = get_field('url', 'option');
                ?>
                <a href="<?php echo $url['url'] ?>" target="<?php echo $url['target'] ?>"><?php echo $url['title'] ?></a>
            </div>
        </footer>
        <?php require get_template_directory() . '/UI/popup_form.php'; ?>
        <?php wp_footer(); ?>
    </body>
</html>