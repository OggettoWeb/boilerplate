class project::magento::install
(
  $mage_root,
  $mage_db,
  $mage_db_user,
  $mage_db_pass,
  $unsecure_base_url,
  $secure_base_url,
  $enc_key,
  $locale,
  $timezone,
  $currency,
  $admin_firstname,
  $admin_lastname,
  $admin_email,
  $admin_username,
  $admin_pass
) {
    exec { 'install_sample_data':
      command     => "/usr/bin/mysql $mage_db < $mage_root/setup/sql/sample_data.sql",
      onlyif      => "test -f $mage_root/setup/sql/sample_data.sql",
      logoutput   => true,
      environment => "HOME=${::root_home}",
      require     => Mysql_grant["$mage_db_user@localhost/$mage_db.*"],
      subscribe   => Mysql_database[$mage_db],
    }

    exec { 'install_magento':
      command => template('project/mage/install.erb'),
      cwd     => $mage_root,
      returns => 0,
      require => Exec['install_sample_data'],
      onlyif  => "test ! -f $mage_root/app/etc/local.xml", # magento should be installed only if there is no local.xml already set up
    }

    file { "mage-sample-data":
      path => "$mage_root/setup/sql/sample_data.sql",
      ensure => absent,
      require => Exec['install_magento'],
    }
}
