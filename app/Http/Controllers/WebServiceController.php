<?php

namespace App\Http\Controllers;

use ZipArchive;
use Google\Client;
use App\Models\Task;
use Google\Service\Drive;
use App\Models\WebService;
use Illuminate\Http\Request;
use Google\Service\Drive\DriveFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class WebServiceController extends Controller
{
    public const TODOLISTS_SCOPES = [
        'https://www.googleapis.com/auth/drive',
        'https://www.googleapis.com/auth/drive.file',
    ];

    public function connect(Request $request, Client $client)
    {
        if ($request->webservice === 'todolists') {

            $client->setScopes(self::TODOLISTS_SCOPES);
            $uri = $client->createAuthUrl();
            return ['uri' => $uri];
        }
    }

    public function callback(Request $request, Client $client)
    {
        $access_token = $client->fetchAccessTokenWithAuthCode($request->code);

        $service = WebService::create([
            'user_id' => auth()->id(), 'token' => $access_token, 'name' => 'todolists'
        ]);
        return $service;
    }

    public function store(Request $request, WebService $webservice, Client $client)
    {
        // need to fetch last 7 days data
        $tasks = Task::where('created_at', '>=', now()->subDays(7))->get()->toJson();

        // creating json file with this data with path
        Storage::put('public/tasks.json', $tasks);

        // creating zip file with this json file
        $zip = new ZipArchive();
        $zip_file_name = storage_path('app/public/' . 'tasks.zip');
        $zip->open($zip_file_name, ZipArchive::CREATE);
        $zip_file_path = storage_path('app/public/' . 'tasks.json');
        $zip->addFile($zip_file_path);
        $zip->close();

        // sending zip file to drive
        $access_token = $webservice->token;
        // dd($access_token);
        $client->setAccessToken($access_token);

        $service = new Drive($client);
        $file = new DriveFile();

        $file->setName("First File!");
        $service->files->create(
            $file,
            [
                'data' => file_get_contents($zip_file_name),
                'mimeType' => 'application/octet-stream',
                'uploadType' => 'multipart'
            ]
        );

        return response('File Uploaded', Response::HTTP_CREATED);
    }
}
