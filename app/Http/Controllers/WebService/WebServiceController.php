<?php

namespace App\Http\Controllers\WebService;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\WebService;
use App\Services\GoogleDrive;
use App\Services\Zipper;
use Google\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class WebServiceController extends Controller
{
    public const TODOLISTS_SCOPES = [
        'https://www.googleapis.com/auth/drive',
        'https://www.googleapis.com/auth/drive.file',
    ];

    public function connect($name, Client $client)
    {
        if ($name === 'todolists') {

            $client->setScopes(self::TODOLISTS_SCOPES);
            $uri = $client->createAuthUrl();

            return ['uri' => $uri];
        }
    }

    public function callback(Request $request, Client $client)
    {
        $access_token = $client->fetchAccessTokenWithAuthCode($request->code);

        $service = WebService::create([
            'user_id' => auth()->id(), 'token' => $access_token, 'name' => 'todolists',
        ]);

        return $service;
    }

    public function store(WebService $webservice, GoogleDrive $drive)
    {
        $tasks = Task::where('created_at', '>=', now()->subDays(7))->get()->toJson();   // fetching last 7 days data

        $jsonFileName = 'tasks.json';                                                   // creating json file with path
        Storage::disk('local')->put("public/$jsonFileName", $tasks);

        $zip_file_name = Zipper::createZipFile($jsonFileName);                          // creating zip of this json file

        $access_token = $webservice->token;                                             // sending zip file to drive
        $drive->uploadFile($zip_file_name, $access_token);

        return response('File Uploaded', Response::HTTP_CREATED);
    }
}
