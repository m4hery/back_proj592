<?php
namespace App\Absract;

abstract class AbstractDocumentFactory
{
    abstract public function createDocument($name, $path, $userId, $parentId, $type, $visibility, $status);
}