<?php
// Licensed to the Apache Software Foundation (ASF) under one
// or more contributor license agreements.  See the NOTICE file
// distributed with this work for additional information
// regarding copyright ownership.  The ASF licenses this file
// to you under the Apache License, Version 2.0 (the
// "License"); you may not use this file except in compliance
// with the License.  You may obtain a copy of the License at
//
//     http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.
//
// set THRIFT_ROOT to php directory of the hive distribution
$GLOBALS['THRIFT_ROOT'] = $_libPath = dirname( __DIR__ ) . '/src';

require_once $_libPath . '/Thrift.php';

// load the required files for connecting to Hive
require_once $_libPath . '/packages/fb303/FacebookService.php';
require_once $_libPath . '/metastore/ThriftHiveMetastore.php';
require_once $_libPath . '/packages/hive_service/ThriftHive.php';
require_once $_libPath . '/transport/TSocket.php';
require_once $_libPath . '/protocol/TBinaryProtocol.php';

// Set up the transport/protocol/client
$transport = new TSocket( '127.0.0.1', 10000 );
$protocol = new TBinaryProtocol( $transport );
$client = new ThriftHiveClient( $protocol );
echo 'Opening...' . PHP_EOL;
$transport->open();

// run queries, metadata calls etc
echo '  * execute: SELECT * from sample_07' . PHP_EOL;

try
{
    $client->execute( 'SELECT * from sample_07' );
    var_dump( $client->fetchAll() );
    $transport->close();
}
catch ( TException $_ex )
{
    echo '  * EXCEPTION: ' . $_ex->getMessage() . PHP_EOL;
}
