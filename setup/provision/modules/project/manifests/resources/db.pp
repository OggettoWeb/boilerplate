class project::resources::db (
  $mage_root,
  $mage_db,
  $backup_path,
  $mage_unsecure_url,
  $mage_secure_url,
  $emails_domain
) {
    include wget

    file { "$mage_root/setup/var_db":
        ensure  => directory,
    }

    wget::fetch { "get-mysql-dump":
        source      => $backup_path,
        destination => "$mage_root/setup/var_db/mysql.sql.gz",
        timeout     => 0,
        verbose     => true,
        require     => [File["$mage_root/setup/var_db"]],
    }

    exec { "unpack-mysql-dump":
        command => "gunzip $mage_root/setup/var_db/mysql.sql.gz",
        cwd     => "$mage_root/setup/var_db/",
        timeout => 0,
        require => Wget::Fetch["get-mysql-dump"]
    }

    exec { "import-mysql-dump":
        command     => "/usr/bin/mysql $mage_db < $mage_root/setup/var_db/mysql.sql",
        logoutput   => true,
        environment => "HOME=${::root_home}",
        require     => Exec["unpack-mysql-dump"],
        timeout     => 0
    }

    exec { "adapt-mysql-dump":
        command     => "$mage_root/setup/sql/adapt.sh $mage_db $mage_unsecure_url $mage_secure_url $emails_domain",
        logoutput   => true,
        environment => "HOME=${::root_home}",
        require     => Exec["import-mysql-dump"],
        timeout     => 0
    }

    file { "delete-mysql-dump":
        path    => "$mage_root/setup/var_db/mysql.sql",
        ensure  => absent,
        require => Exec["import-mysql-dump"],
    }
}