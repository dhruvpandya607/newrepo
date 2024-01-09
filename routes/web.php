<?php

use Google\Client;
use Illuminate\Support\Facades\Route;

Route::get('/todolists', function () {
    $client = new Client();
    $client->setClientId('862355530104-h133ile8lj9161d0h9er9uv9nvhafq62.apps.googleusercontent.com');
    $client->setClientSecret('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');
    $client->setRedirectUri('http://localhost:8000/todolists/callback');
    $client->setScopes([
        'https://www.googleapis.com/auth/drive',
        'https://www.googleapis.com/auth/drive.file',
    ]);

    $url = $client->createAuthUrl();

    return $url;
});

Route::get('/todolists/callback', function () {
    return request('code');
});

Route::get('upload', function () {
    $client = new Client();
    $access_token = 'ya29.a0ARrdaM8zhppotaylqPVBXM1SirlULNGgjhV6SzXODpR30nVwjreCmSueTHmB_M41wVMpCuecnKud8sIxk6TwCVJUtD7kJYrriCLDcassSozlzePscFtkZx16A8Gkvn__mQU0s-1m3UtLrhdC6KS29_7SwTTX';

    $client->setAccessToken($access_token);
    $service = new Google\Service\Drive($client);
    $file = new Google\Service\Drive\DriveFile();

    define('TESTFILE', 'testfile-small.txt');
    if (! file_exists(TESTFILE)) {
        $fh = fopen(TESTFILE, 'w');
        fseek($fh, 1024 * 1024);
        fwrite($fh, '!', 1);
        fclose($fh);
    }

    $file->setName('Hello World!');
    $service->files->create(
        $file,
        [
            'data' => file_get_contents(TESTFILE),
            'mimeType' => 'application/octet-stream',
            'uploadType' => 'multipart',
        ]
    );
});

Route::get('/', function () {
    return view('layout');
});
