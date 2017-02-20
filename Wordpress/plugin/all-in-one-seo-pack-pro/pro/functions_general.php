<?php

//
// Taxonomy meta functions - for pre-4.4... we should look at whether we still need this
//
global $wpdb;
if ( !function_exists( 'add_term_meta' ) ) {
	if ( !isset( $wpdb->taxonomymeta ) )
		add_filter( 'add_taxonomy_metadata', 'add_tax_meta', 10, 5 );
	if ( !function_exists( 'add_tax_meta' ) ) {
		function add_tax_meta( $check, $object_id, $meta_key, $meta_value, $unique = false ) {
			$object_id = ( is_object( $object_id ) ) ? $object_id->term_id : $object_id;
			$m = get_option( 'tax_meta_' . $object_id );
			if ( isset( $m[$meta_key] ) )
				return false;
			$m[$meta_key] = $meta_value;
			update_option( 'tax_meta_' . $object_id, $m );
			return true;
		}
	}
	/**
	 * Add meta data field to a term.
	 *
	 * @param int $term_id Post ID.
	 * @param string $key Metadata name.
	 * @param mixed $value Metadata value.
	 * @param bool $unique Optional, default is false. Whether the same key should not be added.
	 * @return bool False for failure. True for success.
	 */
	function add_term_meta( $term_id, $meta_key, $meta_value, $unique = false ) {
		global $wpdb;
		$tax_unset = 1;
		if ( isset( $wpdb->taxonomymeta ) )
			$tax_unset = 0;
		if ( $tax_unset )
			$wpdb->taxonomymeta = "{$wpdb->prefix}taxonomymeta";
		$meta = add_metadata( 'taxonomy', $term_id, $meta_key, $meta_value, $unique );
		if ( $tax_unset )
			unset( $wpdb->taxonomymeta );
		return $meta;
	}
}
if ( !function_exists( 'delete_term_meta' ) ) {
	if ( !isset( $wpdb->taxonomymeta ) )
		add_filter( 'delete_taxonomy_metadata', 'aioseop_delete_tax_meta', 10, 3 );
	if ( !function_exists( 'aioseop_delete_tax_meta' ) ) {
		function aioseop_delete_tax_meta( $check, $term_id, $key ) {
			$term_id = ( is_object( $term_id ) ) ? $term_id->term_id : $term_id;
			$m = get_option( 'tax_meta_' . $term_id );
			if ( isset($m[$key] ) ) {
				unset( $m[$key] );
				update_option( 'tax_meta_' . $term_id, $m );
				return true;
			}
			return false;
		}
	}
	/**
	 * Remove metadata matching criteria from a term.
	 *
	 * You can match based on the key, or key and value. Removing based on key and
	 * value, will keep from removing duplicate metadata with the same key. It also
	 * allows removing all metadata matching key, if needed.
	 *
	 * @param int $term_id term ID
	 * @param string $meta_key Metadata name.
	 * @param mixed $meta_value Optional. Metadata value.
	 * @return bool False for failure. True for success.
	 */
	function delete_term_meta($term_id, $meta_key, $meta_value = '') {
		global $wpdb;
		$tax_unset = 1;
		if ( isset( $wpdb->taxonomymeta ) )
			$tax_unset = 0;
		if ( $tax_unset )
			$wpdb->taxonomymeta = "{$wpdb->prefix}taxonomymeta";
		$meta = delete_metadata( 'taxonomy', $term_id, $meta_key, $meta_value );
		if ( $tax_unset )
			unset( $wpdb->taxonomymeta );
		return $meta;
	}
}
if ( !function_exists( 'get_term_meta' ) ) {
	if ( !isset( $wpdb->taxonomymeta ) )
		add_filter( 'get_taxonomy_metadata', 'aioseop_get_tax_meta', 10, 4 );
	if ( !function_exists( 'aioseop_get_tax_meta' ) ) {
		function aioseop_get_tax_meta( $check, $term_id, $key, $multi = false ) {
			$t_id = ( is_object( $term_id ) ) ? $term_id->term_id : $term_id;
			$m = get_option( 'tax_meta_' . $t_id );
			if ( isset( $m[$key] ) ) return $m[$key];
			return '';
		}
	}
	/**
	 * Retrieve term meta field for a term.
	 *
	 * @param int $term_id Term ID.
	 * @param string $key The meta key to retrieve.
	 * @param bool $single Whether to return a single value.
	 * @return mixed Will be an array if $single is false. Will be value of meta data field if $single
	 *  is true.
	 */
	function get_term_meta($term_id, $key, $single = false) {
		global $wpdb;
		$tax_unset = 1;
		if ( isset( $wpdb->taxonomymeta ) )
			$tax_unset = 0;
		if ( $tax_unset )
			$wpdb->taxonomymeta = "{$wpdb->prefix}taxonomymeta";
		$meta = get_metadata( 'taxonomy', $term_id, $key, $single );
		if ( $tax_unset )
			unset( $wpdb->taxonomymeta );
		return $meta;
	}
}
if ( !function_exists( 'update_term_meta' ) ) {
	if ( !isset( $wpdb->taxonomymeta ) )
		add_filter( 'update_taxonomy_metadata', 'aioseop_update_tax_meta', 10, 5 );
	if ( !function_exists( 'aioseop_update_tax_meta' ) ) {
		function aioseop_update_tax_meta( $check, $object_id, $meta_key, $meta_value, $unique = false ) {
			$object_id = ( is_object( $object_id ) ) ? $object_id->term_id : $object_id;
			$m = get_option( 'tax_meta_' . $object_id );
			if ( !isset( $m[$meta_key] ) || ( $m[$meta_key] !== $meta_value ) ) {
				$m[$meta_key] = $meta_value;
				update_option( 'tax_meta_' . $object_id, $m );
			}
			return true;
		}
	}
	/**
	 * Update term meta field based on term ID.
	 *
	 * Use the $prev_value parameter to differentiate between meta fields with the
	 * same key and term ID.
	 *
	 * If the meta field for the term does not exist, it will be added.
	 *
	 * @param int $term_id Term ID.
	 * @param string $key Metadata key.
	 * @param mixed $value Metadata value.
	 * @param mixed $prev_value Optional. Previous value to check before removing.
	 * @return bool False on failure, true if success.
	 */
	function update_term_meta($term_id, $meta_key, $meta_value, $prev_value = '') {
		global $wpdb;
		$tax_unset = 1;
		if ( isset( $wpdb->taxonomymeta ) )
			$tax_unset = 0;
		if ( $tax_unset )
			$wpdb->taxonomymeta = "{$wpdb->prefix}taxonomymeta";
		$meta = update_metadata( 'taxonomy', $term_id, $meta_key, $meta_value, $prev_value );
		if ( $tax_unset )
			unset( $wpdb->taxonomymeta );
		return $meta;
	}
}