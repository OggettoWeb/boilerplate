class project::rabbitmq (
  $port,
  $vhost,
  $user,
  $pass
) {
    class { '::rabbitmq':
        port => $port,
        config_variables  => {
            admin_enable => true,
            delete_guest_user => true
        }
    }

    rabbitmq_vhost { $vhost:
        ensure => present,
    }

    rabbitmq_user { $user:
        admin    => true,
        password => $pass,
    }
    rabbitmq_user { 'guest':
        ensure => absent
    }

    rabbitmq_user_permissions { "$user@$vhost":
        configure_permission => '.*',
        read_permission      => '.*',
        write_permission     => '.*',
    }
}
