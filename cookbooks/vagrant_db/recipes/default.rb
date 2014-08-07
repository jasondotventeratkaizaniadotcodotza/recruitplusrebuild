require_recipe "apt"
require_recipe "vim"
require_recipe "openssl"
require_recipe "mysql::server"
require_recipe "mysql::client"

# install packages
package "git" do
  action :install
end

package "curl" do
  action :install
end