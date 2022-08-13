<?php
    $selectCatrgory = $_POST['selectCatrgory'];
    $selectDate = $_POST['selectDate'];
    $location = $_POST['location'];

    function get_months($selectDate) {
        $months = explode(' - ', $selectDate);
        $monthsArr = array();
            for ($i=0; $i < count($months); $i++) { 
                array_push($monthsArr, explode('.', $months[$i])[1]);
            }
        if($monthsArr[0] === $monthsArr[1]) {
            $months = array( 1 => 'Январь' , 'Февраль' , 'Март' , 'Апрель' , 'Май' , 'Июнь' , 'Июль' , 'Август' , 'Сентябрь' , 'Октябрь' , 'Ноябрь' , 'Декабрь' );
            $month = $months[(int) $monthsArr[0]];
            
        } else {
            $month = 'Март';
        }
        return $month;
    }

    function get_google_sheet_data($month) {
        $google_sheets_api = get_field('api_google_sheets', 'option');
        $goole_indetificator_table = get_field('indetifikator_table', 'option');
        $range_sheets_list = get_field('range_sheets_list', 'option');
        $api_key = esc_attr($google_sheets_api);
        $list = "'".$month."'!".$range_sheets_list."";
        $get_cell = new WP_Http();
        $cell_url = "https://sheets.googleapis.com/v4/spreadsheets/$goole_indetificator_table/values/$list?&key=$api_key";
        $cell_response = $get_cell -> get($cell_url);
        $json_body = json_decode($cell_response['body'],true);
        $data = $json_body['values'];
        return $data;
    }

    function restructure_sheets_arr($data) {
        $arr_sheets = array();
        foreach ($data as $key => $row) {
            array_push($arr_sheets, array(
                $row[0],
                $row[1],
                $row[2],
                $row[3],
            ));
        }
        return $arr_sheets;
    }
    function filtered_data($arr_sheets, $selectCatrgory, $location, $selectDate) {
        $arrDate = explode(' - ', $selectDate);
        
        if(count($arrDate) < 2) {
            $start_date = strtotime($arrDate[0]);
            $end_date = $start_date;
        } else {
            $start_date = strtotime($arrDate[0]);
            $end_date = strtotime($arrDate[1]);
        }
        $arr_filtered_sheets = array();
        foreach ($arr_sheets as $key => $value) {
            $date = strtotime($value[0]);
            $inRange = ($date >= $start_date && $date <= $end_date)? true : false;
            if (array_search($selectCatrgory, $value) && array_search($location, $value) && $inRange) {
                array_push($arr_filtered_sheets, $value);
            }
        }
        return $arr_filtered_sheets;
    }

    $month = get_months($selectDate);
    $data  = get_google_sheet_data($month);
    $arr_sheets = restructure_sheets_arr($data);
    $arr_filtered_sheets = filtered_data($arr_sheets, $selectCatrgory, $location, $selectDate);

    for ($i=0; $i < 2; $i++) { 
        echo '<div class="schedule-list__item__table__row">';
        foreach ($data as $key => $row) {
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
?>