<?php

/**
 * @param $str-or-arr, $checker_arr, $rev_return_val
 * @return boolean
 *
 * Check the existence of a page ID from a string or array by an array
 * of page IDs.
 */
function check_page_id_existence ( $str_or_arr, $checker_arr, $rev_return_val = false )
{
	if ( ! is_array( $str_or_arr ) ) {
		if ( in_array( $str_or_arr, $checker_arr ) ) {
			if ( $rev_return_val ) {
				return false;
			} else {
				return true;
			}
		} else {
			if ( $rev_return_val ) {
				return true;
			} else {
				return false;
			}
		}
	} else {
		$i = 0;
		foreach ( $str_or_arr as $id ) {
			if ( in_array( $id, $checker_arr ) ) {
				$i++;
			} else {
				continue;
			}
		}
		if ( count( $str_or_arr ) === $i ) {
			if ( $rev_return_val ) {
				return false;
			} else {
				return true;
			}
		} else {
			if ( $rev_return_val ) {
				return true;
			} else {
				return false;
			}
		}
	}
}

/**
 * Remove items from an array by getting the key of the item to be
 * removed, then removing the item with unset() function.
 */
function remove_items_from_array ( $item, $arr )
{
	$key = array_search( $item, $arr );
	unset( $arr[$key] );
	return $arr;
}

/**
 * Debugging function that prints.
 */
function r($var)
{
	echo '<pre>';
	print_r($var);
	echo '</pre>';
}

/**
 * Debugging function that dumps.
 */
function d($var)
{
	echo '<pre>';
	var_dump($var);
	echo '</pre>';
}

?>
