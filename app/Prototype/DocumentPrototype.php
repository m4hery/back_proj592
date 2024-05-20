<?php

namespace App\Prototype;

use App\Models\Document;

class DocumentPrototype
{
    private $document;

    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    public function clone()
    {
        return  $this->document;
    }
}