class project::php_fpm inherits project::php {
    include php::fpm::daemon
    php::fpm::conf { 'www':
        user  => "vagrant",
        group => "vagrant"
    }
}