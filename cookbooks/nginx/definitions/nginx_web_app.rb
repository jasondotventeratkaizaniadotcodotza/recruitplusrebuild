#
# Cookbook Name:: nginx
# Definition:: nginx_web_app
# Author:: Artur Grigor <arturgrigor@gmail.com>
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

define :nginx_web_app, :template => "nginx_web_app.conf.erb", :enable => true do
  
    application_name = params[:name]

    template "#{node[:nginx][:dir]}/sites-available/#{params[:name]}.conf" do
        source params[:template]
        owner "root"
        group "root"
        mode 0644
        if params[:cookbook]
            cookbook params[:cookbook]
        end
        variables(
            :application_name => application_name,
            :params => params
        )
        if ::File.exists?("#{node[:nginx][:dir]}/sites-enabled/#{params[:name]}.conf")
            notifies :reload, resources(:service => "nginx"), :delayed
        end
    end
  
    nginx_site "#{params[:name]}.conf" do
        enable params[:enable]
    end
end

