Magento-2-Interview-Questions
===========================

Topics:
* <a href="#general-developer-questions">General Developer Questions</a>
* <a href="#core-php">Core PHP</a>
* <a href="#magento-design-patterns">Magento Design Patterns</a>
* <a href="#magento-theory-based">Magento Theory based</a>
* <a href="#how-to-do-scenario-based">How to do?/Scenario based</a>
* <a href="#git">Git</a>
* <a href="#databases">Databases</a>
* <a href="#misc">Misc</a>
* <a href="#managerial-round">Managerial Round</a>

## General Developer Questions
* Explain unit tests versus functional tests.
* What project management tools have you used?
* How do you ensure that you are working efficiently?

## Core PHP
#### Object-Oriented Programming
* What are the benefits of OOP?
* What are the main 3 Object Oriented Programing (OOP) concepts?
* Explain anonymous classes. [[info]](https://www.php.net/manual/en/language.oop5.anonymous.php)
* Describe the differences between abstract classes and interfaces. [[info]](https://stackoverflow.com/a/5899775)

#### Other
* SOLID Principles
* Php traits
* What is PSR?
* require vs include?
* Error types in PHP?
* Magic methods in php
* How we can submit a form without clicking on submit button?
* What are new features introduced in PHP 8?
* Do you know php #Override attribute in PHP 8?
* Polymorphism in php. give some example in magento where it is used
* What is the difference between a variable passed by value and passed by reference?

## Magento Design Patterns [[info]](https://webkul.com/blog/design-patterns-in-magento-2/)
* MVC vs MVVM? / what is view-model ?
[[info]](https://magently.com/blog/magento-2-design-patterns-viewmodel-proxy)
* Service Contracts? [[info]](https://developer.adobe.com/commerce/php/development/components/service-contracts)
* what is dependency injection? [[info]](https://m.academy/articles/dependency-injection-magento-object-manager/)
* EAV Pattern
* Different types of plugins, limitations of plugin, aroundplugin when to use?
* Preferences use, limitations
* What is the difference between Preference and Plugin?
* Type, VirtualType, Argument Replacement
* Singleton Design Pattern in Magento 2 [[info]](https://learningmagento.com/singleton-design-pattern-in-magento-2/)

## Magento Theory based
* How indexing works?
* Different product types in magento
* Difference between bundled products and grouped products
* What happens when your run compile command?
* Difference between rest api and graphql? 
* Difference between id and frontname in module.xml? 
* Magento Cache system/what cache systems do you know, what is use of varnish/redis/fastly/memcache?
* Deployment Process in Magento (premises or cloud)
* What is a JavaScript component? And How it works with RequireJs?
* Steps for performance improvement/How to improve the loading of your Magento pages?
* grunt use? [[info]](https://m.academy/articles/set-up-configure-grunt-magento-2-theming)
* What are ACLs? / acl.xml use
* What are factories ? /repositories/ proxies ? [[info]](https://m.academy/articles/magento-2-model-repository-design-pattern)
* What is the difference between before-after and move keywords in layout files?
* What does generated folder contains?
* What does pub folder contains?
* Different modes in magento ? what is the difference between them ?
* What are collections ? collection getSize() vs count()? collection get() vs create()?
* What are the issues/drawbacks in Magento 2? What can be improved?
* What are Proxies? And what benefits provide them?
* Name objects using EAV in Magento
* csp_whitelist.xml use?
* composer.lock file use?
* What are javascript mixins
* phpcs/phpcbf use?
* Adobe commerce cloud features
* When we have to run setup:compile command?
* Zero downtime deployments in magento
* What is KnockoutJs?
* What are Observable methods?
* What is the biggest difference between Magento 1 & Magento 2?
* What is the difference between POST & GET while hitting graphql API?
* What is getDependencies() method in setup data patch
* Difference between block's "name" and "as" attributes in layout XML
* Cache clean vs cache flush [[info]](https://m.academy/articles/whats-difference-between-magento-2-cache-clean-flush)
* When to use session and when to use registry to store variables?

## How to do?/Scenario based
* How to register a new module?
* What are the ways to extend a Class method in Magento 2?
* How to add order-note field in checkout?
* How to create new email template?
* How to have different sort by option for different categories?
* How to create theme?
* how to setup magento instance on local,tell the steps
* How to cache graphql?
* How to implement custom cache?
* How will you create a new cronjob ?
* How to develop custom REST API? what are the resource types of api ?(anonymous/ etc)
* How to develop custom GraphQL API?
* How to upgrade from lower version of Magento to latest version?
* How to add new column in admin order grid?
* How to change layout of category listing page from 1 column to 2 columns?
* How to display different payment methods to different customers ? (event name in case of observer?)
* How to prevent add to cart for specific customers ?
* How to display block based on the system configuration?
* How many different ways we can override core functionality?
* how to bulk transport(export/import) /High volume data import?
* How to display a custom block on the homepage?
* How to extend a Luma based theme file in your active theme?
* What is the best way to get customer data in the frontend part of your Magento?
* If plugin has some sort order how will you ensure to execute one plugin after another  
* Whenever the product price is saved in the backend the price will be multiplied
* How will you override the public/private/protected function ?
* How can you call block into controller ?
* Website is completely blank. no errors in console. how can you debug ?
* Product description changes every 5 minutes from third party api call. how can we achieve this?

## GIT
* Git merge vs rebase?
* Git fetch vs pull?
* How to revert last commit?
* How do you resolve a merge conflict?
* Tell me your git work flow to do a hotfix.

## Databases
* ACID Properties?
* Do you know database partioning/ sharding?
* different types of joins? name & compare them
* How to join order and order_item table?
* How you will add foreign key in custom table in magento?
* Write me query to fetch last 5 credit card orders payment data.
* How to add new attribute in customer table? In which table this data will be stored?
* how will you add new custom attribute to product 'test' ? in what table the data will be stored in ?
* Where is the relation between configurable product and it’s simple product stored in database?

## Misc
* apache vs nginx? Which one is better?
* opensearch vs elasticsearch ? Which one is better in magento context?
* What is Composer? And Tell the difference between composer update and composer install
* what is composer dump-autoload
* your remote linux server or local is slow or hanging quite often,how you will proceed

## Managerial Round
* Tell me the last time you made a mistake that cost a company or client money, and:
* What did you learn from your mistake?
* What do you do to keep current on technologies?
* What are you learning in your off-time?
* what are the challenging tasks you faced in your current project ?
* what is one exciting/favorite task you done till now ?
* How much time you will estimate for developing theme from scratch with one junior resource?

## Magento Articles/Resources
[Magento 2's Request-Response Lifecycle](https://m.academy/articles/magento-2-request-response-lifecycle)

[Magento 2 configuration settings fallback process](https://m.academy/articles/magento-2-configuration-settings-fallback-process)

[Magento Courses](https://m.academy/courses#browse)

[Certification Info](https://m.academy/articles/magento-certified-developer)

[Magento technical resources list](https://github.com/aleron75/mageres)

[Awesome Magento resources list](https://github.com/run-as-root/awesome-magento2)

[Magento 2 Cache Cheat Sheet](https://gist.github.com/scottsb/ed3058501520aa092675f763e2b93f9b)

[Magento All Events](https://developer.adobe.com/commerce/php/development/components/events-and-observers/event-list)


## Other Resources
[PHP Right Way](https://phptherightway.com/)

[Interview questions](https://github.com/FAQGURU/FAQGURU)

[Awesome Interview Questions](https://github.com/DopplerHQ/awesome-interview-questions)

[Tech Interview Handbook](https://github.com/yangshun/tech-interview-handbook)

[Common Interview Questions & Answers](https://docs.google.com/document/d/0B8n-7ug6P08uNWhfR0VjTi1XZnc/edit?resourcekey=0-6FYgMzKVkwUeqnmMZmxLBg)

[Questions for Engineering Leadership role](https://github.com/kaushikb9/em-interviews)

[Questions to ask the company](https://github.com/viraptor/reverse-interview)

[Salary Negotiating](https://github.com/petermekhaeil/salary-negotiating)