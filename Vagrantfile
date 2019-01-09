# -*- mode: ruby -*-
# vi: set ft=ruby :

# All Vagrant configuration is done below. The "2" in Vagrant.configure
# configures the configuration version (we support older styles for
# backwards compatibility). Please don't change it unless you know what
# you're doing.
Vagrant.configure("2") do |config|
  # The most common configuration options are documented and commented below.
  # For a complete reference, please see the online documentation at
  # https://docs.vagrantup.com.

  # Every Vagrant development environment requires a box. You can search for
  # boxes at https://vagrantcloud.com/search.
  config.vm.box = "debian/jessie64"

  # Disabled automatic box update checking.
  config.vm.box_check_update = false

  config.vm.network "forwarded_port", guest: 80, host: 8142 # Nginx
  config.vm.network "forwarded_port", guest: 5432, host: 5432 # Postgres
  config.vm.network "forwarded_port", guest: 8000, host: 8000 # WebSocket

  # Share an additional folder to the guest VM. The first argument is
  # the path on the host to the actual folder. The second argument is
  # the path on the guest to mount the folder. And the optional third
  # argument is a set of non-required options.
  config.vm.synced_folder "./", "/var/www/backend", :owner => 'www-data', :group => 'www-data'

  # Main provision script, installs all shit.
  config.vm.provision "shell", path: "./deploy/provision.sh"

  config.vm.provision "file", source: "./deploy/nginx.conf", destination: "~/calendar.conf", run: "always"
  config.vm.provision "shell", run: "always"  do |s|
      s.inline = "mv /home/vagrant/calendar.conf /etc/nginx/sites-enabled/calendar.conf; service nginx restart"
      s.privileged = true
  end
end
