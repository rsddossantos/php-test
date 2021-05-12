<?php

namespace Live\Collection;

/**
 * File collection
 *
 * @package Live\Collection
 */
class FileCollection implements CollectionInterface
{
    /**
     * Collection data
     *
     * @var array
     */
    protected $data;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->data = [];
        $files = glob('tests/files/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function get(string $filename, $defaultValue = null)
    {
        if (!$this->has($filename)) {
            return $this->data[0] = $defaultValue;
        }
        $this->data = file($filename);
        return trim($this->data[0]);
    }

    /**
     * {@inheritDoc}
     */
    public function set(string $filename, $value)
    {
        $handle = fopen($filename, 'a+');
        if ($handle) {
            fwrite($handle, $value.PHP_EOL);
            fclose($handle);
        }
        $this->data[] = $value;
    }

    /**
     * {@inheritDoc}
     */
    public function has(string $filename)
    {
        return file_exists($filename);
    }

    /**
     * {@inheritDoc}
     */
    public function count(): int
    {
        return count($this->data);
    }

    /**
     * {@inheritDoc}
     */
    public function clean()
    {
        $this->data = [];
    }
}
