<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Builder\DocumentBuilder;
use App\Models\Document;
use App\Prototype\DocumentPrototype;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Validator;

class DocumentController extends Controller
{


    private function storePhoto($photoRequest, $path): array
    {
        if($photoRequest){
            $image_name = $photoRequest->getClientOriginalName();
            $photo = $photoRequest->storeAs($path,$image_name, 'public');
        }

        return [$photo, $image_name];  
    }

    public function get(Request $request)
    {
        $user_id = $request->get("user_id");
        $data = [];
        foreach(Document::where('user_id', $user_id)->get() as $doc)
        {
            $data[] = $doc->info_folder;
        }

        return response()->json($data);
    }

    /**
     * creation d un fichier ou folder (type = file or folder)
     * si c'est un dossier enfant ou file enfant il faut preciser le parent_id
     */
    public function store(Request $request)
    {
        $vs = Validator::make($request->all(), [
            'name' => 'required',
            'type' => 'required',
            'user_id' => 'required'
        ]);
        $document = new DocumentBuilder();
        if($request->hasFile('file')){
            $resp = $this->storePhoto($request->file('file'), "document");
        }
        $document = $document->setName($request->name ?? $resp[1])
            ->setPath($resp[0] ?? '')
            ->setUserId($request->user_id)
            ->setParentId($request->parent_id)
            ->setType($request->type)
            ->build();


        return response()->json([
            'document' => $document
        ]);
    }

    public function clone(Document $document, Request $request)
    {
        $_document = new DocumentPrototype($document);
        $document =  $_document->clone();
        $doc = new DocumentBuilder();
        $doc->setName($request->name ?? $document->name)
            ->setPath($document->path)
            ->setUserId($request->user_id ?? $document->user_id)
            ->setParentId($request->parent_id ?? $document->parent_id)
            ->setType($request->type ?? $document->type)
            ->build();
        return response()->json([
            'document' => $document
        ]);
    }

    public function update(Document $document, Request $request)
    {
        $document->name = $request->name;
        $document->save();

        return response()->json($document);
    }

    public function destoy(Document $document)
    {
        $document->delete();

        return response()->json(['messg' => 'delete']);
    }

    public function getArchives(Request $request)
    {
        $user_id = $request->get('user_id');

        $data = [];
        foreach(Document::onlyTrashed()->where('user_id', $user_id)->get() as $doc)
        {
            $data[] = $doc->info_folder;
        }

        return response()->json($data);
    }
}
