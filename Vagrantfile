# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant::Config.run do |config|

  # Load Balancer
  config.vm.define :lb do |lb_config|

    lb_config.vm.host_name = "lb"

    lb_config.vm.box = "ubuntu-12.04-amd64-VBoxGA-4.1.14"
    lb_config.vm.box_url = "https://www.dropbox.com/s/f6tpsnpa0l06ew0/vagrant_dev_env.box"

    lb_config.vm.network :hostonly, "33.33.33.10"

    # Provisioners
    lb_config.vm.provision :chef_solo do |chef|
        chef.cookbooks_path = "cookbooks"
        chef.add_recipe "vagrant_lb"
        chef.json.merge!({
            :hostname => "recruit.vagrant",
            :application => {
                :server_name => "recruit.vagrant",
                :backend => {
                    :host => "33.33.33.11",
                    :port => 80
                }
            }
        })
    end

  end

  # Web Servers
  config.vm.define :web do |web_config|
    web_config.vm.host_name = "web"

    web_config.vm.box = "ubuntu-12.04-amd64-VBoxGA-4.1.14"
    web_config.vm.box_url = "https://www.dropbox.com/s/f6tpsnpa0l06ew0/vagrant_dev_env.box"

    web_config.vm.network :hostonly, "33.33.33.11"

    # Shared folder
    web_config.vm.share_folder "recruitplus", "/var/www/recruit.vagrant", "./"

    # Provisioners
    web_config.vm.provision :chef_solo do |chef|
        chef.cookbooks_path = "cookbooks"
        chef.add_recipe "vagrant_web"
        chef.json.merge!({
            :java => {
                :java_home => "/usr/lib/jvm/java-6-openjdk-amd64"
            },
            :jetty => {
                :link => "http://dist.codehaus.org/jetty/jetty-hightide-7.1.6/jetty-hightide-7.1.6.v20100715.tar.bz2",
                :extracted => "/usr/local/src/jetty-hightide-7.1.6.v20100715"
            },
            :solr => {
                :version => "3.6.0",
                :checksum => "3acac4323ba3dbfa153d8ef01f156bab9b0eccf1b1f1f03e91b8b6739d3dc6c6"
            },
            :phpmyadmin => {
                :host => "33.33.33.12",
                :servername => "pma.recruit.vagrant"
            }
        })
    end
  end

  # Database Servers
  config.vm.define :db do |db_config|
    db_config.vm.host_name = "db"

    db_config.vm.box = "ubuntu-12.04-amd64-VBoxGA-4.1.14"
    db_config.vm.box_url = "https://www.dropbox.com/s/f6tpsnpa0l06ew0/vagrant_dev_env.box"

    db_config.vm.network :hostonly, "33.33.33.12"

    # Provisioners
    db_config.vm.provision :chef_solo do |chef|
        chef.cookbooks_path = "cookbooks"
        chef.add_recipe "vagrant_db"
        chef.json.merge!({
            :mysql => {
                :root_password => "root",
                :allow_remote_root => true,
                :bind_address => "0.0.0.0"
            },
        })
    end
  end

end