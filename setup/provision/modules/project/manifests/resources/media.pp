class project::resources::media (
  $mage_root,
  $backup_path
) {
    include wget

    file { "$mage_root/setup/var_media":
        ensure  => directory,
    }

    wget::fetch { "get-media-dump":
        source      => $backup_path,
        destination => "$mage_root/setup/var_media/media.tar.gz",
        timeout     => 0,
        verbose     => false,
        require     => [File["$mage_root/setup/var_media"]],
    }

    exec { "unpack-media-dump":
        command => "tar xzpf $mage_root/setup/var_media/media.tar.gz",
        cwd     => "$mage_root/setup/var_media/",
        returns => 2,
        timeout => 0,
        require => Wget::Fetch["get-media-dump"]
    }

    file { "$mage_root/media":
        ensure  => directory,
    }

    rsync::get { "import-media-dump":
        source  => "$mage_root/setup/var_media/media",
        path    => "$mage_root/",
        purge   => true,
        require => File["$mage_root/media"]
    }

    file { "delete-media-dump":
        path    => "$mage_root/setup/var_media/media.tar.gz",
        ensure  => absent,
        require => Rsync::Get["import-media-dump"],
    }
    file { "delete-media-dump-unpacked":
        path    => "$mage_root/setup/var_media/media",
        ensure  => absent,
        require => Rsync::Get["import-media-dump"],
        force   => true
    }
}
