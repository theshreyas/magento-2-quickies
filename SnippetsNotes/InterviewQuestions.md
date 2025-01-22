Magento-2-Interview-Questions
===========================

Topics:
* <a href="#general-developer-questions">General Developer Questions</a>
* <a href="#core-php">Core PHP</a>
* <a href="#magento-design-patterns">Magento Design Patterns</a>
* <a href="#frontend-specific">Magento Frontend Specific</a>
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
* what are different types of php errors/Error types in PHP?
* Magic methods in php
* How we can submit a form without clicking on submit button?
* What are new features introduced in PHP 8?
* Do you know php #Override attribute in PHP 8?
* Polymorphism in php. give some example in magento where it is used
* What is the difference between a variable passed by value and passed by reference?

## Magento Design Patterns [[info]](https://webkul.com/blog/design-patterns-in-magento-2/)
* What are different design patterns in magento ?
* MVC vs MVVM? / what is view-model ?
[[info]](https://magently.com/blog/magento-2-design-patterns-viewmodel-proxy)
* Service Contracts? [[info]](https://developer.adobe.com/commerce/php/development/components/service-contracts)
* what is dependency injection? [[info]](https://m.academy/articles/dependency-injection-magento-object-manager/)
* EAV Pattern/ Eav vs flat tables
* getmodel vs getsingleton
* Different types of plugins, limitations of plugin, aroundplugin when to use? how priority works in plugins?
* Preferences use, limitations
* What is the difference between Preference and Plugin?
* What is proxy?
* What are injectibles & non-injectibles?
* Explain Type & VirtualType. What is argument replacement?
* Singleton Design Pattern in Magento 2 [[info]](https://learningmagento.com/singleton-design-pattern-in-magento-2/)

## Magento Frontend Specific
* How to create theme from scratch?
* Container vs referencecontainer
* What are javascript mixins?
* What is KnockoutJs?
* What is less?
* What are Observable methods?
* Difference between block's "name" and "as" attributes in layout XML
* How to change layout of category listing page from 1 column to 2 columns?
* How will you override js file?
* all vs map in requirejs
* What is a JavaScript component? And How it works with RequireJs?
* Difference between all vs map in requirejs?
* How to avoid conflict with jquery? (A: jQuery. noConflict())
* What is the difference between before-after and move keywords in layout files?
* How to display a custom block on the homepage? How to display on multiple pages? what is the best solution?
* How to extend a Luma based theme file in your active theme?
* What is the best way to get customer data in the frontend part of your Magento?
* how to call custom block in magento checkout page using knockout js & ui component?

## Magento Theory based
* What is latest magento version?
* Pros & cons of magento?
* Explain directory structure of magento module & magento theme?
* How indexing works? Can you explain what happens when you run reindexing command? What are indexer modes? What is backlog indexing? what are _cl tables?
* What is objectmanager?
* How routing happens in magento?
* Can you explain magento architecture?
* Different product types in magento
* Difference between bundled products and grouped products
* What happens when your run compile command?
* Difference between rest api and graphql? Which one you will prefer? 
* What is the difference between POST & GET while hitting graphql API?
* Difference between id and frontname in module.xml? 
* Magento Cache system/what cache systems do you know, what is use of varnish/redis/fastly/memcache?
* Deployment Process in Magento (premises or cloud)
* Steps for performance improvement/How to improve the loading of your Magento pages?
* Tell me top 3 things each you will do to improve magento performance & security? 
* grunt use? [[info]](https://m.academy/articles/set-up-configure-grunt-magento-2-theming)
* What are ACLs? / acl.xml use
* csp_whitelist.xml use?
* What are factories ? /repositories/ proxies ? How to call customerfactory in controller ?[[info ]](https://m.academy/articles/magento-2-model-repository-design-pattern)
* What are Proxies? And what benefits it provide?
* What does generated folder contains?
* What are extension attributes? use case? custom attribtutes vs extension attributes
* What does pub folder contains?
* What is multistore multiwebsite in magento? What are the usecases?
* Different modes in magento ? what is the difference between them ?
* What are collections ? collection getSize() vs count()? collection get() vs create()?
* What are the issues/drawbacks in Magento 2? What can be improved?
* Name objects using EAV in Magento
* What is component registrar?
* phpcs/phpcbf/phpstan use? what types of errors are displayed by php codesniffer
* Open source vs Adobe commerce vs adobe commerce cloud features (RMA, Cancel Order)
* What are Adobe commerce b2b features?
* Where is Adobe commerce cloud hosted?
* What are yaml files
* customer groups vs customer segmentation
* When we have to run setup:compile command?
* Zero downtime deployments in magento
* What is the biggest difference between Magento 1 & Magento 2?
* What is getDependencies() method in setup data patch
* Cache clean vs cache flush [[info]](https://m.academy/articles/whats-difference-between-magento-2-cache-clean-flush)
* When to use session and when to use registry to store variables?
* what is data operator in integration test?
* where interface and corresponding class is mapped?
* What is the difference between catalog price rule & cart price rule?

## How to do?/Scenario based
* How to register a new module?
* What are the ways to extend a Class method in Magento 2?
* How many different ways we can override core functionality?
* How will you override the public/private/protected function ?
* How to add order-note field in checkout?
* How to create new email template?
* How to have different sort by option for different categories?
* how to setup magento instance on local,tell the steps
* How to setup headless magento? PWA Studio vs Custom Headless
* How to develop custom REST API? what are the resource types of api ?(anonymous/ etc)
* How to develop custom GraphQL API?
* how will you create custom graphql to fetch custom customer attributes
* How will you prevent multiple form submissions (spam attack)? how to do in headless?
* How to cache graphql?
* How to implement custom cache?
* How to create custom console command?
* How to create custom indexer?
* How to create custom admin model, grid with custom APIs?
* How to create custom table & fetch data from this table? what will be the files?
* How to create filter attribute to be displayed on listing page
* You have requirement to customize order increment id, where it will be dynamic based on user country and store, and appended prefix & suffix accordingly, how to achieve?
* How will you create a new cronjob ?
* How to upgrade from lower version of Magento to latest version?
* How to add new column in admin order grid?
* How to display different payment methods to different customers ? (event name in case of observer?)
* How to add new menu in frontend customer account? 
* How to fetch data inside html files, how to do it without controller?
* How will you write controller structure to display custom page on this url m2.test/abc/xyz/pqr?
* How will you create new payment gateway from scratch? keeping maintainability in mind. where will be card details stored?
* How to prevent add to cart for specific customers ?
* How to display block based on the system configuration?
* how to bulk transport(export/import) /High volume data import? queue vs cron? for sync update
* If plugin has some sort order how will you ensure to execute one plugin after another  
* Whenever the product price is saved in the backend the price will be multiplied
* How can you call block into controller ?
* Website is completely blank. no errors in console. how can you debug ?
* How will you debug production issue ? lets say indexing is giving error or getting stuck
* Product description changes every 5 minutes from third party api call. how can we achieve this?

## GIT
* Git merge vs rebase?
* Git fetch vs pull?
* What is git tag?
* How to revert last commit?
* How do you resolve a merge conflict?
* Tell me your git work flow to do a hotfix.

## Databases
* ACID Properties?
* Difference between primary key & unique key?
* What is composite key?
* Function vs Stored Procedure?
* Do you know database partioning/ sharding?
* different types of joins? name & compare them/ write outer join query given two tables
* How to join order and order_item table?
* Name mysql storage engines? which one magento uses?
* How you will add foreign key in custom table in magento?
* Write me query to fetch last 5 credit card orders payment data.
* How to add new attribute in customer table? In which table this data will be stored?
* How will you fetch customer collection and add filter like fetch last 10 customers only (addattributetoselect vs addfieldtoselect)
* addFieldToFilter vs addAttributeToFilter?
* how will you add new custom attribute to product 'test' ? in what table the data will be stored in ?
* how will you add new column to review table?
* how will you solve product collection loop save
    $product->getResource()->saveAttribute($product, 'custom_attributte');
* Where is the relation between configurable product and it’s simple product stored in database?
* How do window functions work in SQL, and when would you use them?
* What is the purpose of indexing in SQL? How do you decide when to create an index?
* Can you explain the differences between UNION and UNION ALL?
* How do you write a SQL query to find the second highest salary in a table?
* What are CTEs (Common Table Expressions) and their benefits?

## Misc
* apache vs nginx? Which one is better?
* opensearch vs elasticsearch ? Which one is better in magento context?
* What is Composer? What is the purpose? And Tell the difference between composer update and composer install? what are composer.json & composer.lock files?
* what is composer dump-autoload
* redis vs varnish
* your remote linux server or local is slow or hanging quite often,how you will proceed

## Managerial Round
* Explain what was your approach/workflow for maintining coding standards?
* Tell me the last time you made a mistake that cost a company or client money, and:
* What did you learn from your mistake?
* What do you do to keep current on technologies?
* What are you learning in your off-time?
* what are the challenging tasks you faced in your current project ?
* what is one exciting OR favorite OR challenging task you done till now ?
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