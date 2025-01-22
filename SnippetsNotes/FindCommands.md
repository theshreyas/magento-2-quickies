# All commands/shortcuts for finding/searching texts
## Linux/Github/SublimeText search

**Sublime Text Find**
```sh
sudo nano ~/.bashrc
#append
	export PS1='\u@\h \[\e[32m\]\w \[\e[91m\]$(__git_ps1)\[\e[00m\]$ '
#reload source
source ~/.bashrc
#list all aliases
alias
```
**Linux Text Find**
```sh
#Magento 2 : Find cacheable="false" cache tag #magento2
find vendor app -regextype 'egrep' -type f -regex '.*/layout/.*\.xml' -not -regex '.*(vendor/magento/|/checkout_|/catalogsearch_result_|/dotmailer).*' | xargs grep --color -n -e 'cacheable="false"'

#Cli : Linux find string in folder #CLI
grep -rnw '/path/to/somewhere/' -e 'pattern' 
grep -rnw '/path/to/somewhere/' -e 'pattern' | grep -v 'ignore'

# filename
grep -rnwl '/path/to/somewhere/' -e 'pattern'
```

**Github Search**
```sh
#edit bashrc file
sudo nano ~/.bashrc
#add your aliases at the end
alias all="sudo rabbitmqctl delete_queue async.operations.all && sudo rm -rf var/cache/* var/view_preprocessed/* var/page_cache/* generated/* pub/static/frontend/* pub/static/adminhtml/*"
#reload source
source ~/.bashrc
```