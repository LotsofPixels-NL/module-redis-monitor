<?php
declare(strict_types=1);

namespace Lotsofpixels\RedisMonitor\Block\Adminhtml\System\Config\Fieldset;


use Magento\Backend\Block\Template;
use Magento\Framework\Data\Form\Element\Renderer\RendererInterface;


/**
 *
 */
class General extends Template implements RendererInterface
{
    /**
     * Class constructor.
     * @param Template\Context $context
     * @param \Magento\Framework\Module\ModuleList $moduleList
     * @param array $data
     */
    public function __construct(
        Template\Context                     $context,
        \Magento\Framework\Module\ModuleList $moduleList,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        array                                $data = []
    )
    {
        $this->_template = 'Lotsofpixels_RedisMonitor::redis_monitor.phtml';
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context, $data);
        $this->moduleList = $moduleList;
    }
    /**
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $_element = $element;
        return $this->toHtml();
    }

    /**
     * @return void
     */
    public function getRedisport1() {
        $valueFromConfig = $this->scopeConfig->getValue(
            'lotsofpixels_redis/config/redis_port1',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
        );
}

    /**
     * @return void
     */
    public function getRedisport2() {
        $valueFromConfig = $this->scopeConfig->getValue(
            'lotsofpixels_redis/config/redis_port2',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
        );
    }
    /**
     * @return array
     */

    public function getRedisCli1() {
        $redismemory1 = shell_exec('redis-cli info memory');
        $output1 = preg_split('/\s+/', trim($redismemory1));
        $redisoutputcli1 = [];
        foreach ($output1 as $line1) {
            $splitline1 = '';
            $kommastring1 = str_replace(':', ',', $line1);
            $splitline1 = (explode(',',$kommastring1));
            $array1 = $splitline1;
            if (!empty($array ['1'])) {$redisoutputcli1 [$array1['0']] = $array1['1'];}
        }
        return $redisoutputcli1;
}
    public function getRedisCli2() {
        $redismemory2 = shell_exec('redis-cli info memory');
        $output2 = preg_split('/\s+/', trim($redismemory2));
        $redisoutputcli2 = [];
        foreach ($output2 as $line2) {
            $splitline2 = '';
            $kommastring2 = str_replace(':', ',', $line2);
            $splitline2 = (explode(',',$kommastring2));
            $array2 = $splitline2;
            if (!empty($array ['1'])) {$redisoutputcli2 [$array2['0']] = $array2['1'];}
        }
        return $redisoutputcli2;
    }
}


