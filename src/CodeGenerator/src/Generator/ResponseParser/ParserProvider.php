<?php

declare(strict_types=1);

namespace AsyncAws\CodeGenerator\Generator\ResponseParser;

use AsyncAws\CodeGenerator\Definition\ServiceDefinition;
use AsyncAws\CodeGenerator\Generator\CodeGenerator\TypeGenerator;
use AsyncAws\CodeGenerator\Generator\Composer\RequirementsRegistry;
use AsyncAws\CodeGenerator\Generator\Naming\NamespaceRegistry;

/**
 * Provide the correct parser according to the definition.
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 *
 * @internal
 */
class ParserProvider
{
    /**
     * @var NamespaceRegistry
     */
    private $namespaceRegistry;

    /**
     * @var RequirementsRegistry
     */
    private $requirementsRegistry;

    /**
     * @var TypeGenerator
     */
    private $typeGenerator;

    public function __construct(NamespaceRegistry $namespaceRegistry, RequirementsRegistry $requirementsRegistry, TypeGenerator $typeGenerator)
    {
        $this->namespaceRegistry = $namespaceRegistry;
        $this->requirementsRegistry = $requirementsRegistry;
        $this->typeGenerator = $typeGenerator;
    }

    public function get(ServiceDefinition $definition): Parser
    {
        switch ($definition->getProtocol()) {
            case 'query':
            case 'rest-xml':
                return new RestXmlParser($this->namespaceRegistry, $this->requirementsRegistry, $this->typeGenerator);
            case 'rest-json':
                return new RestJsonParser($this->namespaceRegistry, $this->requirementsRegistry, $this->typeGenerator);
            case 'json':
                return new JsonRpcParser($this->namespaceRegistry, $this->requirementsRegistry, $this->typeGenerator);
            default:
                throw new \LogicException(\sprintf('Parser for "%s" is not implemented yet', $definition->getProtocol()));
        }
    }
}
