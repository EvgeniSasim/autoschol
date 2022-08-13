<!DOCTYPE HTML>
<html <?php language_attributes(); ?> itemscope itemtype="http://schema.org/WebPage">
  <head>
      <meta charset="<?php bloginfo( 'charset' ); ?>"/>
      <title>
          <?php wp_title('');?>
      </title>
      <meta name="viewport" content="width=device-width, initial-scale=1" />
      <link rel="profile" href="http://gmpg.org/xfn/11" />
    <?php wp_head(); ?>
  </head>
  <header>
    <div class="header-top-section">
      <div class="container">
        <div class="widget-wrapper">
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
          <div class="widgets-info">
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
            <div class="widgets-info__adress">
              <?php
                $addresses = get_field('adresa', 'option');
                foreach ($addresses as $adress) { ?>
                  <span class="adress"><?php echo $adress['vvedite_adres']; ?></span>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="header-bottom-section">
      <div class="container">
        <div id="burger-icon" class="pushmenu">
          <img 
            src="<?php echo get_template_directory_uri(); ?>/img/menu_burger_icon.svg" 
            alt="Меню"
            height="16"
            width="16"
            loading="lazy"
            >
        </div>
        <div class="header-logo">
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
        </div>
        <nav class="navbar-header">
          <div class="mobail-menu_head">
            <span>Меню</span>
            <div id="burger-icon_close" class="pushmenu opened">
              <img 
                src="<?php echo get_template_directory_uri(); ?>/img/close_icon.svg" 
                alt="Закрыть"
                height="12"
                width="12"
                loading="lazy"
              >
            </div>
          </div>
          <?php
              wp_nav_menu([
                'theme_location' => 'menu-header',
                'menu_class'     => 'navbar-navi', 
                'container'      => false,
                'depth'          => 0, 
                'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
                'walker'         => new Popover_Menu(),
              ]);
            ?>
          <div class="widget-wrapper">
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
          <div class="header-btn">
            <?php $idCF7 = url_to_postid(get_field('id_popup', 'option')['id_kontaktnoj_formy']);?>
            <button class="primary-btn <?php echo "btn-" .$idCF7;?>">
              <?php the_field('tekst_knopki', 'option'); ?>
            </button>
          </div>
        </nav>
        <div class="hidden-overley"></div>
        <div class="header-btn">
          <button class="primary-btn <?php echo "btn-" .$idCF7;?>">
            <?php the_field('tekst_knopki', 'option'); ?>
          </button>
          <div class="call">
            <?php
              $numbers = get_field('nomera_telefonov', 'option');
              foreach ($numbers as $key => $number) { 
                if($key == 0) {    
            ?>
              <a href="tel:<?php echo $number['nomer_telefona']; ?>">
                  <img 
                    src="<?php echo get_template_directory_uri(); ?>/img/call_icon.svg" 
                    alt="Позвонить"
                    height="16"
                    width="16"
                    loading="lazy"
                  >
              </a>          
            <?php 
                break;
              }
                } 
            ?>
          </div>
        </div>
      </div>
    </div>
  </header>