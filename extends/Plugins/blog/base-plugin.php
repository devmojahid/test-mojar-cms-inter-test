<?php
namespace Plugin\Blog;

abstract class BasePlugin
{
    /**
     * Plugin name.
     *
     * @var string
     */
    protected $name;

    /**
     * Plugin version.
     *
     * @var string
     */
    protected $version;

    /**
     * Plugin author.
     *
     * @var string
     */
    protected $author;

    /**
     * Plugin constructor.
     *
     * @param string $name
     * @param string $version
     * @param string $author
     */
    public function __construct(string $name, string $version, string $author)
    {
        $this->name = $name;
        $this->version = $version;
        $this->author = $author;
    }

    /**
     * Activate the plugin.
     *
     * @return void
     */
    abstract public function activate();

    /**
     * Deactivate the plugin.
     *
     * @return void
     */
    abstract public function deactivate();

    /**
     * Uninstall the plugin.
     *
     * @return void
     */
    abstract public function uninstall();

    /**
     * Get the plugin name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the plugin version.
     *
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * Get the plugin author.
     *
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * Register plugin routes.
     *
     * @return void
     */
    abstract public function registerRoutes();
}