<?php

 /**
 / ForkNote Walletd API Wrapper
 /
 / For ForkNote Coins: bikercoin bipcoin bitcoal bytecoin crossnote
 /                     cryptopeg dashcoin dinastycoin ethanolium fosscoin
 /                     karbowanec magnatoj quazarcoin redwind xcicoin
 /
 / https://github.com/KittyCatTech/forknote-api-php
 / License: BipCot NoGov Software License
 / https://github.com/KittyCatTech/forknote-api-php/blob/master/LICENSE
 */

class ForkNoteWalletd {

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

	// reset	reset() method allows you to re-sync your wallet.
	// Input value example:
	// {  
	//   'params':{  
	//      'viewSecretKey':'4a2583e42d010e8aabfed22743789569714196246bf01b5f2fec35af9232d907'
	//   },
	//   'jsonrpc':'2.0',
	//   'id':'test',
	//   'method':'reset'
	// }
	// Output value example:
	// {  
	//   'jsonrpc':'2.0',
	//   'id':'test',
	//   'result':{  
	//   }
	// }
   public function reset($viewSecretKey = false) {
      $args = array();
      $args["jsonrpc"] = "2.0";
      $args["id"] = "test";
      $args["method"] = "reset";
      if($viewSecretKey)
      	$args["params"]["viewSecretKey"] = $viewSecretKey;
      $result = $this->apiCall($args);
      if ($result)
         return $result['result'];
   }
	
	// save	save() method allows you to save your wallet by request.
	// Input value example:
	// {  
	//   'params':{  
	//   },
	//   'jsonrpc':'2.0',
	//   'id':'test',
	//   'method':'save'
	// }
	// Output value example:
	// {  
	//   'jsonrpc':'2.0',
	//   'id':'test',
	//   'result':{  
	//   }
	// }
   public function save() {
      $args = array();
      $args["jsonrpc"] = "2.0";
      $args["id"] = "test";
      $args["method"] = "save";
      $result = $this->apiCall($args);
      if ($result)
         return $result['result'];
   }

	// getViewKey	getViewKey() method returns address view key.
	// Input Example:
	// {  
	//   'params':{  
	//   },
	//   'jsonrpc':'2.0',
	//   'id':'test',
	//   'method':'getViewKey'
	// }
	// Return value example:
	// {  
	//   'jsonrpc':'2.0',
	//   'id':'test',
	//   'result':{  
	//      'viewSecretKey':'4a2583e42d010e8aabfed22743789569714196246bf01b5f2fec35af9232d907'
	//   }
	// }
   public function getViewKey() {
      $args = array();
      $args["jsonrpc"] = "2.0";
      $args["id"] = "test";
      $args["method"] = "getViewKey";
      $result = $this->apiCall($args);
      if ($result)
         return $result['result'];
   }	

	// getSpendKeys	getSpendKeys() method returns address spend keys.
	// Input Example:
	// {  
	//   'params':{  
	//      'address':'22p4wUHAMndSscvtYErtqUaYrcUTvrZ9zhWwxc3JtkBHAnw4FJqenZyaePSApKWwJ5BjCJz1fKJoA6QHn5j6bVHg8A8dyhp'
	//   },
	//   'jsonrpc':'2.0',
	//   'id':'test',
	//   'method':'getSpendKeys'
	// }
	// Return value example:
	// {  
	//   'jsonrpc':'2.0',
	//   'id':'test',
	//   'result':{  
	//      'spendSecretKey':'4a2583e42d010e8aabfed22743789569714196246bf01b5f2fec35af9232d907'
	//      'spendPublicKey':'4a2583e42d010e8aabfed22743789569714196246bf01b5f2fec35af9232d907'
	//   }
	// }
	public function getSpendKeys($address) {
      $args = array();
      $args["jsonrpc"] = "2.0";
      $args["id"] = "test";
      $args["method"] = "getSpendKeys";
      $args["params"]["address"] = $address;
      $result = $this->apiCall($args);
      if ($result)
         return $result['result'];
   }

	// getStatus	getStatus() method returns information about the current RPC Wallet state: block_count, known_block_count, last_block_hash and peer_count.
	// Input example:
	// {  
	//   'params':{  
	//   },
	//   'jsonrpc':'2.0',
	//   'id':'test',
	//   'method':'getStatus'
	// }
	// Output example:
	// {  
	//   'jsonrpc':'2.0',
	//   'id':'test',
	//   'result':{  
	//      'peerCount':2,
	//      'blockCount':1,
	//      'lastBlockHash':'8a6f1cb7ed7a9db4751d7b283a0482baff20567173dbfae136c9bceb188e51c4',
	//      'knownBlockCount':0
	//   }
	// }
   public function getStatus() {
      $args = array();
      $args["jsonrpc"] = "2.0";
      $args["id"] = "test";
      $args["method"] = "getStatus";
      $result = $this->apiCall($args);
      if ($result)
         return $result['result'];
   }	

	// getAddresses	getAddresses() method returns an array of your RPC Wallet's addresses.
	// Input example:
	// {  
	//   'params':{  
	//   },
	//   'jsonrpc':'2.0',
	//   'id':'test',
	//   'method':'getAddresses'
	// }
	// Output example:
	// {  
	//   'jsonrpc':'2.0',
	//   'id':'test',
	//   'result':{  
	//      'addresses':[  
	//         '2785gGLpyMJhw4JFVVd4vMDeRMmvTNda9MMgQNBd8se2a1mNRcKYubnaCk5zubLSefZAAmjDk9Fyejb2hVDRZQ23MB2BgUW',
	//         '2785gGLpyMJhw4JFVVd5kFDeRMmvTNda9CClNASd8se2a1mNRcKYubnaCk5zubLSefZAAmjDk9Fyejb2hVDRZQ23MB2BgUW'
	//      ]
	//   }
	// }
   public function getAddresses() {
      $args = array();
      $args["jsonrpc"] = "2.0";
      $args["id"] = "test";
      $args["method"] = "getAddresses";
      $result = $this->apiCall($args);
      if ($result)
         return $result['result'];
   }	

	// createAddress	createAddress() method creates an address.
	// Input value example:
	// {  
	//   'params':{  
	//   },
	//   'jsonrpc':'2.0',
	//   'id':'test',
	//   'method':'createAddress'
	// }
	// Output value example:
	// {  
	//   'jsonrpc':'2.0',
	//   'id':'test',
	//   'result':{  
	//      'address':'21H8EaE5gVG93iFdcuYPcuefGiLpZrJGbbi19Dg41GWJDoghsv2JpCj7oUzixyP5edBPTKwAWHEpEiLpnGgxPjVxHHeovpL'
	//   }
	// }
   public function createAddress( $publicSpendKey = false, $secretSpendKey = false ) {
      $args = array();
      $args["jsonrpc"] = "2.0";
      $args["id"] = "test";
      $args["method"] = "createAddress";
      if ($secretSpendKey) $args["params"]["spendSecretKey"] = $secretSpendKey;
      else if ($publicSpendKey) $args["params"]["spendPublicKey"] = $publicSpendKey;
      print_r($args);
      $result = $this->apiCall($args);
      if ($result)
         return $result['result'];
   }

	// deleteAddress	deleteAddress() method deletes a specified address.
	// Input example:
	// {  
	//   'params':{  
	//      'address':'239eXvWMH2d5X8cpDt2ExK51chEG7Ag6JZtvnSRQzBaRbP9Ug3ewFiT7oUzixyP5edBPTKwAWHEpEiLpnGgxPjVxHJ6ZYC5'
	//   },
	//   'jsonrpc':'2.0',
	//   'id':'test',
	//   'method':'deleteAddress'
	// }
	// Output example:
	// {  
	//   'jsonrpc':'2.0',
	//   'id':'test',
	//   'result':{  
	//   }
	// }
   public function deleteAddress( $address ) {
      $args = array();
      $args["jsonrpc"] = "2.0";
      $args["id"] = "test";
      $args["method"] = "deleteAddress";
      $args["params"]["address"] = $address;
      $result = $this->apiCall($args);
      if ($result)
         return $result['result'];
   }

	// getBalance	getBalance() method returns a balance for a specified address. If address is not specified, returns a cumulative balance of all RPC Wallet's addresses.
	// Input example:
	// {  
	//   'params':{  
	//      'address':'2785gGLpyMJhw4JFVVd4vMDeRMmvTNda9MMgQNBd8se2a1mNRcKYubnaCk5zubLSefZAAmjDk9Fyejb2hVDRZQ23MB2BgUW'
	//   },
	//   'jsonrpc':'2.0',
	//   'id':'test',
	//   'method':'getBalance'
	// }
	// Output example:
	// {  
	//   'jsonrpc':'2.0',
	//   'id':'test',
	//   'result':{  
	//      'lockedAmount':210,
	//      'availableBalance':110
	//   }
	// }
   public function getBalance( $address = false ) {
      $args = array();
      $args["jsonrpc"] = "2.0";
      $args["id"] = "test";
      $args["method"] = "getBalance";
      if ( $address )
      	$args["params"]["address"] = $address;
      $result = $this->apiCall($args);
      if ($result)
         return $result['result'];
   }

	// getBlockHashes	getBlockHashes() method returns an array of block hashes for a specified block range.
	// Input example:
	// {  
	//   'params':{  
	//      'blockCount':11,
	//      'firstBlockIndex':0
	//   },
	//   'jsonrpc':'2.0',
	//   'id':'test',
	//   'method':'getBlockHashes'
	// }
	// Output example:
	// {  
	//   'jsonrpc':'2.0',
	//   'id':'test',
	//   'result':{  
	//      'blockHashes':[  
	//         '8a6f1cb7ed7a9db4751d7b283a0482baff20567173dbfae136c9bceb188e51c4',
	//         '657cd1c33df7f4250d581c97db665cb4a1856ebfadd6efabaeab745c2c76b1be',
	//         '21047174f74576b6722e72646d7bd553e17d7c9f07fef05151bb1f9df7ed9dd8',
	//         '504b9bfb2cd34531551cb2d68ea3e34e030d991164589ba7ed24e16fed3ea374',
	//         'd9d36b5226d11b2cf60e3cf2038b21032c4ac753eabc32fbdd506158f95a69ca',
	//         '171be105f8e39729838144c78ced336d0ebc29a4bd2c7a22901c0e8c0eaabb42',
	//         '5f7933bd0257649a44e571d59a9f4083297acbdd338c1c0094a7226ade8d0f0f',
	//         '967fd52a57e8193f56329bb37abdddce717098429f62c00776342c605a28e19b',
	//         '6b1a21634a3d72821c43a244af16098eba7c0a59a2e409efa38bd420702f7594',
	//         '7bb5ca944c5f916f80d50246f48789cc4605efd166efc2308553fe0d208fbe12',
	//         '83dfef7c288121d87e60f52c74d3da6b422d4b8581ce732ef8b54273bd6c4f45'
	//      ]
	//   }
	// }
   public function getBlockHashes( $firstBlockIndex, $blockCount ) {
      $args = array();
      $args["jsonrpc"] = "2.0";
      $args["id"] = "test";
      $args["method"] = "getBlockHashes";
     	$args["params"]["firstBlockIndex"] = $firstBlockIndex;
     	$args["params"]["blockCount"] = $blockCount;
      $result = $this->apiCall($args);
      if ($result)
         return $result['result'];
   }

	// getTransactionHashes	getTransactionHashes() method returns an array of block and transaction hashes.
	// Input example:
	// {  
	//    'params':{  
	//       'blockCount':100,
	//       'firstBlockIndex':0,
	//  		'addresses':[  
	//         '2AFUzhkRatH2kQ19RaUNiE33mMQ3ejvJrGDhdDo77zn3RJQquQG7QBidoe7AD4EgBbChteaVesg3xcLVdq9EoCHH4NV9mxp'
	//      	]
	//    },
	//   'jsonrpc':'2.0',
	//   'id':'test',
	//   'method':'getTransactionHashes'
	// }
	// Output example:
	// {  
	//   'jsonrpc':'2.0',
	//   'id':'test',
	//   'result':{  
	//      'items':[  
	//          {  
	//             'transactionHashes':[  
	//                957dcbf54f327846ea0c7a16b2ae8c24ba3fa8305cc3bbc6424e85e7d358b44b
	//                25bb751814dd39bf46c972bd760e7516e34200f5e5dd02fda696671e11201f78
	//             ],
	//             'blockHash':'8a6f1cb7ed7a9db4751d7b283a0482baff20567173dbfae136c9bceb188e51c4'
	//          }
	//       ]
	//    }
	// }
	// @TODO Test with all possible types of inputs
	// address array test
   public function getTransactionHashes( $firstBlockIndex=false, $firstblockHash=false, $blockCount, $paymentId=false, $addresses=false ) {
      $args = array();
      $args["jsonrpc"] = "2.0";
      $args["id"] = "test";
      $args["method"] = "getTransactionHashes";
      if ($firstBlockIndex) $args["params"]["firstBlockIndex"] = $firstBlockIndex;
      else {
      	if($firstblockHash) $args["params"]["blockHash"] = $firstblockHash;
      	else return;
      }
     	$args["params"]["blockCount"] = $blockCount;
     	if ($paymentId) $args["params"]["paymentId"] = $paymentId;
     	if ($addresses) $args["params"]["addresses"] = $addresses;
      $result = $this->apiCall($args);
      if ($result)
         return $result['result'];
   }

	// getTransactions	getTransactions() method returns information about the transactions in specified block range or for specified addresses.
	// Input example:
	// {  
	//   'params':{  
	//      'blockCount':1000,
	//      'firstBlockIndex':1,
	//      'addresses':[  
	//         '22p4wUHAMndSscvtYErtqUaYrcUTvrZ9zhWwxc3JtkBHAnw4FJqenZyaePSApKWwJ5BjCJz1fKJoA6QHn5j6bVHg8A8dyhp',
	//         '261K6FuYL4vYvLFQx2ene92JNHip8YGyJGHCCNjPwoFE2RsRYwtzPC7aePSApKWwJ5BjCJz1fKJoA6QHn5j6bVHg8DRRpU1',
	//         '2AVwwZ6Ju6gGeztrtHjsj42xWLavrXPN1PrpnNKGXCMcLACj2WhGqYwaePSApKWwJ5BjCJz1fKJoA6QHn5j6bVHg8A4Z9K8'
	//      ],
	//      paymentId:'somePaymentId'
	//   },
	//   'jsonrpc':'2.0',
	//   'id':'test',
	//   'method':'getTransactions'
	// }
	// Output example:
	// {  
	//   'jsonrpc':'2.0',
	//   'id':'test',
	//   'result':{  
	//      'items':[  
	//         {  
	//            'blockHash':'01bd06ca731914f27e143bbb902ce0bc05bff13d76faa027ea817e68f217488c',
	//            'transactions':[  
	//               {  
	//                  'fee':-70368475742208,
	//                  'extra':'0127cea59bfadc49aa02ed4a225936671e55607b5241621abca2a5e14405906dbb',
	//                  'timestamp':1446029698,
	//                  'blockIndex':1,
	//                  'state':0,
	//                  'transactionHash':'06ec210a8359f253f8b2160a0d6040cf89f2a05a553aaa577b7f508ee5d831f9',
	//                  'amount':70368475742208,
	//                  'unlockTime':11,
	//                  'transfers':[  
	//                     {  
	//                        'amount':70368475742208,
	//                        'type':0,
	//                        'address':'22p4wUHAMndSscvtYErtqUaYrcUTvrZ9zhWwxc3JtkBHAnw4FJqenZyaePSApKWwJ5BjCJz1fKJoA6QHn5j6bVHg8A8dyhp'
	//                     }
	//                  ],
	//                  'paymentId':,
	//                  'isBase':True
	//               }
	//            ]
	//         },
	//         {  
	//            'blockHash':'28aa7d32f4274f6387969d7671bd4db98fd871bf0dd510a1df5e2ef4b1d41a35',
	//            'transactions':[  
	//               {  
	//                  'fee':-70368207307776,
	//                  'extra':'01a8e6e408282b2ddf343e20d5e9aab283723ba10ab7ab7b3131f6981b02a84431',
	//                  'timestamp':1446029698,
	//                  'blockIndex':2,
	//                  'state':0,
	//                  'transactionHash':'922d00d2e6eaed63f62d8e3b968cb08b6ea5c555fe0e6af948ab06efe6eb213a',
	//                  'amount':70368207307776,
	//                  'unlockTime':12,
	//                  'transfers':[  
	//                     {  
	//                        'amount':70368207307776,
	//                        'type':0,
	//                        'address':'22p4wUHAMndSscvtYErtqUaYrcUTvrZ9zhWwxc3JtkBHAnw4FJqenZyaePSApKWwJ5BjCJz1fKJoA6QHn5j6bVHg8A8dyhp'
	//                     }
	//                  ],
	//                  'paymentId':,
	//                  'isBase':True
	//               }
	//            ]
	//         }
	//      ]
	//   }
	// }
	// @TODO Test
   public function getTransactions( $firstBlockIndex=false, $firstblockHash=false, $blockCount, $paymentId=false, $addresses=false ) {
      $args = array();
      $args["jsonrpc"] = "2.0";
      $args["id"] = "test";
      $args["method"] = "getTransactions";
      if ($firstBlockIndex) $args["params"]["firstBlockIndex"] = $firstBlockIndex;
      else {
      	if($firstblockHash) $args["params"]["blockHash"] = $firstblockHash;
      	else return;
      }
     	$args["params"]["blockCount"] = $blockCount;
     	if ($paymentId) $args["params"]["paymentId"] = $paymentId;
     	if ($addresses) $args["params"]["addresses"] = $addresses;
      $result = $this->apiCall($args);
      if ($result)
         return $result['result'];
   }

	// getUnconfirmedTransactionHashes	getUnconfirmedTransactionHashes() method returns information about the current unconfirmed transaction pool or for a specified addresses.
	// Input example:
	// {  
	//   'params':{  
	//      'addresses':[  
	//         '26hM1rZa9wWFHSUBbdrof3C5BZ37s1XiLcVnK3xMSrn1583SEBQ98MnTHvsVSkNFbFWgjhrhmdNzgJDy3JudNV9BFMs66ao',
	//         '27am7ubgS834uVkpMgnqyKicxEJTLNJeL3QtC2zaJuHMbPyBkHcRBnQTHvsVSkNFbFWgjhrhmdNzgJDy3JudNV9BFLppiKL',
	//         '21pbz9qMWKq6xvFAYe723V4adjEF4ZXNrcJHZ1JFB2geHVwDFuze8A4THvsVSkNFbFWgjhrhmdNzgJDy3JudNV9BFLL4WH8'
	//      ]
	//   },
	//   'jsonrpc':'2.0',
	//   'id':'test',
	//   'method':'getUnconfirmedTransactionHashes'
	// }
	// Output example:
	// {  
	//   'jsonrpc':'2.0',
	//   'id':'test',
	//   'result':{  
	//      'transactionHashes':[  
	//         ...,
	//         ...,
	//         ...
	//      ]
	//   }
	// }
	// @TODO Test
   public function getUnconfirmedTransactionHashes( $addresses=false ) {
      $args = array();
      $args["jsonrpc"] = "2.0";
      $args["id"] = "test";
      $args["method"] = "getUnconfirmedTransactionHashes";
     	if ($addresses) $args["params"]["addresses"] = $addresses;
      $result = $this->apiCall($args);
      if ($result)
         return $result['result'];
   }

	// getTransaction	getTransaction() method returns information about the specified transaction.
	// Input example:
	// {  
	//   'params':{  
	//      'transactionHash':'92423b0857d36bd172b3f2effbd47ea477bfe0618a50c29d475542c6d5d1b835'
	//   },
	//   'jsonrpc':'2.0',
	//   'id':'test',
	//   'method':'getTransaction'
	// }
	// Output example:
	// {  
	//   'jsonrpc':'2.0',
	//   'id':'test',
	//   'result':{  
	//      'transaction':{  
	//         'fee':1000000,
	//         'extra':'0130b4472974f2deb9fae7d8fd6602b26396379f3fa05cca2430e10e9e60179f42',
	//         'timestamp':0,
	//         'blockIndex':4294967295,
	//         'state':0,
	//         'transactionHash':'92423b0857d36bd172b3f2effbd47ea477bfe0618a50c29d475542c6d5d1b835',
	//         'amount':-1703701,
	//         'unlockTime':0,
	//         'transfers':[  
	//            {  
	//               'amount':123456,
	//               'type':0,
	//               'address':'25AqTidmdu1awhLZPEUkumZEnM8Rt1fNsbpdRwEGNeLpDDfc1WW9RP6QsdENfxafTz4qE8vThbv413nXhs6WAzYeKBtgA98'
	//            },
	//            {  
	//               'amount':234567,
	//               'type':0,
	//               'address':'278g3wNw5W48DeGbjwxkW3XauBip64uYKS9eFveUHBfdRAG3dYHPZvqXy5BWbfuKEtWZ86PJZdRacAgr1x3gtP5nLyGcVt8'
	//            },
	//            {  
	//               'amount':345678,
	//               'type':0,
	//               'address':'2AtjUXGmhP6CmbRxCtBESR4MjSGiWCQUTPCdsDpw72Co2pwzZT7rjnaBNRCSFCEygjNo5oe8mHyXU4Eip8szu4ZnAFyPW1a'
	//            }
	//         ],
	//         'paymentId':,
	//         'isBase':False
	//      }
	//   }
	// }
	// @TODO Test
   public function getTransaction( $transactionHash ) {
      $args = array();
      $args["jsonrpc"] = "2.0";
      $args["id"] = "test";
      $args["method"] = "getTransaction";
     	$args["params"]["transactionHash"] = $transactionHash;
      $result = $this->apiCall($args);
      if ($result)
         return $result['result'];
   }

	// sendTransaction	sendTransaction() method creates and sends a transaction.
	// Input Example:
	// {  
	//   'params':{  
	//      'anonymity':0,
	//      'fee':1000000,
	//      'unlockTime':0,
	//      'paymentId':'somePaymentId',
	//      'addresses':[  
	//         '27eJo2S9eVo5N2G9zyjkqNBZPR6d2qvVD122vQMGAhcrjZjLu8nsMqk3c4KQ9iMJ4AV4fpBMccmjfJ4cu7uprKLNFX4qWNh',
	//         '24JtjYsLdSJKNNDCPGdMco5NbMBLqVWZ5ZiW5vzjXQUrLpMs1MRnfTQ3c4KQ9iMJ4AV4fpBMccmjfJ4cu7uprKLNFXHARwn',
	//         '21fYPCpaM3ochSSyLnhDAhgw1yV5WPb5c1BfyX5eidbMGyEPgnbSgJW3c4KQ9iMJ4AV4fpBMccmjfJ4cu7uprKLNFX8VQMv'
	//      ],
	//      'transfers':[  
	//         {  
	//            'amount':123456,
	//            'address':'27eJo2S9eVo5N2G9zyjkqNBZPR6d2qvVD122vQMGAhcrjZjLu8nsMqk3c4KQ9iMJ4AV4fpBMccmjfJ4cu7uprKLNFX4qWNh'
	//         },
	//         {  
	//            'amount':234567,
	//            'address':'278g3wNw5W48DeGbjwxkW3XauBip64uYKS9eFveUHBfdRAG3dYHPZvqXy5BWbfuKEtWZ86PJZdRacAgr1x3gtP5nLyGcVt8'
	//         },
	//         {  
	//            'amount':345678,
	//            'address':'2AtjUXGmhP6CmbRxCtBESR4MjSGiWCQUTPCdsDpw72Co2pwzZT7rjnaBNRCSFCEygjNo5oe8mHyXU4Eip8szu4ZnAFyPW1a'
	//         }
	//      ],
	//      'changeAddress':'27eJo2S9eVo5N2G9zyjkqNBZPR6d2qvVD122vQMGAhcrjZjLu8nsMqk3c4KQ9iMJ4AV4fpBMccmjfJ4cu7uprKLNFX4qWNh'
	//   },
	//   'jsonrpc':'2.0',
	//   'id':'test',
	//   'method':'sendTransaction'
	// }
	// Return value example:
	// {  
	//   'jsonrpc':'2.0',
	//   'id':'test',
	//   'result':{  
	//      'transactionHash':'93faedc8b8a80a084a02dfeffd163934746c2163f23a1b6022b32423ec9ae08f'
	//   }
	// }
	// @TODO Test
   public function sendTransaction( $fromAddressesfromAddresses=false, $transfers, $paymentId=false, $anonymity=6, $fee=1000000, $changeAddress=false, $unlockTime=false, $extra=false ) {
      $args = array();
      $args["jsonrpc"] = "2.0";
      $args["id"] = "test";
      $args["method"] = "sendTransaction";
     	if ($fromAddresses) $args["params"]["addresses"] = $fromAddresses;
     	$args["params"]["transfers"] = $transfers;
     	if ($paymentId) $args["params"]["paymentId"] = $paymentId;
     	$args["params"]["anonymity"] = $anonymity;
     	$args["params"]["fee"] = $fee;
     	if ($changeAddress) $args["params"]["changeAddress"] = $changeAddress;
     	if ($unlockTime) $args["params"]["unlockTime"] = $unlockTime;
     	if ($extra) $args["params"]["extra"] = $extra;
      $result = $this->apiCall($args);
      if ($result)
         return $result['result'];
   }

	// createDelayedTransaction	createDelayedTransaction() method creates but not sends a transaction.
	// getDelayedTransactionHashes	getDelayedTransactionHashes() method returns hashes of delayed transactions.
	// deleteDelayedTransaction	deleteDelayedTransaction() method deletes a specified delayed transaction.
	// sendDelayedTransaction	sendDelayedTransaction() method sends a specified delayed transaction.
	// sendFusionTransaction	sendFusionTransaction() method creates and sends a fusion transaction.
	// estimateFusion	estimateFusion() method allows to estimate a number of outputs that can be optimized with fusion transactions.
	

	public function makePaymentId() {
		return bin2hex(openssl_random_pseudo_bytes(32));
	}
}


// SAMPLE CREATE INSTANCE

$fnw = New ForkNoteWalletd("http://127.0.0.1:8070");

// SAMPLE CALLS

//print_r( $fnw->reset() );

//if( is_array($fnw->save()) ) echo "saved\n"; else echo "not saved\n";

//print_r( $view_key = $fnw->getViewKey() );

//print_r( $status = $fnw->getStatus() );

//print_r( $addr = $fnw->createAddress() );

//print_r( $addr = $fnw->getAddresses() );

//print_r( $fnw->getSpendKeys($addr["addresses"][0]) );

//print_r( $fnw->getSpendKeys("") );

//print_r( $fnw->deleteAddress("") );

//print_r( $fnw->reset("") );

//print_r( $addr = $fnw->createAddress(false, "") );

//print_r( $addr = $fnw->createAddress("") );

//print_r( $addr = $fnw->createAddress() );

//print_r( $fnw->getSpendKeys($addr["address"]) );

//print_r( $fnw->deleteAddress($addr["addresses"][0]) );

//print_r( $addr = $fnw->createAddress("") );

//print_r( $fnw->getBalance("") );

//while(true) {
/*
print_r( $status = $fnw->getStatus() );

print_r( $addr = $fnw->getAddresses() );
print_r( $fnw->getBalance() );

//print_r( $fnw->getBlockHashes( $status["blockCount"] - 20, 20 ) );

//$starttime = time();
//$fnw->getBlockHashes( 1, $status["blockCount"] );
//echo "to get all hash: ". (time()- $starttime) . " ms\n";

print_r( $fnw->getTransactionHashes( $status["blockCount"] - 150, false, 150) );

print_r( $fnw->getTransactions( $status["blockCount"] - 1500, false, 1500) );

print_r( $fnw->getUnconfirmedTransactionHashes() );

//print_r( $fnw->getTransaction( $transactionHash ));

echo $fnw->makePaymentId() . PHP_EOL;
*/
//sleep(20);
//}

?>