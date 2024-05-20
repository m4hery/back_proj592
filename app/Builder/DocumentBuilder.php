<?php

namespace App\Builder;

use App\Factory\DocumentFactory;
use App\Models\Document;


class DocumentBuilder
{
    private $name;
    private $path;
    private $userId;
    private $parentId;
    private $type;
    private $visibility;
    private $status;

    public function setName(string $name): DocumentBuilder
    {
        $this->name = $name;
        return $this;
    }

    public function setPath(string|null $path): DocumentBuilder
    {
        $this->path = $path;
        return $this;
    }

    public function setUserId(int $userId): DocumentBuilder
    {
        $this->userId = $userId;
        return $this;
    }

    public function setParentId(int|null $parentId): DocumentBuilder
    {
        $this->parentId = $parentId;
        return $this;
    }

    public function setType(string|null $type): DocumentBuilder
    {
        $this->type = $type;
        return $this;
    }


    public function build($data = null): Document
    {
        if ($data) {
            $factory = new DocumentFactory($data->name, $data->path, $data->userId, $data->parentId, $data->type);
            return $factory->create();
        }
        $factory = new DocumentFactory($this->name, $this->path, $this->userId, $this->parentId, $this->type);
        return $factory->create();  
    }
}