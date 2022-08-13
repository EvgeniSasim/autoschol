<?php
	class Popover_Menu extends Walker_Nav_Menu {

		function start_lvl( &$output, $depth = 0, $args = NULL ) {
			$urlTemplate = get_template_directory_uri();
			$indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); 
			$display_depth = ( $depth + 1);
			$classes = array(
				( $display_depth > 0  ? 'sub-menu' : '' ),
			);
			$class_names = implode( ' ', $classes );
				if($display_depth > 0) {
					$output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
					$output .= '<li data-popper-arrow class="arrow-popper"></li>';
				}
		}
	}
?>