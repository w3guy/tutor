<?php

namespace Tutor\Core\Contracts;

/**
 * Column contract
 *
 * @since 2.2.3
 */
interface ColumnContract {
	/**
	 * Post type columns
	 *
	 * @param array $columns    an array of columns.
	 * @return void
	 */
	public function columns( $columns );

	/**
	 * Column data
	 *
	 * @param string $column_name   column name.
	 * @param int    $post_id       post id of current column.
	 * @return void
	 */
	public function column_data( $column_name, $post_id );
}
