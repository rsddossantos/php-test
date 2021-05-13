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
     * @var string
     */
    protected $data;
    protected $file;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->data = [];
        $this->file = 'tests/files/file';
        if (file_exists($this->file)) {
            unlink($this->file);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function get(string $index, $defaultValue = null)
    {
        if (!$this->has($index)) {
            return $defaultValue;
        }
        return $this->data[$index];
    }

    /**
     * {@inheritDoc}
     */
    public function set(string $index, $value)
    {
        $this->data[$index] = $value;
        $handle = fopen($this->file, 'w');
        foreach ($this->data as $key => $lines) {
            if (is_array($lines)) {
                foreach ($lines as $keylinesarray => $linesarray) {
                    fwrite($handle, $keylinesarray.':'.$linesarray.PHP_EOL);
                }
            } else {
                fwrite($handle, $key.':'.$lines.PHP_EOL);
            }
        }
        fclose($handle);
    }

    /**
     * {@inheritDoc}
     */
    public function has(string $index)
    {
        return array_key_exists($index, $this->data);
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
