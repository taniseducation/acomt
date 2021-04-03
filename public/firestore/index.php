<?PHP
echo '<h1>FS test</h1>';

// 
use Google\Cloud\Storage\StorageClient;

$storage = new StorageClient([
    'keyFilePath' => 'firestore1-309109-8d031bca7e7f.json',
])

$bucket = $storage->bucket('myBucket');

?>