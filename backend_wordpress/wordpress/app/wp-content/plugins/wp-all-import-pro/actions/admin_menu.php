<?php
/**
 * Register plugin specific admin menu
 */

function pmxi_admin_menu() {
	global $menu, $submenu;

	$icon_base64 = "PHN2ZyBjbGFzcz0iaW1nLWZsdWlkIiBpZD0ib3V0cHV0c3ZnIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIGhlaWdodD0iMjAiIHdpZHRoPSIyMCIgdmlld0JveD0iMCAwIDQwIDQwIj48cGF0aCBmaWxsPSIjZjBmMGYxIiBzdHJva2U9Im5vbmUiIGQ9Ik0zNS40MjA4IDE5Ljk4NTNDMzUuMjI0NCAxOS44NTQyIDM0Ljk3MzUgMTkuODEwNSAzNC43NTU0IDE5Ljg4N0wzMC42ODY1IDIxLjIyQzMwLjI4MjkgMjEuMzUxMiAzMC4wNjQ3IDIxLjc4ODIgMzAuMTk1NiAyMi4xODE2QzMwLjMyNjUgMjIuNTg1OSAzMC43NjI5IDIyLjgwNDQgMzEuMTU1NiAyMi42NzMzTDMyLjc0ODIgMjIuMTQ4OEMzMS41NzAxIDIzLjg4NjIgMjguNjU3NSAyNy41NDY3IDI1LjM1MjMgMjYuOTg5NUMyNC43NTIzIDI2Ljg5MTEgMjQuMzA1MSAyNi41MTk2IDI0LjE4NTEgMjYuMDM4OEMyNC4wMTA1IDI1LjM3MjMgMjQuNDU3OCAyNC41NzQ2IDI1LjM5NTkgMjMuODIwNkMyOS4wMzkzIDIwLjkzNTkgMzEuMDM1NiAxNy4xMTE1IDMxLjAzNTYgMTMuMDU3NkMzMS4wMjQ3IDUuODU2ODIgMjUuMTc3NyAwIDE3Ljk3ODIgMEMxMC43Nzg2IDAgNC45NDI1NiA1Ljg1NjgyIDQuOTQyNTYgMTMuMDY4NkM0Ljk0MjU2IDE3LjEyMjUgNi45NDk3MiAyMC45NDY5IDEwLjU4MjIgMjMuODMxNkMxMS41MjA0IDI0LjU3NDYgMTEuOTU2NyAyNS4zODMyIDExLjc5MzEgMjYuMDQ5N0MxMS42NzMxIDI2LjUzMDUgMTEuMjE0OSAyNi45MDIgMTAuNjI1OSAyNy4wMDA0QzcuMzMxNTEgMjcuNTU3NiA0LjQwODA1IDIzLjg5NzEgMy4yMjk5MyAyMi4xNTk4TDQuODExNjYgMjIuNjg0MkM1LjIxNTI3IDIyLjgxNTQgNS42NDA3IDIyLjU5NjggNS43NzE2IDIyLjE5MjVDNS45MDI1MSAyMS43ODgyIDUuNjg0MzQgMjEuMzYyMSA1LjI4MDcyIDIxLjIzMUwxLjIxMTg3IDE5Ljg4N0MwLjk4Mjc5MiAxOS44MTA1IDAuNzQyODA2IDE5Ljg0MzMgMC41NDY0NTQgMTkuOTg1M0MwLjM1MDEwMSAyMC4xMTY0IDAuMjMwMTA4IDIwLjMzNSAwLjIxOTIgMjAuNTc1NEwwLjAwMTAzMDggMjUuMDAwOEMtMC4wMjA3ODYxIDI1LjQyNjkgMC4zMDY0NjggMjUuNzc2NiAwLjcyMDk4OSAyNS43OTg0SDAuNzY0NjIzQzEuMTY4MjQgMjUuNzk4NCAxLjUwNjQgMjUuNDgxNSAxLjUyODIxIDI1LjA2NjNMMS42MTU0OCAyMy4yNjM0QzIuOTEzNTkgMjUuMTY0NyA2LjAxMTU5IDI5IDkuOTM4NjMgMjlDMTAuMjY1OSAyOSAxMC42MDQxIDI4Ljk3ODEgMTAuOTUzMSAyOC45MTI2QzEyLjMyNzYgMjguNjgzMSAxMy4zNzQ4IDI3Ljc2NTMgMTMuNzAyMSAyNi41MDg3QzE0LjA3MjkgMjUuMDU1NCAxMy4zODU3IDIzLjUxNDcgMTEuODE0OSAyMi4yNjlDOS45ODIyNyAyMC44MTU4IDYuOTE2OTkgMTcuNjkwNyA2LjkxNjk5IDEzLjA0NjdDNi45MTY5OSA2LjkyNzY2IDExLjg5MTIgMS45NDQ5OSAxOCAxLjk0NDk5QzI0LjEwODcgMS45NDQ5OSAyOS4wODMgNi45Mjc2NiAyOS4wODMgMTMuMDQ2N0MyOS4wODMgMTcuNjkwNyAyNi4wMTc3IDIwLjgxNTggMjQuMTg1MSAyMi4yNjlDMjIuNjE0MyAyMy41MTQ3IDIxLjkxNjEgMjUuMDY2MyAyMi4yOTc5IDI2LjUwODdDMjIuNjE0MyAyNy43NTQzIDIzLjY3MjQgMjguNjcyMiAyNS4wNDY4IDI4LjkxMjZDMjkuNDUzOSAyOS42NTU2IDMyLjk3NzMgMjUuMzI4NiAzNC4zODQ1IDIzLjI2MzRMMzQuNDcxOCAyNS4wNTU0QzM0LjQ5MzYgMjUuNDU5NyAzNC44MzE3IDI1Ljc4NzUgMzUuMjM1MyAyNS43ODc1SDM1LjI3OUMzNS43MDQ0IDI1Ljc2NTYgMzYuMDIwOCAyNS40MDUgMzUuOTk4OSAyNC45ODk4TDM1Ljc4MDggMjAuNTY0NEMzNS43MzcxIDIwLjM0NTkgMzUuNjA2MiAyMC4xMTY0IDM1LjQyMDggMTkuOTg1M1pNMTMuNSAxOUMxNC4zMjg0IDE5IDE1IDE4LjMyODQgMTUgMTcuNUMxNSAxNi42NzE2IDE0LjMyODQgMTYgMTMuNSAxNkMxMi42NzE2IDE2IDEyIDE2LjY3MTYgMTIgMTcuNUMxMiAxOC4zMjg0IDEyLjY3MTYgMTkgMTMuNSAxOVpNMjIuNSAxOUMyMy4zMjg0IDE5IDI0IDE4LjMyODQgMjQgMTcuNUMyNCAxNi42NzE2IDIzLjMyODQgMTYgMjIuNSAxNkMyMS42NzE2IDE2IDIxIDE2LjY3MTYgMjEgMTcuNUMyMSAxOC4zMjg0IDIxLjY3MTYgMTkgMjIuNSAxOVpNMjQuMjM2NCAzMi40MzE2QzI0LjYxMTkgMzIuMjk0NyAyNS4wMjkyIDMyLjUwNTMgMjUuMTU0MyAzMi44OTQ3TDI2LjQ2ODcgMzYuODEwNUMyNi41MzEzIDM3LjAyMTEgMjYuNSAzNy4yNjMyIDI2LjM3NDggMzcuNDUyNkMyNi4yNDk2IDM3LjY0MjEgMjYuMDQxIDM3Ljc1NzkgMjUuODExNSAzNy43Njg0TDIxLjU4NjggMzhIMjEuNTQ1QzIxLjE1OTEgMzggMjAuODM1NyAzNy42OTQ3IDIwLjgxNDggMzcuMzA1M0MyMC43OTQgMzYuODk0NyAyMS4wOTY1IDM2LjU0NzQgMjEuNTAzMyAzNi41MjYzTDIzLjIzNDkgMzYuNDMxNkMyMC42NDc5IDM0Ljg2MzIgMTguOTQ3NiAzMi45NTc5IDE3Ljk5ODMgMzAuNTA1M0MxNy4wNDkgMzIuOTU3OSAxNS4zNDg3IDM0Ljg2MzIgMTIuNzYxNyAzNi40MzE2TDE0LjUwMzcgMzYuNTI2M0MxNC45MDAxIDM2LjU0NzQgMTUuMjEzMSAzNi44OTQ3IDE1LjE5MjIgMzcuMzA1M0MxNS4xNzE0IDM3LjY5NDcgMTQuODQ4IDM4IDE0LjQ2MiAzOEgxNC40MjAzTDEwLjE5NTUgMzcuNzY4NEM5Ljk2NjAzIDM3Ljc1NzkgOS43Njc4MyAzNy42NDIxIDkuNjMyMjIgMzcuNDUyNkM5LjQ5NjYxIDM3LjI2MzIgOS40NjUzMSAzNy4wMzE2IDkuNTM4MzQgMzYuODEwNUwxMC44MjE0IDMyLjg4NDJDMTAuOTQ2NiAzMi41MDUzIDExLjM1MzQgMzIuMjk0NyAxMS43Mzk0IDMyLjQyMTFDMTIuMTE0OSAzMi41NDc0IDEyLjMyMzYgMzIuOTU3OSAxMi4xOTg0IDMzLjM0NzRMMTEuNjAzOCAzNS4xNTc5QzE1Ljk1MzcgMzIuNjMxNiAxNi44NTA4IDI5LjUwNTMgMTcuMTQyOSAyNi43NTc5QzE3LjE5NTEgMjYuMzI2MyAxNy41NDk3IDI2IDE3Ljk3NzQgMjZDMTguNDA1MSAyNiAxOC43NzAyIDI2LjMyNjMgMTguODEyIDI2Ljc1NzlDMTkuMTA0IDI5LjUxNTggMjAuMDAxMiAzMi42NDIxIDI0LjM3MiAzNS4xNzg5TDIzLjc3NzQgMzMuMzU3OUMyMy42NDE4IDMyLjk3ODkgMjMuODUwNCAzMi41NTc5IDI0LjIzNjQgMzIuNDMxNloiLz48L3N2Zz4=";

	if (current_user_can(PMXI_Plugin::$capabilities)) { // admin management options

		$wpai_menu = array(
			array('pmxi-admin-import',  __('New Import', 'wp_all_import_plugin')),
			array('pmxi-admin-manage' ,  __('Manage Imports', 'wp_all_import_plugin')),
			array('pmxi-admin-settings',  __('Settings', 'wp_all_import_plugin')),
			//array('pmxi-admin-license',  __('Licenses', 'wp_all_import_plugin')),
			array('pmxi-admin-history',  __('History', 'wp_all_import_plugin'))
			/*array('pmxi-admin-addons',  __('Add-ons', 'wp_all_import_plugin')), */
		);

		$wpai_menu = apply_filters('pmxi_admin_menu', $wpai_menu);

		add_menu_page(__('WP All Import', 'wp_all_import_plugin'), __('All Import', 'wp_all_import_plugin'), PMXI_Plugin::$capabilities, 'pmxi-admin-home', array(PMXI_Plugin::getInstance(), 'adminDispatcher'), 'data:image/svg+xml;base64,' . $icon_base64, 112);
		// workaround to rename 1st option to `Home`
		$submenu['pmxi-admin-home'] = array();

		foreach ($wpai_menu as $key => $value) {
			add_submenu_page('pmxi-admin-home', $value[1], $value[1], PMXI_Plugin::$capabilities, $value[0], array(PMXI_Plugin::getInstance(), 'adminDispatcher'));
		}

	}
}

