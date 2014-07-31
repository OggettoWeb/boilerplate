Vagrant.configure("2") do |config|
  config.vm.box = "puppetlabs/debian-7.4-64-puppet"

  config.vm.provider "virtualbox" do |v|
    v.customize ["modifyvm", :id, "--memory", "2048"]
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
