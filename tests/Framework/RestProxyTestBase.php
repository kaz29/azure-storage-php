<?php

/**
 * LICENSE: The MIT License (the "License")
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * https://github.com/azure/azure-storage-php/LICENSE
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * PHP version 5
 *
 * @category  Microsoft
 * @package   MicrosoftAzure\Storage\Tests\Framework
 * @author    Azure Storage PHP SDK <dmsh@microsoft.com>
 * @copyright 2016 Microsoft Corporation
 * @license   https://github.com/azure/azure-storage-php/LICENSE
 * @link      https://github.com/azure/azure-storage-php
 */

namespace MicrosoftAzure\Storage\Tests\Framework;

use MicrosoftAzure\Storage\Common\Logger;
use MicrosoftAzure\Storage\Common\Internal\Serialization\XmlSerializer;
use MicrosoftAzure\Storage\Common\ServicesBuilder;

/**
 * Testbase for all REST proxy tests.
 *
 * @category  Microsoft
 * @package   MicrosoftAzure\Storage\Tests\Framework
 * @author    Azure Storage PHP SDK <dmsh@microsoft.com>
 * @copyright 2016 Microsoft Corporation
 * @license   https://github.com/azure/azure-storage-php/LICENSE
 * @link      https://github.com/azure/azure-storage-php
 */
class RestProxyTestBase extends \PHPUnit\Framework\TestCase
{
    protected $restProxy;
    protected $xmlSerializer;

    protected function getTestName()
    {
        return sprintf('onesdkphp%04x', mt_rand(0, 65535));
    }

    public static function assertHandler($file, $line, $code)
    {
        echo "Assertion Failed:\n
            File '$file'\n
            Line '$line'\n
            Code '$code'\n";
    }

    public function __construct(string $name)
    {
        parent::__construct($name);
        $this->xmlSerializer = new XmlSerializer();
        Logger::setLogFile('C:\log.txt');

        // Note: assert_options() functions are deprecated in PHP 8.3+
        // Modern PHP uses ini_set('assert.exception', 1) if needed
    }

    public function setProxy($serviceRestProxy)
    {
        $this->restProxy = $serviceRestProxy;
    }

    protected function onNotSuccessfulTest(\Throwable $e): never
    {
        parent::onNotSuccessfulTest($e);

        $this->tearDown();
        throw $e;
    }
}
