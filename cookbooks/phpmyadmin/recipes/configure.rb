template "/etc/phpmyadmin/config-db.php" do
  source "config-db.php.erb"
  owner 'www-data'
  mode "0660"
  variables(:password => node[:mysql][:server_root_password], :username => 'root', :host => (node[:scalarium][:roles]['db-master'][:instances][db_master][:private_dns_name] rescue nil) )
end