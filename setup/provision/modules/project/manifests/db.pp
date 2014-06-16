class project::db (
  $root_pass,
  $mage_db,
  $mage_db_user,
  $mage_db_pass,
  $unit_db,
  $unit_db_user,
  $unit_db_pass
) {
  class { 'mysql::server':
    root_password => $root_pass
  }

  mysql::db { $mage_db:
    user => $mage_db_user,
    password => $mage_db_pass,
  }
  mysql::db { $unit_db:
    user => $unit_db_user,
    password => $unit_db_pass,
  }
}
