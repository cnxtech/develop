<?php
/**
 * Copyright (c) 2018. Codex Project.
 *
 * The license can be found in the package and online at https://codex-project.mit-license.org.
 *
 * @copyright 2018 Codex Project
 * @author Robin Radic
 * @license https://codex-project.mit-license.org MIT License
 */

namespace Codex\Documents\Processors\Macros;

use Closure;
use Codex\Exceptions\Exception;

/**
 * The Macro class represents.
 *
 * @author         CLI
 * @copyright      Copyright (c) 2015, CLI. All rights reserved
 */
class Macro
{
    /** @var \Codex\Documents\Document */
    public $document;

    /** @var \Codex\Projects\Project */
    public $project;

    /** @var \Codex\Codex */
    public $codex;

    /**
     * The Class[at]method call signature for the class method that should be called. As configured.
     *
     * @var
     */
    public $handler;

    /** @var array */
    public $arguments = [];

    /**
     * The cleaned macro string (eg: jira:issues:search('project="CODEX"', 54) ).
     *
     * @var string
     */
    public $cleaned;

    /**
     * The raw macro string (eg: <!--*codex:jira:issues:search('project="CODEX"', 54)*--> or <!--*codex:general:hide*--> or <!--*codex:/general:hide*-->.
     *
     * @var string
     */
    public $raw;

    /**
     * The definition is how the macro key. Similair to how it is registered in the config (eg: 'jira:issues:search' or 'general:hide' or 'table:responsive').
     *
     * @var string
     */
    public $definition;

    /**
     * DocTag constructor.
     *
     * @param string $raw
     * @param string $cleaned
     */
    public function __construct($raw, $cleaned)
    {
        $this->raw = $raw;
        $this->cleaned = $cleaned;
        $this->definition = static::extractDefinition($cleaned);
    }

    /**
     * The definition is how the macro key. Similair to how it is registered in the config (eg: 'jira:issues:search' or 'general:hide' or 'table:responsive').
     *
     * @param string $cleaned
     *
     * @return string
     *
     */
    public static function extractDefinition($cleaned)
    {
        if (0 === preg_match_all('/(?:\/|^)(.*?)(?:\(|$)/', $cleaned, $definition)) {
            throw Exception::make('Macro definition could not be extracted');
        }

        return $definition[1][0];
    }

    public function isClosing()
    {
        return starts_with($this->cleaned, '/');
    }

    public function hasArguments()
    {
        return str_contains($this->cleaned, ['(', ')']);
    }

    public function setHandler($handler)
    {
        $this->handler = $handler;
    }

    protected function addArgument($arg)
    {
        $this->arguments[] = $this->transformArg($arg);
    }

    protected function transformArg($arg)
    {
        $arg = trim($arg);
        //https://regex101.com/r/gB9bP9/1

        if (preg_match_all('/^(\')(.*?)(\')$/', $arg, $matches) > 0) {
            return str_replace('COMMA', ',', $matches[2][0]);
        } elseif ('true' === $arg || 'false' === $arg) {
            return 'true' === $arg;
        } elseif (is_numeric($arg)) {
            return (int) $arg;
        } elseif (class_exists((string) $arg)) {
            return app((string) $arg);
        } else {
            return $arg;
        }
    }

    protected function parseArguments()
    {
        // parsing argument houtje touwtje style
        // we explode the arguments string with , ex: "234, true, false, 'mydaady is gone'" = array("234", "true", "false", "'mydaady is gone'")
        // problem is when doing so with ex: "234, true, false, 'mydaady, is gone'" = array("234", "true", "false", "'mydaady", "is gone'")
        // which is unwanted, the explode does not work
        // ninja solution: replace , in strings with CCOMMAA, then revert back after

        $this->arguments = [];

        //https://regex101.com/r/gB9bP9/2
        if (preg_match('/\((.*?)\)(?!.*\))/', $this->cleaned, $argumentString) < 1) {
            return;
        }
        $argumentString = last($argumentString);

        preg_match_all('/\'(.*?)\'/', $argumentString, $stringArguments);
        foreach ($stringArguments[0] as $sai => $stringArgument) {
            $new = str_replace(',', 'COMMA', $stringArgument);
            $argumentString = str_replace($stringArgument, $new, $argumentString);
        }

        foreach (explode(',', $argumentString) as $arg) {
            $this->arguments[] = $this->transformArg($arg);
        }
    }

    protected function getCallable()
    {
        if ($this->handler instanceof Closure) {
            return $this->handler;
        } else {
            // assuming its a @ string
            list($class, $method) = explode('@', (string) $this->handler);
            $instance = app()->make($class);
            foreach (['codex', 'document', 'project', 'definition'] as $property) {
                if (property_exists($instance, $property)) {
                    $instance->{$property} = $this->{$property};
                }
            }

            return [$instance, $method];
        }
    }

    public function canRun()
    {
        return $this->raw && $this->cleaned && $this->handler;
    }

    public function run()
    {
        if ($this->canRun()) {
//            $content = $this->document->getContent();
            $this->parseArguments();
            $arguments = array_merge([$this->isClosing()], $this->arguments);
            $result = \call_user_func_array($this->getCallable(), $arguments);
            return $result;
//            $content = preg_replace('/'.preg_quote($this->raw, '/').'/', $result, $content, 1);
//            $this->document->setContent($content);
        } else {
            throw Exception::make("Macro [{$this->cleaned}] cannot call because some properties havent been set. Prevent the Macro from running by using the canRun() method.");
        }
    }
}
