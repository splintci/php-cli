<?php

namespace CynoBit\PHPCLI;

use Exception;

class Options
{
    /**
     * Non option arguments.
     * @var array
     */
    protected $args;

    /**
     * The name of the binary for the CLI application.
     * @var string
     */
    protected $binary;

    /**
     * Data structure containing the metadata for the commands, arguments and options
     * the Current instance of the command line application deals with. this array
     * is modified by a call to the setup function in a class that overrides
     * CynoBit\PHPCLI\CLI::setup and call certain methods on the $options object provided
     * as an argument to the function. This the The CLI Application Data itself.
     * @var array
     */
    protected $app = [];

    /**
     * Currently parsed command
     *
     * @var string
     */
    protected $command = '';

    /**
     * Undocumented variable
     *
     * @var array
     */
    protected $options = [];

    /**
     * Class Constructor.
     */
    function __construct()
    {
        $this->app = [
            '' => [
                'opts' => [],
                'args' => [],
                'help' => ''
            ]
        ];
        $this->args = $this->get_args();
        $this->binary = basename(array_shift($this->args));
    }

    /**
     * Parse the values of $this->args into their rightful place for the CLI
     * application to make use of it.
     *
     * @return void
     */
    public function parseOptions(): void
    {
        if (isset($this->app[$this->args[0]])) {
            $this->command = array_shift($this->args);
        }

        $args = [];

        for ($x = 0; $x < count($this->args); $x++) {
            $opt = $this->args[$x];
            if ($this->startsWith($opt, '--')) {
                if (isset($this->app[$this->command]['opts'][substr($opt, 2)])) {
                    if ($this->app[$this->command]['opts'][substr($opt, 2)]['type'] != 'boolean') {
                        $val = null;
                        if ($x + 1 < count($this->args) && !preg_match('/^--?[\w]/', $this->args[$x + 1])) {
                            $val = $this->args[++$x];
                        }
                        if (is_null($val)) {
                            throw new Exception(
                                "Option {$this->app[$this->command]['opts'][substr($opt, 2)]} requires an argument",
                                1
                            );
                        }
                        $this->options[substr($opt, 2)] = $val;
                    }
                }
            } elseif ($this->startsWith($opt, '-')) {
                if (isset($this->app[$this->command]['short'][substr($opt, 1)])) {
                    $longName = $this->app[$this->command]['short'][substr($opt, 1)];
                    if ($this->app[$this->command]['opts'][$longName]['type'] != 'boolean') {
                        $val = null;
                        if ($x + 1 < count($this->args) && !preg_match('/^--?[\w]/', $this->args[$x + 1])) {
                            $val = $this->args[++$x];
                        }
                        if (is_null($val)) {
                            throw new Exception(
                                "Option {$this->app[$this->command]['opts'][$longName]} requires an argument",
                                1
                            );
                        }
                        $this->options[$longName] = $val;
                    }
                }
            } else {
                $args[] = $this->args[$x];
            }
        }

        $this->args = $args;
    }

    /**
     * Undocumented function
     *
     * @param  string|null $option
     * @param  boolean $default
     * @return array|bool
     */
    public function getOption(?string $option = null, $default = false)
    {
        if ($option === null) return $this->options;


        if (isset($this->options[$option])) return $this->options[$option];

        return $default;
    }

    public function help(): string
    {
        return "HELP";
    }

    /**
     * Undocumented function
     *
     * @param  string $str
     * @param  string $needle
     * @return boolean
     */
    private function startsWith(string $str, string $needle): bool
    {
        return substr($str, 0, strlen($needle)) == $needle;
    }

    /**
     * Undocumented function
     *
     * @return string
     */
    public function getCommand(): string
    {
        return $this->command;
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    public function getArgs(): array
    {
        return $this->args;
    }

    /**
     * Undocumented function
     *
     * @param  [type] $longName
     * @param  [type] $help
     * @param  [type] $shortName
     * @param  string $type
     * @param  string $command
     * @return void
     */
    public function registerOption($longName, $help, $shortName = null, $command = '', string $type = 'string')
    {
        if (!isset($this->app[$command])) {
            throw new Exception("Command $command not registered.");
        }

        $this->app[$command]['opts'][$longName] = [
            'type'  => $type,
            'help'  => $help,
            'short' => $shortName
        ];

        if ($shortName) {
            if (strlen($shortName) > 1) {
                throw new Exception("Short options should be exactly one ASCII character");
            }

            $this->app[$command]['short'][$shortName] = $longName;
        }
    }

    /**
     * Undocumented function
     *
     * @param  string $arg
     * @param  string $help
     * @param  boolean $required
     * @param  string $command
     *
     * @throws Exception
     *
     * @return void
     */
    public function registerArgument(string $arg, string $help, bool $required = true, string $command = '')
    {
        if (!isset($this->app[$command])) {
            throw new Exception("Command $command not Registered.");
        }

        $this->app[$command]['args'][] = array(
            'name'     => $arg,
            'help'     => $help,
            'required' => $required
        );
    }

    /**
     * Undocumented function
     *
     * @param  string $command
     * @param  string $help
     * @return void
     */
    public function registerCommand(string $command, string $help)
    {
        if (isset($this->setup[$command])) {
            throw new Exception("Command $command already registered");
        }

        $this->app[$command] = array(
            'opts' => [],
            'args' => [],
            'help' => $help
        );
    }

    /**
     * Safely gets the command line arguments.
     *
     * @throws Exception
     *
     * @return array
     */
    private function get_args(): array
    {
        global $argv;
        if (!is_array($argv)) {
            if (!@is_array($_SERVER['argv'])) {
                if (!@is_array($GLOBALS['HTTP_SERVER_VARS']['argv'])) {
                    throw new Exception("Could not read cmd args (register_argc_argv=Off?)");
                }
                return $GLOBALS['HTTP_SERVER_VARS']['argv'];
            }
            return $_SERVER['argv'];
        }
        return $argv;
    }
}
