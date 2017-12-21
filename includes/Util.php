<?php

class Util {

	static function get_breadcrumb() {
		//$path = explode( "/", $_SERVER['REQUEST_URI'] );
		$path = preg_split( "/\//", $_SERVER['PHP_SELF'], -1, PREG_SPLIT_NO_EMPTY );

		$breadcrumb = '<ol class="breadcrumb">';

		foreach ( $path as $item ) {
			if ($item == end($path)) {
				$breadcrumb .= '<li class="breadcrumb-item active">' . ucfirst($item) . '</li>';
			} else {
			$breadcrumb .= '<li class="breadcrumb-item"><a href="">' . ucfirst($item) . '</a></li>';
			}
		}

		$breadcrumb .= '</ol>';

		echo $breadcrumb;
	}
}