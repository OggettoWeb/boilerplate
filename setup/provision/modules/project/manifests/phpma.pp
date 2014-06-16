class project::phpma (
  $root
) {
    # Download PHPMA
    file { 'phpma_dir':
        ensure => directory,
        path => $root
    }

    exec { 'download_phpma':
        command => 'wget -O source.zip http://sourceforge.net/projects/phpmyadmin/files/phpMyAdmin/4.0.9/phpMyAdmin-4.0.9-all-languages.zip/download',
        cwd => '/var/www/phpma',
        require => File['phpma_dir'],
        onlyif => "test ! -f $root/source.zip"
    }

    # Extract PHPMA
    exec { 'unpack_phpma':
        command => 'unzip source.zip',
        cwd => '/var/www/phpma',
        require => [Exec['download_phpma'], Package['unzip']],
        onlyif => "test ! -e $root/phpMyAdmin-4.0.9-all-languages"
    }

    # NGINX config for PHPMA is described in hiera files
}
