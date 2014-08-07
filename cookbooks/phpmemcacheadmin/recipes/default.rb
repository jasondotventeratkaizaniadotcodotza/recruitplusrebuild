#
# Cookbook Name:: phpmemcacheadmin
# Recipe:: default
#
# Copyright 2012, Artur Grigor
#
# Licensed under the Apache License, Version 2.0 (the "License");
# you may not use this file except in compliance with the License.
# You may obtain a copy of the License at
#
#     http://www.apache.org/licenses/LICENSE-2.0
#
# Unless required by applicable law or agreed to in writing, software
# distributed under the License is distributed on an "AS IS" BASIS,
# WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
# See the License for the specific language governing permissions and
# limitations under the License.
#

directory "#{node.phpmemcacheadmin.conf}" do
  group   "root"
  owner   "root"
  mode    "0755"
  action :create
end

template "#{node.phpmemcacheadmin.conf}/apache.conf" do
  source "apache.conf.erb"
  mode "0664"
  notifies :restart, resources(:service => "apache2")
end

remote_file "#{node.phpmemcacheadmin.download}" do
  source   node.phpmemcacheadmin.package
  mode     "0644"
  not_if   "test -f #{node.phpmemcacheadmin.download}"
end

bash "unpack_phpmemcacheadmin" do
  code <<-EOH
  mkdir -p #{node.phpmemcacheadmin.extracted}
  tar xzf #{node.phpmemcacheadmin.download} -C #{node.phpmemcacheadmin.extracted}
  EOH
  not_if "test -d #{node.phpmemcacheadmin.extracted}"
end

bash "install_phpmemcacheadmin" do
  code <<-EOH
  cp -R #{node.phpmemcacheadmin.extracted}/ #{node.phpmemcacheadmin.home}
  chmod -R +r #{node.phpmemcacheadmin.home}
  EOH
  not_if "test -d #{node.phpmemcacheadmin.home}"
  notifies :restart, resources(:service => "apache2")
end

template "#{node.phpmemcacheadmin.home}/Config/Memcache.php" do
  source "Memcache.php.erb"
  mode "0777"
end

template "/etc/apache2/sites-enabled/phpmemcacheadmin" do
  source "vhost.erb"
  mode "0664"
  notifies :restart, resources(:service => "apache2")
end
