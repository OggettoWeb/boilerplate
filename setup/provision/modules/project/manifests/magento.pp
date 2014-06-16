class project::magento (
  $root,
  $unit_db,
  $unit_db_user,
  $unit_db_pass,
  $mage_db,
  $mage_db_user,
  $mage_db_pass,
  $unsecure_base_url,
  $secure_base_url,
  $enc_key
) {

  ### Install Magento
  include project::magento::install

  file { 'mage_local.xml':
    ensure  => present,
    path    => "$root/app/etc/local.xml",
    content => template('project/mage/app/etc/local.xml.erb'),
    require => Class['project::magento::install']
  }


  ### Ensure var folder exists
  file { 'mage_var':
    ensure => directory,
    path => "$root/var",
    mode => 'a=rwx'
  }


  ### Install composer dependancies
  include composer
  composer::exec { 'magento_composer_install':
    cmd       => 'install',
    cwd       => $root,
    logoutput => true,
  }


  ### Setup Magento PHPUnit tests
  exec { 'install_magento_tests':
    command => 'php ecomdev-phpunit.php -a install',
    cwd     => "$root/shell",
    require => [
      Composer::Exec['magento_composer_install'],
      Mysql_grant["$unit_db_user@localhost/$unit_db.*"],
      File['mage_local.xml']
    ],
  }
  exec { 'setup_magento_tests':
    command => 'php ecomdev-phpunit.php -a magento-config --db-user $unit_db_user --db-pwd $unit_db_pass --db-name $unit_db --base-url $unsecure_base_url',
    cwd     => "$root/shell",
    require =>  Exec['install_magento_tests'],
  }

  # Create symlink of VFSStream lib to make Ecomdev tests work
  file { "$root/lib/vfsStream":
    ensure => 'link',
    target => "$root/vendor/mikey179/vfsStream",
    require => Composer::Exec['magento_composer_install']
  }
}
