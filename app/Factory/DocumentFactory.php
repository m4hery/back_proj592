<?php

namespace App\Factory;

use App\Interface\InterfaceDocumentFactory;
use App\Models\Document;

class DocumentFactory implements InterfaceDocumentFactory 
{
    private $name;
    private $path;
    private $userId;
    private $parentId;
    private $type;


    public function __construct($name, $path, $userId, $parentId, $type)
    {
        $this->name = $name;
        $this->path = $path;
        $this->userId = $userId;
        $this->parentId = $parentId;
        $this->type = $type;
    }

    public function create()
    {
        return  Document::create([
            'name' => $this->name,
            'path' => $this->path,
            'user_id' => $this->userId,
            'parent_id' => $this->parentId,
            'type' => $this->type,
        ]);
    }

    public function createFileDocument()
    {
        return  Document::create([
            'name' => $this->name,
            'path' => $this->path,
            'user_id' => $this->userId,
            'parent_id' => $this->parentId,
            'type' => "file",
        ]);
    }

    public function createFolderDocument()
    {
        return  Document::create([
            'name' => $this->name,
            'path' => $this->path,
            'user_id' => $this->userId,
            'parent_id' => $this->parentId,
            'type' => 'folder',

        ]);
    }
}