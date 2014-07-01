class project::phpma (
  $root,
  $version
) {
    # Download PHPMA
    file { 'phpma_dir':
        ensure => directory,
        path   => $root
    }

    exec { 'download_phpma':
        command => "wget -O source.zip http://sourceforge.net/projects/phpmyadmin/files/phpMyAdmin/$version/phpMyAdmin-$version-all-languages.zip/download",
        cwd     => $root,
        require => File['phpma_dir'],
        onlyif  => "test ! -f $root/source.zip"
    }

    # Extract PHPMA
    exec { 'unpack_phpma':
        command => 'unzip source.zip',
        cwd     => $root,
        require => [Exec['download_phpma'], Package['unzip']],
        onlyif  => "test ! -e $root/phpMyAdmin-$version-all-languages"
    }

    # NGINX config for PHPMA is described in hiera files
}
