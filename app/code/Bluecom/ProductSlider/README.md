# Magento 2 - Widget List Product Slider

Magento 2 - Widget List Product Slider - allow to display list product in slider with magento2 system configuration

How to Install the module
-------------------------
Copy Bluecom (Bluecom/ProductSlider) folder in app/code

Run Following Command via terminal
----------------------------------
php bin/magento setup:upgrade

php bin/magento rm -rf var/

php bin/magento setup:di:compile

php rm -rf pub/static

php bin/magento setup:static-content:deploy

How to use Widget List Product Slider
-------------------------------------
Insert Widget List Product Slider while create Page cms or Block cms.

Insert Widget -> Widget Type : Slider Catalog Products List -> Configuration widget -> Insert Widget -> Save Block/ Page

Note
----
if list product not show slide, remove file requirejs-config.js in folder pub/static/_requirejs.
