<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the LGPL. For more information, see
 * <http://www.doctrine-project.org>.
*/

namespace Doctrine\DBAL\Event;

use Doctrine\DBAL\Platforms\AbstractPlatform,
    Doctrine\DBAL\Schema\Table;

/**
 * Event Arguments used when the SQL query for dropping tables are generated inside Doctrine\DBAL\Platform\AbstractPlatform.
 *
 * @license     http://www.opensource.org/licenses/lgpl-license.php LGPL
 * @link        www.doctrine-project.com
 * @since       2.2
 * @author      Jan Sorgalla <jsorgalla@googlemail.com>
 */
class SchemaDropTableEventArgs extends SchemaEventArgs
{
    /**
     * @var string|\Doctrine\DBAL\Schema\Table
     */
    private $_table = null;

    /**
     * @var \Doctrine\DBAL\Platforms\AbstractPlatform
     */
    private $_platform = null;

    /**
     * @var string
     */
    private $_sql = null;

    /**
     * @param string|\Doctrine\DBAL\Schema\Table $table
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     */
    public function __construct($table, AbstractPlatform $platform)
    {
        if (!$table instanceof Table && !is_string($table)) {
            throw new \InvalidArgumentException('SchemaCreateTableEventArgs expects $table parameter to be string or \Doctrine\DBAL\Schema\Table.');
        }

        $this->_table    = $table;
        $this->_platform = $platform;
    }

    /**
     * @return string|\Doctrine\DBAL\Schema\Table
     */
    public function getTable()
    {
        return $this->_table;
    }

    /**
     * @return \Doctrine\DBAL\Platforms\AbstractPlatform
     */
    public function getPlatform()
    {
        return $this->_platform;
    }

    /**
     * @param string $sql
     * @return \Doctrine\DBAL\Event\SchemaDropTableEventArgs
     */
    public function setSql($sql)
    {
        $this->_sql = $sql;

        return $this;
    }

    /**
     * @return string
     */
    public function getSql()
    {
        return $this->_sql;
    }
}