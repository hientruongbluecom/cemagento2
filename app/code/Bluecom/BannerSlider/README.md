# Magento 2 - Widget Banner Slider

Magento 2 - Widget Banner Slider - allow to display list banner in slider with magento2 system configuration

How to Install the module
-------------------------
Copy Bluecom (Bluecom/BannerSlider) folder in app/code

Run Following Command via terminal
----------------------------------
php bin/magento setup:upgrade

php bin/magento rm -rf var/

php bin/magento setup:di:compile

php rm -rf pub/static

php bin/magento setup:static-content:deploy

How to use Widget Banner Slider
-------------------------------------
Insert slider ( Dashboard Admin -> Content -> Sliders ([Bluecom] Banner Slider) -> Add New Slider )

Insert banner ( Dashboard Admin -> Content -> Banners ([Bluecom] Banner Slider) -> Add New Banner )

Insert Widget in content page/block -> Widget Type : Slider Banner -> Configuration widget -> Insert Widget -> Save page/sudoblock

Note
----
if not show slide, remove file requirejs-config.js in folder pub/static/_requirejs.
