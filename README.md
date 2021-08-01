# Magento 2 - Save System Config to env.php

Magento 2 module for the Israeli payment gateway [Credit Guard](https://www.creditguard.co.il/?lang=en)




## Installation

#### Step 1

##### Using Composer (recommended)

```
composer require maxmage/magento2-save-config
```

##### Manual Installation (less recommended)
 * Download the extension
 * Unzip the file
 * Create a folder {Magento root}/app/code/MaxMage/SaveConfig
 * Copy the content from the unzip folder
 * Flush cache

#### Step 2 -  Enable the module
```
 php -f bin/magento module:enable --clear-static-content MaxMage_SaveConfig
 php -f bin/magento setup:upgrade
 php -f bin/magento cache:flush
 
```
#### How To Use

1. It's allow you to save the active section config (dropdown, input and textarea)
2. It's allow you to save an exactly config record

<img src="https://i.imgur.com/uqVKlfW.png" align="right" />
  
  
Module saves actual data which you see on a screen. After import required to run a command in CLI  

```
 php -f bin/magento app:config:import
```
 
Support
---
Before reporting an issue, check if you can reproduce it on the clean Magento instance.
If that is the cases, please open an issue on [GitHub](https://github.com/MaxMage/magento2-save-config/issues).

Contribution
---
Want to contribute to this extension? The quickest way is to open a [pull request on GitHub](https://help.github.com/articles/using-pull-requests).

Need help setting up or want to customize this extension to meet your business needs? Please email us to maxmagedev@gmail.com.

