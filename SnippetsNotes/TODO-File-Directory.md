```sh
protected \Magento\Framework\Filesystem\DirectoryList $dir,
protected \Magento\Store\Model\StoreManagerInterface $storeManager,
```

```sh
$this->dir->getRoot(); // Output: /var/www/html/m2
$this->dir->getPath('media'); // Output: /var/www/html/m2/pub/media
$this->dir->getPath('pub'); // Output: /var/www/html/m2/pub
$this->dir->getPath('static'); // Output: /var/www/html/m2/pub/static
$this->dir->getPath('var'); // Output: /var/www/html/m2/var
$this->dir->getPath('app'); // Output: /var/www/html/m2/app
$this->dir->getPath('etc'); // Output: /var/www/html/m2/app/etc
$this->dir->getPath('lib_internal'); // Output: /var/www/html/m2/lib/internal
$this->dir->getPath('lib_web'); // Output: /var/www/html/m2/lib/web
$this->dir->getPath('tmp'); // Output: /var/www/html/m2/var/tmp
$this->dir->getPath('cache'); // Output: /var/www/html/m2/var/cache
$this->dir->getPath('log'); // Output: /var/www/html/m2/var/log
$this->dir->getPath('session'); // Output: /var/www/html/m2/var/session
$this->dir->getPath('setup'); // Output: /var/www/html/m2/setup/src
$this->dir->getPath('di'); // Output: /var/www/html/m2/var/di
$this->dir->getPath('upload'); // Output: /var/www/html/m2/pub/media/upload
$this->dir->getPath('generation'); // Output: /var/www/html/m2/var/generation
$this->dir->getPath('view_preprocessed'); // Output: /var/www/html/m2/var/view_preprocessed
$this->dir->getPath('composer_home'); // Output: /var/www/html/m2/var/composer_home
$this->dir->getPath('html'); // Output: /var/www/html/m2/var/view_preprocessed/html
$this->dir->getRoot().'/vendor'; // Output: /var/www/html/m2/vendor

$this->storeManager->getStore()->getBaseUrl(); // http://m2.test/
```


1.create file/folder if not exists
2.check if file/folder exists
3.count no of files in a folder
4.copy/move/rename/delete/create file
