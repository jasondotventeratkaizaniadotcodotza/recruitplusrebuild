require_recipe "apt"
require_recipe "vim"
require_recipe "apache2"
require_recipe "apache2::mod_php5"
require_recipe "apache2::mod_expires"
require_recipe "apache2::mod_rewrite"
require_recipe "openssl"
require_recipe "php"
require_recipe "php::module_curl"
require_recipe "php::module_gd"
require_recipe "php::module_memcache"
require_recipe "php::module_mysql"
#require_recipe "php::module_xdebug"
require_recipe "imagemagick"
require_recipe "memcached"
require_recipe "phpmyadmin"
require_recipe "phpmemcacheadmin"
# require_recipe "jetty"
# require_recipe "solr"

execute "disable-default-site" do
  command "sudo a2dissite default"
  notifies :restart, resources(:service => "apache2")
end

execute "enable-default-ssl" do
  command "sudo a2enmod ssl"
  notifies :restart, resources(:service => "apache2")
end

execute "discover-auto" do
  command "sudo pear config-set auto_discover 1"
  returns [0,1]
end

execute "discover-phing" do
  command "sudo pear channel-discover pear.phing.info"
  returns [0,1]
end

execute "install-phing" do
  command "sudo pear install phing/phing"
  returns [0,1]
end

# install packages
package "git" do
  action :install
end

package "curl" do
  action :install
end

# install composer php
execute "install-composer" do
  command "sudo curl -s http://getcomposer.org/installer | php -- --install-dir=#{node.composer.dir}"
  not_if { File.exists? "#{node.composer.dir}/#{node.composer.executable}" }
end

web_app "application" do
  template "application.conf.erb"
  notifies :restart, resources(:service => "apache2")
end