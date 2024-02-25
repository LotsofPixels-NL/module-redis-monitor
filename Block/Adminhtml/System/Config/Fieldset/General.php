<?php
declare(strict_types=1);

namespace Lotsofpixels\RedisMonitor\Block\Adminhtml\System\Config\Fieldset;


use Magento\Backend\Block\Template;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Data\Form\Element\Renderer\RendererInterface;
use Magento\Store\Model\ScopeInterface;


/**
 *
 */
class General extends Template implements RendererInterface
{

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Class constructor.
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(
        Template\Context     $context,
        ScopeConfigInterface $scopeConfig,
        array                $data = []
    )
    {
        $this->_template = 'Lotsofpixels_RedisMonitor::redis_monitor.phtml';
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context, $data);
    }

    /**
     * @param AbstractElement $element
     * @return string
     */
    public function render(AbstractElement $element): string
    {
        $_element = $element;
        return $this->toHtml();
    }

    /**
     * @return mixed
     */
    public function getRedisport1(): mixed
    {
        return $this->scopeConfig->getValue("lotsofpixels_redis/config/redis_port1", ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return mixed
     */
    public function getRedisport2(): mixed
    {
        return $this->scopeConfig->getValue("lotsofpixels_redis/config/redis_port2", ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return array
     */
    public function getRedisCli1(): array
    {
        $redisport1 = $this->getRedisport1();
        $redisoutput1 = [];
        $clicommmand1 = 'redis-cli -p ' . $redisport1 . ' info memory';
        $redismemory1 = shell_exec($clicommmand1);
        if (is_null($redismemory1)) {
            $redisoutput1 ['redisport'] = $redisport1;
            $redisoutput1 ['Error'] = 'Could not connect to Redis at ' . $redisport1 . 'Connection refused';
            return $redisoutput1;
        } else {
            $output1 = preg_split('/\s+/', trim($redismemory1));

            foreach ($output1 as $line1) {
                $kommastring1 = str_replace(':', ',', $line1);
                $splitline1 = (explode(',', $kommastring1));
                $array1 = $splitline1;
                if (!empty($array1 ['1'])) {
                    $redisoutput1 [$array1['0']] = $array1['1'];
                }
            }
            if ($redisport1) {
                $redisoutput1 ['redisport'] = $redisport1;
            }
            return $redisoutput1;
        }
    }

    /**
     * @return array
     */
    public function getRedisCli2(): array
    {
        $redisport2 = $this->getRedisport2();
        $redisoutput2 = [];
        $clicommmand2 = 'redis-cli -p ' . $redisport2 . ' info memory';
        $redismemory2 = shell_exec($clicommmand2);
        if (is_null($redismemory2)) {
            $redisoutput2 ['redisport'] = $redisport2;
            $redisoutput2 ['Error'] = 'Could not connect to Redis at ' . $redisport2 . 'Connection refused';
            return $redisoutput2;
        } else {
            $output2 = preg_split('/\s+/', trim($redismemory2));
            $redisoutput2 = [];
            foreach ($output2 as $line2) {
                $kommastring2 = str_replace(':', ',', $line2);
                $splitline2 = (explode(',', $kommastring2));
                $array2 = $splitline2;
                if (!empty($array2 ['1'])) {
                    $redisoutput2 [$array2['0']] = $array2['1'];
                }
            }
            if ($redisport2) {
                $redisoutput2 ['redisport'] = $redisport2;
            }
            return $redisoutput2;
        }
    }
}


