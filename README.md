# ForkNote-API-PHP
ForkNote API Wrapper in PHP

For use with all ForkNote Coins: bikercoin bipcoin bitcoal bytecoin crossnote cryptopeg dashcoin dinastycoin ethanolium fosscoin karbowanec magnatoj quazarcoin redwind xcicoin

## Functions:

### [ForkNoteDaemon](https://github.com/KittyCatTech/forknote-api-php/blob/master/forknoteDaemonAPI.php)
* getBlockTemplate($reserveSize, $walletAddress) - Returns blocktemplate with an empty “hole” for nonce.
* getLastBlockHeader() - Returns last block header.
* getBlockHeaderByHash($hash) - Returns last block header by given hash.
* getBlockHeaderByHeight($height) - Returns block header by given block height.
* getCurrencyId() - Returns unique currency identifier.
* getBlockchainSettings() - Returns the settings of the used configuration file.
* BlocksListJson($height) - Returns list of shortly described blocks.
* BlockJson($hash) - Returns detailed description of a block.
* TransactionJson($hash) - Returns detailed description of a transaction.
* getHeight() - Returns current chain height.


### [ForkNoteWalletd]()
* Coming Soon

### [ForkNoteSimpleWallet]()
* Coming Soon

## Usage:

[Download ForkNote](http://forknote.net/download)

* Add the following code to the [coin's config file](https://github.com/forknote/configs):

```
rpc-bind-ip=0.0.0.0
enable-blockchain-indexes=1
enable-cors=*
```

* Launch forknoted with the corresponding config file
Linux/Mac
```
./forknoted --config-file <path_to_config_file>
```
Windows
```
"C:\Program Files\forknote-windows\forknoted"
--config-file "<path_to_config_file>"
```

Find your coin's rpc port in the config file. ( i.e. rpc-bind-port=18871)

```vim
<?php
include 'forknoteDaemonAPI.php';

// Create instance of ForkNoteDaemon
$fnd = New ForkNoteDaemon("http://127.0.0.1:18871");

// Get Header of the most recent block
$last_block_header = $fnd->getLastBlockHeader();

// Print detailed descrition of the most recent block
print_r( $fnd->BlockJson($last_block_header["block_header"]["hash"]) );

?>
```

## License:

[BipCot NoGov Software License](https://github.com/KittyCatTech/forknote-api-php/blob/master/LICENSE)


## Development:

Created by KittyCatTech.

Donations are accepted in Monero and BipCoin:

XMR: 49kC7NB3iagZf2T4AhBdL84N9JaugEhvJVJDBEuMEKQSUnrx3xFoDzejpRKiSgX7V1j1im8h8xyRmNXJJSQtBtJS7F25nzs

BIP: bip1WevdQxcaVYr1bRuqEsEqU4vEJ5qFtHsrWANG7hbTYyvTmvTswC8FcX6yAZ2MunWE3Fu1qLpTBVUnf7hDhWpi4BbozDmQJ1
