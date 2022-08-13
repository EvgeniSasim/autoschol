<?php 
    $schedule_list = $args['schedule_list'];
    $nameBtn = $args["filtr_btn"] ? $args["filtr_btn"] : 'Фильтр';
    add_action( 'wp_init_air_datepicker', 'init_air_datepicker');
    do_action('wp_init_air_datepicker');
?>
<section class="google-sheets-section">
    <div class="container">
    <ul class="btn-list google-sheets">
        <?php foreach ($schedule_list as $key => $schedule) { ?>
            <li 
                data-name="name-<?php echo $key; ?>" 
                class="btn-list__item <?php if($key === 0) { echo 'active'; } ?>">
                <span><?php echo $schedule['cat_schedule']; ?></span>
            </li>
            <?php } ?>
        </ul>
        <div class="google-sheets__row">
            <?php foreach ($schedule_list as $key => $schedule) { ?>
            <div class="google-sheets__row__col <?php if($key === 0) { echo 'active'; } ?>">
                <div class="filteres">
                    <div class="data-picker">
                        <input 
                        id="date-filter__<?php echo $key; ?>" 
                        class="goo_sheets_input"
                        type="text"
                        placeholder="Выберите дату"
                        inputmode='none'
                        readonly="readonly"
                        >
                        <span></span>
                    </div>
                    <div class="data-picker">
                        <select name="name" id="select__<?php echo $key; ?>">
                            <option value="" disabled selected hidden>Выберите категорию прав</option>
                            <option value="A">Категория А</option>
                            <option value="B">Категория Б</option>
                        </select>
                        <span></span>
                    </div>
                    <div class="get-sheets-data data-picker">
                        <button 
                            id="btn-filter__<?php echo $key; ?>" 
                            data-location="<?php echo $schedule['value_tab']; ?>" 
                            class="primary-btn">
                           <?php echo $nameBtn; ?>
                        </button>
                    </div>
                </div>
                <div class="schedule-list">
                <div class="schedule-list__item">
                    <div class="schedule-list__item__table">
                        <?php 
                            $filter = array(
                                'location' => $schedule['value_tab'],
                            );
                            add_action( 'wp_get_google_sheet_data', 'get_google_sheet_data' );
                            do_action( 'wp_get_google_sheet_data', $filter );
                        ?>
                        <div class="schedule-list__item__table__row">
                            <div class="schedule-list__item__table__row__col"><span>Как оплачивать за экзамен</span></div>
                            <div class="schedule-list__item__table__row__col descr">
                                <?php echo  $schedule['kak_oplachivat_za_ekzamen']; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <?php } ?>
        </div>
    </div>
</section>
<?php 
    $scripts = '
        tabMenu(".google-sheets > .btn-list__item",".google-sheets__row__col");
    ';
    add_action( 'wp_enqueue_scripts', 'add_scripts_ui' );
    do_action( 'wp_enqueue_scripts', $scripts );

// Get google sheets data
function get_google_sheet_data($filter) {
    $months = array( 1 => 'Январь' , 'Февраль' , 'Март' , 'Апрель' , 'Май' , 'Июнь' , 'Июль' , 'Август' , 'Сентябрь' , 'Октябрь' , 'Ноябрь' , 'Декабрь' );
    $mouns = $months[date( 'n' )];
	$google_sheets_api = get_field('api_google_sheets', 'option');
	$goole_indetificator_table = get_field('indetifikator_table', 'option');
	$range_sheets_list = get_field('range_sheets_list', 'option');
	$api_key = esc_attr($google_sheets_api);
	$location = "'".$mouns."'!".$range_sheets_list."";
	$get_cell = new WP_Http();
	$cell_url = "https://sheets.googleapis.com/v4/spreadsheets/$goole_indetificator_table/values/$location?&key=$api_key";
	$cell_response = $get_cell -> get($cell_url);
    if($cell_response["response"]['code'] === 200) {
	$json_body = json_decode($cell_response['body'],true);
	$list = $json_body['values'];
    $arr_sheets = array();
    $arr_filtered_sheets = array();
    foreach ($list as $key => $row) {
        array_push($arr_sheets, array(
            $row[0],
            $row[1],
            $row[2],
            $row[3],
        ));
    }
    foreach ($arr_sheets as $key => $value) {
        if (array_search($filter['location'], $value)) {
            array_push($arr_filtered_sheets, $value);
        }
    }
    for ($i=0; $i < 3; $i++) { 
        echo '<div class="schedule-list__item__table__row">';
        foreach ($list as $key => $row) {
            if(!empty($row[$i]) && $key < 1) {
                echo '<div class="schedule-list__item__table__row__col"><span>'.$row[$i].'</span></div>';
            }
        }
        foreach ($arr_filtered_sheets as $key => $filter_res) {
            if(!empty($filter_res[$i])) {
                echo '<div class="schedule-list__item__table__row__col"><span>'.$filter_res[$i].'</span></div>';
            }
        }
        echo '</div>';
    }
} else {
    echo '<div class="schedule-list__item__table__row">
            <div class="schedule-list__item__table__row__col"><span>Нет данных</span></div>
            <div class="schedule-list__item__table__row__col"><span></span></div>
            <div class="schedule-list__item__table__row__col"><span></span></div>
            <div class="schedule-list__item__table__row__col"><span></span></div>
            <div class="schedule-list__item__table__row__col"><span></span></div>
          </div>';
    echo '<div class="schedule-list__item__table__row">
            <div class="schedule-list__item__table__row__col"><span>Нет данных</span></div>
            <div class="schedule-list__item__table__row__col"><span></span></div>
            <div class="schedule-list__item__table__row__col"><span></span></div>
            <div class="schedule-list__item__table__row__col"><span></span></div>
            <div class="schedule-list__item__table__row__col"><span></span></div>
          </div>';
}
}
add_action('wp_get_google_sheet_data_ajax', 'get_google_sheet_data_ajax');
do_action('wp_get_google_sheet_data_ajax');
?>