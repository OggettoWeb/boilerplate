class project::system (
  $hostname
) {
  host { $hostname:
    ip => "127.0.0.1"
  }

  user { "vagrant":
    ensure => present,
    shell  => "/bin/bash",
  }

  package { 'vim': ensure => installed }
  package { 'unzip': ensure => installed }
  include git
}
