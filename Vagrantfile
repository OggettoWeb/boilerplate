Vagrant.configure("2") do |config|
  config.vm.box = "puppetlabs/debian-7.6-64-puppet"
  
  # Give VM 1/4 system memory on the host
  host = RbConfig::CONFIG['host_os']
  if host =~ /darwin/
    # sysctl returns Bytes and we need to convert to MB
    mem = `sysctl -n hw.memsize`.to_i / 1024 / 1024 / 4
  elsif host =~ /linux/
    # meminfo shows KB and we need to convert to MB
    mem = `grep 'MemTotal' /proc/meminfo | sed -e 's/MemTotal://' -e 's/ kB//'`.to_i / 1024 / 4
  else
    mem = 2048
  end

  config.vm.provider "virtualbox" do |v|
    v.customize ["modifyvm", :id, "--memory", mem]
    v.customize ['modifyvm', :id, '--natdnshostresolver1', 'on']
  end

  config.vm.network "private_network", ip: "192.168.99.99"
  config.vm.synced_folder ".", "/var/www/magento", nfs: true, mount_options: ['rw', 'tcp', 'nolock', 'async']

  config.vm.provision :shell, :inline => "sudo apt-get update"
  config.vm.provision "puppet" do |puppet|
      puppet.manifests_path = "setup/provision/manifests"
      puppet.manifest_file = "default.pp"
      puppet.module_path = "setup/provision/modules"
      puppet.hiera_config_path = "setup/provision/hiera.yaml"
      puppet.working_directory = "/var/www/magento/"
      puppet.options = "--verbose --debug"
      puppet.facter = {
        "fqdn" => "localhost"
      }
  end
end
