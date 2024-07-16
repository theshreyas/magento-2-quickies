# Linux Snippets
## BASHRC Shortcuts that I use

**Always show git branch in terminal**
```sh
sudo nano ~/.bashrc
#append
	export PS1='\u@\h \[\e[32m\]\w \[\e[91m\]$(__git_ps1)\[\e[00m\]$ '
#reload source
source ~/.bashrc
#list all aliases
alias
```

```sh
#edit bashrc file
sudo nano ~/.bashrc
#add your aliases at the end
alias all="sudo rabbitmqctl delete_queue async.operations.all && sudo rm -rf var/cache/* var/view_preprocessed/* var/page_cache/* generated/* pub/static/frontend/* pub/static/adminhtml/*"
#reload source
source ~/.bashrc
```
https://www.digitalocean.com/community/tutorials/an-introduction-to-useful-bash-aliases-and-functions
https://www.cyberciti.biz/tips/bash-aliases-mac-centos-linux-unix.html

```sh
#Shreyas Custom Aliases
alias fix="gsettings set org.gnome.shell.extensions.dash-to-dock dock-position 'RIGHT' && gsettings set org.gnome.shell.extensions.dash-to-dock dock-position 'LEFT'"
alias all="sudo rabbitmqctl delete_queue async.operations.all && sudo rm -rf var/cache/* var/view_preprocessed/* var/page_cache/* generated/* pub/static/frontend/* pub/static/adminhtml/* && sudo php bin/magento setup:up && sudo php -dmemory_limit=-1 bin/magento s:d:c && sudo php -dmemory_limit=-1 bin/magento s:s:d -f &&  sudo php bin/magento cache:c &&  sudo php bin/magento cache:f && sudo chmod -R 777 var generated/* pub/static/* && sudo chmod -R 777 var"
alias allo="sudo rm -rf var/cache/* var/view_preprocessed/* var/page_cache/* generated/* pub/static/frontend/* pub/static/adminhtml/* && sudo php bin/magento setup:up && sudo php -dmemory_limit=-1 bin/magento s:d:c && sudo php -dmemory_limit=-1 bin/magento s:s:d -f &&  sudo php bin/magento cache:c &&  sudo php bin/magento cache:f && sudo chmod -R 777 var generated/* pub/static/* && sudo chmod -R 777 var"
alias allno="sudo rm -rf var/cache/* var/view_preprocessed/* var/page_cache/* generated/* pub/static/frontend/* pub/static/adminhtml/* && sudo php -dmemory_limit=-1 bin/magento s:d:c && sudo php -dmemory_limit=-1 bin/magento s:s:d -f &&  sudo php bin/magento cache:c &&  sudo php bin/magento cache:f && sudo chmod -R 777 var generated/* pub/static/* && sudo chmod -R 777 var"
alias elstart="sudo service elasticsearch start"
alias elstop="sudo service elasticsearch stop"
alias elstatus="sudo service elasticsearch status"
alias elrestart="sudo service elasticsearch restart"
alias sostart="sudo service sonar start"
alias sostop="sudo service sonar stop"
alias sostatus="sudo service sonar status"
alias sorestart="sudo service sonar restart"
alias m2="cd /var/www/html/m2"
alias m3="cd /var/www/html/m3"
```