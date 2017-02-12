<?php

 /**
 / ForkNote Daemon API Wrapper
 /
 / For ForkNote Coins: bikercoin bipcoin bitcoal bytecoin crossnote
 /                     cryptopeg dashcoin dinastycoin ethanolium fosscoin
 /                     karbowanec magnatoj quazarcoin redwind xcicoin
 /
 / https://github.com/KittyCatTech/forknote-api-php
 / License: BipCot NoGov Software License
 / https://github.com/KittyCatTech/forknote-api-php/blob/master/LICENSE
 */

class ForkNoteDaemon {

   private $server;

   public function __construct($server) {

      $this->server = $server;
      //if( !$result ) {
      //   throw new Exception("Can't Connect to API");
      //}
      return true;
   }

   private function apiCall($req) {
      static $ch = null;
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $url = $this->server . "/json_rpc";
      curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json; charset=utf-8"));
      curl_setopt($ch, CURLOPT_URL, $url );
      //echo json_encode( $req );
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode( $req ) );
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
      $res = curl_exec($ch);
      if ($res === false) throw new Exception('Could not get reply: '.curl_error($ch));
      $result = json_decode($res, true);
      // Check for Error
      if( !isset($result['result']) ){ 
         echo  "API call to '" . $req['method'] . "' returned ";
         if(isset($result['error'])) echo "Error(" . $result['error']['code'] . "): " . $result['error']['message'] . PHP_EOL;
         else echo "Unknown Error: " . print_r($result, true) . PHP_EOL;
         return false;
      }
      return $result;
   }

   private function apiHttpCall($method, $req = array()) {
      static $ch = null;
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $url = $this->server . "/" . $method;
      curl_setopt($ch, CURLOPT_POSTFIELDS, $req );
      curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json; charset=utf-8"));
      curl_setopt($ch, CURLOPT_URL, $url );
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
      $res = curl_exec($ch);
      if ($res === false) throw new Exception('Could not get reply: '.curl_error($ch));
      return $res;
   }


   // getblockcount
   // Returns current chain height.
   // Input:
   // {
   //    "jsonrpc": "2.0",
   //    "id" : "test",
   //    "method": "getblockcount"
   // }
   // Output:
   // {
   //    "id": "test",
   //    "jsonrpc": "2.0",
   //    "result": {
   //       "count": 123456,
   //       "status": "OK"
   //    }
   // }
   // @TODO Debug Error(-32603): JsonValue type is not ARRAY or OBJECT
   public function getBlockCount() {
      $args = array();
      $args["jsonrpc"] = "2.0";
      $args["id"] = "test";
      $args["method"] = "getblockcount";
      $result = $this->apiCall($args);
      //print_r($result);
      if ($result)
         return $result['result'];
   }

   // getblockhash
   // Returns block hash by its height
   // Input:
   // {
   //    "jsonrpc": "2.0",
   //    "id": "test",
   //    "method": "on_getblockhash",
   //    "params": {
   //       "height": 123456
   //    }
   // }
   // Output:
   // {
   //    "id": "test",
   //    "jsonrpc": "2.0",
   //    "result": "a7428..."
   // }
   // @TODO Debug Error(-32603): JsonValue type is not ARRAY
   public function getBlockHash($height) {
      $args = array();
      $args["jsonrpc"] = "2.0";
      $args["id"] = "test";
      $args["method"] = "on_getblockhash";
      $args["params"]["height"] = $height;
      $result = $this->apiCall($args);
      //print_r($result);
      if ($result)
         return $result['result'];
   }

   // getblocktemplate
   // Returns blocktemplate with an empty “hole” for nonce.
   // Input:
   // {
   //    "jsonrpc": "2.0",
   //    "id" : "test",
   //    "method": "getblocktemplate",
   //    "params": {
   //       "reserve_size": 200,
   //       "wallet_address": "28j5g2Hbe1..."
   //    }
   // }
   // Output:
   // {
   //    "id": "test",
   //    "jsonrpc": "2.0",
   //    "result": {
   //       "blocktemplate_blob": "0100de...",
   //       "difficulty": 65563,
   //       "height": 123456,
   //       "reserved_offset": 395,
   //       "status": ""
   //    }
   // }
   public function getBlockTemplate($reserveSize, $walletAddress) {
      $args = array();
      $args["jsonrpc"] = "2.0";
      $args["id"] = "test";
      $args["method"] = "getblocktemplate";
      $args["params"]["reserve_size"] = $reserveSize;
      $args["params"]["wallet_address"] = $walletAddress;
      $result =  $this->apiCall($args);
      //print_r($result);
      if ($result)
         return $result['result'];
   }

   // submitblock
   // Submits mined block.
   // Input:
   // {
   //    "jsonrpc": "2.0",
   //    "id" : "test",
   //    "method": "submitblock",
   //    "params": ["0100b...."]
   // }
   // Output:
   // {
   //    "id": "test",
   //    "jsonrpc": "2.0",
   //    "result": {
   //       "status" : "OK"
   //    }
   // }
   public function submitBlock($block) {
      $args = array();
      $args["jsonrpc"] = "2.0";
      $args["id"] = "test";
      $args["method"] = "submitblock";
      $args["params"] = $block;
      $result =  $this->apiCall($args);
      //print_r($result);
      if ($result)
         return $result['result'];
   }

   // getlastblockheader
   // Returns last block header.
   // Input:
   // {
   //    "jsonrpc": "2.0",
   //    "id" : "test",
   //    "method": "getlastblockheader"
   // }
   // Output:
   // {
   //    "id": "test",
   //    "jsonrpc": "2.0",
   //    "result": {
   //       "block_header": {
   //          "depth": 1,
   //          "difficulty": 65198,
   //          "hash": "9a8be83...",
   //          "height": 123456,
   //          "major_version": 1,
   //          "minor_version": 0,
   //          "nonce": 2358499061,
   //          "orphan_status": false,
   //          "prev_hash": "dde56b7e...",
   //          "reward": 44090506423186,
   //          "timestamp": 1356589561
   //       },
   //       "status": "OK"
   //    }
   // }
   public function getLastBlockHeader() {
      $args = array();
      $args["jsonrpc"] = "2.0";
      $args["id"] = "test";
      $args["method"] = "getlastblockheader";
      $result =  $this->apiCall($args);
      //print_r($result);
      if ($result)
         return $result['result'];
   }

   // getblockheaderbyhash
   // Returns last block header by given hash.
   // Input:
   // {
   //    "jsonrpc": "2.0",
   //    "id" : "test",
   //    "method": "getblockheaderbyhash",
   //    "params": {
   //       "hash" : "9a8be8..."
   //    }
   // }
   // Output:
   // {
   //    "id": "test",
   //    "jsonrpc": "2.0",
   //    "result": {
   //       "block_header": {
   //          "depth": 1,
   //          "difficulty": 65198,
   //          "hash": "9a8be83...",
   //          "height": 123456,
   //          "major_version": 1,
   //          "minor_version": 0,
   //          "nonce": 2358499061,
   //          "orphan_status": false,
   //          "prev_hash": "dde56b7e...",
   //          "reward": 44090506423186,
   //          "timestamp": 1356589561
   //       },
   //       "status": "OK"
   //    }
   // }
   public function getBlockHeaderByHash($hash) {
      $args = array();
      $args["jsonrpc"] = "2.0";
      $args["id"] = "test";
      $args["method"] = "getblockheaderbyhash";
      $args["params"]["hash"] = $hash;
      $result =  $this->apiCall($args);
      //print_r($result);
      if ($result)
         return $result['result'];
   }

   // getblockheaderbyheight
   // Returns block header by given block height.
   // Input:
   // {
   //    "jsonrpc": "2.0",
   //    "id" : "test",
   //    "method": "getblockheaderbyheight",
   //    "params": {
   //       "height" : 123456
   //    }
   // }
   // Output:
   // {
   //    "id": "test",
   //    "jsonrpc": "2.0",
   //    "result": {
   //       "block_header": {
   //          "depth": 1,
   //          "difficulty": 65198,
   //          "hash": "9a8be83...",
   //          "height": 123456,
   //          "major_version": 1,
   //          "minor_version": 0,
   //          "nonce": 2358499061,
   //          "orphan_status": false,
   //          "prev_hash": "dde56b7e...",
   //          "reward": 44090506423186,
   //          "timestamp": 1356589561
   //          },
   //       "status": "OK"
   //    }
   // }
   public function getBlockHeaderByHeight($height) {
      $args = array();
      $args["jsonrpc"] = "2.0";
      $args["id"] = "test";
      $args["method"] = "getblockheaderbyheight";
      $args["params"]["height"] = $height;
      $result =  $this->apiCall($args);
      //print_r($result);
      if ($result)
         return $result['result'];
   }

   // getcurrencyId
   // Returns unique currency identifier.
   // Input:
   // {
   //    "jsonrpc": "2.0",
   //    "id" : "test",
   //    "method": "getcurrencyid"
   // }
   // Output:
   // {
   //    "id": "test",
   //    "jsonrpc": "2.0",
   //    "result": {
   //       "currency_id_blob" : "a7..."
   //    }
   // }
   public function getCurrencyId() {
      $args = array();
      $args["jsonrpc"] = "2.0";
      $args["id"] = "test";
      $args["method"] = "getcurrencyid";
      $result =  $this->apiCall($args);
      //print_r($result);
      if ($result)
         return $result['result'];
   }

   // f_get_blockchain_settings
   // Returns the settings of the used configuration file.
   // Input:
   //  {
   //     "jsonrpc": "2.0",
   //     "id": "test",
   //     "method": "f_get_blockchain_settings"
   //  }
   // Output:
   //  {
   //     "id": "test",
   //     "jsonrpc": "2.0",
   //     "result": {
   //         "base_coin": {
   //             "git": "https://github.com/amjuarez/bytecoin.git",
   //             "name": "bytecoin"
   //         },
   //         "core": {
   //             "BYTECOIN_NETWORK": "12112111-1110-4101-1311-001212110110",
   //             "CHECKPOINTS": [
   //                 "28000:70d2531151529ac00bf875281e15f51324934bc85e5733dcd92e1ccb1a665ff8",
   //                 "40000:c181ec9223a91fef8658c7aa364c093c41c28d250870ca1ed829bf74f0abf038"
   //             ],
   //             "CRYPTONOTE_BLOCK_GRANTED_FULL_REWARD_ZONE": 20000,
   //             "CRYPTONOTE_BLOCK_GRANTED_FULL_REWARD_ZONE_V1": 10000,
   //             "CRYPTONOTE_DISPLAY_DECIMAL_POINT": 12,
   //             "CRYPTONOTE_MINED_MONEY_UNLOCK_WINDOW": 10,
   //             "CRYPTONOTE_NAME": "dashcoin",
   //             "CRYPTONOTE_PUBLIC_ADDRESS_BASE58_PREFIX": 72,
   //             "DEFAULT_DUST_THRESHOLD": 1000000,
   //             "DIFFICULTY_CUT": 60,
   //             "DIFFICULTY_LAG": 15,
   //             "DIFFICULTY_TARGET": 120,
   //             "EMISSION_SPEED_FACTOR": 18,
   //             "EXPECTED_NUMBER_OF_BLOCKS_PER_DAY": 720,
   //             "GENESIS_BLOCK_REWARD": 0,
   //             "GENESIS_COINBASE_TX_HEX": "010a01ff0001ffffffffffff0f029b2e4c0271c0b42e7c53291a94d1c0cbff8883f8024f5142ee494ffbbd08807121013c086a48c15fb637a96991bc6d53caf77068b5ba6eeb3c82357228c49790584a",
   //             "MAX_BLOCK_SIZE_INITIAL": 25600,
   //             "MINIMUM_FEE": 1000000,
   //             "MONEY_SUPPLY": "18446744073709551615",
   //             "P2P_DEFAULT_PORT": 7610,
   //             "RPC_DEFAULT_PORT": 7611,
   //             "SEED_NODES": [
   //                 "108.61.188.13:7610",
   //                 "128.199.146.23:29080"
   //             ],
   //             "UPGRADE_HEIGHT": 1
   //         },
   //         "extensions": [
   //             "core/bytecoin.json",
   //             "print-genesis-tx.json",
   //             "simplewallet-default-fee.json",
   //             "max-transaction-size-limit.json",
   //             "genesis-block-reward.json"
   //         ],
   //         "status": "OK"
   //     }
   //  }
   public function getBlockchainSettings() {
      $args = array();
      $args["jsonrpc"] = "2.0";
      $args["id"] = "test";
      $args["method"] = "f_get_blockchain_settings";
      $result =  $this->apiCall($args);
      //print_r($result);
      if ($result)
         return $result['result'];
   }

   // f_blocks_list_json
   // Returns list of shortly described blocks.
   // Input:
   //  {
   //     "jsonrpc": "2.0",
   //     "id": "test",
   //     "method": "f_blocks_list_json",
   //     "params": {
   //         "height": 10
   //     }
   //  }
   // Output:
   // {
   //     "id": "test",
   //     "jsonrpc": "2.0",
   //     "result": {
   //         "blocks": [
   //             {
   //                 "cumul_size": 350,
   //                 "hash": "73c87db65839d0697627ef0a58fbe4d20340c74503df0c22aba5298e0814a16d",
   //                 "height": 10,
   //                 "timestamp": 1404556851,
   //                 "tx_count": 1
   //             },
   //             ...
   //             {
   //                 "cumul_size": 120,
   //                 "hash": "2eb6307a9b1be29348db19fdd0a1dad483983cf25241ca27f56d333dbb913d85",
   //                 "height": 0,
   //                 "timestamp": 0,
   //                 "tx_count": 1
   //             }
   //         ],
   //         "status": "OK"
   //     }
   // }
   public function BlocksListJson($height) {
      $args = array();
      $args["jsonrpc"] = "2.0";
      $args["id"] = "test";
      $args["method"] = "f_blocks_list_json";
      $args["params"]["height"] = $height;
      $result =  $this->apiCall($args);
      //print_r($result);
      if ($result)
         return $result['result'];
   }

   // f_block_json
   // Returns detailed description of a block.
   // Input:
   //  {
   //     "jsonrpc": "2.0",
   //     "id": "test",
   //     "method": "f_block_json",
   //     "params": {
   //         "hash": "74e21b7b7869465dd0bc0929a92df667d0fc88979999fe07ffa24ab925fad17d"
   //     }
   //  }
   // Output:
   //  {
   //     "id": "test",
   //     "jsonrpc": "2.0",
   //     "result": {
   //         "block": {
   //             "alreadyGeneratedCoins": 4907142100217515000,
   //             "alreadyGeneratedTransactions": 672169,
   //             "baseReward": 18719332960321,
   //             "blockSize": 1515,
   //             "depth": 15,
   //             "difficulty": 308978448,
   //             "hash": "74e21b7b7869465dd0bc0929a92df667d0fc88979999fe07ffa24ab925fad17d",
   //             "height": 347655,
   //             "major_version": 2,
   //             "minor_version": 0,
   //             "nonce": 2147485048,
   //             "orphan_status": false,
   //             "penalty": 0,
   //             "prev_hash": "d1d2e3a67decae0cf7c6559cb5c50e908db572aa04f092c5f4db1693781702c6",
   //             "reward": 18720332960321,
   //             "sizeMedian": 386,
   //             "timestamp": 1446725921,
   //             "totalFeeAmount": 1000000000,
   //             "transactions": [
   //                 {
   //                     "amount_out": 60321,
   //                     "blockSize": 37383401493432,
   //                     "fee": 0,
   //                     "hash": "eba9c70143bf39a211a2ab2e0635d928455299da45f21cf8da31461ebc467a6a"
   //                 },
   //                 {
   //                     "amount_out": 100000000000,
   //                     "blockSize": 7672522688954774000,
   //                     "fee": 1000000000,
   //                     "hash": "b3aacbdc9cdb3dbd80731621d3dbbcaf9d6bdc7b731933c5cc92b5ff12777852"
   //                 }
   //             ],
   //             "transactionsCumulativeSize": 1119
   //         },
   //         "status": "OK"
   //     }
   //  }
   public function BlockJson($hash) {
      $args = array();
      $args["jsonrpc"] = "2.0";
      $args["id"] = "test";
      $args["method"] = "f_block_json";
      $args["params"]["hash"] = $hash;
      $result =  $this->apiCall($args);
      //print_r($result);
      if ($result)
         return $result['result'];
   }

   // f_transaction_json
   // Returns detailed description of a transaction.
   // Input:
   //  {
   //     "jsonrpc": "2.0",
   //     "id": "test",
   //     "method": "f_transaction_json",
   //     "params": {
   //         "hash": "17246c6ee2e8c05f93dd29ee499f38e8ce4023ea693a3a9e39fb41f2877bbd3d"
   //     }
   //  }
   // Output:
   //  {
   //     "id": "test",
   //     "jsonrpc": "2.0",
   //     "result": {
   //         "block": {
   //             "cumul_size": 8751,
   //             "hash": "533380e35d0dcec920ed58d92eb6af81771e2f4e414fca54f6105f5208650730",
   //             "height": 347985,
   //             "timestamp": 1446765470,
   //             "tx_count": 5
   //         },
   //         "status": "OK",
   //         "tx": {
   //             "": "288a8873fe8cbe233b51fd1d2c252f8a74e8eee3dae61d35b9b434645c27f704a502357be566a75ef168032d676d2e0936d50c6f38ea5317ea7a82dd2ce69f03",
   //             "extra": "01d58d5fd664de79feb3f53ebf9a6a4fa0a5d7987a4c905840d29ef9f13fe380da",
   //             "unlock_time": 0,
   //             "version": 1,
   //             "vin": [
   //                 {
   //                     "type": "02",
   //                     "value": {
   //                         "amount": 200000000000,
   //                         "k_image": "1980a3e2d130c8548b92c63e16c6fedf79819755232eda22939c353c3b66046c",
   //                         "key_offsets": [
   //                             33019,
   //                             22585,
   //                             63469,
   //                             65530
   //                         ]
   //                     }
   //                 },
   //                 ...
   //                 {
   //                     "type": "02",
   //                     "value": {
   //                         "amount": 8000000000000,
   //                         "k_image": "9831d04dc056d8ef5d562ba68ccaa276653594bc32ea687584bfc143c2089b84",
   //                         "key_offsets": [
   //                             46597,
   //                             1208,
   //                             4399,
   //                             42365
   //                         ]
   //                     }
   //                 }
   //             ],
   //             "vout": [
   //                 {
   //                     "amount": 10000000,
   //                     "target": {
   //                         "data": {
   //                             "key": "de25ddd2a718fa274689a6a5c1d996b67c4b41ad30660a44a3a0fb5968d92547"
   //                         },
   //                         "type": "02"
   //                     }
   //                 },
   //                 ...
   //                 {
   //                     "amount": 5000000000000,
   //                     "target": {
   //                         "data": {
   //                             "key": "ba9bfb77a79b7b3a6a61c6fbaa441443e38d1a7f44279c78652f84121be3b4b9"
   //                         },
   //                         "type": "02"
   //                     }
   //                 }
   //             ]
   //         },
   //         "txDetails": {
   //             "amount_out": 8199010000000,
   //             "fee": 1000000000,
   //             "hash": "17246c6ee2e8c05f93dd29ee499f38e8ce4023ea693a3a9e39fb41f2877bbd3d",
   //             "mixin": 4,
   //             "paymentId": "",
   //             "size": 1227
   //         }
   //     }
   //  }
   public function TransactionJson($hash) {
      $args = array();
      $args["jsonrpc"] = "2.0";
      $args["id"] = "test";
      $args["method"] = "f_transaction_json";
      $args["params"]["hash"] = $hash;
      $result =  $this->apiCall($args);
      //print_r($result);
      if ($result)
         return $result['result'];
   }

   // /getheight
   // Returns current chain height
   // JSON
   // Input:     -     -     
   // Output: [int] height
   public function getHeight() {
      $result = $this->apiHttpCall("getheight");
      $json = json_decode($result, true);
      // Check for Error
      if( !isset($json['status']) || $json['status'] != "OK" ){ 
         echo  "API call to 'getHeight' returned ";
         if(isset($json['error'])) echo "Error(" . $json['error']['code'] . "): " . $json['error']['message'] . PHP_EOL;
         else echo "Unknown Error: " . print_r($result, true) . PHP_EOL;
         return false;
      }
      if ($json && isset($json['height']))
         return $json['height'];
   }

   // /getknownblockids       
   // Returns list of known block ids     
   // JSON
   // Input:     -     -     
   // Output: [list] main chain block ids   
   //         [list] alternative chains block ids   
   //         [list] invalid block ids
   // @TODO Debug Error: Requested url is not found
   public function getKnownBlockIds() {
      $result = $this->apiHttpCall("getknownblockids");
      if ($result)
         return $result;
   }

   // /start_mine      
   // Starts mining threads      
   // JSON     
   // Input: [string] wallet address
   //        [int] number of threads
   // Output: [string] status  
   public function startMine($address, $threads) {
      // @TODO
   }

   // /stop_mine     
   // Stops mining threads       
   // JSON
   // Input:     -     -     
   // Output: [string] status  
   public function stopMine() {
      // @TODO
   }

   // /gettransactions     
   // Returns transactions as serialized blobs     
   // JSON     
   // Input: [list] tx ids     -     
   // Output: [list] transactions as hex   
   //         [list] missing tx ids   
   //         [string] status  
   public function getTransactions($txids = array()) {
      //@TODO
      //$result = $this->apiHttpCall("gettransactions", $txids);
      //if ($result)
      //   return $result;
   }

   // /sendrawtransactions       
   // Send transaction to the network     
   // JSON     
   // Input: [string] serialized transaction in hex form     -     
   // Output: [string] status  
   public function sendRawTransactions($txs) {
      //@TODO
   }

   // /getblocks.bin       
   // Returns blocks in binary form      
   // BIN    
   // Input: [list] block ids     -     
   // Output: [list] blocks   
   //         [int] start height   
   //         [int] current height   
   //         [string] status  
   public function getBlocks($blockids = array()) {
      //@TODO
   }

   // /get_o_indexes.bin      
   // Get global output indicies       
   // BIN      
   // Input: [hash] transaction id      -     
   // Output: [vector] output indicies   
   //         [string] status  
   public function getOIndexes($transactionids = array()) {
      //@TODO
   }

   // /getrandom_outs.bin
   // Get random output indicies for a given amount (purpose: for ring signatures)      
   // BIN      
   // Input: [list] amounts    
   //        [int] count      
   // Output: [vector]   
   //         { [int] amount; [list] outs }   
   //         output entries  
   public function getRandomOuts($amounts = array(), $count) {
      //@TODO
   }

}


// SAMPLE CREATE INSTANCE
/*

$fnd = New ForkNoteDaemon("http://127.0.0.1:18871");

// SAMPLE CALLS

print_r( $fnd->getBlockCount() );
// Error(-32603): JsonValue type is not ARRAY or OBJECT

print_r( $fnd->getBlockHash(117931) );
// Error(-32603): JsonValue type is not ARRAY

print_r( $fnd->getBlockTemplate(200,"bip1WevdQxcaVYr1bRuqEsEqU4vEJ5qFtHsrWANG7hbTYyvTmvTswC8FcX6yAZ2MunWE3Fu1qLpTBVUnf7hDhWpi4BbozDmQJ1") );
// returned result

// $fnd->submitBlock($block)
// @TODO untested

print_r( $block_header = $fnd->getLastBlockHeader() ); 
// returned result

print_r( $fnd->getBlockHeaderByHash("210216992d0596ae216bdd39bd20673767aa6729f690e844410338aa03fdafbc") );
// returned result

print_r( $fnd->getBlockHeaderByHeight(117937) );
// returned result

print_r( $fnd->getCurrencyId() );
// returned result

print_r( $fnd->getBlockchainSettings() );
// returned result

print_r( $fnd->BlocksListJson($block_header["block_header"]["height"]) );
// returned result

print_r( $fnd->BlockJson($block_header["block_header"]["hash"]) );
// returned result

print_r( $fnd->TransactionJson("02c872a5581e385aac63d8a2a72b9810c10b52039a731cee6491e4606b103daa") );
// returned result

echo $fnd->getHeight() . PHP_EOL;
// returned result

print_r( $fnd->getKnownBlockIds() );
//Error: Requested url is not found

*/


?>