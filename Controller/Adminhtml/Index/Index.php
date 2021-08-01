<?php
/**
 * Copyright © 2021 Max Mage. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MaxMage\SaveConfig\Controller\Adminhtml\Index;

use Magento\Config\Model\Config\Factory as ConfigFactory;
use Magento\Framework\App\DeploymentConfig\Writer;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Config\File\ConfigFilePool;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Stdlib\ArrayManager;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Index
 * @package MaxMage\SaveConfig\Controller\Adminhtml\Index
 */
class Index extends Action
{

    /**
     * @var Writer
     */
    protected $deploymentConfig;

    /**
     * @var ConfigFactory
     */
    protected $configFactory;

    /**
     * @var ArrayManager
     */
    protected $arrayManager;

    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Index constructor.
     * @param Writer $deploymentConfig
     * @param ConfigFactory $configFactory
     * @param ArrayManager $arrayManager
     * @param JsonFactory $resultJsonFactory
     * @param StoreManagerInterface $storeManager
     * @param Context $context
     */
    public function __construct(
        Writer $deploymentConfig,
        ConfigFactory $configFactory,
        ArrayManager $arrayManager,
        JsonFactory $resultJsonFactory,
        StoreManagerInterface $storeManager,
        Context $context
    ) {
        $this->deploymentConfig = $deploymentConfig;
        $this->configFactory = $configFactory ?? ObjectManager::getInstance()->get(ConfigFactory::class);
        $this->arrayManager = $arrayManager;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->storeManager = $storeManager;

        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Json|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $params = $this->getRequest()->getParams();
        $resultJson = $this->resultJsonFactory->create();
        if ($params['isAjax']) {

            try {
                $scope = $this->getScopeLevel($params);

                foreach ($params as $key => $value) {
                    //validate if it's config path
                    if (strpos($key,'/') !== false) {
                        try {
                            $configData = $this->arrayManager->set('system/' . $scope . $key , [], $value);
                            $this->deploymentConfig->saveConfig([ConfigFilePool::APP_ENV => $configData], false);
                            return $resultJson->setData(['message' => 'Config data were saved.']);
                        } catch (\Exception $e) {
                            return $resultJson->setData(['message' => $e->getMessage()]);
                        }
                    }
                }
            } catch (\Exception $e) {
                return $resultJson->setData(['message' => $e->getMessage()]);
            }
        }
        return $resultJson->setData(['message' => 'Wrong request.']);
    }

    /**
     * @param $params
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    protected function getScopeLevel($params)
    {
        $scope = 'default/';

        if (isset($params['website'])) {
            $scope = 'websites/' . $this->storeManager->getWebsite($params['website'])->getCode() . '/';
        } elseif (isset($params['store'])) {
            $scope = 'stores/' . $this->storeManager->getStore($params['store'])->getCode() . '/';
        }

        return $scope;
    }
}