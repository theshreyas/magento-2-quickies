```sh
\Magento\Framework\Filesystem\DirectoryList $dir,
$this->_dir = $dir;
```

---------------------PLUGIN------------------------

if og function does not return anything, plugin also dont need to return anything

beforePlugin


afterPlugin
---------------------PREFERENCE------------------------

preference types
11111]
    public function __construct(
        LocatorInterface $locator,
        StoreManagerInterface $storeManager,
        ConfigInterface $productOptionsConfig,
        ProductOptionsPrice $productOptionsPrice,
        UrlInterface $urlBuilder,
        ArrayManager $arrayManager
    ) {
        $this->locator = $locator;
        $this->storeManager = $storeManager;
        $this->productOptionsConfig = $productOptionsConfig;
        $this->productOptionsPrice = $productOptionsPrice;
        $this->urlBuilder = $urlBuilder;
        $this->arrayManager = $arrayManager;
    }
22222]
    	public function __construct(
		$name,
		$primaryFieldName,
		$requestFieldName,
		CollectionFactory $collectionFactory,
		PoolInterface $pool,
		array $meta = [],
		array $data = []
	) {
		parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
		$this->collection = $collectionFactory->create();
		$this->pool       = $pool;
	}



	https://magento.stackexchange.com/a/359121