# magento-2-quickies

**All tested on Magento 2.4.6**

**Adminlogo** - Change various logos in the admin panel

**CatalogDeleteACL** - Provide separate ACL for category & product delete access (for api as well)

**CmsImage** - Add Image attribute in CMS Page 

**FormatIncrementId** - Format Magento Increment Id (Reduce Length/Remove Zero-padding/Add Prefix) [Read more here](https://www.classyllama.com/blog/m2-incrementid)

**FrontendDisable** - Disable Magento frontend & Redirect to Admin/HomePage/Custom URL

**Amazonpay GraphQl** - Amazonpay Graphql support added(tested on 2.3.4)
(Deprecated. AmazonPay has added graphql support now)

**DynamicAttributesGraphql GraphQl** (2.3)
Graphql products query returns only ids for select or multiselect fields. This is quickfix which will allow to get Text Labels as well as Id Values.

**FetchProductById GraphQl** - Fetch Product by productid using GraphQl

**RequestedQtyGraphQlBug GraphQl** - Magento 2 [Core Bug](https://github.com/magento/magento2/issues/33281) Fix

**GuestStockAlert** - Implemented Default Product stock alerts for guests as well.

**MassProductUpdate** - This module provides mass update actions in admin product grid, it can update product prices for selected products by lumpsum amount or via percentage changes

**MoveOutofStockToLast** - This module Display out of stock products to the end of category page.

**OrderGridExport** - This module provides additional options in admin order grid export, like 'export xls' and 'export custom csv'.

**RenameCountry** - Rename Country

**SetupDataWithCSV** - Setup Data Patch for Bulk upload through CSV

**SystemXML** - All System Configurations Reference with examples

**WidgetFeaturedCategories** - Custom Widget for Featured Categories

**WPPasswordConverter** - Customer Passwords migration from Wordpress to Magento. After saving wordpress customer passwords into magento, on every login it will check whether it matches wp old password, if so it will resave it in magento format and customer will be logged in.