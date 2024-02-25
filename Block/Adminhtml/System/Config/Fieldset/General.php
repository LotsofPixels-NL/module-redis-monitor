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
     * @return string|array
     */
    public function getRedisCli1(): string|array
    {
        $redisport1 = $this->getRedisport1();
        $redisoutput1 = [];
        $clicommmand1 = 'redis-cli -p ' . $redisport1 . ' info memory';
        $redismemory1 = shell_exec($clicommmand1);
        if (is_null($redismemory1)) {
            return 'error';
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
     * @return string
     */
    public function getRedisCli2(): string|array
    {
        $redisport2 = $this->getRedisport2();
        $redisoutput2 = [];
        $clicommmand2 = 'redis-cli -p ' . $redisport2 . ' info memory';
        $redismemory2 = shell_exec($clicommmand2);
        if (is_null($redismemory2)) {
            return 'error';
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


    /**
     * @return string
     */
    public function renderOutput1()
    {
        $clidata1 = $this->getRedisCli1();
        if ($clidata1 === "error") {
            $tabledata1 = "<table><tr><th>Redis Instance 1</th></tr>";
            $tabledata1 .= "
                <tr>
                    <td>Connection refused</td>

                </tr>
                <tr>
                                    <td>Could not connect to Redis</td>
</tr>
            </table>";
            return $tabledata1;
        } else {
            $tabledata1 = "<table><tr><th>Redis Instance 1</th></tr>";
            $tabledata1 .= "
                <tr>
                    <td>Max Memory</td>
                    <td>" . $clidata1['maxmemory_human'] . "</td>
                </tr>
                <tr>
                    <td>Used Memory</td>
                    <td>" . $clidata1['used_memory_human'] . "</td>
                </tr>
                <tr>
                    <td>Used Peak Memory</td>
                    <td>" . $clidata1['used_memory_peak_human'] . "</td>
                </tr>
            </table>";
            return $tabledata1;
        }

    }

    /**
     * @return string
     */
    public function renderOutput2()
    {
        $clidata2 = $this->getRedisCli2();
        if ($clidata2 === "error") {
            $tabledata1 = "<table><tr><th>Redis Instance 2</th></tr>";
            $tabledata1 .= "
                <tr>
                    <td>Connection refused</td>

                </tr>
                <tr><td> - </td></tr>
                <tr>
                                    <td>Could not connect to Redis</td>
</tr>
            </table>";
            return $tabledata1;
        } else {
            $tabledata2 = "<table><tr><th>Redis Instance 2</th></tr>";
            $tabledata2 .= "
                <tr>
                    <td>Max Memory</td>
                    <td>" . $clidata2['maxmemory_human'] . "</td>
                </tr>
                <tr>
                    <td>Used Memory</td>
                    <td>" . $clidata2['used_memory_human'] . "</td>
                </tr>
                <tr>
                    <td>Used Peak Memory</td>
                    <td>" . $clidata2['used_memory_peak_human'] . "</td>
                </tr>
            </table>";
            return $tabledata2;
        }

    }
}


