<?php
if (!defined("ABSPATH")) exit;

class WCIM_Settings_KDR
{
  // register_settings
  public function register_settings()
  {
    register_setting(
      'wcim_kdr_settings_group', // group name
      'wcim_kdr_settings'
    );
  }
}
