<?php

/**
 * Fired during plugin activation
 *
 * @link       https://rajanlama.com.np
 * @since      1.0.0
 *
 * @package    Fintech_Profiler
 * @subpackage Fintech_Profiler/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Fintech_Profiler
 * @subpackage Fintech_Profiler/includes
 * @author     Rajan Lama <rajan.lama786@gmail.com>
 */
class Fintech_Profiler_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		// Register the plugin roles once, at activation time, instead of
		// recreating them on every request.
		$fintech_caps = array(
			'delete_private_fintech_profiles',
			'delete_published_fintech_profiles',
			'edit_private_fintech_profile',
			'edit_published_fintech_profiles',
			'publish_fintech_profiles',
			'edit_fintech_profiles',
			'edit_others_fintech_profiles',
			'delete_fintech_profiles',
			'delete_others_fintech_profiles',
			'read_private_fintech_profiles',
			'edit_fintech_profile',
			'delete_fintech_profile',
			'read_fintech_profile',
			'upload_files',
		);

		$financial_caps = array(
			'publish_financial_profiles',
			'edit_financial_profiles',
			'edit_others_financial_profiles',
			'delete_financial_profiles',
			'delete_others_financial_profiles',
			'read_private_financial_profiles',
			'edit_financial_profile',
			'delete_financial_profile',
			'read_financial_profile',
			'upload_files',
		);

		if (! get_role('fintech_manager')) {
			add_role('fintech_manager', 'Fintech Manager', $fintech_caps);
		}

		if (! get_role('financial_manager')) {
			add_role('financial_manager', 'Financial Manager', $financial_caps);
		}

		// Ensure existing roles keep the custom caps (idempotent).
		$fintech_role = get_role('fintech_manager');
		if ($fintech_role) {
			foreach ($fintech_caps as $cap) {
				$fintech_role->add_cap($cap, true);
			}
		}

		$financial_role = get_role('financial_manager');
		if ($financial_role) {
			foreach ($financial_caps as $cap) {
				$financial_role->add_cap($cap, true);
			}
		}

		$admin_role = get_role('administrator');
		if ($admin_role) {
			foreach (array_merge($fintech_caps, $financial_caps) as $cap) {
				$admin_role->add_cap($cap, true);
			}
		}

		// Rebuild rewrite rules so the registered post types are reachable.
		flush_rewrite_rules();
	}

}
