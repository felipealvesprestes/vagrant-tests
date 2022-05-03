$script_mysql = <<-SCRIPT
    apt-get update && \
    apt-get install -y mysql-server-5.7 && \
    mysql -e "create user 'phpuser'@'%' identified by 'pass';"
SCRIPT

Vagrant.configure("2") do |config|

    # virtualbox
    config.vm.provider "virtualbox" do |v|
        v.memory = 512
        v.cpus = 1
    end

    config.vm.box = "ubuntu/bionic64"

    # mysql (com shell)
    # config.vm.define "mysqldb" do |mysql|

    #     mysql.vm.network "private_network", ip: '192.168.56.4'
    
    #     mysql.vm.provision "shell", inline: "cat /configs/id_rsa.pub >> .ssh/authorized_keys"
    #     mysql.vm.provision "shell", inline: $script_mysql
    #     mysql.vm.provision "shell", inline: "cat /configs/mysqld.cnf > /etc/mysql/mysql.conf.d/mysqld.cnf"
    #     mysql.vm.provision "shell", inline: "service mysql restart"
    
    #     mysql.vm.synced_folder "./configs", "/configs"
    #     mysql.vm.synced_folder ".", "/vagrant", disabled: true
    # end

    # php
    config.vm.define "phpweb" do |php|

        php.vm.provider "virtualbox" do |v|
            v.name = 1024
            v.cpus = 2
            v.name = "php"
        end

        php.vm.network "forwarded_port", guest: 8888, host: 8085
        php.vm.network "private_network", ip: '192.168.56.5'
        
        php.vm.provision "shell", inline: "apt-get update && apt-get install -y puppet"

        php.vm.provision "puppet" do |puppet|
            puppet.manifests_path = "./configs/manifests"
            puppet.manifest_file = "phpweb.pp"
        end
    end
    
    # mysql (para usar com ansible)
    config.vm.define "mysqlserver" do |mysqlserver|

        mysqlserver.vm.provider "virtualbox" do |v|
            v.name = "mysql"
        end

        mysqlserver.vm.network "private_network", ip: '192.168.56.6'

        mysqlserver.vm.provision "shell", inline: "cat /vagrant/configs/id_rsa.pub >> .ssh/authorized_keys"
    end

    # ansible
    config.vm.define "ansible" do |ansible|

        ansible.vm.provider "virtualbox" do |v|
            v.name = "ansible"
        end

        ansible.vm.network "private_network", ip: '192.168.56.7'

        ansible.vm.provision "shell", inline: "
            apt update && \
            apt install -y software-properties-common && \
            add-apt-repository --yes --update ppa:ansible/ansible && \
            apt install -y ansible
        "

        ansible.vm.provision "shell", inline: "
            cp /vagrant/id_rsa /home/vagrant && \
            chmod 600 /home/vagrant/id_rsa && \
            chown vagrant:vagrant id_rsa
        "

        ansible.vm.provision "shell", inline: "
            ansible-playbook -i /vagrant/configs/ansible/hosts /vagrant/configs/ansible/playbook.yml
        "
    end

    # box especifico
    config.vm.define "memcache" do |memcache|

        memcache.vm.box = "centos/7"

        memcache.vm.provider "virtualbox" do |v|
            v.name = 512
            v.cpus = 1
            v.name = "centos"
        end
    end
end
