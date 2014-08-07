require_recipe "apt"
require_recipe "vim"
require_recipe "openssl"
require_recipe "nginx"
require_recipe "varnish"

# install packages
package "git" do
  action :install
end

package "curl" do
  action :install
end

template "#{node[:nginx][:dir]}/sites-available/application.conf" do
  source "application-site.erb"
  owner "root"
  group "root"
  mode 0644
end

template "#{node[:nginx][:dir]}/conf.d/backends.conf" do
  source "application-backend.erb"
  owner "root"
  group "root"
  mode 0644
end

nginx_web_app "application" do
    template "application-site.erb"
    notifies :restart, resources(:service => "nginx")
end

service "nginx" do
  supports :status => true, :restart => true, :reload => true
  action [ :enable, :start ]
end