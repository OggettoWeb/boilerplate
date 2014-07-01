class project::php (
  $remote_debug_host,
  $web_user,
  $web_group
) {
    include php::cli
    php::module { [ 'curl', 'mcrypt', 'gd', 'mysql', 'xdebug', 'dev' ]: }

    php::ini { '/etc/php.ini':
        display_errors      => 'On',
        memory_limit        => '256M',
        upload_max_filesize => '256M'
    }

    php::ini { '/etc/php5/fpm/php.ini':
        display_errors      => 'On',
        memory_limit        => '256M',
        upload_max_filesize => '256M',
        require             => Php::Ini['/etc/php.ini']
    }

    project::php::module::ini { 'xdebug':
        auto_enable => false,
        settings => {
            'xdebug.remote_enable'    => 'true',
            'xdebug.remote_host'      => $remote_debug_host,
            'xdebug.remote_autostart' => 1,
        }
    }

    package { 'php-pear':
        ensure => present
    }

    # Install Weakref extension
    package { 'libpcre3-dev':
        ensure => present
    }
    exec { 'pecl-install-weakref':
      command => '/usr/bin/pecl install channel://pecl.php.net/weakref-0.2.2',
      require => [
          Package['php-pear'],
          Package['libpcre3-dev'],
          Php::Module['dev']
      ],
      onlyif => 'test ! "$(/usr/bin/pecl list | grep Weakref)"'
    }
    file { "${php::params::php_conf_dir}/weakref.ini":
        content => 'extension = weakref.so',
    }

    # create session directory
    file { [ '/var/lib/php', '/var/lib/php/session']:
      ensure => 'directory',
      owner  => $web_user,
      group  => $web_group,
    }
}
