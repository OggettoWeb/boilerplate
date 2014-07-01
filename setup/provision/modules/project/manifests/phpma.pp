class project::phpma (
  $root,
  $version,
  $web_user,
  $web_group
) {
    # Download PHPMA
    file { 'phpma_dir':
        ensure => directory,
        path   => $root,
        owner  => $web_user,
        group  => $web_group,
    }

    exec { 'download_phpma':
        command => "wget -O source.zip http://sourceforge.net/projects/phpmyadmin/files/phpMyAdmin/$version/phpMyAdmin-$version-all-languages.zip/download",
        cwd     => $root,
        require => File['phpma_dir'],
        onlyif  => "test ! -f $root/source.zip",
        user    => $web_user
    }

    # Extract PHPMA
    exec { 'unpack_phpma':
        command => 'unzip source.zip',
        cwd     => $root,
        require => [Exec['download_phpma'], Package['unzip']],
        onlyif  => "test ! -e $root/phpMyAdmin-$version-all-languages",
        user    => $web_user
    }

    # Configure PHPMA
    file { 'phpma/config.inc.php':
      ensure  => present,
      path    => "$root/phpMyAdmin-$version-all-languages/config.inc.php",
      content => template('project/phpma/config.inc.php.erb'),
      require => Exec['unpack_phpma'],
    }

    # NGINX config for PHPMA is described in hiera files
}
