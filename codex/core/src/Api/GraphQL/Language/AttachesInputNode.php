<?php

namespace Codex\Api\GraphQL\Language;


use GraphQL\Language\AST\ObjectTypeDefinitionNode;
use GraphQL\Language\Parser;
use Nuwave\Lighthouse\Schema\AST\DocumentAST;
use Nuwave\Lighthouse\Schema\AST\PartialParser;

trait AttachesInputNode
{
    /**
     * @param ObjectTypeDefinitionNode $objectType
     * @param DocumentAST              $documentAST
     *
     * @throws \Exception
     *
     * @return DocumentAST
     */
    protected function attachNodeInterfaceToObjectType(ObjectTypeDefinitionNode $objectType, DocumentAST $documentAST)
    {
        $objectType->interfaces = array_merge(
            collect($objectType->interfaces)->toArray(),
            [Parser::parseType('Node', ['noLocation' => true])]
        );

        $globalIdFieldName = config('lighthouse.global_id_field', '_id');
        $globalIdFieldDefinition = PartialParser::fieldDefinition($globalIdFieldName.': ID!');
        $objectType->fields->merge([$globalIdFieldDefinition]);

        return $documentAST->setDefinition($objectType);
    }
}
