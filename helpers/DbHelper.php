<?php

namespace app\helpers;

use Yii;

/**
 * Database Helper
 */
class DbHelper
{
    //---------------------------------------------------------------------------------------------
    // description: Check if database table exists.
    // parameters : $tableName
    // return     : bool
    //---------------------------------------------------------------------------------------------
    public static function tableExists($tableName)
    {
        return (Yii::$app->db->getTableSchema($tableName, true) !== null);
    }
    //---------------------------------------------------------------------------------------------
    public static function tableNotExists($tableName)
    {
        return !self::tableExists($tableName);
    }

    //---------------------------------------------------------------------------------------------
    /**
     * Get table default options.
     *
     * @return string $tableOptions
     */
    //---------------------------------------------------------------------------------------------
    public static function getTableOptions()
    {
        $tableOptions = null;
        if (Yii::$app->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            //$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB AUTO_INCREMENT=1';
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        return $tableOptions;
    }

    //---------------------------------------------------------------------------------------------
    // description: Get database table prefix.
    // parameters : void
    // return     : $prefix (string)
    //---------------------------------------------------------------------------------------------
    public static function getTablePrefix()
    {
        return Yii::$app->db->tablePrefix;
    }

    //---------------------------------------------------------------------------------------------
    // description: Get raw database table name.
    //              Eg: DbHelper::getRawTableName('{{%customer}}');  // returns 'tbl_customer'
    // parameters : $tableName
    // return     : $rawTableName (string)
    //---------------------------------------------------------------------------------------------
    public static function getRawTableName($tableName)
    {
        return Yii::$app->db->schema->getRawTableName($tableName);
    }

    //---------------------------------------------------------------------------------------------
    // description: Get raw database table name.
    //              Eg: DbHelper::getRawTableName('{{%customer}}');  // returns 'tbl_customer'
    // parameters : $tableName
    // return     : $rawTableName (string)
    //---------------------------------------------------------------------------------------------
    public static function getTableNames()
    {
        // Get database connection
        $connection = Yii::$app->db;                  // get connection
        $dbSchema   = $connection->schema;            // or $connection->getSchema();
        $allTables  = $dbSchema->getTableNames();     // returns array of tbl schemas
        return $allTables;
    }

    //---------------------------------------------------------------------------------------------
    // description: Get table foreign keys.
    //              Eg: DbHelper::getForeignKeys('{{%customer}}');  // returns 'tbl_customer'
    // parameters : $tableName
    // return     : array $foreignKeys
    //---------------------------------------------------------------------------------------------
    public static function getTableForeignKeys($tableName)
    {
        return Yii::$app->db->schema->getRawTableName($tableName)->foreignKeys;
    }

    //---------------------------------------------------------------------------------------------
    // description: Drop tables in specified list.
    // parameters : $tables List of table names to drop.
    // return     : void
    //---------------------------------------------------------------------------------------------
    public static function dropTables($tables)
    {
        Yii::$app->db->createCommand("SET foreign_key_checks = 0")->execute();
        foreach ($tables as $table) {
            // Drop foreign keys (safe method)
            //$foreignKeys = self::getTableForeignKeys($table);
            //foreach($foreignKeys as $fk) {
            //    Yii::$app->db->createCommand()->dropForeignKey($fk, $table);
            //}

            if (self::tableExists($table)) {
                Yii::$app->db->createCommand()->dropTable($table)->execute();
            }
        }
        Yii::$app->db->createCommand("SET foreign_key_checks = 1")->execute();
    }

    //---------------------------------------------------------------------------------------------
    // description: Drop all tables except those in specified list.
    // parameters : $table_exception_list (default: ['migration'])
    // return     : void
    //---------------------------------------------------------------------------------------------
    public static function dropAllTablesExcept($table_exception_list = ['migration'])
    {
        Yii::$app->db->createCommand("SET foreign_key_checks = 0")->execute();
        $tables = Yii::$app->db->schema->getTableNames();
        foreach ($tables as $table) {
            // Drop all tables, except tables in exception list
            if (!in_array($table, $table_exception_list)) {
                if (self::tableExists($table)) {
                    Yii::$app->db->createCommand()->dropTable($table)->execute();
                }
            }
        }
        Yii::$app->db->createCommand("SET foreign_key_checks = 1")->execute();
    }

    //---------------------------------------------------------------------------------------------
    // description: Drop all tables (no exception).
    // parameters : void
    // return     : void
    //---------------------------------------------------------------------------------------------
    public static function dropAllTables()
    {
        self::dropAllTablesExcept([]);
    }

    //---------------------------------------------------------------------------------------------
    // description: Drop all RBAC related tables.
    // parameters : void
    // return     : void
    //---------------------------------------------------------------------------------------------
    public static function dropRbacTables()
    {
        try {
            try {
                $authManager = Yii::$app->authManager;

                // Delete RBAC related tables manually
                if ($authManager instanceof DbManager) {
                    $tablesToDrop = [
                        $authManager->assignmentTable,
                        $authManager->itemChildTable,
                        $authManager->itemTable,
                        $authManager->ruleTable,
                    ];
                } else {
                    $tablesToDrop = [
                        self::getRawTableName('{{%auth_assignment}}'),
                        self::getRawTableName('{{%auth_item_child}}'),
                        self::getRawTableName('{{%auth_item}}'),
                        self::getRawTableName('{{%auth_rule}}'),
                    ];

                    //for ($i=0; count($tablesToDrop); $i++) {
                    //    if (!self::tableExists($tablesToDrop[$i])) {
                    //        unset($tablesToDrop[$i]);
                    //    }
                    //}
                    $tablesToDropVerified = $tablesToDrop;
                    foreach ($tablesToDrop as $table) {
                        if (!self::tableExists($table)) {
                            // Remove table from list if it does not exist in database
                            $tablesToDropVerified = array_diff($tablesToDrop, [$table]);
                        }
                    }
                    $tablesToDrop = $tablesToDropVerified;

                    if (count($tablesToDrop)) {
                        $authManager->removeAll();  // remove previous rbac data files under [app]/rbac/data, or all data in tables
                    }
                }

                self::dropTables($tablesToDrop);

            } catch (Exception $exc) {
                echo "Exception:  $exc\n";

                echo "Attempting one more time to drop tables...\n";
                self::dropTables($tablesToDrop);
            }
        } finally {
            // Delete migration entries so we can proceed with other downgrade migrations later
            Yii::$app->db->createCommand()->delete('migration', ['version' => 'm180523_151638_rbac_updates_indexes_without_prefix'])->execute();
            Yii::$app->db->createCommand()->delete('migration', ['version' => 'm170907_052038_rbac_add_index_on_auth_assignment_user_id'])->execute();
            Yii::$app->db->createCommand()->delete('migration', ['version' => 'm140506_102106_rbac_init'])->execute();
            Yii::$app->db->createCommand()->delete('migration', ['version' => 'm180409_110000_init_rbac'])->execute();
        }
    }

    //---------------------------------------------------------------------------------------------
    // description: Get table colum type for specified column.
    //              Eg: DbHelper::generateMigration($table->columns[0]);
    // parameters : $schema (string). The schema of the tables. Defaults to empty string,
    //                                meaning the current or default schema name.
    //              $useSchemaBuilderTrait (bool, default=T) Enable to generate migration using newer
    //                                schema builder trait nomenclature.
    // return     : $migration_result (string)
    //---------------------------------------------------------------------------------------------
    public static function generateMigration($schema = '', $useSchemaBuilderTrait=true)
    {
        // Set the default file name
        //$fileName = 'database-migration.php';
        //$fileName = 'database-migration-' . date('Y-m-d_H-i-s') . '.php';
        $fileName = 'm' . date('ymd_His') . '_create_tables.php';

        // Get database schema
        $tables = Yii::$app->db->schema->getTableSchemas($schema);

        $addForeignKeys  = '';
        $dropForeignKeys = '';

        $result = "<?php

use yii\db\Schema;
use yii\db\Migration;

class " . basename($fileName, ".php") . " extends Migration
{
    private static function tableExists(\$tableName)
    {
        return (Yii::\$app->db->getTableSchema(\$tableName, true) !== null);
    }

    private function getTableOptions()
    {
        \$tableOptions = null;
        if (\$this->db->driverName === 'mysql') {
            \$tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        return \$tableOptions;
    }\n\n";


        $result .= "    public function safeUp()\n    {\n";
        foreach ($tables as $table) {
            $compositePrimaryKeyCols = array();

            // Create table
            $result .= "        if (!self::tableExists('{{%$table->name}}')) {\n";

            $result .= '            $this->createTable(\'{{%' . $table->name . '}}\', [' . "\n";
            foreach ($table->columns as $col) {
                $result .= '               \'' . $col->name . '\' => ' . self::getColType($col, $useSchemaBuilderTrait) . ',' . "\n";

                if ($col->isPrimaryKey && !$col->autoIncrement) {
                    // Add column to composite primary key array
                    $compositePrimaryKeyCols[] = $col->name;
                }
            }
            $result .= '            ], $this->getTableOptions());' . "\n\n";

            // Add foreign key(s) and create indexes
            foreach ($table->foreignKeys as $fkName => $fk) {

                // Example: FK: travel_advisory.embassy_id >> Reference: embassy.id
                //
                //   fkCol: FK_travel_advisory_embassy_id
                //
                //   table->foreignKeys: [
                //       [FK_travel_advisory_embassy_id] => [
                //           [0] => embassy,
                //           [embassy_id] => id,
                //       ]
                //   ]
                $keys     = array_keys($fk);
                $refTable = $fk[0];         // eg: embassy
                $fkCol    = $keys[1];       // eg: embassy_id
                $refCol   = $fk[$keys[1]];  // eg: id

                // Foreign key naming convention: FK_table_foreignTable_col (max 64 characters)
                //$fkName = substr('FK_' . $table->name . '_' . $fk[0] . '_' . $fkName, 0 , 64);

                // Foreign key naming convention: FK_table_foreignkey (max 64 characters)
                $fkName = substr('FK_' . $table->name . '_' . $fkCol, 0 , 64);

                // Debug
                //if ($fkName == "FK_travel_advisory_embassy_id") {
                //    echo "<pre>col: ".print_r($fkName, true) . "</pre>";
                //    echo "<pre>table->foreignKeys: ".print_r($table->foreignKeys, true) . "</pre>";
                //    die();
                //}

                $addForeignKeys  .= '        $this->addForeignKey('  . "'$fkName', '{{%$table->name}}', '$fkCol', '{{%$refTable}}', '".$refCol."', 'RESTRICT', 'RESTRICT');\n";
                $dropForeignKeys .= '        $this->dropForeignKey(' . "'$fkName', '{{%$table->name}}');\n";

                // Index naming convention: IDX_col
                $result .= '            $this->createIndex(\'IDX_' . $table->name . '_' . $fkCol . "', '{{%$table->name}}', '$fkCol', FALSE);\n";
            }

            // Add composite primary key for join tables
            if ($compositePrimaryKeyCols) {
                $result .= '            $this->addPrimaryKey(\'PK_' . $table->name . "', '{{%$table->name}}', '" . implode(',', $compositePrimaryKeyCols) . "');\n";
            }

            $result .= '        }' . "\n\n";  // if table exists

        }
        $result .= $addForeignKeys; // This needs to come after all of the tables have been created.
        $result .= "    }\n\n\n";

        $result .= "    public function safeDown()\n    {\n";
        $result .= "        \$this->execute(\"SET foreign_key_checks = 0;\");\n\n";
        $result .= $dropForeignKeys . "\n"; // This needs to come before the tables are dropped.
        foreach ($tables as $table) {
            $result .= '        $this->dropTable(\'{{%' . $table->name . '}}\');' . "\n";
        }
        $result .= "\n";
        $result .= "        \$this->execute(\"SET foreign_key_checks = 1;\");\n";
        $result .= "    }\n";

        $result .= "}\n";

        // Serve the file as a download
        header("Content-Type: text/x-php");
        header('Content-Disposition: attachment; filename="'. $fileName . '"');  // File will be called $fileName

        return $result;
    }

    //---------------------------------------------------------------------------------------------
    // description: Get table colum type for specified column.
    //              Eg: DbHelper::getColType($table->columns[0]);
    // parameters : $col
    //            : $useSchemaBuilderTrait (bool, default=T)
    // return     : $colType (string)
    //---------------------------------------------------------------------------------------------
    // Sample table to test data types:
    //
    // CREATE TABLE `test` (
    //    `id`             int(11) NOT NULL,
    //    `fld_char`       char(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    //    `fld_string`     varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    //    `fld_date`       date DEFAULT NULL,
    //    `fld_datetime`   datetime DEFAULT NULL,
    //    `fld_year`       year(4) DEFAULT NULL,
    //    `fld_time`       time DEFAULT NULL,
    //    `fld_timestamp`  timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    //    `fld_integer`    int(11) DEFAULT NULL,
    //    `fld_bigint`     bigint(11) DEFAULT NULL,
    //    `fld_mediumint`  mediumint(9) DEFAULT NULL,
    //    `fld_smallint`   smallint(6) DEFAULT NULL,
    //    `fld_tinyint`    tinyint(1) DEFAULT NULL,
    //    `fld_boolean`    tinyint(1) DEFAULT NULL,
    //    `fld_decimal`    decimal(11,2) DEFAULT NULL,
    //    `fld_double`     double(11,2) DEFAULT NULL,
    //    `fld_float`      float(11,2) DEFAULT NULL,
    //    `fld_real`       double(11,2) DEFAULT NULL,
    //    `fld_text`       text COLLATE utf8mb4_unicode_ci,
    //    `fld_longtext`   longtext COLLATE utf8mb4_unicode_ci,
    //    `fld_mediumtext` mediumtext COLLATE utf8mb4_unicode_ci,
    //    `fld_tinytext`   tinytext COLLATE utf8mb4_unicode_ci,
    //    `fld_blob`       blob,
    //    `fld_longblob`   longblob,
    //    `fld_mediumblob` mediumblob,
    //    `fld_tinyblob`   tinyblob,
    //    `fld_binary`     binary(11) DEFAULT NULL,
    //    `fld_enum`       enum('red','blue','green') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    //    `fld_set`        set('red','blue','green') COLLATE utf8mb4_unicode_ci DEFAULT NULL
    //  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    //
    //  ALTER TABLE `test`
    //    ADD PRIMARY KEY (`id`);
    //
    //  ALTER TABLE `test`
    //    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
    //  COMMIT;
    //---------------------------------------------------------------------------------------------
    // Reference field types:
    // at  = abstract type
    // db  = db type
    // php = php type
    //
    // $this->createTable('test', array(
    //     'id'             => $this->primaryKey(),
    //     'fld_char'       => $this->char(11)          /* at=char,      db=char(11),      php=string   */,
    //     'fld_string'     => $this->string(255)       /* at=string,    db=varchar(255),  php=string   */,
    //     'fld_date'       => $this->date()            /* at=date,      db=date,          php=string   */,
    //     'fld_datetime'   => $this->datetime()        /* at=datetime,  db=datetime,      php=string   */,
    //     'fld_year'       => $this->year(4)           /* at=date,      db=year(4),       php=string   */,
    //     'fld_time'       => $this->time()            /* at=time,      db=time,          php=string   */,
    //     'fld_timestamp'  => $this->timestamp()->defaultValue(CURRENT_TIMESTAMP) /* t=timestamp, db=timestamp, php=string */,
    //     'fld_integer'    => $this->integer(11)       /* at=integer,   db=int(11),       php=integer  */,
    //     'fld_bigint'     => $this->biginteger(11)    /* at=bigint,    db=bigint(11),    php=integer  */,
    //     'fld_mediumint'  => $this->mediuminteger(11) /* at=integer,   db=mediumint(11), php=integer  */,
    //     'fld_smallint'   => $this->smallinteger(1)   /* at=smallint,  db=smallint(6),   php=smallint */,
    //     'fld_tinyint'    => $this->tinyinteger(1)    /* at=tinyint,   db=tinyint(1),    php=integer  */,
    //     'fld_boolean'    => $this->tinyinteger(1)    /* at=tinyint,   db=tinyint(1),    php=integer  */,
    //     'fld_decimal'    => $this->decimal(11,2)     /* at=decimal,   db=decimal(11,2), php=string   */,
    //     'fld_double'     => $this->double(11,2)      /* at=double,    db=double(11,2),  php=double   */,
    //     'fld_float'      => $this->float(11,2)       /* at=float,     db=float(11,2),   php=double   */,
    //     'fld_real'       => $this->double(11,2)      /* at=double,    db=double(11,2),  php=double   */,
    //     'fld_text'       => $this->text()            /* at=text,      db=text,          php=string   */,
    //     'fld_longtext'   => 'LONGTEXT'               /* at=text,      db=longtext,      php=string   */,
    //     'fld_mediumtext' => 'MEDIUMTEXT'             /* at=text,      db=mediumtext,    php=string   */,
    //     'fld_tinytext'   => 'TINYTEXT'               /* at=text,      db=tinytext,      php=string   */,
    //     'fld_blob'       => 'BLOB'                   /* at=binary,    db=blob,          php=resource */,
    //     'fld_longblob'   => 'LONGBLOB'               /* at=binary,    db=longblob,      php=resource */,
    //     'fld_mediumblob' => 'MEDIUMBLOB'             /* at=string,    db=mediumblob,    php=resource */,
    //     'fld_tinyblob'   => $this->tinyblob()        /* at=string,    db=tinyblob,      php=resource */,
    //     'fld_binary'     => $this->string(11)        /* at=string,    db=binary(11),    php=string   */,
    //     'fld_enum'       => $this->string()          /* at=string,    db=enum('red','blue','green'), php=string */,
    //     'fld_set'        => $this->string(0)         /* at=string,    db=set('red','blue','green'),  php=string */,
    // ), '');
    public static function getColType($col, $useSchemaBuilderTrait=true)
    {
        // Get primary key
        if ($col->isPrimaryKey && $col->autoIncrement) {
            return ($useSchemaBuilderTrait ? '$this->primaryKey()' :  "'pk'");
        }

        // Get field data type
        switch(strtolower($col->type)) {  // use abstract type
            case 'date':  // includes dbtypes: date, year
            case 'datetime':
            case 'time':
            case 'timestamp':
                if  (stripos($col->dbType, 'year') !== false) {
                    //$result = ($useSchemaBuilderTrait ? '$this->' . strtolower($col->dbType)  : $col->dbType);
                    //$result = $col->dbType . ($useSchemaBuilderTrait ?  " /* Review YEAR: abstract_type=$col->type, dbtype=$col->dbType, phptype=$col->phpType */" : '');
                    $result = $col->dbType;
                    // switch back to standard schema builder
                    $useSchemaBuilderTrait = false;
                } else {
                    $result = ($useSchemaBuilderTrait ? '$this->' . $col->dbType . '()' : $col->dbType);
                }
                break;

            case 'text':    // includes dbtypes: text, longtext, mediumtext, tinytext
            case 'binary':  // include dbtypes: blob, longblob
                if ($col->dbType == 'longtext' || $col->dbType == 'mediumtext' || $col->dbType == 'tinytext' || $col->dbType == 'blob' || $col->dbType == 'longblob') {
                    $result = strtoupper("'{$col->dbType}'");
                } else {
                    $result = ($useSchemaBuilderTrait ? '$this->' . $col->dbType . '('.$col->size.')' : $col->dbType);
                }
                break;

            case 'char':
            case 'decimal': // aka money
            case 'double':  // include dbtype: double, real
            case 'float':
                //$result = ($useSchemaBuilderTrait ? '$this->' . $col->dbType . '('.$col->size.')' . '('.$col->scale.')'. '('.$col->precision.')'  : $col->dbType);  // debug
                $result = ($useSchemaBuilderTrait ? '$this->' . $col->dbType  : $col->dbType);
                break;

            case 'bigint':
            case 'smallint':
            case 'tinyint':
                $result = ($useSchemaBuilderTrait ? '$this->' . $col->type . 'eger('.$col->size.')'  : $col->dbType);
                break;

            case 'integer':  // includes dbtypes: int, mediumint
            case 'string':   // includes dbtypes: varchar, mediumblob, tinyblob, binary
                if (stripos($col->dbType, 'varchar') !== false) {
                    // varchar
                    $result = ($useSchemaBuilderTrait ? '$this->' . $col->type . '('.$col->size.')' : $col->dbType);
                } else if (stripos($col->dbType, 'binary') !== false) {
                    // binary
                    $result = ($useSchemaBuilderTrait ? '$this->' . substr($col->dbType, 0, stripos($col->dbType, '(')) . '('.$col->size.')'  : $col->dbType);
                } else if ($col->dbType == 'longblob' || $col->dbType == 'mediumblob' || $col->dbType == 'tinyblob' || $col->dbType == 'blob') {
                    // longblob, mediumblob, tinyblob, blob
                    //$result = ($useSchemaBuilderTrait ? '$this->' . $col->dbType . '('.$col->size.')' : $col->dbType);
                    $result = strtoupper("'{$col->dbType}'");
                } else if (stripos($col->dbType, 'int') !== false) {
                    // int, mediumint
                    $result = ($useSchemaBuilderTrait ? '$this->' . substr($col->dbType, 0, stripos($col->dbType, '(')) . 'eger('.$col->size.')'  : $col->dbType);
                } else {
                    // For unknown data, add row comments to data, to encourage further review by user
                    //$result = $col->dbType . ($useSchemaBuilderTrait ?  " /* Review STRING/INTEGER: abstract_type=$col->type, dbtype=$col->dbType, phptype=$col->phpType */" : '');  // debug
                    $result = $col->dbType;
                    // switch back to standard schema builder
                    $useSchemaBuilderTrait = false;
                }
                break;

            default:
                // For unknown abstract types
                //$result = $col->dbType . ($useSchemaBuilderTrait ?  " /* Review UNKNOWN: abstract_type=$col->type, dbtype=$col->dbType, phptype=$col->phpType */" : '');  // debug
                $result = $col->dbType;
                // switch back to standard schema builder
                $useSchemaBuilderTrait = false;
                break;
        }

        //  Get NOT NULL
        if (!$col->allowNull) {
            $result .= ($useSchemaBuilderTrait ? '->notNull()' : ' NOT NULL');
        }

        // Get default value
        if ($col->defaultValue != null) {
            $result .= ($useSchemaBuilderTrait ? "->defaultValue('{$col->defaultValue}')" : " DEFAULT '{$col->defaultValue}'");
        } elseif ($col->allowNull) {
            $result .= ($useSchemaBuilderTrait ? '' :' DEFAULT NULL');
        }

        //return addslashes($result . ", /* Options: abstract_type=$col->type, dbtype=$col->dbType, phptype=$col->phpType */");  // debug
        //return addslashes($result);
        return ($useSchemaBuilderTrait ? $result : "\"{$result}\"");
    }

    //---------------------------------------------------------------------------------------------
    /**
     *  Get host name or database name from database connection string in
     *  Yii::$app->db->dsn:
     *   [dsn] => 'mysql:host=localhost;dbname=acme_mydatabase'
     *
     *  Usage:
     *    $db = Yii::$app->getDb();
     *   $dbName = $this->getDsnAttribute('dbname', $db->dsn);
     */
    //---------------------------------------------------------------------------------------------
    private static function getDsnAttribute($name, $dsn)
    {
        if (preg_match('/' . $name . '=([^;]*)/', $dsn, $match)) {
            return $match[1];
        } else {
            return null;
        }
    }

    //---------------------------------------------------------------------------------------------
    /**
     *  Get database name from database connection string in
     *  Yii::$app->db->dsn:
     *   [dsn] => 'mysql:host=localhost;dbname=acme_mydatabase'
     *
     *  Usage:
     *    $dbName = \app\helpers\DbHelper::getDatabaseName();
     */
    //---------------------------------------------------------------------------------------------
    public static function getDatabaseName()
    {
        $db = Yii::$app->getDb();
        $dbName = self::getDsnAttribute('dbname', $db->dsn);
        return $dbName;
    }

    //---------------------------------------------------------------------------------------------
    public static function backupDatabase($tables = '*', $triggers = '*', $is_data_included = true)
    {
        return self::backupDatabaseV2($tables, $triggers, $is_data_included);
    }

    //---------------------------------------------------------------------------------------------
    /**
     * Dumps the MySQL database that this controller's model is attached to.
     * This action will serve the sql file as a download so that the user can save
     * the backup to their local computer.
     *
     * This version is susceptible to running out of memory for databases with
     * larget datasets.
     *
     * @param string $tables Comma separated list of tables you want to download,
     *                       or '*' if you want to download them all.
     * @return file with database schema and data.
     */
    //---------------------------------------------------------------------------------------------
    public static function backupDatabaseV1($tables = '*')
    {
        $result = '';

        $db = Yii::$app->getDb();
        $databaseName = self::getDsnAttribute('dbname', $db->dsn);

        // Set the default file name
        $fileName = $databaseName . '-backup-' . date('Y-m-d_H-i-s') . '.sql';

        // Serve the file as a download
        header("Content-Type: text/x-sql");
        header("Content-Disposition: attachment; filename={$fileName}");  // File will be called $fileName
        // Disable caching - HTTP 1.1
        header("Cache-Control: no-cache, no-store, must-revalidate");
        // Disable caching - HTTP 1.0
        header("Pragma: no-cache");
        // Disable caching - Proxies
        header("Expires: 0");

        // Do a short header
        $result .= '-- Database: `' . $databaseName . '`' . "\n";
        $result .= '-- Generation time: ' . date('D jS M Y H:i:s') . "\n\n\n";

        if ($tables == '*') {
            $tables = array();
            $qryTables = $db->createCommand('SHOW TABLES')->queryAll();
            foreach($qryTables as $resultKey => $resultValue) {
                $tables[] = $resultValue['Tables_in_'.$databaseName];
            }
        } else {
            $tables = is_array($tables) ? $tables : explode(',', $tables);
        }

        // Run through all the tables
        foreach ($tables as $table) {
            $tableData = $db->createCommand('SELECT * FROM ' . $table)->queryAll();

            $result .= 'DROP TABLE IF EXISTS ' . $table . ';';
            $createTableResult = $db->createCommand('SHOW CREATE TABLE ' . $table)->queryAll();
            $createTableEntry = current($createTableResult);
            $result .= "\n\n" . $createTableEntry['Create Table'] . ";\n\n";

            // Output the table data
            foreach($tableData as $tableDataIndex => $tableDataDetails) {
                $result .= 'INSERT INTO ' . $table . ' VALUES(';

                foreach($tableDataDetails as $dataKey => $dataValue) {
                    if (is_null($dataValue)) {
                        $escapedDataValue = 'NULL';
                    } else {
                        // Convert the encoding
                        //$escapedDataValue = mb_convert_encoding( $dataValue, "UTF-8", "ISO-8859-1" );
                        $escapedDataValue = $dataValue;  // no char conversion (keep it as UTF-8)

                        // Escape any apostrophes using the datasource of the model.
                        //$escapedDataValue = str_replace("'", "\'", $escapedDataValue);  // escape apostrophes
                        $escapedDataValue = addslashes($escapedDataValue);  // escape apostrophes
                        //if (stripos($escapedDataValue, ' ') !== false) {
                        //    $escapedDataValue = "'" . $escapedDataValue . "'";  // quote string if spaces found
                        //}
                        //if (!is_numeric($escapedDataValue)) {
                        //    $escapedDataValue = "'" . $escapedDataValue . "'";  // quote string if non-numeric
                        //}
                        $escapedDataValue = "'{$escapedDataValue}'";        // quote string for all fields without NULL
                    }

                    $tableDataDetails[$dataKey] = $escapedDataValue;
                }
                $result .= implode(',', $tableDataDetails);

                $result .= ");\n";
            }

            $result .= "\n\n\n";
        }

        //echo $result;  // Since Yii 2.0.14 you cannot echo in controller. Response must be returned
        return $result;
    }

    //---------------------------------------------------------------------------------------------
    /**
     * Dumps the MySQL database that this controller's model is attached to.
     * This action will serve the sql file as a download so that the user can
     * save the backup to their local computer.
     *
     * Use this version for databases with large datasets.  It is optimized to
     * reduce memory consumption.
     *
     * @param string $tables   Comma separated list of tables you want to download,
     *                         or '*' if you want to download them all.
     * @param string $triggers Comma separated list of triggers you want to download,
     *                         or '*' if you want to download them all.
     * @param bool $is_data_included Default: true.
     * @return file with database schema and data.
     */
    //---------------------------------------------------------------------------------------------
    public static function backupDatabaseV2($tables = '*', $triggers = '*', $is_data_included = true)
    {
        //ini_set('memory_limit','64M');  // limit memory to 64MB
        ini_set('memory_limit','-1');     // no memory limit on output buffering
        ob_start();                       // output buffering start

        Yii::$app->response->format = yii\web\Response::FORMAT_RAW;  // Raw for Text output

        $db = Yii::$app->getDb();
        $databaseName = self::getDsnAttribute('dbname', $db->dsn);

        // Set the default file name
        $fileName = $databaseName . '-backup-' . date('Y-m-d_H-i-s') . '.sql';

        // Serve the file as a download
        header("Content-Type: text/x-sql");
        header("Content-Disposition: attachment; filename=\"{$fileName}\"");  // File will be called $fileName
        // Disable caching - HTTP 1.1
        header("Cache-Control: no-cache, no-store, must-revalidate");
        // Disable caching - HTTP 1.0
        header("Pragma: no-cache");
        // Disable caching - Proxies
        header("Expires: 0");

        // Do a short SQL header
        echo "-- Database: `{$databaseName}`\n";
        echo "-- Generation time: " . date('D jS M Y H:i:s') . "\n\n\n";

        //-----------------
        // Tables & Views
        //-----------------
        if ($tables == '*') {
            $tables = array();
            $qryTables = $db->createCommand('SHOW TABLES')->queryAll();
            foreach($qryTables as $resultKey => $resultValue) {
                $tables[] = $resultValue["Tables_in_{$databaseName}"];
            }
            //echo "Tables: " . print_r($tables, true);  //debug
        } else {
            $tables = is_array($tables) ? $tables : explode(',', $tables);
        }

        // Run through all the tables
        foreach ($tables as $table) {
            if ($is_data_included) {
                $tableCountData = $db->createCommand("SELECT COUNT(*) AS total FROM `{$table}`")->queryAll();
                $totalRecs = $tableCountData[0]['total'];
                //echo "Total: " . print_r($tableCountData, true);  //debug
            }

            // SQL CREATE code
            echo "DROP TABLE IF EXISTS `{$table}`;";

            // Tables
            try {
                $createTableResult = $db->createCommand("SHOW CREATE TABLE `{$table}`")->queryAll();
                $createTableEntry = current($createTableResult);
                if (!empty($createTableEntry['Create Table'])) {
                    echo "\n\n" . $createTableEntry['Create Table'] . ";\n\n";
                }
            } catch (\Exception $exc) {
                //throw new \Exception($exc->getMessage() . ":\n" . json_encode($dumped), 0, $exc);
                echo "\n\n-- No table definition for '{$table}'\n\n";
            }

            // Views
            try {
                $createViewResult = $db->createCommand("SHOW CREATE VIEW `{$table}`")->queryAll();
                $createViewEntry = current($createViewResult);
                if (!empty($createViewEntry['Create View'])) {
                    echo "\n\n" . $createViewEntry['Create View'] . ";\n\n";
                }
            } catch (\Exception $exc) {
                //throw new \Exception($exc->getMessage() . ":\n" . json_encode($dumped), 0, $exc);
                //echo "\n\n-- No view definition for '" . $table . "'\n\n";
            }

            if ($is_data_included) {
                // Process table data in chunks to avoid running out of memory
                for($startIdx = 0, $chunkSize = 10000; $startIdx < $totalRecs; $startIdx += $chunkSize) {
                    $tableData = $db->createCommand("SELECT * FROM `{$table}` LIMIT {$startIdx},{$chunkSize}")->queryAll();

                    // Output the table data (rows)
                    foreach($tableData as $tableRowIndex => $tableRow) {
                        $strRow = "INSERT INTO `{$table}` VALUES(";

                        // Field values
                        foreach($tableRow as $fieldName => $fieldValue) {
                            if (is_null($fieldValue)) {
                                $escapedFieldValue = 'NULL';
                            } else {
                                // Convert the encoding
                                //$escapedFieldValue = mb_convert_encoding( $fieldValue, "UTF-8", "ISO-8859-1" );
                                $escapedFieldValue = $fieldValue;  // no char conversion (keep it as UTF-8)

                                // Escape any apostrophes using the datasource of the model.
                                //$escapedFieldValue = str_replace("'", "\'", $escapedFieldValue);  // escape apostrophes
                                //$escapedFieldValue = str_replace('"', '\"', $escapedFieldValue);  // escape double-quoted substrings
                                $escapedFieldValue = addslashes($escapedFieldValue);  // escape apostrophes and double-quoted substrings
                                //$escapedFieldValue = str_replace("'", "&apos;", $escapedFieldValue);  // escape apostrophes
                                //$escapedFieldValue = str_replace('"', '&quot;', $escapedFieldValue);  // escape double-quoted substrings
                                //if (stripos($escapedFieldValue, ' ') !== false) {
                                //    $escapedFieldValue = "'{$escapedFieldValue}'";  // quote string if spaces found
                                //}
                                //if (!is_numeric($escapedFieldValue)) {
                                //    $escapedFieldValue = "'{$escapedFieldValue}'";  // quote string if non-numeric
                                //}
                                $escapedFieldValue = "'{$escapedFieldValue}'";        // quote string for all fields without NULL
                            }

                            $tableRow[$fieldName] = $escapedFieldValue;
                        }
                        $strRow .= implode(',', $tableRow);
                        $strRow .= ");\n";
                        echo $strRow;
                    }
                }
            }

            echo "\n\n\n";
        }

        echo "\n\n\n";

        //-----------------
        // Triggers
        //-----------------
        if ($triggers == '*') {
            $triggers = array();
            $result = $db->createCommand('SHOW TRIGGERS')->queryAll();
            foreach($result as $resultKey => $resultValue) {
                $triggers[] = $resultValue['Trigger'];
            }
        } else {
            $triggers = is_array($triggers) ? $triggers : explode(',', $triggers);
        }

        // Run through all the triggers
        echo "\n\n-- Triggers \n\n";
        foreach ($triggers as $trigger) {
            echo "DROP TRIGGER IF EXISTS `{$trigger}`;";
            // Triggers
            $createTriggerResult = $db->createCommand("SHOW CREATE TRIGGER `{$trigger}`")->queryAll();
            $createTriggerEntry = current($createTriggerResult);
            //if (!empty($createTriggerEntry['sql_mode'])) {
            //    echo "\n\n" . $createTriggerEntry['sql_mode'] . ";\n\n";
            //}
            if (!empty($createTriggerEntry['SQL Original Statement'])) {
                echo "\n\n" . $createTriggerEntry['SQL Original Statement'] . ";\n\n";
            }
            //if (!empty($createTriggerEntry['character_set_client'])) {
            //    echo "\n\n" . $createTriggerEntry['character_set_client'] . ";\n\n";
            //}
            //if (!empty($createTriggerEntry['collation_connection'])) {
            //    echo "\n\n" . $createTriggerEntry['collation_connection'] . ";\n\n";
            //}
            //if (!empty($createTriggerEntry['Database Collation'])) {
            //    echo "\n\n" . $createTriggerEntry['Database Collation'] . ";\n\n";
            //}

            echo "\n\n\n";
        }

        echo "\n\n\n\n\n\n\n\n\n\n\n\n";
        return ob_get_clean();  // return output buffer and turn off buffering
    }

    //---------------------------------------------------------------------------------------------
    public static function backupDatabaseV3($tables = '*', $triggers = '*', $is_data_included = true)
    {
        //ini_set('memory_limit','64M');  // limit memory to 64MB
        ini_set('memory_limit','-1');     // no memory limit

        Yii::$app->response->format = yii\web\Response::FORMAT_RAW;  // Raw for Text output

        $strReturn = "";

        $db = Yii::$app->getDb();
        $databaseName = self::getDsnAttribute('dbname', $db->dsn);

        // Set the default file name
        $fileName = $databaseName . '-backup-' . date('Y-m-d_H-i-s') . '.sql';

        // Serve the file as a download
        header("Content-Type: text/x-sql");
        header("Content-Disposition: attachment; filename=\"{$fileName}\"");  // File will be called $fileName
        // Disable caching - HTTP 1.1
        header("Cache-Control: no-cache, no-store, must-revalidate");
        // Disable caching - HTTP 1.0
        header("Pragma: no-cache");
        // Disable caching - Proxies
        header("Expires: 0");

        // Do a short SQL header
        $strReturn .= "-- Database: `{$databaseName}`\n";
        $strReturn .= "-- Generation time: " . date('D jS M Y H:i:s') . "\n\n\n";

        //-----------------
        // Tables & Views
        //-----------------
        if ($tables == '*') {
            $tables = array();
            $qryTables = $db->createCommand('SHOW TABLES')->queryAll();
            foreach($qryTables as $resultKey => $resultValue) {
                $tables[] = $resultValue["Tables_in_{$databaseName}"];
            }
            //$strReturn .= "Tables: " . print_r($tables, true);  //debug
        } else {
            $tables = is_array($tables) ? $tables : explode(',', $tables);
        }

        // Run through all the tables
        foreach ($tables as $table) {
            if ($is_data_included) {
                $tableCountData = $db->createCommand("SELECT COUNT(*) AS total FROM `{$table}`")->queryAll();
                $totalRecs = $tableCountData[0]['total'];
                //$strReturn .= "Total: " . print_r($tableCountData, true);  //debug
            }

            // SQL CREATE code
            $strReturn .= "DROP TABLE IF EXISTS `{$table}`;";

            // Tables
            try {
                $createTableResult = $db->createCommand("SHOW CREATE TABLE `{$table}`")->queryAll();
                $createTableEntry = current($createTableResult);
                if (!empty($createTableEntry['Create Table'])) {
                    $strReturn .= "\n\n" . $createTableEntry['Create Table'] . ";\n\n";
                }
            } catch (\Exception $exc) {
                //throw new \Exception($exc->getMessage() . ":\n" . json_encode($dumped), 0, $exc);
                $strReturn .= "\n\n-- No table definition for '{$table}'\n\n";
            }

            // Views
            try {
                $createViewResult = $db->createCommand("SHOW CREATE VIEW `{$table}`")->queryAll();
                $createViewEntry = current($createViewResult);
                if (!empty($createViewEntry['Create View'])) {
                    $strReturn .= "\n\n" . $createViewEntry['Create View'] . ";\n\n";
                }
            } catch (\Exception $exc) {
                //throw new \Exception($exc->getMessage() . ":\n" . json_encode($dumped), 0, $exc);
                //$strReturn .= "\n\n-- No view definition for '" . $table . "'\n\n";
            }

            if ($is_data_included) {
                // Process table data in chunks to avoid running out of memory
                for($startIdx = 0, $chunkSize = 10000; $startIdx < $totalRecs; $startIdx += $chunkSize) {
                    $tableData = $db->createCommand("SELECT * FROM `{$table}` LIMIT {$startIdx},{$chunkSize}")->queryAll();

                    // Output the table data (rows)
                    foreach($tableData as $tableRowIndex => $tableRow) {
                        $strReturn .= "INSERT INTO `{$table}` VALUES(";

                        // Field values
                        foreach($tableRow as $fieldName => $fieldValue) {
                            if (is_null($fieldValue)) {
                                $escapedFieldValue = 'NULL';
                            } else {
                                // Convert the encoding
                                //$escapedFieldValue = mb_convert_encoding( $fieldValue, "UTF-8", "ISO-8859-1" );
                                $escapedFieldValue = $fieldValue;  // no char conversion (keep it as UTF-8)

                                // Escape any apostrophes using the datasource of the model.
                                //$escapedFieldValue = str_replace("'", "\'", $escapedFieldValue);  // escape apostrophes
                                //$escapedFieldValue = str_replace('"', '\"', $escapedFieldValue);  // escape double-quoted substrings
                                $escapedFieldValue = addslashes($escapedFieldValue);  // escape apostrophes and double-quoted substrings
                                //$escapedFieldValue = str_replace("'", "&apos;", $escapedFieldValue);  // escape apostrophes
                                //$escapedFieldValue = str_replace('"', '&quot;', $escapedFieldValue);  // escape double-quoted substrings
                                //if (stripos($escapedFieldValue, ' ') !== false) {
                                //    $escapedFieldValue = "'{$escapedFieldValue}'";  // quote string if spaces found
                                //}
                                //if (!is_numeric($escapedFieldValue)) {
                                //    $escapedFieldValue = "'{$escapedFieldValue}'";  // quote string if non-numeric
                                //}
                                $escapedFieldValue = "'{$escapedFieldValue}'";        // quote string for all fields without NULL
                            }

                            $tableRow[$fieldName] = $escapedFieldValue;
                        }
                        $strReturn .= implode(',', $tableRow);
                        $strReturn .= ");\n";
                    }
                }
            }

            $strReturn .= "\n\n\n";
        }

        $strReturn .= "\n\n\n";

        //-----------------
        // Triggers
        //-----------------
        if ($triggers == '*') {
            $triggers = array();
            $result = $db->createCommand('SHOW TRIGGERS')->queryAll();
            foreach($result as $resultKey => $resultValue) {
                $triggers[] = $resultValue['Trigger'];
            }
        } else {
            $triggers = is_array($triggers) ? $triggers : explode(',', $triggers);
        }

        // Run through all the triggers
        $strReturn .= "\n\n-- Triggers \n\n";
        foreach ($triggers as $trigger) {
            $strReturn .= "DROP TRIGGER IF EXISTS `{$trigger}`;";
            // Triggers
            $createTriggerResult = $db->createCommand("SHOW CREATE TRIGGER `{$trigger}`")->queryAll();
            $createTriggerEntry = current($createTriggerResult);
            //if (!empty($createTriggerEntry['sql_mode'])) {
            //    $strReturn .= "\n\n" . $createTriggerEntry['sql_mode'] . ";\n\n";
            //}
            if (!empty($createTriggerEntry['SQL Original Statement'])) {
                $strReturn .= "\n\n" . $createTriggerEntry['SQL Original Statement'] . ";\n\n";
            }
            //if (!empty($createTriggerEntry['character_set_client'])) {
            //    $strReturn .= "\n\n" . $createTriggerEntry['character_set_client'] . ";\n\n";
            //}
            //if (!empty($createTriggerEntry['collation_connection'])) {
            //    $strReturn .= "\n\n" . $createTriggerEntry['collation_connection'] . ";\n\n";
            //}
            //if (!empty($createTriggerEntry['Database Collation'])) {
            //    $strReturn .= "\n\n" . $createTriggerEntry['Database Collation'] . ";\n\n";
            //}

            $strReturn .= "\n\n\n";
        }

        //return $strReturn;
        Yii::$app->response->data = $strReturn;
    }

    /**
     * Debug specified ActiveQuery.  Include any query in the {$query} param to
     * find out the raw SQL.
     *
     * Usage:
     *   \app\helpers\DbHelper::debugQuery(
     *       Visitor::find()->where(['status' => 1])->orderBy(['id' => SORT_ASC])
     *   );
     *
     * @param ActiveQuery $query
     */
    public static function debugQuery($query)
    {
        $sql = $query->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql;

        \yii::debug("\n" . __METHOD__ . "\nSQL: {$sql}\n", 'dev');
        return "<pre>{$sql}</pre>";
    }

}
