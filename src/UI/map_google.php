<?php 
    $title = $args['zagolovok'];
    $info_cards = $args['info_card'];
    $map_points = $args['ukazhite_tochki_na_karte'];
    $zoom = $args['zoom'];
    add_action( 'wp_google_map', 'google_map');
    do_action('wp_google_map');
?>
<section class="map-google-section">
    <div class="container">
        <h3><?php echo $title; ?></h3>
        <div class="map-container">
        <div class="map-container__elem"></div>
            <?php foreach($info_cards as $key => $info_card): ?>
                <?php $rows = $info_card['add_info']; ?>
            <ul id="marker<?php echo $key; ?>" class="info-list <?php echo $key == 0 ? 'active' : '' ?>">
                <?php foreach($rows as $key => $row): ?>
                <li class="info-list__item">
                    <h4><?php echo $row['zagolovok'] ?></h4>
                    <span><?php echo $row['znachenie'] ?></span>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php if ( is_home() || is_front_page()) { ?>
<script>
    let dir = '<?php echo get_template_directory_uri(); ?>';
    let showCard = (markerID) => {
       let markers = document.querySelectorAll('.info-list');
       markers.forEach(marker => {
           let markerIdEl = marker.getAttribute('id');
            if(markerID == markerIdEl) {
                marker.classList.add('active');
            } else {
                marker.classList.remove('active');
            }
       });
    }
    function initMap() {
    const mapElement = document.querySelector('.map-container__elem');
    const position = { 
        <?php foreach($map_points as $key => $point): ?>
        marker<?php echo $key; ?>: {lat: <?php echo $point['lat']; ?>, lng: <?php echo $point['lng']; ?> },
        <?php endforeach; ?>
    };
    let ulurlu = position.marker1;
    const map = new google.maps.Map(mapElement, {
      zoom: <?php echo $zoom; ?>,
      center: ulurlu,
      disableDefaultUI: true,
    });
    <?php foreach($info_cards as $key => $info_card): ?>
    const marker<?php echo $key; ?> = new google.maps.Marker({
      position: position.marker<?php echo $key; ?>,
      map,
      title: "<?php echo $info_card['add_info'][0]['zagolovok']; ?>",
      markerID: "marker<?php echo $key; ?>",
      icon: {
		url: '<?php echo $info_card['location_icon']['url']; ?>',
		scaledSize: new google.maps.Size(41, 41)
	    }
    });
    google.maps.event.addListener(marker<?php echo $key; ?>, 'click', function() {
        showCard(marker<?php echo $key; ?>.markerID);
    });
    <?php endforeach; ?>
    }
</script>
<?php } ?>